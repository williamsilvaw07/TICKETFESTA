<?php


////CHECKOUT

/**
 * Flux checkout - Allow custom CSS files.
 *
 * @param array $sources Sources.
 *
 * @return array
 */
function flux_allow_custom_css_files( $sources ) {
	$sources[] = 'http://site.com/wp-content/themes/storefront/style.css';
	return $sources;
}
add_filter( 'flux_checkout_allowed_sources', 'flux_allow_custom_css_files' );

add_action( 'flux_before_layout', 'get_header' );
add_action( 'flux_after_layout', 'get_footer' );

////FONTASWER


function my_theme_enqueue_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');



function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

////END

