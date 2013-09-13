<?php
/**
 * Actus for ELgg 1.8
 * View for actus objects
 *
 * @author Andrea Porcella / Ligne bleue Cyber
 * @link http://www.ligne-bleue-cyber.com/
 * @copyright (c) Ligne bleue Cyber 2012
 * @license GNU General Public License (GPL) version 2
 */

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);

if(!$entity){
	return TRUE;
}
if($entity){
	if(is_manager() || $entity->public){$ctrlPublic=true;}
	else{$ctrlPublic=false;}
}


// SET THE VALUES AND ELEMENTS FOR OUTPUT

	// Container
	$container = $entity->getContainerEntity();
	
	// Categories
	$categories = elgg_view('output/categories', $vars);
	
	// Excerpt
	$excerpt = $entity->excerpt;
	if (!$excerpt) {
		$excerpt = elgg_get_excerpt($entity->description);
	}

	// Owner
	$owner = $entity->getOwnerEntity();
	$events_icon = elgg_view('object/events/elements/date_icon', array('datedebut'=>$entity->datedebut, 'heure'=>$entity->heuredebut, ));
	
	
	$owner_link = elgg_view('output/url', array(
			'href' => "events/owner/$owner->username",
			'text' => $owner->name,
			'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	$date = elgg_view_friendly_time($entity->time_created);


	// Comments
	if ($entity->comments_on != 'Off') {
		$comments_count = $entity->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
					'href' => $entity->getURL() . '#actus-comments',
					'text' => $text,
					'is_trusted' => true,
			));
		} else {
			$comments_link = '';
		}
	} else {
		$comments_link = '';
	}
	
	// Menu of entity
	$metadata = elgg_view_menu('entity', array(
			'entity' => $vars['entity'],
			'handler' => 'events',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
	));
	
	// do not show the metadata and controls in widget view
	if (elgg_in_context('widgets')) {
			$metadata = '';
	}
	
	//Subtitle
	$subtitle = "$author_text $date $comments_link $categories";
	
	

// SWITCH THE VIEW
if($full && full!='cms'){
	
	$events_icon .= '<a href="'.$vars['url'].'events/download-ics/'.$vars['entity']->guid.'" title=""><img src="'.$vars['url'].'mod/lbc_events/_graphics/iCal2.0.png" style="width: 72px;margin-top: 5px;" /></a></p>';
	
	$body = elgg_view('events/maps', array('location'=>$entity->lieu, 'zoom'=>15));
	
	$body .= elgg_view('output/longtext', array(
		'value' => $entity->description,
		'class' => 'blog-post',
	));
	
	
	$params = array(
		'entity' => $entity,
		'title' => false,
		'info' => true,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	
	if($entity->owner_guid!=elgg_get_logged_in_user_guid())
		$body .= elgg_view('object/events/elements/menu_user', $params);
	
	$body .= elgg_view('object/events/elements/invited', $params);
	
	
	//elgg_dump($entity);
	
	$params = $params + $vars;
	$summary = elgg_view('object/events/elements/summary', $params);
   
	
	echo elgg_view('object/elements/full', array(
			'summary' => $summary,
			'icon' => $events_icon,
			'body' => $body,
	));
	
}
else{
	$params = array(
			'entity' => $entity,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'content' => $excerpt,
			'tags'=>false
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/events/elements/summary', $params);
	echo elgg_view_image_block($events_icon, $list_body);
}
?>