<?php
$owner = elgg_get_page_owner_entity();

$invited=$vars['invited']; 
$invited_groups=$vars['invited_groups'];
$invited_all=$vars['ctrl_all'];
$value="";
$valueAll="";

if(isset($invited) || isset($invited_groups)){
	$ctrl_invite="A";
}

if($invited_all){
	$invited_all="A";
	$ctrl_invite="0";
}
//echo '<pre>'; print_r($invited); echo'</pre>';
//die();

if($owner instanceof ElggUser){
	if(is_manager()){
		$textA = elgg_echo("events:invite:all");
		$textB = elgg_echo("events:invite:groups_member");
		$users = elgg_get_entities(array('types'=> 'user', "limit"=>9999));
	}
	else{
		$textA = elgg_echo("events:invite:allfriends");
		$textB = elgg_echo("events:invite:friends");
		$users = $owner->getFriends();
	}
}
else if($owner instanceof ElggGroup){
	$textA = elgg_echo("events:invite:all");
	$textB = elgg_echo("events:invite:members");
	$users = $owner->getMembers(999);
}

$menu  =  elgg_view('input/checkboxe', array("name"=>"ctrl_all", "class"=>"ctrl_all", "value"=>$invited_all, "options"=>array($textA=>"A")));
$menu .= elgg_view('input/checkboxe', array("name"=>"ctrl_invite", "class"=>"ctrl_invite", "value"=>$ctrl_invite, "options"=>array($textB=>"A")));

?>

<div class='input_invite'>
	<?php echo $menu; ?>
</div>

<div id="invite">
	<?php 
		if(!$owner instanceof ElggGroup)
			echo elgg_view('input/invite_groups', array("invited"=>$invited_groups));
			//echo"'users : <pre>"; print_r($invited); echo"</pre>";
	    	echo elgg_view('input/invitepickers', array("value"=>$invited, 'entities'=>$users, 'name'=>'invited')); 
	 ?>
</div>


<script type="text/javascript">
	
		$(".ctrl_all").click(function(){
			var value = $(this).attr('checked');
			if(value){
				$(".ctrl_invite").attr("checked", false);
				$('input[name~="invited"]').attr("checked", false);
				var ctrl = $('input[name*="invited"]').attr("checked", false);
				$("#invite").slideUp();
				//$('input[name~="invited_groups"]').attr("checked", false);
				
		     }
		});
		$(".ctrl_invite").click(function(){
			var value = $(this).attr('checked');
			if(value){
				$("#invite").slideDown();
				$(".ctrl_all").attr("checked", false);
		     }
			else {
				$("#invite").slideUp();
				$(".ctrl_all").attr("checked", true);
				var ctrl = $('input[name*="invited"]').attr("checked", false);
			}
		});
		$(document).ready(function(){
			var value = $(".ctrl_invite").attr('checked');
			if(value){$("#invite").slideDown();}
			else {
				$("#invite").slideUp();
				$(".ctrl_all").attr("checked", true);
				}
		});
		
</script>