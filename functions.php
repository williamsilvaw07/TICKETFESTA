<?php





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

function iam00_return_coupon_associate_with_event()
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
        $coupons = iam00_get_coupon_associate_with_event($eventId);
        // Loop through each coupon
        foreach ($coupons as $coupon) {
            
            $coupon = new WC_Coupon($coupon->ID);
            
            $expire_date = $coupon->get_date_expires();
            $formatted_expire_date = $expire_date ? date('Y-m-d H:i', strtotime($expire_date)) : '';
            
            $start_date = $coupon->get_date_created();
            $formatted_start_date = $start_date ? date('Y-m-d H:i', strtotime($start_date)) : '';

            $response_data = array(
                'code' => $coupon->get_code(),
                'discount_type' => $coupon->get_discount_type(),
                'amount' => $coupon->get_amount(),
                'individual_use' => $coupon->get_individual_use(),
                'description' => $coupon->get_description(),
                'usage_limit' => $coupon->get_usage_limit(),
                'expire_date' => $formatted_expire_date,
                'start_date' => $formatted_start_date,
            );

            // Output or use $response_data as needed
            // print_r($response_data);

            $response[] = $response_data;
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
add_action('wp_ajax_get_event_ticket_coupon_action', 'iam00_return_coupon_associate_with_event'); // For logged-in users

function iam00_create_woo_coupon_for_ticket()
{
    //check nonce
    if (!isset($_POST['nonce'])) {
        $response_data = array(
            'message' => 'Nonce missing',
        );
        wp_send_json_success($response_data, 422);
        wp_die();
    } else {
        if (!wp_verify_nonce($_POST['nonce'], 'add-coupon-nonce')) {
            // Nonce is invalid, handle accordingly
            $response_data = array(
                'message' => 'Invalid nonce',
            );
            wp_send_json_success($response_data, 422);
            wp_die();
        }
    }
    // check woocommerce active
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        $response_data = array(
            'message' => 'Woocommerce is not active',
        );
        wp_send_json_success($response_data, 422);
        die();
    }
    //Get the user id
    $userId = get_current_user_id();
    //Get Event id && Check if this event own by this user
    if (isset($_POST['event_id'])) {
        $eventId = $_POST['event_id'];
        $event = get_post($eventId);

        if (!$event) {
            $response_data = array(
                'message' => 'event not found',
            );
            wp_send_json_success($response_data, 422);
            die();
        }
        if ((int) $event->post_author !== $userId) {
            $response_data = array(
                'message' => 'event not belongs to you',
            );
            wp_send_json_success($response_data, 422);
            die();
        }
    } else {
        $response_data = array(
            'message' => 'event_id missing',
        );
        wp_send_json_success($response_data, 422);
        die();
    }
    //Get the products id
    if (isset($_POST['product_ids']) && is_array($_POST['product_ids'])) {
        $product_ids = array_map('intval', $_POST['product_ids']);
        $invalid_product_id = false;
        //Product Belongs to the Event
        foreach ($product_ids as $product_id) {
            $post_id = get_post_meta($product_id, '_tribe_wooticket_for_event', true);
            if ($post_id !== $eventId) {
                $invalid_product_id = true;
            }
        }
        if ($invalid_product_id) {
            $response_data = array(
                'message' => 'Invalid product in product list',
            );
            wp_send_json_success($response_data, 422);
            die();
        }
    } else {
        $response_data = array(
            'message' => 'product_ids is missing',
        );
        wp_send_json_success($response_data, 422);
        die();
    }
    if (isset($_POST['coupon_code'])) {
        $coupon_code = $_POST['coupon_code'];
        $discount_type = isset($_POST['discount_type']) ? $_POST['discount_type'] : 'percent';
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
        $individual_use = isset($_POST['individual_use']) ? $_POST['individual_use'] : true;
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $usage_limit = isset($_POST['usage_limit']) ? $_POST['usage_limit'] : 1;

        //Check if coupon name unique
        if (wc_get_coupon_id_by_code($coupon_code)) {
            $response_data = array(
                'message' => 'Coupon already exists with the code: ' . $coupon_code,
            );
            wp_send_json_success($response_data, 422);
            die();
        }
        //Create coupon associate with the product id
        $coupon = new WC_Coupon();
        // Set coupon properties
        $coupon->set_code($coupon_code);
        $coupon->set_product_ids($product_ids);
        $coupon->set_discount_type($discount_type); // Change this to 'fixed_cart' for a fixed amount discount
        $coupon->set_amount($amount); // Change this to the discount amount (either percentage or fixed amount)
        $coupon->set_individual_use($individual_use); // Set to true if the coupon should be used alone
        $coupon->set_description($description);
        $coupon->set_usage_limit($usage_limit); // Change this to the maximum number of times the coupon can be used

        $expire_date = '';
        if (isset($_POST['end_date_time']) && $_POST['end_date_time'] != '' ) {
            $expire_date = strtotime($_POST['end_date_time']);
            $coupon->set_date_expires($expire_date);
        }

        $start_date = '';
        if (isset($_POST['start_date_time'])) {
            $start_date = strtotime($_POST['start_date_time']);
            $coupon->set_date_created($start_date);
        }

        // Save the coupon
        $coupon->save();

        
        $formatted_expire_date = $expire_date ? date('Y-m-d H:i', strtotime($expire_date)) : '';
        $formatted_start_date = $expire_date ? date('Y-m-d H:i', strtotime($expire_date)) : '';


        $response_data = array(
            'message' => 'Coupon created successfully',
            'code' => $coupon_code,
            'discount_type' => $discount_type,
            'amount' => $amount,
            'individual_use' => $individual_use,
            'description' => $description,
            'usage_limit' => $usage_limit,
            'expire_date' => $formatted_expire_date,
            'start_date' => $formatted_start_date,
            'usage_limit' => $usage_limit,
        );
        wp_send_json_success($response_data, 200);
        die();

        //return coupon details

    } else {
        $response_data = array(
            'message' => 'coupon_code is missing',
        );
        wp_send_json_success($response_data, 422);
        die();
    }
    // Always use die() at the end of your handler function
    die();
}
add_action('wp_ajax_add_coupon_action', 'iam00_create_woo_coupon_for_ticket'); // For logged-in users

function iam00_create_event()
{
    $event = tribe_events()
        ->set_args([
            'title' => 'My Event',
            'start_date' => '+2 days 15:00:00',
            'duration' => HOUR_IN_SECONDS,
            'status' => 'publish',
        ])
        ->create();

    $response_data = array(
        'message' => 'Event Created',
    );
    wp_send_json_success($response_data, 200);
    wp_die();
}
add_action('wp_ajax_add_event', 'iam00_create_event');

/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */

add_action('wp_enqueue_scripts', 'generatepress_child_style');
function generatepress_child_style()
{
    if (is_page_template('organizer-template.php') || is_page_template('organizer-coupons.php')) {
        /** Call landing-page-template-one enqueue */
        wp_enqueue_style('fontawsome', get_stylesheet_directory_uri() . '/adminlte/plugins/fontawesome-free/css/all.min.css');
        wp_enqueue_style('tempusdominus', get_stylesheet_directory_uri() . '/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
        wp_enqueue_style('adminlte', get_stylesheet_directory_uri() . '/adminlte/css/adminlte.min.css');

        wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), null, true);
        wp_enqueue_script('moment', get_stylesheet_directory_uri() . '/adminlte/plugins/moment/moment.min.js', array(), null, true);
        wp_enqueue_script('tempusdominus', get_stylesheet_directory_uri() . '/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', array('jquery'), null, true);
        wp_enqueue_script('adminlte', get_stylesheet_directory_uri() . '/adminlte/js/adminlte.min.js', array('jquery', 'bootstrap'), null, true);


        wp_enqueue_script('organizer-js', get_stylesheet_directory_uri() . '/js/organizer.js', array('jquery'), null, true);
        // Pass the AJAX URL to the script
        wp_localize_script(
            'organizer-js',
            'iam00_ajax_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('add-coupon-nonce'),
            )
        );

    } else {
        /** Call regular enqueue */
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    }
}




