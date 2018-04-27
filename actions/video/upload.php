<?php
/**
 * Elgg video uploader/edit action n
 *
 * @package ElggVideo
 */

// Get variables
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('video_guid');
$tags = get_input("tags");



if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('video');

// check if upload failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
	$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);
	register_error($error);

	forward(REFERER);
}

// check whether this is a new video or an edit
$new_video = true;
if ($guid > 0) {
	$new_video = false;
}

if ($new_video) {
	// must have a video if a new video upload
	if (empty($_FILES['upload']['name'])) {
		$error = elgg_echo('video:novideo');
		register_error($error);
		forward(REFERER);
	}

	$video = new Video();
	$video->subtype = "video";

	// if no title on new upload, grab videoname
	if (empty($title)) {
		$title = htmlspecialchars($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8');
	}

} else {
	// load original video object
	$video = new Video($guid);
	if (!$video) {
		register_error(elgg_echo('video:notfound'));
		forward(REFERER);
	}

	// user must be able to edit video
	if (!$video->canEdit()) {
		register_error(elgg_echo('video:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $video->title;
	}
}

$video->title = $title;
$video->description = $desc;
$video->access_id = $access_id;
$video->container_guid = $container_guid;

$tags = explode(",", $tags);
$video->tags = $tags;

// TM: added Views however it is reseting views once  a video is edited edited
// $video->video_views = 1;
// $video->views = 1;

// Save the entity to push attributes to database
// and to get access to guid if adding a new video
$video->save();

// we have a video upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "video/{$video->getGUID()}/";

	// if previous video, delete it
	if ($new_video == false) {
		$videoname = $video->getFilenameOnFilestore();
		if (file_exists($videoname)) {
			unlink($videoname);
		}

		// use same videoname on the disk - ensures thumbnails are overwritten
		$videostorename = $video->getFilename();
		$videostorename = elgg_substr($videostorename, elgg_strlen($prefix));
	} else {
		$videostorename = elgg_strtolower($_FILES['upload']['name']);
	}

	$video->setFilename($prefix . $videostorename);
	$mime_type = ElggFile::detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);

	$video->setMimeType($mime_type);
	$video->originalvideoname = $_FILES['upload']['name'];
	$video->simpletype = 'video';

	// Open the video to guarantee the directory exists
	$video->open("write");
	$video->close();
	move_uploaded_file($_FILES['upload']['tmp_name'], $video->getFilenameOnFilestore());

	// Change the directory mode
	chmod($video->getFileDirectory(), 0775);

	$guid = $video->save();
}

// video saved so clear sticky form
elgg_clear_sticky_form('video');

// handle results differently for new videos and video updates
if ($new_video) {
	if ($guid) {
		elgg_load_library('elgg:video');

		// Find out file info and save it as metadata
		$info = new VideoInfo($video);
		//TM: notes: Here video resolution is saved as 0x3125 then later converter will change that to our settings
		$video->resolution = $info->getResolution();
		$video->bitrate = $info->getBitrate();
		$video->duration = $info->getDuration();

		// Mark the video as unconverted so conversion script can find it
		$video->conversion_done = false;
		
		// TM: start added Views for new videos
	    
                 $video->video_views = 0;
		 $video->views = 0;
		// TM: Ends
		
		$video->save();

		$video->setSources();

		video_create_thumbnails($video);

		$message = elgg_echo("video:saved");
		system_message($message);
	} else {
		// failed to save video object - nothing we can do about this
		$error = elgg_echo("video:uploadfailed");
		register_error($error);
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("video/group/$container->guid/all");
	} else {
		forward("video/owner/$container->username");
	}

} else {
	if ($guid) {
		system_message(elgg_echo("video:saved"));
	} else {
		register_error(elgg_echo("video:uploadfailed"));
	}

	forward($video->getURL());
}
