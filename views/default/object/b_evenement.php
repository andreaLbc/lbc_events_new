<?php

$contextRubrique="context_rubrique_".$_SESSION['b_nav']['rubrique'];


//OPEN DE CONTEXT DIV
echo'<div id="'.$contextRubrique.'">';


//SWITCH THE VIEW
if(isset($vars['entity']) && get_context()=='search'){
	
		if(get_input('search_viewtype')=='gallery'){
			echo elgg_view("b_evenement/gallery", $vars); //con $vars ripasso tutti i valori alla pagina di view
		}
		else{
			echo elgg_view("b_evenement/list", $vars); 			
		}
	
}
else {

	//SET LANGUAGE VALUE AND LANGUAGE VIEW SETUP
	$lang = (!get_object_language($vars['entity'])? get_language(): get_object_language($vars['entity']));
	$direction=get_local_language_direction($lang);
	$contentWrapper = get_language_contentwrapper_class($lang);
	$text_align = get_language_text_align_style($lang);
	if($lang){$ctrlLang=true;} else{$ctrlLang=false;}

	set_visit_evenement($vars['entity']);

	$title=ucfirst($vars['entity']->title);
	$description=$vars['entity']->description;
	$lieu=$vars['entity']->lieu;
	$datedebut = b_date_from_timestamp($vars['entity']->datedebut);
	$datefin =   b_date_from_timestamp($vars['entity']->datefin);
	$heuredebut=$vars['entity']->heuredebut;
	$heurefin=$vars['entity']->heurefin;
	$urlevenement=$vars['entity']->url;
	$container_guid=$vars['entity']->container_guid;
	$comments=$vars['entity']->comments;
	$embedvideo=$vars['entity']->embedvideo;
	$tags=$vars['entity']->tags;
    $public = $vars['entity']->public;
    
	//SET THE CAN EDIT AND THE OWER
	$canedit=$vars['entity']->canEdit();
	$owner=$vars['entity']->getOwnerEntity();

	//GET THE IMG INFO
	$img = $vars['entity']->img_or;
	if($img){
		$imgView= img_view($img, 'b_evenement', '3', false);
		$idImg = get_metastring_id($img);
	}

	//GET THE FILES INFO
	$file=$vars['entity']->file_all;
	if($vars['entity']->file1){
		$fileB[0]=$vars['entity']->file1;
		if(isset($file) && is_array($file)){
			$file=array_merge($file, $fileB);
		}
		else{
			$file=$fileB;
		}

	}
	//SET THE DETAIL VIEW ELEMENT
	$timeCreated=elgg_view("output/friendlytime_classic", array("time"=>$vars['entity']->time_created, "type"=>"2"));
	$detail_left="<p class='info_date_pub_'>".$timeCreated."<a href=\"{$owner->getURL()}\">{$owner->name}</a></p>";
	if($canedit){
		$detail = elgg_view('output/edit', array("entity"=>$vars['entity'], "nameobjet"=>'evenement', "ctrlimg"=>true, "lang"=>$lang));
	}

	if($public=="A"){
		$ctrl_view="public";
	}
	
	//DISPLAY THE PAGE VIEW

?>
		
<?php if($canedit){echo $detail;}?>
<div id="content_area_user_title">
	<h2><?php echo elgg_view('output/text', array("value"=>$title)); ?></h2>
	<?php if(isloggedin()){echo $detail_left;} ?>
</div>


<div class="<?php echo $contentWrapper; ?>">

	<div class="clearfloat"></div>
    <?php
	//print page content block
	echo elgg_view('output/longtext', array("value"=>$description, "img"=>$imgView, "lang"=>$lang));
	?>

	<div class="clearfloat"></div>
	
	<div class="info_evenement">
		<div class="block_1">
			
				<ul>
					<?php 
						if (!empty($lieu)) {
							echo '<li><span>'.elgg_echo('b_evenement:view:lieu').'</span> '.$lieu.'</li>';
						}	
					?>
					<?php 
						if (!empty($datedebut)) {
							echo '<li><span>'.elgg_echo('b_evenement:view:datedebut').'</span> '.$datedebut.'</li>';
						}	
					?>
					<?php 
						if (!empty($heuredebut)) {
							echo '<li><span>'.elgg_echo('b_evenement:view:heuredebut').'</span> '.$heuredebut.'</li>';
						}
					?>
					<?php 
						if (!empty($datefin) && $datefin!=$datedebut ) {
							echo '<li><span>'.elgg_echo('b_evenement:view:datefin').'</span> '.$datefin.'</li>';
						}	
					?>
					<?php 
						if (!empty($heurefin)) {
							echo '<li><span>'.elgg_echo('b_evenement:view:heurefin').'</span> '.$heurefin.'</li>';
						}
					?>
				</ul>
			
				<?php 
					if (!empty($urlevenement)) {
						echo elgg_view('output/block_url', array("href"=>$urlevenement, "text"=>$urlevenement, "target"=>'_blank', "objetname"=>'b_evenement'));
					}
				?>
				
				<ul style="margin-top:10px">
					<li>
						<a href="<?php echo $vars['url']?>pg/evenement/download-ics/<?php echo $vars['entity']->guid ?>">
							<img src="<?php echo $vars['url']?>mod/b_evenement/_graphics/iCal2.0.png" />
						</a>
					</li>
				</ul>
				
		</div>
		<div class="block_2">
			<?php  
				if($vars["entity"]->owner_guid!=get_loggedin_userid())
					echo elgg_view('b_evenement/invite_menu_user', array("entity"=>$vars["entity"], "handler"=>"evenement")); 
			?>
		</div>
		<div class="clearfloat"></div>
		
    </div>
	
	<?php if (!empty($tags)){
		echo '<div class="block_content">';
		echo elgg_view('output/tags', array('tags' => $tags, "objetname"=>'b_evenement'));
		echo'</div>';
	}
	?>
	<div class="clearfloat_marg"></div>
</div>

<div class="clearfloat"></div>

<?php echo elgg_view("annotation/block_comment", array("entity"=>$vars['entity']));?>    			
  

<?php 
}

echo '</div>';
?>