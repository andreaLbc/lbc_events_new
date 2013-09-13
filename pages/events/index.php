<?php
/**
 * Events index
*
*/

// GET THE NUMBER OF EVENTS
//$num_members = get_number_events('public');
//$num_members = get_number_users('yours');
//$num_members = get_number_users('friends');

$title = elgg_echo('item:object:events');

// SET THE ADD MENU
elgg_register_title_button('events');

// SET PAGE OWNER
elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

//SET CONTEXT
elgg_set_context('events');


$order = array('order_by_metadata' => array('name'=>'datedebut', 'direction' => 'DESC', 'as' => 'integer'));
switch ($vars['page']) {
	case 'your-events':
		
		$options = array(
				'relationship' => 'invite_to_events',
				'relationship_guid' => elgg_get_logged_in_user_guid(),
				'inverse_relationship' => false,
				'full_view' => false
		);
		$options = array_merge($options, $order);
		$content = elgg_list_entities_from_relationship($options);
		break;
	
	case 'friends':
		$content = get_online_users();
		break;

	case 'public':
	default:
		$options = array('type' => 'object', 'subtype'=>"events", 'limit'=>'30', 'full_view' => false, 'metadata_name_value_pairs'=>array('name'=>'$public' , 'value'=>'A'));
		$options = array_merge($options, $order);
		$options = array_merge($options);
		$content = elgg_list_entities_from_metadata($options);
		
		break;
}

$params = array(
		'content' => $content,
		'sidebar' => elgg_view('events/sidebar'),
		'title' => $title . " ($num_members)",
		'filter_override' => elgg_view('events/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
