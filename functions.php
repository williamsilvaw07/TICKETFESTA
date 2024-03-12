<?php













function customd_enqueue_scripts() {
    // Load html5-qrcode.min.js from a CDN
    wp_enqueue_script('html5-qrcode', 'https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js', array('jquery'), null, true);

    // Correct path for custom script for handling the QR code scanning
    // Replace get_template_directory_uri() with get_stylesheet_directory_uri() if TICKETFESTA is a child theme.
    wp_enqueue_script('custom-qr-scanner', get_stylesheet_directory_uri() . '/js/custom-qr-scanner.js', array('jquery', 'html5-qrcode'), null, true);

    // Localize script for AJAX
    wp_localize_script('custom-qr-scanner', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'customd_enqueue_scripts');


function custom_qr_scanner_shortcode() {
    ob_start(); ?>
    <div id="qr-reader" style="width: 100%; height: auto;"></div>
    <div id="qr-reader-results"></div>
    <?php return ob_get_clean();
}
add_shortcode('custom_qr_scanner', 'custom_qr_scanner_shortcode');




function handle_qr_code_scan() {
    $decodedText = $_POST['decodedText'];
    // Here you can add your logic to handle the scanned QR code, such as validating it against your database

    // Example: Sending a success message back
    wp_send_json_success(['message' => 'QR Code scanned successfully: ' . $decodedText]);
}
add_action('wp_ajax_handle_qr_code_scan', 'handle_qr_code_scan'); // For logged-in users
add_action('wp_ajax_nopriv_handle_qr_code_scan', 'handle_qr_code_scan'); // For guests







function display_all_tickets() {
    $api_url = 'https://ticketfesta.co.uk/wp-json/tribe/tickets/v1/tickets'; // Adjust this URL to the endpoint for fetching tickets
    $api_key = '72231569'; // Use your actual API Key, ensure secure handling

    $response = wp_remote_get($api_url, [
        'timeout' => 30,
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            // Add any additional headers as per the API documentation
        ],
    ]);

    if (is_wp_error($response)) {
        return "Failed to fetch tickets: " . $response->get_error_message();
    } else {
        $tickets = json_decode(wp_remote_retrieve_body($response), true);
        if (empty($tickets)) {
            return "No tickets found.";
        }

        // Prepare the tickets display
        $output = '<ul class="tickets-list">';
        foreach ($tickets as $ticket) {
            $output .= sprintf('<li>%s - %s</li>', esc_html($ticket['title']), esc_html($ticket['description']));
        }
        $output .= '</ul>';

        return $output;
    }
}



add_shortcode('display_tickets', 'display_all_tickets');
