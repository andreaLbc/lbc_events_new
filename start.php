<?php 
/**
 * Events for ELgg 1.8
 *
 * @author Andrea Porcella / Ligne bleue Cyber
 * @link http://www.ligne-bleue-cyber.com/
 * @copyright (c) Ligne bleue Cyber 2013
 * @license GNU General Public License (GPL) version 2
 */


// INITIALIZE THE PMMUGIN
elgg_register_event_handler('init','system', 'events_init'); 


function events_init(){
	
	// READ THE CONFIG
	global $CONFIG;
	
	// REGISTER THE URL HANDLER FOR OBJECT events
	elgg_register_entity_url_handler('object', 'events', 'events_url_handler');
	
	// REGISTER THE PAGE HANDLER (manage the url for plugin);
	elgg_register_page_handler('events', 'events_page_handler');
	
	// REGISTER OBJECT
	elgg_register_entity_type('object', 'events');
	
	// REGISTER TRANSLATION
	register_translations($CONFIG->pluginspath . "lbc_events/languages/", true);
	
	// REGISTER ACTION
	$action_base = elgg_get_plugins_path() . 'lbc_events/actions/events';
	elgg_register_action("events/add", "$action_base/add.php");
	elgg_register_action("events/edit", "$action_base/edit.php");
	elgg_register_action("events/delete", "$action_base/delete.php");
	
	elgg_register_action("events/confirm", "$action_base/invite_confirm.php");
	elgg_register_action("events/peutetre", "$action_base/invite_peutetre.php");
	elgg_register_action("events/refuse", "$action_base/invite_refuse.php");
	
	// EXTEND THE CSS FILE
	elgg_extend_view('css/elgg', 'css/plugins/events/css');
	
	// SET MENUS FOR PLUGINS ON PAGE
	elgg_register_event_handler('pagesetup', 'system', 'events_page_menu');
		
	
	// SET MENU FOR USER OWNER BLOCK
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'events_owner_block_menu');
	
	
	//GROUP OPTION
	// add the group files tool option
	add_group_tool_option('events', elgg_echo('groups:enableevents'), true);
	
	// extend group main page
	elgg_extend_view('groups/tool_latest', 'events/group_module');
	
	
	//REGISTER CSS AND JS
	$js_events  = 'mod/lbc_events/vendors/plugins/events.js';
	elgg_register_js('events', $js_events);
	
		
}


/**
 * Add a menu item to the user ownerblock
 */
function events_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "events/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('events', elgg_echo('item:object:events'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->events_enable != "no") {
			$url = "events/calendar/group-events/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('events', elgg_echo('events:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}


// MENU
function events_page_menu(){
	
	// SET MENU ON TOP MENU NAVIGATION
	if(elgg_is_logged_in()){
		$item = new ElggMenuItem('events', elgg_echo('item:object:events'), 'events/calendar/your-events');
	}
	else{
		$item = new ElggMenuItem('events', elgg_echo('item:object:events'), 'events/calendar/all');
	}
	elgg_register_menu_item('site', $item);
	
	$context = elgg_get_context();
	$owner = elgg_get_page_owner_entity();
	
	//elgg_dump('Context : '.$context);
	//elgg_dump('Owner guid : '.$owner_guid->guid);
	
	if($owner instanceof ElggGroup){
		$owner_guid = $owner->guid;
	}
	else{
		$owner_guid = elgg_get_logged_in_user_entity()->username;
	}
	
	//elgg_dump('Owner guid : '.$owner_guid);
	//SET MENU ON SIDE BAR
	if(elgg_is_admin_logged_in() || is_manager()){
		
		
		elgg_register_menu_item('page', 
			array(
				'name' => 'events-1',
				'text' => elgg_echo('events:all'),
				'href' => 'events/all',
				'contexts' => array('events'),
				'section' => 'events',
				'title ' => elgg_echo('events:all'),
				'parent_name'=>"events",
			)
		);
		
		elgg_register_menu_item('page', 
			array(
				'name' => 'events-2',
				'text' => elgg_echo('events:owner'),
				'href' => $ownerlink,
				'contexts' => array('events'),
				'section' => 'events',
				'parent_name'=>"events",
				'title ' => elgg_echo('events:owner'),
			)
		);
	}

} 


// SET THE URL ON ELGG STANDARD STRUCTURE
function events_page_handler($page){
	
	$plugin_path= elgg_get_plugins_path();
	$base_path = $plugin_path . 'lbc_events/pages/events';

	if(!is_null($page)){
		
		switch($page[0]){
			case "add": 
				set_input('container_guid', $page[1]);
				include("$base_path/add.php"); 
				return true;
		    break;
			
		    case "edit": 
		    	set_input('guid', $page[1]); 
		    	include("$base_path/edit.php");
		    	return true;
			break;
		    
		    case "calendar":
		    	switch($page[1]){
		    		case "your-events":
		    		case "friends":
		    		case "owner":
		    		case "all":
		    		case "public":
		    			$vars = array();
		    			$vars['page'] = $page[1];
		    			include("$base_path/index.php");
		    			return true;
		    			break;
		    		case "group-events":
		    			set_input('owner', $page[2]);
		    			include("$base_path/group.php");
		    			return true;
		    			break;
		    				
		    	}
		    	return true;
		    	break;
		    	
		   case "view":
				elgg_load_js('events');
				set_input('guid',  $page[1]);
				set_input('title', $page[2]);
				include("$base_path/view.php"); 
				return true;
		   break;
		   
		   case 'download-ics':
		   		set_input('guid', $page[1]);
		   		include("$base_path/download.php");
		   		return true;
		   break;
		}
	}
}


// SET THE OBJECT URL HANDLER ON ELGG STANDARD STRUCTURE
function events_url_handler($object){
		global $CONFIG;
		$title = $object->title;
		$title = elgg_get_friendly_title($title);
		
		return $CONFIG->url . "events/view/". $object->getGUID() . "/".$title;
}


function events_timestamp_from_date($date, $hour=0, $minute=0, $second=0){
	
	$ctrlDate=explode('/', $date);
	if(count($ctrlDate)!=0){
		$b_time=mktime($hour, $minute, $second, $ctrlDate[1], $ctrlDate[0], $ctrlDate[2]);
	}
	else{$b_time==null;}
	
	return $b_time;

}

function events_date_from_timestamp($timestamp){
	
	if($timestamp){$b_date=date("d.m.Y", $timestamp);}
	return $b_date;

}

?>