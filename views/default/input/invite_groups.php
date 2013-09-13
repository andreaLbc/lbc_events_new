<?php
$invited=$vars['invited'];
$params = array(
				'types' => 'group',
				'limit' => '999'
 			);
$groups= elgg_get_entities_from_metadata($params);

if($groups){
?>
 <div class="container_invite_groups" style="margin:20px 0;width: 100%;">
   <h3 class="invite_h3"> <?php echo elgg_echo("events:invite:groups"); ?> </h3>
      <table id="notificationstable" cellspacing="0" cellpadding="4" border="1" width="100%">
		<?php 	
			foreach($groups as $group){
					  $checked='';
					  $fields='';
					  if(in_array($group->guid, $invited)){$checked = 'checked="checked"'; }
					  $fields  ='<td class="togglefield" style="width: 10px; padding-top: 3px;"><input type="checkbox" name="invited_groups['.$group->guid.']" id="'.$method.'checkbox" value="'.$group->guid.'" '.$checked.' />';
					  ?>
				 
						<tr>
					  		<?php echo $fields; ?>
						    <td class="namefield" style="width: 580px">
								<a href="<?php echo $group->getURL(); ?>">
										<?php echo elgg_view_entity_icon($group, 'tiny', array('href' => '')); ?>
								</a>
								<p class="namefieldlink">
									<a href="<?php echo $group->getURL(); ?>"><?php echo ucfirst(strtolower($group->name));  ?></a>
								</p>
							</td>
						    <td>&nbsp;</td>
					    </tr>
		<?php } ?>
	   </table>
</div>
		<?php 		
}
?>