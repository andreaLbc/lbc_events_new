<?php
action_gatekeeper();

global $CONFIG;

$guid=get_input("guid");
$handler = get_input("handler");
$user=$_SESSION['user']->getGUID();



//REMOVE OLD REPONSE
remove_entity_relationship($user, "confirmed_to_events", $guid);
remove_entity_relationship($user, "refused_to_events", $guid);
remove_entity_relationship($user, "peutetre_to_events", $guid);
remove_entity_relationship($user, "indecide_to_events", $guid);

if(!add_entity_relationship($user, "peutetre_to_events", $guid)){
	$error=true;
}


if(!$error){
		//system_message("<br>".$mess.elgg_echo('b_evenement:invite:succes'));	
}
else{
		register_error($mess.elgg_echo('error'));	
}

forward($handler."/view/".$guid);
