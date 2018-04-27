<?php
/**
 * Edit video thumbnail
 */
 get_input('guid');
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
	
	$title = elgg_echo('video:thumbnail:edit'),

 
 $body = elgg_view_layout('content', array(
	'content' => $form,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('video/sidebar', array('page' => 'edit')),
));

echo elgg_view_page($title, $body);
