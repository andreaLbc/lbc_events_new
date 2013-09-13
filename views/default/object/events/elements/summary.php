<?php
/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

$entity = $vars['entity'];

$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
	if (isset($entity->title)) {
		$text = $entity->title;
	} else {
		$text = $entity->name;
	}
	$params = array(
		'text' => $text,
		'href' => $entity->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$info = elgg_extract('info', $vars, '');
$content = elgg_extract('content', $vars, '');

if($info){
	
	$info  = '<p>'.elgg_echo('events:view:lieu').'  : '.$entity->lieu;
	$info .= '<br />'.elgg_echo('events:view:datedebut').'  : '.events_date_from_timestamp($entity->datedebut);
	$info .= '<br />'.elgg_echo('events:view:datefin').' : '.events_date_from_timestamp($entity->datefin);
	$info .= '<br />'.elgg_echo('events:view:heuredebut').'  : '.$entity->heuredebut;
	$info .= '<br />'.elgg_echo('events:view:heurefin').' : '.$entity->heurefin;
	$subtitle = $subtitle.$info;

}

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') {
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
}

if ($metadata) {
	echo $metadata;
}
if ($title_link) {
	echo "<h3>$title_link</h3>";
}
echo "<div class=\"elgg-subtext event-info\">$subtitle</div>";
//echo $tags;

//echo elgg_view('object/summary/extend', $vars);
if ($content) {
	echo "<div class=\"elgg-content\">$content</div>";
}