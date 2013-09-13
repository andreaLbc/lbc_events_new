<?php
$entity=elgg_extract('entity', $vars, '');
$handler='events';
$user=$user=$_SESSION['user']->getGUID();

if($entity->invited_all){$ctrl_all=$entity->invited_all;}
if($entity->invited){$invited=unserialize($entity->invited);}
if($entity->invited_groups){$invited_groups=unserialize($entity->invited_groups);}
if($entity->confirmed){$confirmed=unserialize($entity->confirmed);}
if($entity->peutetre){$peutetre=unserialize($entity->peutetre);}
if($entity->refused){$refused=unserialize($entity->refused);}

if(is_array($invited_groups)){
	foreach($invited_groups as $gr){		
		$group=get_entity($gr);
		$member=$group->getMembers(999);
	}
}
		
if(isset($member) && is_array($member)){
	foreach($member as $mb){
		$grMb[$mb->guid]=$mb->guid;
	}
}

if(isset($grMb) && is_array($grMb)){
	$invited= array_diff($invited, $grMb);
	$invited= array_merge($invited, $grMb);
}
		
if(isset($invited) && is_array($invited)){$indecide=$invited;}
if(isset($confirmed) && is_array($confirmed)){$indecide=array_diff($invited,$confirmed);}
if(isset($peutetre) && is_array($peutetre)){$indecide=array_diff($indecide,$peutetre);}
if(isset($refused) && is_array($refused)){$indecide=array_diff($indecide,$refused);}


if(in_array($user, $invited) || isset($ctrl_all)){
	$ctrlmenu=true;
}
else if(!in_array($user, $invited)){$ctrlmenu=false;}

if(in_array($user, $confirmed)){$active1="active";} else{$active1="";}
if(in_array($user, $peutetre)) {$active2="active";} else{$active2="";}
if(in_array($user, $refused)) {$active3="active";}  else{$active3="";}

$ctrlmenu=true;
if($ctrlmenu){

	$menu='<div class="block_edit_invite"><h4>'.elgg_echo("events:invite:title").'</h4><ul id="edit">';
    $menu.='<li>'.elgg_view('output/confirmlink', array(
						   "href"=> $vars['url']."action/events/confirm?guid=".$entity->getGUID()."&handler=".$handler, 
				           "text"=> elgg_echo('events:invite:confirm',$lang),
    					   "class"=>'elgg-button elgg-button-submit '.$active1,
				           "confirm"=>elgg_echo('events:invite:confirm:confirm',$lang))).'</li>';
	$menu.='<li>'.elgg_view('output/confirmlink', array(
						   "href"=> $vars['url']."action/events/peutetre?guid=".$entity->getGUID()."&handler=".$handler, 
				           "text"=> elgg_echo('events:invite:peut-etre',$lang),
							"class"=>'elgg-button elgg-button-submit'.$active2, 
				           "confirm"=>elgg_echo('events:invite:peut-etre:confirm',$lang))).'</li>';
    $menu.='<li>'.elgg_view('output/confirmlink', array(
						   "href"=> $vars['url']."action/events/refuse?guid=".$entity->getGUID()."&handler=".$handler, 
				           "text"=> elgg_echo('events:invite:refuse',$lang), 
    						"class"=>'elgg-button elgg-button-submit'. $active3,
				           "confirm"=>elgg_echo('events:invite:refuse:confirm',$lang))).'</li>';
	$menu.='</ul>
			</div>
			<div class="clearfloat"></div>';

	echo $menu;
}
	
?>
