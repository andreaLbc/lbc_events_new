<?php
/**
 * Group pages
 *
 * @package ElggPages
 */

$group = elgg_get_page_owner_entity();

if ($group->events_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "events/calendar/group-events/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));


elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'events',
	'limit' => 3,
	'full_view' => false,
	'pagination' => false,
	'container_guid'=>$group->guid
);
$content = elgg_list_entities_from_metadata($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('pages:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "events/add/$group->guid",
	'text' => elgg_echo('events:add'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('events:group'),
	'content' => $content, 
	'all_link' => $all_link,
	'add_link' => $new_link,
));
