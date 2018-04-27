<?php
// our library
elgg_load_library('elgg:video');

// get the video id as input
$guid = elgg_extract('guid', $vars);

$video = get_entity($guid);
	if (!elgg_instanceof($video, 'object', 'video') || !$video->canEdit()) {
		forward('video/all');
	}

elgg_set_page_owner_guid($video->getContainerGUID());
$owner = elgg_get_page_owner_entity();

gatekeeper(); 
group_gatekeeper();
	
 $title = elgg_echo('video:edit');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('video'), 'video/all');
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb($owner->name, "video/owner/$owner->username");
} else {
	elgg_push_breadcrumb($owner->name, "video/group/$owner->guid");
}
elgg_push_breadcrumb($title, $video->getURL());
elgg_push_breadcrumb($title );

      elgg_set_page_owner_guid($video->getContainerGUID());
	$form_vars = array('enctype' => 'multipart/form-data');
	$body_vars = video_prepare_form_vars($video);
	$content = elgg_view_form('video/upload', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('video/sidebar', array('page' => 'edit')),
));

echo elgg_view_page($title, $body);