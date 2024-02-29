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




add_action('woocommerce_payment_complete', 'custom_woocommerce_auto_complete_order');
function custom_woocommerce_auto_complete_order($order_id)
{
    if (!$order_id) {
        return;
    }

    $order = wc_get_order($order_id);
    $order->update_status('completed');
}




function enqueue_custom_styles_for_orders()
{
    wp_enqueue_style('custom-orders-style', get_stylesheet_directory_uri() . '/css/custom-orders-style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles_for_orders');

function add_custom_class_to_order_rows()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
                $('.woocommerce-orders-table__row').each(function () {
                    $(this).addClass('coupon-style');
                });
            });
        </script>
        <?php
}
add_action('wp_footer', 'add_custom_class_to_order_rows');

function customize_order_number_display($order_number, $order)
{
    return 'Order ' . $order_number; // Prepend "Order" to the order number
}

add_filter('woocommerce_order_number', 'customize_order_number_display', 10, 2);


// Function to customize My Account page tabs

function add_username_above_account_navigation()
{
    $current_user = wp_get_current_user();
    if ($current_user->display_name) {
        // The message is hidden by default using inline CSS; JavaScript will show it later.
        echo '<div id="custom-welcome-message" class="my-account-welcome-message" style="display: none;">Welcome, ' . esc_html($current_user->display_name) . '!</div>';
    }
}
add_action('woocommerce_before_account_navigation', 'add_username_above_account_navigation');

function move_custom_welcome_message_script()
{
    if (is_account_page()) {
        // Add inline JavaScript to move the welcome message and show it
        ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        // Move the welcome message to just above the <ul> inside the navigation
                        var welcomeMessage = $('#custom-welcome-message');
                        welcomeMessage.prependTo('.woocommerce-MyAccount-navigation');
                        // Now display the message
                        welcomeMessage.show();
                    });
                </script>
                <?php
    }
}
add_action('wp_footer', 'move_custom_welcome_message_script');
function change_view_order_text_script()
{
    if (is_account_page()) {
        // Add inline JavaScript to change the "View" buttons to "View Tickets"
        ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        // Change the text of each "View" button to "View Tickets"
                        $('.woocommerce-MyAccount-orders .woocommerce-button').each(function () {
                            if ($(this).text().trim() === 'View') {
                                $(this).text('View Tickets');
                            }
                        });
                    });
                </script>
                <?php
    }
}
add_action('wp_footer', 'change_view_order_text_script');





function customize_my_account_menu_items($items)
{
    // Remove unwanted sections
    unset($items['downloads']); // Remove "Downloads"
    unset($items['edit-address']); // Remove "Addresses"
    unset($items['coupons']); // Assuming 'coupons' is a custom endpoint. If it doesn't exist or has a different key, adjust accordingly.

    // Rename "Orders" to "Tickets"
    $items['orders'] = __('Tickets', 'woocommerce');

    return $items;
}
add_filter('woocommerce_account_menu_items', 'customize_my_account_menu_items');

// Optional: Function to change the "Orders" page title to "Tickets"
function change_my_account_orders_title($translated_text, $text, $domain)
{
    if (is_account_page()) {
        switch ($translated_text) {
            case 'Orders':
                $translated_text = __('Tickets', 'woocommerce');
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'change_my_account_orders_title', 20, 3);


///Redirect right to checkout page
/*
add_filter('woocommerce_add_to_cart_validation', 'custom_redirect_after_add_to_cart', 10, 3);

function custom_redirect_after_add_to_cart($passed, $product_id, $quantity) {
    if ($passed) {
        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
    return $passed;
}
*/


// $custom_post = get_post(1742);
// echo "<pre>";
// $product = wc_get_product(1835);
// var_dump($product);
// echo "</pre>";

// $userId = get_current_user_id();
// var_dump($userId);
// var_dump((int) $custom_post->post_author === $userId);
// echo "</pre>";
// die();

function iam00_return_ticket_associate_with_event()
{
    //check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'add-coupon-nonce')) {
        $response_data = array(
            'message' => 'Invalid nonce',
        );
        wp_send_json_success($response_data, 422);
        wp_die();
    }
    if (isset($_POST['event_id'])) {
        $eventId = (int) $_POST['event_id'];
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_tribe_wooticket_for_event' AND meta_value = {$eventId}");

        $ids = [];

        foreach ($results as $key => $value) {
            $ids[] = $value->post_id;
        }
        $args = array(
            'include' => $ids, // Replace with your actual product IDs
            'return' => 'objects' // Ensure product objects are returned
        );
        $products = wc_get_products($args);

        $response = [];

        foreach ($products as $product) {
            // Access product data:
            $response[$product->get_id()] = $product->get_name();
        }

        wp_send_json_success($response, 200);
        die();
    } else {
        $response_data = array(
            'message' => 'event_id missing',
        );
        wp_send_json_success($response_data, 422);
        die();
    }
}
add_action('wp_ajax_get_event_ticket_action', 'iam00_return_ticket_associate_with_event'); // For logged-in users

function dd($object){
    echo "<pre>";
    var_dump( $object);
    echo "</pre>";
    exit();
}

function iam00_get_coupon_associate_with_event($eventId){
     // Set up query arguments
     $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_tribe_wooticket_for_event',
                'value' => $eventId,
            ),
        ),
    );

    // Query products
    $query = new WP_Query($args);

    // Get product IDs
    $products = $query->posts;
    $product_ids = [];
    foreach ($products as $product) {
        $product_ids[] = $product->ID;
    }
    
    // Get all coupons
    $args = array(
        'post_type' => 'shop_coupon',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'product_ids',
                'value' => $product_ids,
                'compare' => 'IN',
            ),
        ),
    );
    $query = new WP_Query($args);
    return $query->posts;
}
