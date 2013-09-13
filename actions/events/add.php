<?php 

action_gatekeeper();
global $CONFIG;

//echo '<pre>'; print_r($_POST); echo'</pre>';
//die();

// GET LOGGEDIN USER ENTITY
$lg_user = elgg_get_logged_in_user_entity();




//GET THE VALUE FROM FORM
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
$container_guid = get_input('container_guid', 0);
$ctrl_group = get_input('ctrl_group', null);
$embedvideo=get_input('embedvideo');
$comments=get_input('comments', null);
$invited_all = get_input("ctrl_all", null);
$invited=$_POST['invited'];;

$container= get_entity($container_guid);

if(is_array($invited)){
	$invited=serialize($invited);
} 
else {
	$arrayinvited=array();
	$arrayinvited[0]=$invited;
	$invited=serialize($arrayinvited);
}

$invited_groups=$_POST['invited_groups'];
$isgroupinvited = false;

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

// SET PUBLIC ON
$public = "A";


//SET LANGUAGE VALUE AND METAVALUE
$metatitle='title'; 
$metadescription='description';
$metaexcerpt='excerpt';
$metalieu='lieu';
$metatags='tags';

//CONVERT TAGS VALUE IN ONE PREFORMATTED ARRAY
$tagarray = string_to_tag_array($tags);

//SET THE ERROR CONTROLL
$error='';

//CONTROLL THE REQUIRED VALUE
if($title==null || $description==null ||  $datedebut==null || $datefin==null){
	$error=1;
}

    
//ADD NEW OBJECT    
if (!$error){	
	
	$addAction= new ElggObject();
	$addAction->subtype="events";
	$addAction->$metatitle=$title;
	$addAction->$metadescription=$description;
	$addAction->$metaexcerpt=$excerpt;
	$addAction->$metalieu=$lieu;
	$addAction->datedebut=$datedebut;
	$addAction->datefin=$datefin;
	$addAction->heuredebut=$heuredebut;
	$addAction->heurefin=$heurefin;
	$addAction->url=$url;
	$addAction->ctrl_group=$ctrl_group;
	$addAction->invited_all=$invited_all;
	$addAction->invited=$invited;
	$addAction->invited_groups=$invited_groups;
	$addAction->embedvideo=$embedvideo;
	if($date){$addAction->ctrl_date=$date;}
	if($public){$addAction->public=$public;}
	if($comments){$addAction->comments=$comments;}
	
	if (is_array($tagarray)){$addAction->tags = $tagarray;}
	$addAction->access_id=$access_id;
	$addAction->owner_guid= $lg_user->guid;
	$addAction->container_guid=$container_guid;
	
	//SAVE
	$newGuid=$addAction->save();
	
	// ADD OWNER ON LIST OF INVITED
	add_entity_relationship($lg_user->guid, "invite_to_events", $newGuid);
	add_entity_relationship($lg_user->guid, "confirmed_to_events", $newGuid);
	
	
	if($access_id!=0){
		if($invited_all != "A"){
				//NEW RELATIONSCHIP
				
			   // SEARCH MEMBERS OF SELECTED GROUPS
			   if($isgroupinvited){
					$invited_groups=unserialize($invited_groups);
					$grMb = array();
	    			foreach($invited_groups as $gr){
	    				//$group=get_entity($gr);
	    				$count = get_group_members($gr, 999, 0, 0, true);
	    				$groupmembers = get_group_members($gr, $count, 0, 0, false);
	    				foreach ($groupmembers as $groupmember){
			            	$grMb[$groupmember->guid]=$groupmember->guid;
			            }
	    			}	
				}
				
				// SEARCH USERS HAS INVITED
				$invited=unserialize($invited);
				
				// MERGE MEMBER OF GROUPS AND INViTED
				if($isgroupinvited){	  
	    			$invited= array_merge($invited, $grMb);
	    		}
	    		
	    		
				
	    		//SET INVITATIONS
				foreach ($invited as $k=>$v){
						
						//ADD RELANTIONCHIPS
						add_entity_relationship($v, "invite_to_events", $newGuid);
						add_entity_relationship($v, "indecide_to_events", $newGuid);
					  	
						//SEND NOTIFICATIONS
		        		if ($addAction->public=="A"){
		        
			            	$datedebut = events_date_from_timestamp ($addAction->datedebut);
			    			$to_entity = get_entity($v);
			  				$descr = $addAction->description;
			  				$owner = $addAction->getOwnerEntity();
			  				$title = $addAction->title;
			  	       		
				
				        	$message = sprintf(elgg_echo('events:invitation:message'),ucfirst($to_entity->prenom),ucfirst($to_entity->name),$title,$lieu,$datedebut,$addAction->getURL());
				        	$subject = sprintf(elgg_echo('events:invitation:subject'),$title);
				        	
				        	if (!check_entity_relationship($v, "invitationsent", $newGuid)){
					              notify_user($v, $CONFIG->site->guid, $subject, $message);
					              add_entity_relationship($v, "invitationsent", $newGuid);
			            	}		
				    	}
				}
		}
		else {
				
				// IF INVITED ALL USERS
				
				if ($container instanceof ElggGroup){
					$allUser  = $container->getMembers(2000);
				}
				else{
					if(is_manager()){
						$all=array();
						$options = array(
								'types'=>'user',
								'limit'=>2000
						);
						
						// SET LIMIT OF QUERY
						$countusers = elgg_get_entities(array_merge($options,array('count'=>true)));
						$allUser  = elgg_get_entities(array_merge($options,array('limit'=>$countusers)));
					}
					else{
						$allUser = $lg_user->getFriends();
					}
					
				}
				
				foreach($allUser as $entity){
					    if($entity->guid!=$lg_user->guid){
							//ADD RELANTIONCHIPS
							add_entity_relationship($entity->guid, "invite_to_events", $newGuid);
						    add_entity_relationship($entity->guid, "indecide_to_events", $newGuid);
							
						    $allInvited[$entity->guid] = $entity->guid;
						    
		  					//SEND NOTIFICATIONS
		  					if ($addAction->public=="A"){
		  					    
		  						$datedebut = events_date_from_timestamp($addAction->datedebut);
		      					$descr = $addAction->description;
								$title = $addAction->title;
				      	       	$message = sprintf(elgg_echo('events:invitation:message'),ucfirst($entity->prenom),ucfirst($entity->name),$title,$lieu,$datedebut,$addAction->getURL());
				             	$subject = sprintf(elgg_echo('events:invitation:subject'),$title);
				             	
				             	if (!check_entity_relationship($entity->guid, "invitationsent", $newGuid)){
				                  notify_user($entity->guid, $CONFIG->site->guid, $subject, $message);
				                  add_entity_relationship($entity->guid, "invitationsent", $newGuid);
				                }			
							}
					    }
				}
			    
			    //REGISTER INVITED ARRAY
			    $addAction->invited = serialize($allInvited);
			    $addAction->save();
		}
	}
	if(!$newGuid){$error = 2;}
}


		
//SET FILES AND OBJECT LANGUAGE FOR NEW INSERT
if(!$error){
	//add_to_river('river/object/events','create',$_SESSION['user']->guid, $newGuid, "");
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
		forward("events/calendar/group-events/".$container_guid."/all");
	}
	else{
		forward("events/calendar/your-events");
	}
}	
?>