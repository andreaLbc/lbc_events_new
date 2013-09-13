<?php 
/**
 * Actus for ELgg 1.8
 * Edit one events
 * 
 * @author Andrea Porcella / Ligne bleue Cyber
 * @link http://www.ligne-bleue-cyber.com/
 * @copyright (c) Ligne bleue Cyber 2012
 * @license GNU General Public License (GPL) version 2
 */


// ONLY LOGED IN USER
gatekeeper();

global $CONFIG;

// GET ENTITY GUID AND VALUE
$guid=get_input('guid');
$object=get_entity($guid);



// CTRL SUBTYPE if not 'events' forward to Homepage
if($object->getSubtype()!='events'){
	register_error(elgg_echo('noaccess'));
	forward();
}


// CTRL CONTAINER GUID
$container_guid = $object->container_guid;
$container = get_entity($container_guid);
set_input('container_guid', $container_guid);

// SET PAGE OWNER
 elgg_set_page_owner_guid($container_guid);


 //Load specific js
 elgg_load_css('css_timepicker');
 elgg_load_js('timepicker');
 
 //SET CANVAS ELEMENTS
 $title = elgg_echo('events:edit');
 
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
	elgg_push_breadcrumb(elgg_echo('events:toolbar'), '/events/calendar/your-events');
}
elgg_push_breadcrumb($title);
elgg_push_breadcrumb($object->title, $object->getURL());



//Set breadcrumb




	
// SET CANVAS ELEMENTS
$content = elgg_view('forms/events/add', array("entity"=>$object));


//SET VIEW LAYOUT
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' =>$sidebar,
));

//PRINT PAGE
echo elgg_view_page($title, $body);
?>