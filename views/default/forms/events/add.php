<?php 
/**
 * Actus for ELgg 1.8
 * Form for create and edit the acuts
 *
 * @author Andrea Porcella / Ligne bleue Cyber
 * @link http://www.ligne-bleue-cyber.com/
 * @copyright (c) Ligne bleue Cyber 2012
 * @license GNU General Public License (GPL) version 2
 */

global $CONFIG;

//GET CONTAINER GUID
$container_guid = get_input('container_guid', elgg_get_page_owner_guid());

$owner = get_entity($container_guid);
if($owner instanceof ElggGroup){
	$accDef = array(
			ACCESS_PRIVATE => elgg_echo("PRIVATE"),
			$owner->group_acl => elgg_echo("events:access:invited")
	);
	
}
else{
	$accDef = array(
			ACCESS_PRIVATE => elgg_echo("PRIVATE"),
			ACCESS_LOGGED_IN => elgg_echo("events:access:invited"),
	);
	
	if(!is_manager()){
		$accDef = array(
				ACCESS_PRIVATE => elgg_echo("PRIVATE"),
				ACCESS_FRIENDS => elgg_echo("events:access:invited"),
		);
	}
		$accesPublic = ACCESS_FRIENDS;
}

//GET SETTING FOR LANGUAGE
$setting = $CONFIG->multilanguages;

if(isset($vars['entity'])){
 	
	//GET THE VALUE FROM FORM
 	$guid=$vars['entity']->getGUID();
 	//$typeventss=$vars['entity']->typeventss;
 	$title=$vars['entity']->title;
 	$description=$vars['entity']->description;
 	$excerpt = $vars['entity']->excerpt;
 	$lieu=$vars['entity']->lieu;
 	$datedebut=b_date_from_timestamp($vars['entity']->datedebut);
 	$datefin=  b_date_from_timestamp($vars['entity']->datefin);
 	
 	$datedebut=str_replace('.', '/',$datedebut);
 	$datefin=  str_replace('.', '/',$datefin);
 	
 	$heuredebut=$vars['entity']->heuredebut;
 	$heurefin=$vars['entity']->heurefin;
 	$url=$vars['entity']->url;
 	$file=$vars['entity']->file_all;
 	$img=$vars['entity']->img_or;
  	$tags=$vars['entity']->tags;
  	$access_id=$vars['entity']->access_id;
	
  	$comments = $vars['entity']->comments;
	$public = $vars['entity']->public;
 	$date = $vars['entity']->ctrl_date;
 	$container_guid=$vars['entity']->container_guid;
 	
	$ctrl_group=$vars['entity']->ctrl_group;
	$ctrl_all=$vars['entity']->invited_all;
	
	if($vars['entity']->invited){$invited=unserialize($vars['entity']->invited);}
	if($vars['entity']->invited_groups){$invited_groups=unserialize($vars['entity']->invited_groups);}
	
	//SET ACTION
  	$action=$vars['url']. "action/events/edit";
 	$edit=true;
}
    
else{
	$action=$vars['url']. "action/events/add";
 	$container_guid=$vars['container_guid'];
}


// PREPARE THE FORM BODY
$form_body .= '<div class="block_form">';
$form_body .= '<label>'.elgg_echo('comments').'</label> ';
$form_body .= elgg_view('input/dropdown', array(
		'name' => 'comments',
		'id' => 'comments',
		'value' => $comments,
		'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));
$form_body .= '</div>';


$form_body .= '<div class="block_form">';
$form_body .= '<label>'. elgg_echo('status').'</label> ';
$form_body .=  elgg_view('input/dropdown', array(
		'name' => 'access_id',
		'id' => 'status',
		'value' => $access_id,
		'options_values' => $accDef
));
$form_body .= '</div>';

$form_body  .= '<div class="block_form">';
	$form_body .=  elgg_view('input/categories', $vars);
$form_body .= '</div>';


$form_body  .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:title').'</label>';			
	$form_body .= elgg_view('input/text', array( "name"=>"title", "value"=>$title, "classValidate"=>"validate[required] text-input"));
$form_body .= '</div>';

$form_body  .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:excerpt').'</label>';
	$form_body .= elgg_view('input/plaintext', array( "name"=>"excerpt", "value"=>$excerpt, "classValidate"=>"validate[required] text-input"));
$form_body .= '</div>';

$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:description').'</label>';
	$form_body .= elgg_view('input/longtext', array( "name"=>"description", "value"=>$description, "classValidate"=>"validate[required] text-input"));
$form_body .= '</div>';

$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:lieu').'</label>';
	$form_body .= elgg_view('input/text', array( "name"=>"lieu", "value"=>$lieu, "classValidate"=>"validate[required] text-input"));
$form_body .= '</div>';


$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:datedebut').'</label><br/>';
	$form_body .= elgg_view('input/timepicker', array( 
					"name_date"=>"datedebut",  
					"name_time"=>"heuredebut", 
					"style_time"=>"width:220px", 
					"style_date"=>"width:220px",
					"value_date"=>$datedebut,
			        "value_time"=>$heuredebut
				  ));
$form_body .= '</div>';

$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:datefin').'</label><br/>';
	$form_body .= elgg_view('input/timepicker', array( 
					"name_date"=>"datefin",
					"name_time"=>"heurefin",
					"style_time"=>"width:220px",
					"style_date"=>"width:220px",
					"value_date"=>$datefin,
					"value_time"=>$heurefin
					));
$form_body .= '</div>';

$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('events:formAdd:url').'</label>';
	$form_body .= elgg_view('input/text', array( "name"=>"url", "value"=>$url));
$form_body .= '</div>';


$form_body .= '<div class="block_form">';
	$form_body .= '<label>'.elgg_echo('tags').'</label>';
	$form_body .=  elgg_view('input/tags', array( "name"=>"tags", "value"=>$tags,  "classValidate"=>"validate[custom[tags]] text-input"));
$form_body .= '</div>';


$form_body .= '<div class="block_form">';
	$form_body .= elgg_view('input/invite', array("invited"=>$invited, "invited_groups"=>$invited_groups, "ctrl_all"=>$ctrl_all));
$form_body .= '</div>';


$form_body .= elgg_view('input/hidden', array("name"=>"container_guid",  "value"=>$container_guid));

$form_body .= elgg_view('input/submit', array("value"=>elgg_echo("save")));

if($edit){
	$form_body .= elgg_view('input/hidden', array("name"=>"guid",  "value"=>$vars['entity']->getGUID()));
}

// PRINT THE FORM
echo elgg_view('input/form', array("action"=>$action, "body"=>$form_body));
?>