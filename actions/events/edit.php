<?php 
action_gatekeeper();
global $CONFIG;

//echo '<pre>'; print_r($_POST); echo"</pre>";
//die('pippo');

// GET LOGGEDIN USER ENTITY
$lg_user = elgg_get_logged_in_user_entity();

//GET VALUE FROM FORM
$guid= get_input('guid', 0);
$container_guid = get_input('container_guid');
$title=get_input('title');
$description=$_POST['description'];
$excerpt = get_input('excerpt');
$lieu=get_input('lieu');
$datedebut=  events_timestamp_from_date(get_input('datedebut'));
$datefin  =  events_timestamp_from_date(get_input('datefin'));
$heuredebut=get_input('heuredebut');
$heurefin=get_input('heurefin');
$url=get_input('url');
$tags=get_input('tags');
$access_id=get_input('access_id');
$lang = get_input('lang');

$embedvideo=get_input('embedvideo');

$comments=get_input('comments', null);
$public= get_input('public', "A");
$invited_all = get_input("ctrl_all", null);


//SET CONTAINER ENTITY
$container = get_entity($container_guid);

$invited=$_POST['invited'];
if(is_array($invited)){
	$invited=serialize($invited);
} else {
	$arrayinvited=array();
	$arrayinvited[0]=$invited;
	$invited=serialize($arrayinvited);
}
$isgroupinvited = false;
$invited_groups=$_POST['invited_groups'];
if(is_array($invited_groups)){
	$invited_groups=serialize($invited_groups);
	$isgroupinvited = true;
}
$ctrl_date= get_input('ctrl_date');

if (!empty($ctrl_date)){
	$date=   events_timestamp_from_date(get_input('ctrl_date'));
	$dateS=mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	if($date>$dateS){$public="N";}
}


//CONVERT TAGS VALUE IN ONE PREFORMATTED ARRAY
$tagarray = string_to_tag_array($tags);


//SET THE ERROR CONTROLL
$error='';


//CONTROLL THE REQUIRED VALUE
if ($title==null || $description==null ||  $datedebut==null || 
    $datefin==null){	
    $error=1;
}

//SET LANGUAGE VALUE AND METAVALUE
$metatitle='title';
$metadescription='description';
$metaexcerpt='excerpt';
$metalieu='lieu';
$metatags='tags';


//EDIT ENTITY
if (!$error){
	//SHOW HIDDEN ENTITY
	enable_entity($guid);
	
	$editAction=get_entity($guid);
	$old_invited=$editAction->invited;
	$old_invited_groups=$editAction->invited_groups;
	$editAction->$metatitle=$title;
	$editAction->$metadescription=$description;
	$editAction->$metaexcerpt=$excerpt;
	$editAction->$metalieu=$lieu;
	$editAction->datedebut=$datedebut;
	$editAction->datefin=$datefin;
	$editAction->heuredebut=$heuredebut;
	$editAction->heurefin=$heurefin;
	$editAction->url=$url;
	$editAction->embedvideo=$embedvideo;
	$editAction->ctrl_date=$date;
	$editAction->public=$public;
	$editAction->comments=$comments;
	$editAction->invited_all=$invited_all;
	$editAction->invited=$invited;
	$editAction->invited_groups=$invited_groups;
	
	if (is_array($tagarray)){$editAction->$metatags = $tagarray;}
	$editAction->access_id=$access_id;
	
	
	
	
	//SAVE EDIT
	if(is_null($editAction->save())){
		$error=2;
		
	}
	else if($access_id!=0){

		
		//GET OLD RELATIONSCHIP
			
        $options = array(
    		'relationship' => "invite_to_events",
    		'relationship_guid' => $guid,
    		'inverse_relationship' => true
    	);
    	$count = elgg_get_entities_from_relationship(array_merge($options,array('count' => true)));
	    $entities = elgg_get_entities_from_relationship(array_merge($options,array('limit' => $count)));

	   
	    	$entities_guids = array();
	    	
			foreach ($entities as $entity){
				$entities_guids[] = $entity->guid;
				remove_entity_relationship($entity->guid, "invite_to_events", $guid);
				remove_entity_relationship($entity->guid, "indecide_to_events", $guid);
			}
		    
			//REGISTER OWNER ON EVENTS
			add_entity_relationship($editAction->owner_guid, "confirmed_to_events", $guid);
			add_entity_relationship($editAction->owner_guid, "invite_to_events", $guid);
			
			
			
			//NEW RELATIONSCHIP
			if($invited_all != "A"){
				if($isgroupinvited){
			   		$invited_groups=unserialize($invited_groups);
					$grMb = array();
    				foreach($invited_groups as $gr){		
    					$count = count(get_group_members($gr, 999));
    					//die('count '.$count);
    					$groupmembers = get_group_members($gr, $count, 0, 0, false);
    					foreach ($groupmembers as $groupmember){
            				$grMb[$groupmember->guid]=$groupmember->guid;
            			}
    				}	
				}
				$invited = unserialize($invited);
				
				if($isgroupinvited){	  
    				$invited= array_merge($invited, $grMb);
    			}
		  
				foreach ($invited as $k=>$v){
				
					if($v!=''){
						
						//echo "Guid invited ->".$v." ->".$guid;
						if(add_entity_relationship($v, "invite_to_events", $guid)){
							//echo '  Ok invite_to_events ->';
						}else{ 
							//echo 'Error! invite_to_events ->';
						}
						if(add_entity_relationship($v, "indecide_to_events", $guid)){
							//echo 'Ok indecide_to_events ';
						}else{ 
							//echo 'Error! indecide_to_events ->';
						}
						
						//send notification
						if ($editAction->public=="A"){
			            	if (!(in_array($v,$entities_guids))){
				                $datedebut = events_date_from_timestamp ($editAction->datedebut);
				                $to_entity = get_entity($v);
				      				
				      			$descr = $editAction->description;
				      			$title = $editAction->title;
								$message = sprintf(elgg_echo('events:invitation:message'),ucfirst($to_entity->prenom),ucfirst($to_entity->name),$title,$lieu,$datedebut,$editAction->getURL());
				    	       	$subject = sprintf(elgg_echo('events:invitation:subject'),$title);
				    	       	//notify_user($v, $CONFIG->site->guid, $subject, $message);
				      	       	if (!check_entity_relationship($v, "invitationsent", $guid)){
				                  	//notify_user($v, $CONFIG->site->guid, $subject, $message);
				                  	add_entity_relationship($v, "invitationsent", $guid);
				                }
			               	}
		        		}	
					}
				}
		} else {
    
			
				$container= get_entity($container_guid);
				
				
				if ($container instanceof ElggGroup){
					$allUser = $container->getMembers(999);
				}
				else{
				if(is_manager()){
						$all=array();
						$options = array(
								'types'=>'user',
								'limit'=>999
						);
						$countusers = elgg_get_entities(array_merge($options,array('count'=>true)));
						$allUser  = elgg_get_entities(array_merge($options,array('limit'=>$countusers)));
					}
					else{
						$allUser = $lg_user->getFriends();
					}
				}			
                
				
				foreach($allUser as $entity){
					
					if($entity->guid!=$lg_user->guid){
						add_entity_relationship($entity->guid, "invite_to_events", $guid);
						add_entity_relationship($entity->guid, "indecide_to_events", $guid);
						
						$allInvited[$entity->guid] = $entity->guid;
						
	  					//send a notification
	  					 if ($editAction->public=="A"){
	      					if (!in_array($entity->guid,$entities_guids)){
	      						$datedebut = events_date_from_timestamp ($editAction->datedebut);
	    						$descr = $editAction->description;
	    						$title = $editAction->title;   		
	    						$message = sprintf(elgg_echo('events:invitation:message'),ucfirst($entity->prenom),ucfirst($entity->name),$title,$lieu,$datedebut,$editAction->getURL());
	           	  				$subject = sprintf(elgg_echo('events:invitation:subject'),$title);
	           	  				//notify_user($entity->guid, $CONFIG->site->guid, $subject, $message);
				                if (!check_entity_relationship($entity->guid, "invitationsent", $guid)){
				               		//notify_user($entity->guid, $CONFIG->site->guid, $subject, $message);
				                	add_entity_relationship($entity->guid, "invitationsent", $guid);
				                }		
	    					}
	    				 }
    				}
				}
				
				//REGISTER INVITED ARRAY
				$editAction->invited = serialize($allInvited);
				$editAction->save();
    	}
		
    	
    	
		$ctrl_group=$editAction->ctrl_group;	
		/*if($public!="A"){
			disable_entity($guid, "not_public");
		}*/
	}
	
}



//CONTROLL ERROR AND SET THE SYSTEM MESSAGE
if($error==1){
	register_error(elgg_echo('events:error:values'));
    forward("events/add");
}
else if($error==2){
  	register_error(elgg_echo('events:edit:notsucces'));
	forward("events/add");
}
else{
	system_message(elgg_echo('events:edit:succes'));
	
	if($container instanceof ElggGroup){
		forward("events/calendar/group-events/".$container_guid."/".elgg_get_friendly_title( $owner->name));
	}
	else{
		forward("events/calendar/your-events");
	}
	
}
?>