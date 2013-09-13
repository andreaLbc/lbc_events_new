<?php 
$timestamp = $vars['datedebut'];
$day = date('d', $timestamp);
$month = elgg_echo(date('M', $timestamp));
$year = date('Y', $timestamp);

?>
<div class="events_icon">
	<p class="month"><?php echo $month ?></p>
	<p class="day"><?php echo $day ?></p>
	<p class="year"><?php echo $year ?></p>

</div>