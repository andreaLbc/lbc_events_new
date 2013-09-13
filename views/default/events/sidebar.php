<?php
/**
 * Members sidebar
 */

// Tag search
$body = elgg_view('events/calendrier');

echo elgg_view_module('aside', elgg_echo('events:calendar'), $body);