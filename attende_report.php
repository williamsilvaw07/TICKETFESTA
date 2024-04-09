<?php
/*
 * Template Name: Attende Report Page Template
 * Template Post Type: page
 */

// Silence is golden.

if($_GET['id']){
echo do_shortcode('[tribe_community_tickets view="attendees_report" id="'.$_GET["id"].'"]');
}
echo "test";