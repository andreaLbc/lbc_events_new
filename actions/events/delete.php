<?php 
	action_gatekeeper();// gestisco il token
	
	//SHOW HIDDEN ENTITY
	$access_status = access_get_show_hidden_status(); //Recuperare lo statuto che impedisce di vedere gli oggetti disabilitati
	access_show_hidden_entities(true); //rendo possibile la visualizzione degli oggetti disabilitati
	
	
	//GET VALUE FROM FORM
	$guid=get_input('guid');
	$object=get_entity($guid);
	
	
	
	//DELETE ENTITY AND SET THE SYSTEM MESSAGE
	if(delete_entity($guid)){
		system_message(elgg_echo('events:delete:succes'));
	}
	else{
		system_message(elgg_echo('events:delete:notsucces'));
	}
	
	access_show_hidden_entities($access_status); //riristino l'impossibilita di vedere gli oggetti disable
	
	if(!$object->getContainerEntity() instanceof ElggGroup){
		forward("events/calendar/your-events");
	}
	else{
		forward("events/calendar/group-events/".$container_guid."/".elgg_get_friendly_title( $owner->name));
	}
?>