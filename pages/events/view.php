<?php 

// GET ENTITY GUID AND VALUE
$guid =   get_input('guid');
$object = get_entity($guid);
$title =  $object->title;


// CTRL SUBTYPE if not 'lbc_events' forward to Homepage
if(!$object || $object->getSubtype()!='events'){
	register_error(elgg_echo('noaccess'));
	forward();
}

//CTRL GROUP ACCESS
group_gatekeeper();

// CTRL CONTAINER GUID
$container_guid = $object->container_guid;
$container = get_entity($container_guid);


// SET PAGE OWNER
elgg_set_page_owner_guid($container_guid);

// SET TITLE
$title = $object->title;

//load antiscroll
elgg_load_css('css_antiscroll');
elgg_load_js('antiscroll');

//SET BREADCRUMB
if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "events/group/$container->guid/all");
	elgg_push_breadcrumb(elgg_echo('events:group'), 'events/calendar/group-events/'.$container_guid.'/all');
	
} else {
	elgg_push_breadcrumb(elgg_echo('events:toolbar'), '/events/calendar/your-events');
}
elgg_push_breadcrumb($title);


// SET CONTEXT
elgg_set_context('events');
if($container instanceof ElggGroup){
	elgg_set_context('groups');
	// change the opage owner
	    elgg_set_page_owner_guid($container_guid);
} 



// SET CANVAS ELEMENTS
$content  = elgg_view_entity($object, array('full_view' => true));
$content .= elgg_view_comments($object);


// SET VIEW LAYOUT
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('events/sidebar'),
));


// PRINT PAGE
echo elgg_view_page($title, $body);
?>