<?php
/**
 * Members navigation
 */

$tabs = array(
	'newest' => array(
		'title' => elgg_echo('events:label:your'),
		'url' => "events/calendar/your-events",
		'selected' => $vars['selected'] == 'your-events',
	),
	'online' => array(
		'title' => elgg_echo('events:label:public'),
		'url' => "events/calendar/public",
		'selected' => $vars['selected'] == 'public',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
