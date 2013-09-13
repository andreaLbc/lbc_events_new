<?php 
$entity = elgg_extract('entity', $vars, null);
if(isset($entity)){

	global $CONFIG;

	$itemPerLine = 5; //Items per line in block !

	$optionsCO = array('relationship' => "confirmed_to_events",'relationship_guid' => $entity->guid, 'inverse_relationship' => TRUE, 'limit'=>'999');
	$confirmed=elgg_get_entities_from_relationship($optionsCO);

	$optionsPO = array('relationship' => "peutetre_to_events",'relationship_guid' => $entity->guid, 'inverse_relationship' => TRUE, 'limit'=>'999');
	$peutetre=elgg_get_entities_from_relationship($optionsPO);

	$optionsIN = array('relationship' => "indecide_to_events",'relationship_guid' => $entity->guid, 'inverse_relationship' => TRUE, 'limit'=>'999');
	$indecide = elgg_get_entities_from_relationship($optionsIN);


	$num_confirmed=0;
	$n=1;
	foreach($confirmed as $user){
		if(check_entity_relationship($user->guid, 'invite_to_events', $entity->guid)){
			$userconfirmed.= "<div class=\"member\">";
			$userconfirmed.= "<div class=\"member_icon\"><a href=\"".$user->getURL()."\">" . elgg_view("profile/icon",array('entity' => $user, 'size' => 'small', 'override' => 'false')) . "</a></div>";
			$userconfirmed.= "</div>";
			if( $n % $itemPerLine == 0 ) $userconfirmed.= "<div class=\"clearfloat\"></div>";
			$n++;
			$num_confirmed++;
		}
	}

	$userconfirmed.= "<div class=\"clearfloat\"></div>";
	$more_url = "{$vars['url']}pg/evenement/indecide/{$entity->guid}/3";
	$userconfirmed.="<div id=\"groups_member_link\"><a href=\"{$more_url}\"></a></div>";

	$num_peutetre=0;
	$n=1;
	foreach($peutetre as $user){
		if(check_entity_relationship($user->guid, 'invite_to_events', $entity->guid)){
			$userpeutetre.= "<div class=\"member\">";
			$userpeutetre.= "<div class=\"member_icon\"><a href=\"".$user->getURL()."\">" . elgg_view("profile/icon",array('entity' => $user, 'size' => 'small', 'override' => 'false')) . "</a></div>";
			$userpeutetre.= "</div>";
			if( $n % $itemPerLine == 0 ) $userpeutetre.= "<div class=\"clearfloat\"></div>";
			$n++;
			$num_peutetre++;
		}
	}
	$userpeutetre.= "<div class=\"clearfloat\"></div>";
	$more_url = "{$vars['url']}pg/evenement/indecide/{$entity->guid}/3";
	$userpeutetre.="<div id=\"groups_member_link\"><a href=\"{$more_url}\"></a></div>";


	
	$num_indecide=0;
	$n=1;
	foreach($indecide as $user){
		if(check_entity_relationship($user->guid, 'invite_to_events', $entity->guid)!=false){
			$userinvited.= "<div class=\"member\">";
			$userinvited.= "<div class=\"member_icon\"><a href=\"".$user->getURL()."\">" . elgg_view("profile/icon",array('entity' => $user, 'size' => 'small', 'override' => 'false')) . "</a></div>";
			$userinvited.= "</div>";
			if( $n % $itemPerLine == 0 ) $userinvited.= "<div class=\"clearfloat\"></div>";
			$num_indecide++;
			$n++;
		}
	}
	$userinvited.= "<div class=\"clearfloat\"></div>";
	$more_url = "{$vars['url']}pg/evenement/indecide/{$entity->guid}/3";
	$userinvited.="<div id=\"groups_member_link\"><a href=\"{$more_url}\"></a></div>";

	

?>
<div class="events_block_invited">
	
	<div class="container_box " style="margin-left:0">
		<div class="boxA">
		     <h4><?php echo elgg_echo('events:invited:attente', array($num_indecide)); ?></h4>
		   	 <div class="margin box-wrap antiscroll-wrap">
		   	 	<div class="box">
		          <div class="antiscroll-inner">
		            <div class="box-inner">
				   	 	<?php echo $userinvited; ?>
				   		<div style="clear:both"></div>
				   	</div>
				  </div>
				</div>
		   	 </div>
		</div>
		<div class="boxA">
			 <h4><?php echo elgg_echo('events:invited:confirmed', array($num_confirmed)); ?></h4>
			 <div class="margin box-wrap antiscroll-wrap">
		   	 	<div class="box">
		          <div class="antiscroll-inner">
		            <div class="box-inner">
				   	 	<?php echo $userconfirmed; ?>
				   		<div style="clear:both"></div>
				   	</div>
				  </div>
				</div>
		   	 </div>
		</div>
		<div class="boxA" style="margin-right:0">
			 <h4><?php echo elgg_echo('events:invited:peut-etre', array($num_peutetre)); ?></h4>
			 <div class="margin box-wrap antiscroll-wrap">
		   	 	<div class="box">
		          <div class="antiscroll-inner">
		            <div class="box-inner">
				   	 	<?php echo $userpeutetre; ?>
				   		<div style="clear:both"></div>
				   	</div>
				  </div>
				</div>
		   	 </div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>

<?php 

}

?>