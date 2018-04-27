<?php

/****
*
* The Start of TM video test
* https://github.com/CodePulse/pse/blob/a60516a17e72dda203607282baf830900e5270b6/docroot/sites/all/modules/contrib/community/youtube/youtube.inc#L44
**/

/**
 * Returns a list of standard MyTube video sizes.
 */
function mytube_size_options() {
  return array(
    '420x315' => '450px by 315px',
    '480x360' => '480px by 360px',
    '640x480' => '640px by 480px',
    '960x720' => '960px by 720px',
    'responsive' => 'responsive (full-width of container)',
    'custom' => 'custom',
  );
}


/**
 * Search through an array for a matching key.
 *
 *  https://gist.github.com/steve-todorov/3671626
 * Examples:
 * <code>
 *      $array = array(
 *          "database.name" => "my_db_name",
 *          "database.host" => "myhost.com",
 *          "database.user" => "admin",
 *          "database.pass" => "a secret."
 *      );
 *
 *      $search = array_contains_key($array, "database");
 *      var_dump($search);
 *
 *      Result:
 *      array (size=4)
 *          'database.name' => string 'my_db_name' (length=10)
 *          'database.host' => string 'myhost.com' (length=10)
 *          'database.user' => string 'admin' (length=5)
 *          'database.pass' => string 'a secret.' (length=9)
 * </code>
 *
 * @param array  $input_array
 * @param string $search_value
 * @param bool   $case_sensitive
 *
 * @return array
 */
function array_contains_key( array $input_array, $search_value, $case_sensitive = false)
{
    if($case_sensitive)
        $preg_match = '/'.$search_value.'/';
    else
        $preg_match = '/'.$search_value.'/i';
    $return_array = array();
    $keys = array_keys( $input_array );
    foreach ( $keys as $k ) {
        if ( preg_match($preg_match, $k) )
            $return_array[$k] = $input_array[$k];
    }
    return $return_array;
}


function CaesarCypher($Char2) {
        $Map = array('256x144' => '256x144','426x240' => '426x240','640x360' =>'640x360','854x480' => '854x480','1280x720' => '1280x720','1920x1080' => '1920x1080','852x480' => '852x480','640x480' => '640x480','320x240' => '320x240' ) ; // mapping values in an associative array
				
	      if(array_key_exists($Char2, $Map)) //  checking the key exists in an array or not.
		{
		return $Map[$Char2];
		}
		return $Char2;
		}

function get_file_resolution_metadata($file_path) {
    // rWatcher Edit:  Use FLVMetaData lib instead of ffmpeg for .flv files.
    //  For other files, just set a 320x240 default video resolution.
    $pi = pathinfo($file_path);
    $extension = isset($pi["extension"]) ? $pi["extension"] : "flv"; // No extension?  Assume FLV.
    $mime_type = in_array(strtolower($extension), array("mp4", "m4v")) ?
      "video/mp4" : "video/x-flv";
    $vid_width = 320;
    $vid_height = 240;
    if (strtolower($extension) == "flv") {
      $flvinfo = new FLVMetaData($file_path);
      $info = $flvinfo->getMetaData();
      if (($info["width"] != "") && ($info["height"] != "")) {
        $vid_width = $info["width"];
        $vid_height = $info["height"];
      }
    }
    return array($vid_width, $vid_height, $mime_type, $extension);
  }


/*
* Compare Two Different Array Value
*
*/

function compare_two_array_values($arr_one, $arr_two) {
// Compare Two Different Array Value

	// $arr_one = [];
	// $arr_two = [];
	
	 $arr_one = [];
	 $arr_two = [];

for ( $i=0; $i < count ($arr_one) ; $i++) {

if($arr_one [$i] == $arr_two [$i]) {

 echo $arr_one[$i] . ':' . 'is same value as:' .$arr_two[$i] . ' <br>';
 
  } else {
  
  echo $arr_one[$i] . ':' . 'value is not the same as:' .$arr_two[$i] . ' <br>';
  
}

}


}

/**
 *  Splits height and width when given size, as from youtube_size_options.
 *   Usage
 *  $youtube_size_options = '420x315' ;
 * $youtube_get_dimensions = youtube_get_dimensions($youtube_size_options);
 *  output// array(2) { ["width"]=> string(3) "420" ["height"]=> string(3) "315" } 
 */
function mytube_get_dimensions($size = NULL, $width = NULL, $height = NULL) {
  $dimensions = array();
  if ($size == 'responsive') {
    $dimensions['width'] = '100%';
    $dimensions['height'] = '100%';
  }
  elseif ($size == 'custom') {
    $dimensions['width'] = (int) $width;
    $dimensions['height'] = (int) $height;
  }
  else {
    // Locate the 'x'.
    $strpos = strpos($size, 'x');
    // Width is the first dimension.
    $dimensions['width'] = substr($size, 0, $strpos);
    // Height is the second dimension.
    $dimensions['height'] = substr($size, $strpos + 1, strlen($size));
  }
  return $dimensions;
}

/**
 *  Splits height and width when given size, as from youtube_size_options.
 *   Usage
 *  $youtube_size_options = '420x315' ;
 * $youtube_get_dimensions = youtube_get_dimensions($youtube_size_options);
 *  output// array(2) { ["width"]=> string(3) "420" ["height"]=> string(3) "315" } 
 */
function check_mytube_dimensions() {

   $vudu = video_get_resolution_options();

	// elgg_load_library('elgg:video');

	foreach ($videos as $video) {
		$sources = $video->getSources();
		
		// var_dump ($sources);
		
		$success = true;
		foreach ($sources as $source) {
			// Converted sources may exist if previous conversion has been interrupted
			if ($source->conversion_done == true) {
				continue;
			}
			
			$info = new VideoInfo($video);
			// video size stored in ariginal video infomation like e.g = '420x315' 
	                $size =  $info ->getResolution(); 
			
			 
				 // Locate the 'x'.
    			$strpos = strpos($size, 'x');
   				 // Width is the first dimension.
   			 $first_dimension_width = substr($size, 0, $strpos);
   
   				 // Height is the second dimension.
   			 $second_dimension_height = substr($size, $strpos + 1, strlen($size));

   			  if ($first_dimension_width == 0) {
   				 $new_resolution = $source->resolution;
 			 }

 }


}


   

  return $new_resolution;
}


/**
   * Echos the dimensions as width x height
   *
   * @return string
   * https://github.com/jelmerdemaat/codeandcolours/blob/35d3f52bcd85da81d15074ad057b0b981db3c493/kirby/toolkit/lib/dimensions.php#L257
   */
function DimensionsToString() {
    return $this->width . ' x ' . $this->height;
  }

/**
* Get video resolution using FFMpeg
* 
* @param string $ffmpeg_fullpath
* @param string $file            Path to video file
* 
* @return array
* https://github.com/genacode/rsTU_8_1_9965/blob/fad9822bb28c40df5c9b5dba0f75611bf69c3880/include/video_functions.php#L10
*/
function get_video_resolution($ffmpeg_fullpath, $file)
    {
    $video_resolution = array(
        'width'  => 0,
        'height' => 0,
    );
    $cmd    = $ffmpeg_fullpath . ' -i ' . escapeshellarg($file) . " 2>&1 | grep Stream | grep -oP ', \K[0-9]+x[0-9]+'";
    $output = run_command($cmd, true);
    $video_resolution_pieces = explode('x', $output);
    if(2 === count($video_resolution_pieces))
        {
        $video_resolution['width']  = $video_resolution_pieces[0];
        $video_resolution['height'] = $video_resolution_pieces[1];
        }
    return $video_resolution;
    }

/*************** End of TM test function


/*
* TM: function
* get the part after the last underscore
* Then get the filename without extenstion
* 
*  
*/
function getFilenameResolutionWithoutExtension($filename) {
    if (!$filename) { return false; }
    // get the part after the last underscore, use strrpos:
    // $str = 'kenya_uganda_amerika'; the Result: amerika
    
 $filename = substr($filename, strrpos($filename, '_') + 1);

  // Now get Filename Without Extension 
  $filename =  substr($filename, 0, strrpos($filename, '.'));
    return $filename;
}



/**
 * Video helper functions
 *
 * @package ElggVideo
 */
 
// TM: start
/**
 * Grants the access
 *
 * @param <type> $functionName
 */
function videoGetAccess_videos() {
	video_access_override(array('status' => true));
}
/**
 * Remove access
 *
 * @param string $functionName
 */
function videoRemoveAccess_videos() {
	video_access_override(array('status' => false));
}

function video_access_override($params=array()) {
	if($params['status']) {
		$func="elgg_register_plugin_hook_handler";
	} else {
		$func="elgg_unregister_plugin_hook_handler";
	}
	$func_name="videoGetAccessForAll_videos";
	$func("premissions_check","all",$func_name, 9999);
	$func("container_permissions_check","all",$func_name, 9999);
	$func("permissions_check:metadata","all",$func_name, 9999);
}


/**
 * Elgg hook to override permission check of entities (izap_videos, izapVideoQueue, izap_recycle_bin)
 *
 * @param <type> $hook
 * @param <type> $entity_type
 * @param <type> $returnvalue
 * @param <type> $params
 * @return <type>
 */
function videoGetAccessForAll_videos($hook, $entity_type, $returnvalue, $params) {
	return true;
}


//TM: STARTS Creating ISO 8601 durations 
 
 
/**
 *  Creating ISO 8601 durations 
 * Convert a number of seconds to whole numbers of hours, minutes, seconds
 * @param {int}
 * @return {hash}
 */
function secondsToDuration ($seconds) {
  $remaining = $seconds;
  $parts = array();
  $multipliers = array(
    'hours' => 3600,
    'minutes' => 60,
    'seconds' => 1
  );
  foreach ($multipliers as $type => $m) {
    $parts[$type] = (int)($remaining / $m);
    $remaining -= ($parts[$type] * $m);
  }
  return $parts;
} 
 
 
 /**
 * Format a duration as ISO 8601
 * @param {hash}
 * @return {string}
 */
function formatDuration ($parts) {
  $default = array(
    'hours' => 0, 
    'minutes' => 0,
    'seconds' => 0
  );
  extract(array_merge($default, $parts));
                   
  return "PT{$hours}H{$minutes}M{$seconds}S";
}

function durationInDotsToseconds($string_duration) {

$str_time = $string_duration;

$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

return $time_seconds;

}

/*
* Although it takes up a few lines of code, this would be the fastest way as it's using the language construct 
* foreach rather than a function call (which is more expensive). 
* @ $b = is the pointer to make shure we don't play the same video again
*/

function array_get_next(array $a, $b) {

   $return = array();
    $cur = 0;
    foreach ($a as $key => $val) {
    // Not to load the same guid
  //  if($val== $b){
    $return[$key] = $val->guid;

    }

    $return_one_random_guid = $return[array_rand($return)];
    
    return  $return_one_random_guid;
    
}

function get_all_videos_lists() {
// Let use find all video entities on the site
 
 $offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 10);   
    
     $options = array(
	'type' => 'object',
	'subtype' => 'video',
	'limit' => $limit,
	'offset' => $offset,
	'full_view' => false,
	'list_type_toggle' => false,
	'no_results' => elgg_echo('video:notfound'),
	
	);

       $getter = 'elgg_get_entities';
      $entities = call_user_func($getter, $options);    
        
       return $entities;
}

function get_all_owner_videos() {
// Let use find all video entities belonging to page owner or user
    
     $options = array(
	'type' => 'object',
	'subtype' => 'video',
	'container_guid' => elgg_get_page_owner_guid(),
	// 'limit' => 6,
	// 'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('video:none'),
	
	);

       $getter = 'elgg_get_entities';
      $entities = call_user_func($getter, $options);    
        
       return $entities;
}




// TM end

/**
 * Prepare the upload/edit form variables
 *
 * @param object $video
 * @return array
 */
function video_prepare_form_vars($video = null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $video,
	);

	if ($video) {
		foreach (array_keys($values) as $field) {
			if (isset($video->$field)) {
				$values[$field] = $video->$field;
			}
		}
	}

	if (elgg_is_sticky_form('video')) {
		$sticky_values = elgg_get_sticky_values('video');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('video');

	return $values;
}

function video_get_page_contents_list ($container = 0) {
	$options = array(
		'type' => 'object',
		'subtype' => 'video',
		'full_view' => false,
	);
	$videos = elgg_list_entities($options);

	elgg_register_title_button();

	$params = array(
		'title' => elgg_echo('video'),
		'content' => $videos,
	);

	return $params;
}

function video_get_page_contents_upload () {
	$owner = elgg_get_page_owner_entity();

	// set up breadcrumbs
	if (elgg_instanceof($owner, 'user')) {
		elgg_push_breadcrumb($owner->name, "video/owner/$owner->username");
	} else {
		elgg_push_breadcrumb($owner->name, "video/group/$owner->guid/all");
	}

	$title = elgg_echo('video:add');
	elgg_push_breadcrumb($title);

	// Video upload form
	$form_vars = array('enctype' => 'multipart/form-data');
	$body_vars = video_prepare_form_vars();
	$form = elgg_view_form('video/upload', $form_vars, $body_vars);

	$params = array(
		'title' => $title,
		'content' => $form,
		'filter' => '',
	);

	return $params;
}

/**
 * Edit a video
 *
 * @package Video
 */
function video_get_page_contents_edit ($video_guid) {
	elgg_load_library('elgg:video');

	$video = get_entity($video_guid);
	if (!elgg_instanceof($video, 'object', 'video') || !$video->canEdit()) {
		forward();
	}

	$title = elgg_echo('video:edit');

	elgg_push_breadcrumb(elgg_echo('video'), "video/all");
	elgg_push_breadcrumb($video->title, $video->getURL());
	elgg_push_breadcrumb($title);

	elgg_set_page_owner_guid($video->getContainerGUID());

	$form_vars = array('enctype' => 'multipart/form-data');
	$body_vars = video_prepare_form_vars($video);

	$content = elgg_view_form('video/upload', $form_vars, $body_vars);

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);

	return $params;
}

/**
 * Edit video thumbnail
 */
function video_get_page_contents_edit_thumbnail ($guid) {
	$video = get_entity($guid);

	if (!$video) {
		register_error('notfound');
		forward(REFERER);
	}

	elgg_require_js('video/thumbnailer');

	$info_text = elgg_echo('video:thumbnail:instructions');
	$info = "<p>$info_text</p>";

	$sources = $video->getSourceUrls();

	$video_preview = elgg_view('output/video', array(
		'sources' => $sources,
		'id' => 'elgg-video',
	));

	$form = elgg_view_form('video/thumbnail', array(), array('guid' => $guid));

	$params = array(
		'title' => elgg_echo('video:thumbnail:edit'),
		'content' => $info . $video_preview . $form,
		'filter' => false,
	);

	return $params;
}

/**
 * Display individual's or group's videos
 */
function video_get_page_contents_owner () {
	// access check for closed groups
	group_gatekeeper();

	$owner = elgg_get_page_owner_entity();
	if (!$owner) {
		forward('video/all');
	}

	elgg_push_breadcrumb($owner->name);

	elgg_register_title_button();

	$params = array();

	if ($owner->guid == elgg_get_logged_in_user_guid()) {
		// user looking at own videos
		$params['filter_context'] = 'mine';
	} else if (elgg_instanceof($owner, 'user')) {
		// someone else's videos
		// do not show select a tab when viewing someone else's posts
		$params['filter_context'] = 'none';
	} else {
		// group videos
		$params['filter'] = '';
	}

	if (elgg_instanceof($owner, 'group')) {
		$title = elgg_echo('video:group');
	} else {
		$title = elgg_echo("video:user", array($owner->name));
	}

	// List videos
	$content = elgg_list_entities(array(
		'types' => 'object',
		'subtypes' => 'video',
		'container_guid' => $owner->guid,
		'limit' => 10,
		'full_view' => FALSE,
	));
	if (!$content) {
		$content = elgg_echo("video:none");
	}

	$sidebar = elgg_view('video/sidebar');

	$params['content'] = $content;
	$params['title'] = $title;
	$params['sidebar'] = $sidebar;

	return $params;
}

/**
 * Get page components to view a video.
 *
 * @param int $guid GUID of a video entity.
 * @return array
 */
function video_get_page_contents_view ($guid = null) {
	$video = get_entity($guid);
	if (!$video) {
		register_error(elgg_echo('noaccess'));
		$_SESSION['last_forward_from'] = current_page_url();
		forward('');
	}

	$owner = elgg_get_page_owner_entity();

	$crumbs_title = $owner->name;
	if (elgg_instanceof($owner, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "video/group/$owner->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "video/owner/$owner->username");
	}

	$title = $video->title;

	elgg_push_breadcrumb($title);

	if ($video->conversion_done) {
		$content = elgg_view_entity($video, array('full_view' => true));
		$content .= elgg_view_comments($video);
	} else {
		$string = elgg_echo('video:conversion_pending');
		$content = "<div>$string</div>";
	}

	/*
	elgg_register_menu_item('title', array(
		'name' => 'download',
		'text' => elgg_echo('video:download'),
		'href' => "video/download/$video->guid",
		'link_class' => 'elgg-button elgg-button-action',
	));
	*/
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);

	return $params;
}

/**
 * Make thumbnails of given video position. Defaults to beginning of video.
 *
 * @param Video $video    The video object
 * @param int   $position Video position
 */
function video_create_thumbnails($video, $position = 0) {
	$icon_sizes = elgg_get_config('icon_sizes');
	$square = elgg_get_plugin_setting('square_icons', 'video');

	// Default to square thumbnail images
	if (is_null($square)) {
		$square = true;
	}

	$square = $square == 1 ? true : false;

	$dir = $video->getFileDirectory();
	$guid = $video->getGUID();

	// Use default thumbnail as master
	$imagepath = "$dir/icon-master.jpg";

	try {
		$thumbnailer = new VideoThumbnailer();
		$thumbnailer->setInputFile($video->getFilenameOnFilestore());
		$thumbnailer->setOutputFile($imagepath);
		$thumbnailer->setPosition($position);
		$thumbnailer->execute();
	} catch (exception $e) {
		$msg = elgg_echo('VideoException:ThumbnailCreationFailed', array(
			$video->getFilenameOnFilestore(),
			$e->getMessage(),
			$thumbnailer->getCommand()
		));

		error_log($msg);
		elgg_add_admin_notice('video_thumbnailing_error', $msg);
		return false;
	}

	$files = array();

	// Create the thumbnails
	foreach ($icon_sizes as $name => $size_info) {
		// We have already created master image
		if ($name == 'master') {
			continue;
		}

		$resized = get_resized_image_from_existing_file($imagepath, $size_info['w'], $size_info['h'], $square);

		if ($resized) {
			$file = new ElggFile();
			$file->owner_guid = $video->owner_guid;
			$file->container_guid = $guid;
			$file->setFilename("video/{$guid}/icon-{$name}.jpg");
			$file->open('write');
			$file->write($resized);
			$file->close();

			$files[] = $file;
		} else {
			error_log("ERROR: Failed to create thumbnail '$name' for video {$video->getFilenameOnFilestore()}.");

			// Delete all images if one fails
			foreach ($files as $file) {
				$file->delete();
			}

			return false;
		}
	}

	$video->icontime = time();

	return true;
}