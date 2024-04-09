<?php
/*
 * Template Name: Attende Report Page Template
 * Template Post Type: page
 */

// Silence is golden.

if($_GET['id'] && $_GET['passCode'] == '2342fsd232321sdf'){
echo do_shortcode('[tribe_community_tickets view="attendees_report" id="'.$_GET["id"].'"]');
}
