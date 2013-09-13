<?php
/**
 * Events for ELgg 1.8
 * Create a new events
 * 
 * @author Andrea Porcella / Ligne bleue Cyber
 * @link http://www.ligne-bleue-cyber.com/
 * @copyright (c) Ligne bleue Cyber 2012
 * @license GNU General Public License (GPL) version 2
 */

// ONLY LOGGED IN USERS
gatekeeper();

global $CONFIG;

// GET THE CONTAINER-GUID INFO
$container_guid= get_input('container_guid', 0);
$container = get_entity($container_guid);

	// if not container and container if not ElggUser or ElggGroup forward to home
	if (!$container || !elgg_instanceof($container)) {
		register_error(elgg_echo('noaccess'));
		forward();
	}

	
//SET PAGE OWNER
elgg_set_page_owner_guid($container_guid);

//Load specific js
elgg_load_css('css_timepicker');
elgg_load_js('timepicker');


//SET CANVAS ELEMENTS
$title = elgg_echo('events:add');


//SET CONTEXT and SIDEBAR
elgg_set_context('events');
$sidebar = elgg_view('events/sidebar');
if($container instanceof ElggGroup){
	elgg_set_context('events');
	$sidebar = '';
	elgg_push_breadcrumb($container->name, $container->getURL());
	elgg_push_breadcrumb(elgg_echo('events:group'), 'events/calendar/group-events/'.$container_guid.'/all');
}
else{
	//Set breadcrumb
	elgg_push_breadcrumb(elgg_echo('events'));
	elgg_push_breadcrumb(elgg_echo('events:owner'), 'events/calendar/your-events/');
}

elgg_push_breadcrumb($title);



//Get content
$content .= elgg_view('forms/events/add', array('container_guid'=>$container_guid));

//SET VIEW LAYOUT
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

//PRINT PAGE
echo elgg_view_page($title, $body);

?>