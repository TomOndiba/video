<?php
elgg_push_breadcrumb(elgg_echo('video'), 'video/all');
$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 10);
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'video',
	'limit' => $limit,
	'offset' => $offset,
	'full_view' => false,
	'list_type_toggle' => false,
));
if (!$content) {
	$content = elgg_echo('video:notfound');
}
$title = elgg_echo('video');
elgg_register_title_button();
$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'filter_override' => elgg_view('video/nav', array('selected' => 'all')),
	'content' => $content,
	'title' => $title,
));
echo elgg_view_page($title, $body);