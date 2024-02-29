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
 
 
 
 
 
 
 /**
  * Your code goes below.
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  */
 
 /*
 
  function list_user_events() {
     $current_user_id = get_current_user_id();
     if (!$current_user_id) {
         echo "No user logged in.";
         return;
     }
 
     // Query for all events created by the current user
     $user_events = get_posts([
         'post_type' => 'tribe_events',
         'author' => $current_user_id,
         'posts_per_page' => -1
     ]);
 
     if (empty($user_events)) {
         echo "<p>No events found for this user.</p>";
         return;
     }
 
     echo "<h3>User Events</h3>";
 
     // Loop through each event and display its information
     foreach ($user_events as $event) {
         $event_id = $event->ID;
         $event_title = esc_html($event->post_title);
         
         echo "<h4>Event Title: $event_title - ID: $event_id</h4>";
         
         // Display the sales report shortcode for this event
         echo do_shortcode("[tribe_community_tickets view='sales_report' id='$event_id']");
     }
 }
 
 // Usage
 list_user_events();
 */
 
 
 
 /*
 function list_user_events() {
     $current_user_id = get_current_user_id();
     if (!$current_user_id) {
         echo "No user logged in.";
         return;
     }
 
     // Query for all events created by the current user
     $user_events = get_posts([
         'post_type' => 'tribe_events',
         'author' => $current_user_id,
         'posts_per_page' => -1
     ]);
 
     if (empty($user_events)) {
         echo "<p>No events found for this user.</p>";
         return;
     }
 
     echo "<h3>User Events</h3>";
 
     // Loop through each event and display its information
     foreach ($user_events as $event) {
         $event_id = $event->ID;
         $event_title = esc_html($event->post_title);
         $total_sales = get_total_sales_for_event($event_id);
 
         echo "<h4>Event Title: $event_title - ID: $event_id</h4>";
         echo "<p>Total Ticket Sales: $total_sales</p>";
         
         // Display the sales report shortcode for this event
         echo do_shortcode("[tribe_community_tickets view='sales_report' id='$event_id']");
     }
 }
 
 
 function get_total_sales_for_event($event_id) {
     $products = fetch_woocommerce_products();
 
     $total_sales = 0;
     echo "<p>Debug: Checking products for event ID: " . htmlspecialchars($event_id) . "</p>";
 
     foreach ($products as $product) {
         echo "<p>Debug: Checking product ID: " . htmlspecialchars($product->id) . "</p>";
 
         foreach ($product->meta_data as $meta) {
             echo "<p>Debug: Meta Key: " . htmlspecialchars($meta->key) . ", Meta Value: " . htmlspecialchars($meta->value) . "</p>";
 
             if ($meta->key === '_tribe_wooticket_for_event' && $meta->value == $event_id) {
                 echo "<p>Debug: Match found. Product ID: " . htmlspecialchars($product->id) . " linked to event ID: " . htmlspecialchars($event_id) . "</p>";
                 $total_sales += $product->total_sales;
                 echo "<p>Debug: Adding sales: " . htmlspecialchars($product->total_sales) . " from product ID: " . htmlspecialchars($product->id) . "</p>";
                 break; // Break the inner loop once the matching event ID is found
             }
         }
     }
 
     echo "<p>Debug: Total sales for event ID " . htmlspecialchars($event_id) . ": " . htmlspecialchars($total_sales) . "</p>";
     return $total_sales;
 }
 
 
 
 function fetch_woocommerce_products() {
     $consumer_key = 'ck_a23d3274327f59fe678e41555ae04c96aacd93cf';
     $consumer_secret = 'cs_db2129ea904a9e50ec0b12d5c562bbdf748b18e7';
     $url = 'https://thaynna-william.co.uk/wp-json/wc/v3/products';
 
     $args = [
         'headers' => [
             'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret)
         ]
     ];
 
     $response = wp_remote_get($url, $args);
     if (is_wp_error($response)) {
         error_log('Error fetching WooCommerce products: ' . $response->get_error_message());
         return [];
     }
 
     $body = wp_remote_retrieve_body($response);
     $data = json_decode($body);
 
     return $data;
 }
 
 // Usage
 list_user_events();
 
 
 */
 
 
 
 
 
 
 add_filter('woocommerce_product_data_store_cpt_get_defaults', 'set_default_product_virtual', 10, 2);
 function set_default_product_virtual($defaults, $product_type)
 {
     $defaults['virtual'] = true; // Set products to virtual by default
     return $defaults;
 }
 
 
 
 
 
 
 
 
 function set_default_organizer_featured_image($organizer_id)
 {
     // Check if the organizer has a featured image
     if (has_post_thumbnail($organizer_id)) {
         return;
     }
 
     // Path to your default image (Upload your default image to the media library and replace this URL)
     $default_image_url = '/wp-content/uploads/2024/01/default-avatar-photo-placeholder-profile-icon-vector.jpg';
 
     // Find the attachment ID of the image from the URL
     $default_image_id = attachment_url_to_postid($default_image_url);
 
     // Set the default image as the featured image for the organizer
     if ($default_image_id) {
         set_post_thumbnail($organizer_id, $default_image_id);
     }
 }
 
 // Hook into The Events Calendar's action that runs after an organizer is saved/updated
 add_action('tribe_events_organizer_updated', 'set_default_organizer_featured_image');
 
 
 
 
 
 ///FUNCTION TO MAKKE THE ORGANIZERS DEFUALT A GLOBE FUNCTION 
 function get_default_organizer_id_for_current_user()
 {
     if (is_user_logged_in()) {
         $current_user_id = get_current_user_id();
         return get_user_meta($current_user_id, '_tribe_organizer_id', true);
     }
 
     return false; // Return false if user is not logged in
 }
 
 
 
 
 
 
 
 
 
 
 
 
 // FUNCTION TO CREATE LIST OF ORGANIZERS
 function display_user_created_organizers()
 {
 
 
     // Define ajaxurl for the JavaScript
     ?>
         <script type="text/javascript">
             var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
         </script>
         <?php
 
 
 
 
         if (!is_user_logged_in()) {
             return 'You need to be logged in to view this page.'; // Only display for logged-in users
         }
 
         ob_start(); // Start output buffering
     
         // Create a nonce for the AJAX request
         $nonce = wp_create_nonce('create_new_organizer_nonce');
 
         echo '<div class="organizers-header">';
         echo '<h2>Your Organizers</h2>'; // Title
         echo '<a class="organizers_add_new_btn" href="javascript:void(0);" onclick="createNewOrganizer()">Create New Organizer</a>';
         echo '<input type="hidden" id="create_new_organizer_nonce" value="' . esc_attr($nonce) . '" />';
         echo '</div>';
 
         // JavaScript for createNewOrganizer
         ?>
         <script>
             function createNewOrganizer() {
                 console.log('Attempting to create a new organizer...'); // Debugging line
 
                 var nonce = document.querySelector('#create_new_organizer_nonce').value;
 
                 fetch('/wp-admin/admin-ajax.php?action=create_new_organizer', {
                     method: 'POST',
                     credentials: 'same-origin',
                     headers: {
                         'Content-Type': 'application/x-www-form-urlencoded'
                     },
                     body: 'nonce=' + nonce
                 })
                     .then(response => {
                         if (!response.ok) {
                             throw new Error(`HTTP error! status: ${response.status}`);
                         }
                         return response.json();
                     })
                     .then(data => {
                         console.log('Response received:', data); // Debugging line
 
                         if (data.success && data.data && data.data.organizer_id) {
                             console.log('Redirecting to organizer ID:', data.data.organizer_id); // Debugging line
                             window.location.href = '/edit-organisers/?id=' + data.data.organizer_id;
                         } else {
                             console.error('Unexpected response:', data);
                             alert('Unexpected response received. Check console for details.');
                         }
                     })
                     .catch(error => {
                         console.error('Error caught in fetch request:', error);
                         alert('Error creating new organizer. Check console for details.');
                     });
             }
 
 
             function deleteOrganizer(organizerId) {
                 console.log('Delete organizer called with ID:', organizerId);
 
                 if (!confirm('Are you sure you want to delete this organizer?')) {
                     return;
                 }
 
                 var data = {
                     'action': 'delete_organizer',
                     'organizer_id': organizerId
                 };
 
                 jQuery.post(ajaxurl, data, function (response) {
                     console.log('AJAX response:', response);
 
                     if (response.success) {
                         alert(response.data.message);
                         jQuery('#organizer-row-' + organizerId).remove(); // Remove the row from the table
                     } else {
                         var message = response.data && response.data.message ? response.data.message : 'Unknown error occurred';
                         console.log('Error message:', message);
                         alert(message);
                     }
                 }).fail(function (jqXHR, textStatus, errorThrown) {
                     console.log('AJAX error:', textStatus, errorThrown);
                     alert('Failed to delete: ' + errorThrown);
                 });
 
 
 
 
 
 
 
 
             }
         </script>
         <?php
 
         $current_user_id = get_current_user_id();
         $default_organizer_id = get_default_organizer_id_for_current_user();
 
         $args = array(
             'post_type' => 'tribe_organizer',
             'posts_per_page' => -1,
             'author' => $current_user_id,
         );
 
         $organizer_query = new WP_Query($args);
 
 
         if ($organizer_query->have_posts()) {
             echo '<table id="user-organizers-list" style="width: 100%;">';
             echo '<thead>';
             echo '<tr>';
             echo '<th>Organizer Logo</th>';
             echo '<th>Organizer Name</th>';
             echo '<th>Actions</th>';
             echo '</tr>';
             echo '</thead>';
             echo '<tbody>';
 
             while ($organizer_query->have_posts()) {
                 $organizer_query->the_post();
                 $organizer_id = get_the_ID();
                 $edit_url = esc_url("/edit-organisers/?id={$organizer_id}");
                 $profile_url = tribe_get_organizer_link($organizer_id, false, false); // Get URL only
     
                 echo '<tr id="organizer-row-' . $organizer_id . '">'; // Unique ID for each row
                 echo '<td>' . get_the_post_thumbnail($organizer_id, 'thumbnail') . '</td>';
 
                 $organizer_title = get_the_title();
                 if ($organizer_id == $default_organizer_id) {
                     $organizer_title .= ' (Default)';
                 }
                 echo '<td>' . $organizer_title . '</td>';
 
                 echo '<td class="action-links">';
                 echo '<a href="' . $edit_url . '" class="edit-link action-link">Edit</a>';
                 // Only show delete link if it's not the default organizer
                 if ($organizer_id != $default_organizer_id) {
                     echo '<a href="javascript:void(0);" onclick="deleteOrganizer(' . $organizer_id . ')" class="delete-link action-link">Delete</a>';
                 }
                 echo '<a href="' . $profile_url . '" class="profile-link action-link">View Profile</a>';
                 echo '</td>';
                 echo '</tr>';
             }
 
             echo '</tbody>';
             echo '</table>';
 
             wp_reset_postdata();
         } else {
             echo 'No organizers found.';
         }
 
         return ob_get_clean(); // Return the buffered output
 }
 function register_organizers_shortcode()
 {
     add_shortcode('user_organizers', 'display_user_created_organizers');
 }
 
 add_action('init', 'register_organizers_shortcode');
 