<?php

function my_enqueue_styles() {
    wp_enqueue_style( 'font-awesome', 'https://cdn.jsdelivr.net/npm/fontawesome@4.7.0/css/font-awesome.min.css', array(), '4.7.0' ); // Adjust version number if needed
  }
  add_action( 'wp_enqueue_scripts', 'my_enqueue_styles' );
  