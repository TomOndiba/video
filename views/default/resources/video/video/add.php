<?php
elgg_load_library('elgg:video');
$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('video'), 'video/all');
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


$body = elgg_view_layout('content', array(
	'content' => $form,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('video/sidebar', array('page' => 'add')),
));

echo elgg_view_page($title, $body);