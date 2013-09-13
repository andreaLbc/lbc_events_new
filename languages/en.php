<?php
$english = array(
/**
 * Menu items and titles
 */
			'item:object:events' => "Events",
	        'blockmenu:events' => "Events",
			"groups:enableevents"=>"Enable groups events",
	        'events:toolbar' => "Event",			
			'events:add' => "Insert event",
			'events:owner' => "Your events",
			"events:group"=>"Group events",
		    'events:title:user_event' => '%s\'s events',
			'events:label:your' => "Your events",
			'events:label:friends' => "Events of your friends",
			'events:label:public' => "Public events",
		
			'events:access:invited'=>"Invited members",
			'events:calendar'=>'Calendar',
			'events:all' => "All events",
			'events:view' => "View events",
			'events:edit' => "Edit events",			
			'events:all_title' =>"Event",
			'events:list_title' => "Your events",
			'events:view_title' => "Your events",
			'events:edit_title' => "Edit event",
			'events:add_title' => "Insert event",	
			'events:view:type' =>"Category",
			'events:view:pays' =>"Country",
			'events:view:rubrique' =>"Heading",
			'events:view:theme' =>"Theme",						
			'events:view:title' => "Event title",
			'events:view:description' => "Event text",
			'events:view:lieu' =>"Place",
			'events:view:datedebut' =>"Start date",
			'events:view:datefin' =>"End date",
			'events:view:heuredebut' =>"Start time",		
			'events:view:heurefin' =>"End time",	
			'events:view:url' =>"Links",
			'events:view:files' =>"Files",
			'events:view:tags' =>"Tags",

		
			'events:formAdd:type' =>"Category *",
			'events:formAdd:pays' =>"Country *",
			'events:formAdd:rubrique' =>"Heading *",
			'events:formAdd:theme' =>"Theme *",						
			'events:formAdd:title' => "Event title *",
			"events:formAdd:excerpt"=>'Event Excerpt',
			'events:formAdd:description' => "Event text *",
			'events:formAdd:lieu' =>"Place ",
			'events:formAdd:datedebut' =>"Start date *",
			'events:formAdd:datefin' =>"End date *",
			'events:formAdd:heuredebut' =>"Start time *",		
			'events:formAdd:heurefin' =>"End time *",
			"events:formAdd:heurefin:view" =>"End time",
			"events:formAdd:heuredebut:view" =>"Start time",		
            'events:formAdd:url' =>"Link",		
			'events:formAdd:uploadFile' =>  "Upload file",
			'events:formAdd:uploadImage' => "Upload image",
			'events:formAdd:tags' =>"Tags",
	        'events:formAdd:access' =>"Access",
			"events:edit:succes"=>"Your event was successfully saved",
			"events:edit:notsucces"=>"Your event was not correctly saved. Please contact your administrator",	
			"events:delete:confirm"=>"Are you sure you want to delete this event?",
			"events:delete:succes"=>'Your event was successfully deleted',
	        "events:delete:notsucces"=>'Your event cannot be deleted at this time. Please contact your administrator',
	        'events:error:values' =>"Error! Check that all required (*) fields are correctly completed",
			'events:river:create' => "%s has updated a page entitled",
			'events:river:update' => "%s has updated a page entitled",
			'events:river:annotate' => "a comment on the event",
			"events:river:annotate" => "a comment on the event",
			"events:actusevenement"=>"News and events",
			"events:formAdd:uploadFileNew" => "Load another file",
			"events:suite" =>"Access the event",
			"events:invited:title"=>"Your invitations to events",
			"events:invited:confirmed" =>"(%s) will take part",
			"events:invited:peut-etre" =>"(%s) may or may not take part",
			"events:invited:attente" =>"(%s) awaiting answer",
			"events:invite:title"=>"Do you take part in this event?",
			"events:invite:confirm"=>"Yes",
			"events:invite:peut-etre"=>"Perhaps",
			"events:invite:refuse"=>"No",
			"events:invite:confirm:confirm"=>"Are you sure you will take part?",
			"events:invite:peut-etre:confirm"=>"Are you sur you may or may not take part?",
			"events:invite:refuse:confirm"=>"Are you sure you will not take part?",
			"events:jeparticipe"=>"I participate",
			

/**
 * notification messages
 */

			"events:new" => "Go to Sinacs",		

	
			"evenement:new:message" => 
"%s %s

has registerd a new event in its diary.
\"%s\" aura lieu le \"%s\".

Click here for more details about the event: %s

To keanr more, go to Sinacs.fr" ,

"events:invitation:message" => 
"%s %s

Sinacs.org invites you to the event \" %s \" to be held in the %s %s. 

Click here to get more details on this event: %s 

For more information, visit Sinacs.org." ,
			"events:invitation:subject" => "Invitation à l'événement %s du Sinacs.fr",
		
		
			// INVITE //
		    "events:invite:friends"=>"Invite friends",
			"events:invite:allfriends"=>"Invite all friends",
			"events:invite:groups_member"=>"Invite groups / members",
			"events:invite:all"=>"Invite all members",
			"events:invite:groups"=>"Groups",
			"events:invite:members"=>"Invite the memeber",
		
			'Jan' => "Jan",
			'Feb' => "Feb",
			'Mar' => "Mar",
			'Apr' => "Apr",
			'May' => "May",
			'Jun' => "Jun",
			'Jul' => "Jul",
			'Aug' => "Aug",
			'Sep' => "Sep",
			'Oct' => "Oct",
			'Nov' => "Nov",
			'Dec' => "Dec",
		
);
add_translation("en",$english);