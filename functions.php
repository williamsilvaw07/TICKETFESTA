<?php










function my_enqueue_instascan_script() {
    // Enqueue the Instascan library
    wp_enqueue_script('instascan', 'https://cdnjs.cloudflare.com/ajax/libs/instascan/0.0.0/instascan.min.js', array(), '0.0.0', true);

    // Enqueue your custom JS file, ensuring it loads after Instascan
    wp_enqueue_script('my-custom-instascan-script', get_stylesheet_directory_uri() . '/js/my-custom-instascan.js', array('instascan'), null, true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_instascan_script');

function display_instascan_scanner_shortcode() {
    // This ensures the scripts are enqueued when the shortcode is used
    my_enqueue_instascan_script();
    
    // Return the HTML for the scanner
    return '<video id="qr-scanner" style="width: 100%;"></video>';
}
add_shortcode('display_instascan_scanner', 'display_instascan_scanner_shortcode');
