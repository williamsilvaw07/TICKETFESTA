<?php

// Function to customize My Account page tabs

function add_username_above_account_navigation() {
    $current_user = wp_get_current_user();
    if ($current_user->display_name) {
        // The message is hidden by default using inline CSS; JavaScript will show it later.
        echo '<div id="custom-welcome-message" class="my-account-welcome-message" style="display: none;">Welcome, ' . esc_html($current_user->display_name) . '!</div>';
    }
}
add_action('woocommerce_before_account_navigation', 'add_username_above_account_navigation');

function move_custom_welcome_message_script() {
    if (is_account_page()) {
        // Add inline JavaScript to move the welcome message and show it
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
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




function customize_my_account_menu_items( $items ) {
    // Remove unwanted sections
    unset($items['downloads']); // Remove "Downloads"
    unset($items['edit-address']); // Remove "Addresses"
    unset($items['coupons']); // Assuming 'coupons' is a custom endpoint. If it doesn't exist or has a different key, adjust accordingly.

    // Rename "Orders" to "Tickets"
    $items['orders'] = __('Tickets', 'woocommerce');

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'customize_my_account_menu_items' );

// Optional: Function to change the "Orders" page title to "Tickets"
function change_my_account_orders_title( $translated_text, $text, $domain ) {
    if ( is_account_page() ) {
        switch ( $translated_text ) {
            case 'Orders':
                $translated_text = __( 'Tickets', 'woocommerce' );
                break;
        }
    }
    return $translated_text;
}
add_filter( 'gettext', 'change_my_account_orders_title', 20, 3 );




///FUNCTION TO ADD EVENT IMAGE TO TICKETS 

function set_ticket_product_image_from_event_featured_image($product_id) {
    // Assuming you can get the event ID associated with this product/ticket
    $event_id = get_event_id_from_ticket_product($product_id); // You'll need to replace this with the actual function or method to get the event ID

    if ($event_id) {
        $thumbnail_id = get_post_thumbnail_id($event_id);

        if ($thumbnail_id) {
            set_post_thumbnail($product_id, $thumbnail_id);
        }
    }
}

// Hook into product creation and update - you might need to adjust these hooks
add_action('woocommerce_new_product', 'set_ticket_product_image_from_event_featured_image');
add_action('woocommerce_update_product', 'set_ticket_product_image_from_event_featured_image');


///Redirect right to checkout page
add_filter('woocommerce_add_to_cart_validation', 'custom_redirect_after_add_to_cart', 10, 3);

function custom_redirect_after_add_to_cart($passed, $product_id, $quantity) {
    if ($passed) {
        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
    return $passed;
}



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
        if(isset($_POST['expire_date']) && $_POST['expire_date'] != '' && isset($_POST['expire_time']) && $_POST['expire_time'] != ''){
            $expire_date = strtotime("{$_POST['expire_date']} {$_POST['expire_time']}");
            $coupon->set_date_expires($expire_date);
        }
        
        $start_date = '';
        if(isset($_POST['start_date']) && isset($_POST['start_time'])){
            $start_date = strtotime("{$_POST['start_date']} {$_POST['start_time']}");
            $coupon->set_date_created($start_date);
        }

        $usage_limit = '';
        if( isset($_POST['usage_limit']) && $_POST['usage_limit'] != '' ){
            $usage_limit = (int) $_POST['usage_limit'];
            $coupon->set_usage_limit($usage_limit);
        }

        // Save the coupon
        $coupon->save();

        $response_data = array(
            'message' => 'Coupon created successfully',
            'code' => $coupon_code,
            'discount_type' => $discount_type,
            'amount' => $amount,
            'individual_use' => $individual_use,
            'description' => $description,
            'usage_limit' => $usage_limit,
            'expire_date' => $expire_date,
            'start_date' => $start_date,
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
            'title'      => 'My Event',
            'start_date' => '+2 days 15:00:00',
            'duration'   => HOUR_IN_SECONDS,
            'status'     => 'publish',
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
    if (is_page_template('organizer-template.php')) {
        /** Call landing-page-template-one enqueue */
        wp_enqueue_style('fontawsome', get_stylesheet_directory_uri() . '/adminlte/plugins/fontawesome-free/css/all.min.css');
        wp_enqueue_style('adminlte', get_stylesheet_directory_uri() . '/adminlte/css/adminlte.min.css');

        wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), null, true);
        wp_enqueue_script('adminlte', get_stylesheet_directory_uri() . '/adminlte/js/adminlte.min.js', array('jquery', 'bootstrap'), null, true);
		
		
		wp_enqueue_script('organizer-js', get_stylesheet_directory_uri() . '/js/organizer.js', array('jquery'), null, true);
        // Pass the AJAX URL to the script
        wp_localize_script('organizer-js', 'iam00_ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('add-coupon-nonce'),
        ));
      
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






add_filter( 'woocommerce_product_data_store_cpt_get_defaults', 'set_default_product_virtual', 10, 2 );
function set_default_product_virtual( $defaults, $product_type ) {
    $defaults['virtual'] = true; // Set products to virtual by default
    return $defaults;
}





add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);

    // Add any other fields you want to remove

    return $fields;
}





function set_default_organizer_featured_image($organizer_id) {
    // Check if the organizer has a featured image
    if (has_post_thumbnail($organizer_id)) {
        return;
    }

    // Path to your default image (Upload your default image to the media library and replace this URL)
    $default_image_url = 'https://thaynna-william.co.uk/wp-content/uploads/2024/01/default-avatar-photo-placeholder-profile-icon-vector.jpg';

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
function get_default_organizer_id_for_current_user() {
    if (is_user_logged_in()) {
        $current_user_id = get_current_user_id();
        return get_user_meta($current_user_id, '_tribe_organizer_id', true);
    }

    return false; // Return false if user is not logged in
}












// FUNCTION TO CREATE LIST OF ORGANIZERS
function display_user_created_organizers() {


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
                window.location.href = 'https://thaynna-william.co.uk/edit-organisers/?id=' + data.data.organizer_id;
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

    jQuery.post(ajaxurl, data, function(response) {
        console.log('AJAX response:', response);

        if (response.success) {
            alert(response.data.message);
            jQuery('#organizer-row-' + organizerId).remove(); // Remove the row from the table
        } else {
            var message = response.data && response.data.message ? response.data.message : 'Unknown error occurred';
            console.log('Error message:', message);
            alert(message);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log('AJAX error:', textStatus, errorThrown);
        alert('Failed to delete: ' + errorThrown);
    });








}
    </script>
    <?php

    $current_user_id = get_current_user_id();
    $default_organizer_id = get_default_organizer_id_for_current_user();

    $args = array(
        'post_type'      => 'tribe_organizer',
        'posts_per_page' => -1,
        'author'         => $current_user_id,
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
            $edit_url = esc_url("https://thaynna-william.co.uk/edit-organisers/?id={$organizer_id}");
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
function register_organizers_shortcode() {
    add_shortcode('user_organizers', 'display_user_created_organizers');
}

add_action('init', 'register_organizers_shortcode');

function get_organizer_id_shortcode_function($atts) {
    $atts = shortcode_atts(array(
        'id' => '0'
    ), $atts);

    $organizer_id = $atts['id'];

    if ($organizer_id == '0' && isset($_GET['id']) && !empty($_GET['id'])) {
        $organizer_id = $_GET['id'];
    }

    if ($organizer_id == '0') {
        return "No organizer ID provided.";
    }

    return do_shortcode('[tribe_community_events view="edit_organizer" id="' . $organizer_id . '"]');
}

add_shortcode('get_organizer_id_shortcode_function_shortcode', 'get_organizer_id_shortcode_function');

function update_organizer_slug_on_title_change( $post_id, $post, $update ) {
    if ( 'tribe_organizer' !== $post->post_type ) {
        return;
    }

    remove_action( 'save_post', 'update_organizer_slug_on_title_change', 10 );

    $new_slug = sanitize_title( $post->post_title );

    if ( $post->post_name !== $new_slug ) {
        wp_update_post( array(
            'ID'        => $post_id,
            'post_name' => $new_slug,
        ) );
    }

    add_action( 'save_post', 'update_organizer_slug_on_title_change', 10, 3 );
}

add_action( 'save_post', 'update_organizer_slug_on_title_change', 10, 3 );

function check_organizer_name_existence( $post_id, $post, $update ) {
    if ('tribe_organizer' !== $post->post_type) {
        return;
    }

    if (!isset($_POST['post_title'])) {
        return;
    }

    $organizer_name = sanitize_text_field( $_POST['post_title'] );

    $existing_organizers = get_posts(array(
        'post_type' => 'tribe_organizer',
        'post_status' => 'publish',
        'title' => $organizer_name,
        'exclude' => array($post_id),
        'posts_per_page' => 1,
    ));

    if (count($existing_organizers) > 0) {
        wp_die('Error: An organizer with this name already exists. Please choose a different name.', 'Organizer Name Exists', array('back_link' => true));
    }
}

add_action('save_post', 'check_organizer_name_existence', 10, 3);

function reset_organizer_slug_on_deletion($post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === 'tribe_organizer') {
        $new_slug = $post->post_name . '-deleted-' . time();
        wp_update_post(array(
            'ID'        => $post_id,
            'post_name' => $new_slug,
        ));
    }
}

add_action('before_delete_post', 'reset_organizer_slug_on_deletion');




function ajax_delete_organizer() {
    header('Content-Type: application/json'); // Ensure JSON response

    $organizer_id = isset($_POST['organizer_id']) ? intval($_POST['organizer_id']) : 0;

    if (!$organizer_id) {
        wp_send_json_error('Invalid Organizer ID');
        die();
    }

    if (!current_user_can('delete_post', $organizer_id)) {
        wp_send_json_error('No permission to delete this organizer');
        die();
    }

    $result = wp_delete_post($organizer_id, true);

    if ($result) {
        wp_send_json_success(array('message' => 'Organizer deleted successfully'));
    } else {
        wp_send_json_error('Deletion failed');
    }

    die();
}
add_action('wp_ajax_delete_organizer', 'ajax_delete_organizer');













function customize_organizer_slug($slug, $post_ID, $post_status, $post_type) {
    if ('tribe_organizer' != $post_type) {
        return $slug;
    }

    // Check if slug ends with a number
    if (preg_match('/-\d+$/', $slug)) {
        $original_slug = preg_replace('/-\d+$/', '', $slug);
        $existing_posts = get_posts(array(
            'post_type' => 'tribe_organizer',
            'name' => $original_slug,
            'post_status' => 'any',
            'numberposts' => 1
        ));

        if (empty($existing_posts)) {
            return $original_slug; // Use the original slug if no posts found
        }
    }

    return $slug;
}

add_filter('wp_unique_post_slug', 'customize_organizer_slug', 10, 4);













////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



///FUNCTION TO CHECK IF ORGANIZE NAME IS UNIQE
function ajax_check_organizer_name() {
    $organizer_name = sanitize_text_field( $_POST['organizer_name'] );

    $existing_organizers = get_posts(array(
        'post_type' => 'tribe_organizer',
        'post_status' => 'publish',
        'title' => $organizer_name,
        'posts_per_page' => 1,
    ));

    if (count($existing_organizers) > 0) {
        echo 'An organizer with this name already exists.';
    }
    wp_die();
}

add_action('wp_ajax_check_organizer_name', 'ajax_check_organizer_name');
add_action('wp_ajax_nopriv_check_organizer_name', 'ajax_check_organizer_name'); // If needed for non-logged in users


//////////////////////END////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////FUNCTION TO CREATE A SIGN UP FORM FOR THE ORGANIZER
// Function to display the custom registration form
function custom_user_registration_form() {
    if (is_user_logged_in()) {
        return 'You are already logged in.';
    }

    $html = '<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
    $html .= '<p><label for="first_name">First Name <strong>*</strong></label>';
    $html .= '<input type="text" name="first_name" id="first_name" required></p>';
    $html .= '<p><label for="last_name">Last Name <strong>*</strong></label>';
    $html .= '<input type="text" name="last_name" id="last_name" required></p>';
    $html .= '<p><label for="email">Email <strong>*</strong></label>';
    $html .= '<input type="email" name="email" id="email" required></p>';
    $html .= '<p><label for="password">Password <strong>*</strong></label>';
    $html .= '<input type="password" name="password" id="password" required></p>';
    $html .= '<p><label for="organizer_title">Organizer Title <strong>*</strong></label>';
    $html .= '<input type="text" name="organizer_title" id="organizer_title" required></p>';
    $html .= '<p><input type="submit" name="submit" value="Register"></p>';
    $html .= '</form>';
    $html .= '<p>Already have an account? <a href="' . home_url('/custom-login') . '">Login here</a>.</p>';

    return $html;
}

// Function to handle the registration process
function custom_user_registration() {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && !is_user_logged_in()) {
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $organizer_title = sanitize_text_field($_POST['organizer_title']);

        $user_id = wp_create_user($email, $password, $email); // Username is set to email

        if (!is_wp_error($user_id)) {
            // Update user meta for first name and last name
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);

            // Assign the 'organiser' role to the user
            $user = new WP_User($user_id);
            $user->set_role('organiser');

            // Automatically log the user in
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            // Create the organizer post
            $organizer_data = array(
                'post_title'   => $organizer_title, // Use the organizer title for the post title
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'tribe_organizer',
                'post_author'  => $user_id
            );
            $organizer_id = wp_insert_post($organizer_data);

            if (!is_wp_error($organizer_id)) {
                update_user_meta($user_id, '_tribe_organizer_id', $organizer_id);

                // Redirect to the specified page
                wp_redirect('https://thaynna-william.co.uk/dashboard');
                exit;
            } else {
                echo 'Error creating organizer.';
            }
        } else {
            echo 'Error creating user.';
        }
    }
}

// Function to register the shortcode
function register_custom_registration_shortcode() {
    add_shortcode('custom_registration_form', 'custom_user_registration_form');
}

// Hooking up the functions to WordPress
add_action('init', 'register_custom_registration_shortcode');
add_action('init', 'custom_user_registration');
//////END





///FUNCTION FOR ADMIN ORGANIZER LOGIN FORM
function restrict_access_and_show_login_form() {
    if (is_page_template('organizer-template.php')) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/custom-login'));
            exit;
        }

        $user = wp_get_current_user();
        if (!in_array('organiser', (array) $user->roles) && !in_array('administrator', (array) $user->roles)) {
            wp_redirect(home_url('/custom-login'));
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_access_and_show_login_form');
//////END






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///FUNCTION TO DISPLAY THE CURRENT USER EVENTS 


/**
 * Retrieves events for the current logged-in user.
 */
function get_my_events() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        return 'You must be logged in to see your events.';
    }

    // Get the current user
    $current_user = wp_get_current_user();

    // Query the events post type for the current user's events
    $args = array(
        'post_type' => 'tribe_events', // Replace with your actual event post type
        'author' => $current_user->ID,
        // Add any additional query arguments you need
    );

    $events_query = new WP_Query($args);

    // Start building the output
    $output = '<ul class="my-events-list">';

    // Loop through the events and build the list
    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $output .= '<li>' . get_the_title() . ' - ' . get_the_date() . '</li>';
        }
    } else {
        $output .= '<li>No events found.</li>';
    }

    // Reset the post data
    wp_reset_postdata();

    $output .= '</ul>';

    return $output;
}

/**
 * Shortcode to display the list of events for the current user.
 */
function my_events_shortcode($atts) {
    // Extract the attributes passed to the shortcode
    $a = shortcode_atts(array(
        'view' => 'my_events', // The default view attribute
    ), $atts);

    // Check if the view is set to 'my_events'
    if ($a['view'] === 'my_events') {
        return get_my_events(); // Call the function to get the events
    }

    // You can add additional views and handle them here

    return 'Invalid view specified.';
}

// Register the shortcode with WordPress
add_shortcode('tribe_community_events', 'my_events_shortcode');







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function get_svg_icon($type) {
    $tick_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 161 121" fill="none">
  <path d="M59.2923 120.272C57.9275 120.267 56.5783 119.982 55.3283 119.434C54.0783 118.887 52.9544 118.087 52.0264 117.087L3.65329 65.6281C1.84504 63.701 0.876365 61.1346 0.960363 58.4933C1.04436 55.8521 2.17415 53.3524 4.10119 51.5441C6.02823 49.7359 8.59467 48.7672 11.2359 48.8512C13.8772 48.9352 16.3769 50.065 18.1851 51.992L59.1928 95.6871L142.9 4.11661C143.75 3.0588 144.806 2.18581 146.006 1.55128C147.205 0.916742 148.521 0.534051 149.873 0.426711C151.226 0.319371 152.586 0.489649 153.87 0.927084C155.154 1.36452 156.336 2.05987 157.341 2.97044C158.347 3.88102 159.156 4.98758 159.718 6.22216C160.281 7.45674 160.585 8.79329 160.612 10.1497C160.639 11.5061 160.389 12.8537 159.876 14.1098C159.364 15.3659 158.599 16.504 157.631 17.4541L66.6578 116.987C65.7385 118.006 64.6185 118.824 63.3681 119.389C62.1177 119.954 60.7639 120.255 59.3918 120.272H59.2923Z" fill="#21DAB8"/>
</svg>'; // Replace with your tick SVG
    $cross_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 239 239" fill="none">
  <path d="M133.474 119.441L176.273 76.7416C178.147 74.8673 179.2 72.3253 179.2 69.6747C179.2 67.0241 178.147 64.4821 176.273 62.6079C174.399 60.7336 171.857 59.6807 169.206 59.6807C166.556 59.6807 164.014 60.7336 162.139 62.6079L119.44 105.407L76.74 62.6079C74.8658 60.7336 72.3238 59.6807 69.6732 59.6807C67.0226 59.6807 64.4806 60.7336 62.6063 62.6079C60.7321 64.4821 59.6792 67.0241 59.6792 69.6747C59.6792 72.3253 60.7321 74.8673 62.6063 76.7416L105.406 119.441L62.6063 162.141C61.6734 163.066 60.933 164.167 60.4277 165.38C59.9223 166.593 59.6622 167.894 59.6622 169.208C59.6622 170.522 59.9223 171.823 60.4277 173.036C60.933 174.249 61.6734 175.349 62.6063 176.275C63.5316 177.208 64.6325 177.948 65.8454 178.453C67.0583 178.959 68.3592 179.219 69.6732 179.219C70.9872 179.219 72.2881 178.959 73.501 178.453C74.7139 177.948 75.8148 177.208 76.74 176.275L119.44 133.475L162.139 176.275C163.065 177.208 164.166 177.948 165.379 178.453C166.591 178.959 167.892 179.219 169.206 179.219C170.52 179.219 171.821 178.959 173.034 178.453C174.247 177.948 175.348 177.208 176.273 176.275C177.206 175.349 177.947 174.249 178.452 173.036C178.957 171.823 179.217 170.522 179.217 169.208C179.217 167.894 178.957 166.593 178.452 165.38C177.947 164.167 177.206 163.066 176.273 162.141L133.474 119.441Z" fill="#FF0040"/>
</svg>'; // Replace with your cross SVG

    if ($type === 'positive') {
        return $tick_svg;
    } else {
        return $cross_svg;
    }
}









////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//FUNCTION TO CREATE SHORTCODE FOR ORGANIZER SHORT CODE REPORTS

function my_tribe_community_tickets_sales_report_shortcode( $atts ) {
    // Check if 'event_id' is in the URL and is a number
    if ( isset( $_GET['event_id'] ) && is_numeric( $_GET['event_id'] ) ) {
        $event_id = intval( $_GET['event_id'] );
        return do_shortcode( '[tribe_community_tickets view="sales_report" id="' . $event_id . '"]' );
    } else {
        return 'No Sales Report Found';
    }
}
add_shortcode( 'organizer_sales_report', 'my_tribe_community_tickets_sales_report_shortcode' );




function my_tribe_community_tickets_attendees_report_shortcode( $atts ) {
    // Check if 'event_id' is in the URL and is a number
    if ( isset( $_GET['event_id'] ) && is_numeric( $_GET['event_id'] ) ) {
        $event_id = intval( $_GET['event_id'] );
        return do_shortcode( '[tribe_community_tickets view="attendees_report" id="' . $event_id . '"]' );
    } else {
        return 'No Attendees Report Found';
    }
}
add_shortcode( 'organizer_attendees_report', 'my_tribe_community_tickets_attendees_report_shortcode' );

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////














function get_ticket_info($user_id) {
    $today = date('Y-m-d');
    $total_sales_today = 0;
    $total_tickets_sold_today = 0;
    $total_sales_lifetime = 0;
    $total_tickets_sold_lifetime = 0;
    $total_tickets_sold_previous_day = 0; // Initialize the variable for tickets sold one day before

    // Calculate the total sales for the previous day
    $total_sales_previous_day = get_total_sales_for_previous_day($user_id);

    // Fetch orders
    $orders = wc_get_orders(array(
        'status' => array('completed'),
        'limit' => -1,
        'type' => 'shop_order',
    ));

    foreach ($orders as $order) {
        // Skip if not an instance of WC_Order
        if (!($order instanceof WC_Order)) {
            continue;
        }

        $order_date = $order->get_date_created()->format('Y-m-d');
        $is_today = ($order_date === $today);
        $is_previous_day = ($order_date === date('Y-m-d', strtotime('-1 day'))); // Check if the order is from the previous day

        foreach ($order->get_items() as $item) {
            $product_id = $item->get_product_id();
            $event_id = get_post_meta($product_id, '_tribe_wooticket_for_event', true);
            $event_author = get_post_field('post_author', $event_id);

            if ($event_author == $user_id) {
                $quantity = $item->get_quantity();
                $total_tickets_sold_lifetime += $quantity;
                $total_sales_lifetime += $order->get_total();

                if ($is_today) {
                    $total_tickets_sold_today += $quantity;
                    $total_sales_today += $order->get_total();
                }

                // Check if it's from the previous day and add to the total tickets sold one day before
                if ($is_previous_day) {
                    $total_tickets_sold_previous_day += $quantity;
                }
            }
        }
    }

    return array(
        'total_sales_today' => $total_sales_today,
        'total_tickets_sold_today' => $total_tickets_sold_today,
        'total_sales_lifetime' => $total_sales_lifetime,
        'total_tickets_sold_lifetime' => $total_tickets_sold_lifetime,
        'total_sales_previous_day' => $total_sales_previous_day,
        'total_tickets_sold_previous_day' => $total_tickets_sold_previous_day // Add total tickets sold one day before
    );
}








function get_total_sales_for_previous_day($user_id) {
    // Calculate the date for the previous day
    $previous_day = date('Y-m-d', strtotime('-1 day'));

    $total_sales_previous_day = 0;

    // Fetch orders
    $orders = wc_get_orders(array(
        'status' => array('completed'),
        'date_created' => $previous_day, // Filter orders for the previous day
        'limit' => -1,
        'type' => 'shop_order',
    ));

    foreach ($orders as $order) {
        // Skip if not an instance of WC_Order
        if (!($order instanceof WC_Order)) {
            continue;
        }

        foreach ($order->get_items() as $item) {
            $product_id = $item->get_product_id();
            $event_id = get_post_meta($product_id, '_tribe_wooticket_for_event', true);
            $event_author = get_post_field('post_author', $event_id);

            if ($event_author == $user_id) {
                $total_sales_previous_day += $order->get_total();
            }
        }
    }
 
    return $total_sales_previous_day;
}

function calculate_percentage_change($previous_value, $current_value) {
    if ($previous_value == 0) {
        if ($current_value > 0) {
            return '100%'; // Represents a significant increase from 0
        } else {
            return '0%'; // No change if current value is also 0
        }
    }

    $percentage_change = (($current_value - $previous_value) / $previous_value) * 100;
    return round($percentage_change, 2) . '%';
}

function calculate_amount_change($previous_value, $current_value) {
    $amount_change = $current_value - $previous_value;
    
    // Check if the amount change is zero
    if ($amount_change == 0) {
        return '£0.00';
    }
    
    // Check if the amount is negative
    if ($amount_change < 0) {
        // If negative, add minus sign before the pound sign
        return '-£' . esc_html(number_format(abs($amount_change), 2));
    } else {
        // If positive, just add the pound sign
        return '£' . esc_html(number_format($amount_change, 2));
    }
}


function shortcode_todays_sales() {
    $user_id = get_current_user_id(); // Get the current user's ID
    $ticket_info = get_ticket_info($user_id);
    $total_sales_today = $ticket_info['total_sales_today'];
    $total_sales_previous_day = $ticket_info['total_sales_previous_day']; // Get previous day's sales

    // Calculate percentage change and amount change
    $percentage_change = calculate_percentage_change($total_sales_previous_day, $total_sales_today);
    $amount_change = calculate_amount_change($total_sales_previous_day, $total_sales_today);

    // Format amounts in pounds (£)
    $total_sales_today_formatted = '£' . number_format($total_sales_today, 2);
    $total_sales_previous_day_formatted = '£' . number_format($total_sales_previous_day, 2);

    // Create the HTML for the card-like section
    $output = '
    <div class="sales-card today_sale_admin_dashboard">
        <div class="sales-card-content ">
            <div class="sales-today ">
                <h5 class="admin_dashboard_sales-label card_admin_dashboard ">Today\'s Sales</h5>
                <div class="admin_dashboard_sales-amount ">' . esc_html($total_sales_today_formatted) . '</div>
            </div>
            <div class="admin_dashboard_sales-yesterday ">
                <div class="admin_dashboard_sales_amount_yesterday ">' . esc_html($total_sales_previous_day_formatted) . '</div>
            </div>
            <div class="admin_dashboard_lower_other_day ">
                <span class="admin_dashboard_percentage-change ">' . esc_html($percentage_change) . '</span>
                <p class="dmin_dashboard_amount-change_p_tag"><span class="admin_dashboard_amount-change">' . esc_html($amount_change) . '</span></p>
                
            </div>
            <span class="from_text_price_yesturday">Compared to previous day</span>
        </div>
    </div>';

    return $output;
}

add_shortcode('todays_sales', 'shortcode_todays_sales');



function shortcode_todays_tickets_sold() {
    $ticket_info = get_ticket_info(get_current_user_id());
    $total_tickets_sold_today = $ticket_info['total_tickets_sold_today'];
    $total_tickets_sold_previous_day = $ticket_info['total_tickets_sold_previous_day'];

    // Calculate the percentage change correctly
    if ($total_tickets_sold_previous_day == 0) {
        $percentage_change = '0%';
    } else {
        $percentage_change = number_format((($total_tickets_sold_today - $total_tickets_sold_previous_day) / $total_tickets_sold_previous_day) * 100, 2) . '%';
    }

    // Calculate the amount change as a number (not currency)
    $amount_change = $total_tickets_sold_today - $total_tickets_sold_previous_day;

    // Determine the color based on the amount change
    if ($amount_change < 0) {
        $color = 'red';
    } elseif ($amount_change > 0) {
        $color = 'green';
    } else {
        $color = '#aaa'; // No change
    }

    return '
    <div class="sales-card today_sale_admin_dashboard">
        <div class="sales-card-content ">
            <div class="sales-today ">
                <h5 class="admin_dashboard_sales-label card_admin_dashboard ">Tickets Sold Today</h5>
                <div class="admin_dashboard_sales-amount ">' . esc_html($total_tickets_sold_today) . ' <span class="admin_dashboard_sales-amount_span">Tickets</span></div>
            </div>
            <div class="admin_dashboard_sales-yesterday ">
                <div class="admin_dashboard_sales_amount_yesterday ">' . esc_html($total_tickets_sold_previous_day) . '</div>
            </div>
            <div class="admin_dashboard_lower_other_day ">
                <span class="admin_dashboard_percentage-change" style="color: ' . $color . ' !important;">' . esc_html($percentage_change) . '</span>
                <p class="dmin_dashboard_amount-change_p_tag"><span class="admin_dashboard_amount-change">' . esc_html($amount_change) . '</span></p>
            </div>
            <span class="from_text_price_yesturday">Compared to previous day</span>
        </div>
    </div>';
}
add_shortcode('todays_tickets_sold', 'shortcode_todays_tickets_sold');


function shortcode_valid_tickets_sold() {
    $ticket_info = get_ticket_info(get_current_user_id());
    return '<div class="summary_tabs_my_events_ticket_refunded">Valid Tickets Sold: ' . esc_html($ticket_info['total_tickets_sold_lifetime']) . '</div>';
}
add_shortcode('valid_tickets_sold', 'shortcode_valid_tickets_sold');







function shortcode_revenue() {
    $ticket_info = get_ticket_info(get_current_user_id());
    $total_sales_lifetime = $ticket_info['total_sales_lifetime'];

    return '
    <div class="sales-card today_sale_admin_dashboard">
        <div class="sales-card-content ">
            <div class="sales-today ">
                <h5 class="admin_dashboard_sales-label card_admin_dashboard ">Revenue</h5>
                <div class="admin_dashboard_sales-amount ">£' . esc_html(number_format($total_sales_lifetime, 2)) . ' <span class="admin_dashboard_sales-amount_span">GBP</span></div>
                <div class="admin_dashboard_sales-amount_view_full_report">
                    <a href="YOUR_LINK_HERE">View Full Breakdown</a>
                </div>                
            </div>
            <!-- Additional sections can go here -->
        </div>
    </div>';
}
add_shortcode('revenue', 'shortcode_revenue');









function shortcode_current_user_upcoming_live_events_count() {
    if (!is_user_logged_in()) {
        return 'You must be logged in to view your events.';
    }

    $current_user_id = get_current_user_id();
    $today_date = date('Y-m-d');

    // Query for live events happening today or in the future
    $events = tribe_get_events([
        'posts_per_page' => -1, // Retrieve all matching events
        'start_date'     => $today_date, // From today onwards
        'end_date'       => '2030-12-31', // Arbitrary far future date
        'author'         => $current_user_id, // Events by the current user
        'post_status'    => 'publish', // Only published (live) events
    ]);

    // Count the events
    $upcoming_live_events_count = count($events);

    // Return the count in the specified HTML layout
    return '
    <div class="sales-card today_sale_admin_dashboard">
        <div class="sales-card-content ">
            <div class="sales-today ">
                <h5 class="admin_dashboard_sales-label card_admin_dashboard ">Live Events</h5>
                <div class="admin_dashboard_sales-amount ">' . $upcoming_live_events_count . ' <span class="admin_dashboard_sales-amount_span">Events</span></div>
                <div class="admin_dashboard_sales-amount_view_full_report">
                    <a href="/organizer-events/">View Live Events </a>
                </div>                
            </div>
            <!-- Additional sections can go here -->
        </div>
    </div>';
}

add_shortcode('user_live_events_count', 'shortcode_current_user_upcoming_live_events_count');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



///FUNCTION FOR THE EVENT STAUS 
add_action( 'init', 'update_event_status' );

function update_event_status() {
    if (
        isset( $_POST['event_status_nonce'], $_POST['event_status'], $_POST['event_id'] ) &&
        wp_verify_nonce( $_POST['event_status_nonce'], 'event_status_update' )
    ) {
        $event_id = absint( $_POST['event_id'] );
        $new_status = sanitize_text_field( $_POST['event_status'] );

        if ( current_user_can( 'edit_post', $event_id ) && in_array( $new_status, [ 'draft', 'publish' ] ) ) {
            wp_update_post( [
                'ID'          => $event_id,
                'post_status' => $new_status
            ] );
        }
    }
}





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///FUNCTION TO GET THE LASTES 5 ORDER FOR THE CURRENT USER 
function get_latest_orders_for_events($limit = 4, $page = 1) {
    $current_user_id = get_current_user_id(); // Get the current user ID
    $offset = ($page - 1) * $limit; // Calculate the offset for the current page
    
    // Define the query for orders
    $query_args = array(
        'limit' => $limit,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'status' => array('completed', 'processing', 'on-hold'),
        'paginate' => true
    );

    // Fetch the orders
    $orders_pagination = wc_get_orders($query_args);
    $latest_orders = $orders_pagination->orders;

    $order_data = [];

    foreach ($latest_orders as $order) {
        if (!($order instanceof WC_Order)) {
            continue;
        }

        $items = $order->get_items();
        $valid_for_user = false;

        foreach ($items as $item) {
            $event_id = get_post_meta($item->get_product_id(), '_tribe_wooticket_for_event', true);

            if ($event_id) {
                $event_author_id = get_post_field('post_author', $event_id);
                if ($event_author_id == $current_user_id) {
                    $valid_for_user = true;
                    break;
                }
            }
        }

        if ($valid_for_user) {
            $data = new stdClass();
            $data->order_id = $order->get_id();
            $data->customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
            $data->customer_email = $order->get_billing_email();
            $data->order_status = wc_get_order_status_name($order->get_status());
            $data->order_subtotal = $order->get_subtotal();
            $data->ticket_names = [];
            $data->time_since = human_time_diff(strtotime($order->get_date_created()->date('Y-m-d H:i:s'))) . ' ago';

            foreach ($items as $item) {
                $product_name = $item->get_name();
                $data->ticket_names[] = $product_name;
            }

            $order_data[] = $data;
        }
    }

    return array('orders' => $order_data, 'total_pages' => $orders_pagination->max_num_pages);
}


function recent_activity_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 4,
        'page' => 1
    ), $atts, 'recent_activity');

    $latest_orders_data = get_latest_orders_for_events($atts['limit'], $atts['page']);
    $latest_orders = $latest_orders_data['orders'];

    ob_start();
    ?>



<div class="admin_dashboard_main_recent_activity">
    <h2>Recent Activity <span>Last 24h</span></h2>
    <div class="admin_dashboard_main_activity_titles">
        <div>Customer</div>
        <div>Product</div>
        <div>Status</div>
        <div>Purchased</div>
        <div>Amount</div>
    </div>
    <div class="admin_dashboard_main_activity_list">
        <?php foreach ($latest_orders as $order_info): ?>
        <div class="admin_dashboard_main_activity_item">
            <div class="admin_dashboard_main_customer_info">
                <strong class="title">Customer</strong>
                <strong><?php echo esc_html($order_info->customer_name); ?></strong>
                <span><?php echo esc_html($order_info->customer_email); ?></span>
            </div>
            <div class="admin_dashboard_main_product">
                <strong class="title">Product</strong>
                <?php 
                $product_names = implode(', ', $order_info->ticket_names);
                if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                    echo esc_html(mb_strlen($product_names) > 20 ? mb_substr($product_names, 0, 20) . '...' : $product_names);
                } else {
                    echo esc_html(strlen($product_names) > 20 ? substr($product_names, 0, 20) . '...' : $product_names);
                }
                ?>
            </div>
            <div class="admin_dashboard_main_status">
                <strong class="title">Status</strong>
                <span class="status_result"><?php echo esc_html($order_info->order_status); ?></span>
            </div>
            <div class="admin_dashboard_main_retained">
                <strong class="title">Purchased</strong>
                <span class="time_info"><?php echo esc_html($order_info->time_since); ?></span>
            </div>
            <div class="admin_dashboard_main_amount">
                <strong class="title">Amount</strong>
                <?php echo wc_price($order_info->order_subtotal); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>



    <?php
    return ob_get_clean();
}
add_shortcode('recent_activity', 'recent_activity_shortcode');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handle_create_new_organizer() {
    // Check for nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'create_new_organizer_nonce')) {
        wp_send_json_error('Nonce verification failed.');
        return;
    }

    // Ensure only logged-in users can create an organizer
    if (!is_user_logged_in()) {
        wp_send_json_error('User must be logged in.');
        return;
    }

    $current_user_id = get_current_user_id();

    $organizer_data = array(
        'post_title'   => 'New Organizer', // Default title, you can modify as needed
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'tribe_organizer',
        'post_author'  => $current_user_id
    );

    $organizer_id = wp_insert_post($organizer_data);

    if (is_wp_error($organizer_id)) {
        // Log and send error response
        error_log('Error creating organizer: ' . $organizer_id->get_error_message());
        wp_send_json_error('Error creating new organizer: ' . $organizer_id->get_error_message());
    } else {
        // Log success and send success response
        error_log('Organizer created: ' . $organizer_id);
        wp_send_json_success(array('organizer_id' => $organizer_id));
    }
}

add_action('wp_ajax_create_new_organizer', 'handle_create_new_organizer');
// If you want non-logged in users to create organizers, uncomment the following line:
// add_action('wp_ajax_nopriv_create_new_organizer', 'handle_create_new_organizer');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/////////////FUNCTIONS FOR NEW AND EDIT EVENT 


////FUNCTION TO LIMIT EVENT IMAGE UPLOAD TO 1MB
add_filter( 'tribe_community_events_max_file_size_allowed', function() {
    return 1048576; // 1MB
} );


/*
add_filter( 'tribe_events_community_required_fields', 'my_community_required_fields', 10, 1 );

function my_community_required_fields( $fields ) {

if ( ! is_array( $fields ) ) {
return $fields;
}

$fields[] = 'event_image';

return $fields;
}
*/
add_action('save_post_tribe_events', 'save_event_sponsors', 10, 3);

function save_event_sponsors($post_id, $post, $update) {
    if (!isset($_FILES['event_sponsors_logo'])) {
        return;
    }

    $sponsor_logos = $_FILES['event_sponsors_logo'];
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size = 500 * 1024; // 500KB in bytes

    for ($i = 0; $i < count($sponsor_logos['name']); $i++) {
        if (!in_array($sponsor_logos['type'][$i], $allowed_types) || $sponsor_logos['size'][$i] > $max_size) {
            continue;
        }

        if ($sponsor_logos['error'][$i] == UPLOAD_ERR_OK) {
            $tmp_name = $sponsor_logos['tmp_name'][$i];
            $name = basename($sponsor_logos['name'][$i]);
            $upload_dir = wp_upload_dir();
            $path = $upload_dir['path'] . '/' . $name;

            if (move_uploaded_file($tmp_name, $path)) {
                $attachment_id = wp_insert_attachment(array(
                    'guid' => $upload_dir['url'] . '/' . $name,
                    'post_mime_type' => $sponsor_logos['type'][$i],
                    'post_title' => preg_replace('/\.[^.]+$/', '', $name),
                    'post_content' => '',
                    'post_status' => 'inherit'
                ), $path, $post_id);

                add_post_meta($post_id, 'event_sponsor_logo', $attachment_id);
            }
        }
    }
}
// Function to handle the AJAX request for removing a sponsor logo for logged-in users
add_action('wp_ajax_remove_sponsor_logo', 'handle_remove_sponsor_logo');

// Function to handle the AJAX request for removing a sponsor logo for logged-out users
add_action('wp_ajax_nopriv_remove_sponsor_logo', 'handle_remove_sponsor_logo');

function handle_remove_sponsor_logo() {
    // Check for nonce security
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'remove_sponsor_logo_nonce')) {
        wp_send_json_error(array('error' => 'Nonce verification failed.'));
        exit;
    }

    $logo_id = isset($_POST['logo_id']) ? intval($_POST['logo_id']) : 0;
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

    if ($logo_id > 0 && $event_id > 0) {
        if (delete_post_meta($event_id, 'event_sponsor_logo', $logo_id)) {
            wp_delete_attachment($logo_id, true);
            wp_send_json_success();
        } else {
            wp_send_json_error(array('error' => 'Failed to remove logo from event metadata.'));
        }
    } else {
        wp_send_json_error(array('error' => 'Invalid logo or event ID.'));
    }

    exit;
}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////BUGGGGGGGGGGG ON HERE*********/

///FUNCTION TO REDRIECT THE USER AFTER EVENT SUBMIT OR UPDATE 
// Redirect after event submission or update
// add_action('template_redirect', 'tribe_submission_redirect');

// function tribe_submission_redirect() {
//     // Check if we're on the event submission page and an event has been submitted
//     if (isset($_POST['community-event'])) {
//         // Get the event ID from the submitted form
//         $event_id = isset($_POST['post_ID']) ? intval($_POST['post_ID']) : 0;

//         // Ensure we have a valid event ID
//         if ($event_id > 0) {
//             // Construct the URL to the custom submission received page, including the event ID
//             $url = home_url("/event-submission-received?event_id={$event_id}");

//             // Redirect to the custom URL and exit
//             wp_redirect($url);
//             exit;
//         }
//     }
// }

// Shortcode to display event submission response
function my_event_submission_response_shortcode($atts) {
    // Get the event ID from the URL
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

    // Make sure we have an event ID before proceeding
    if ($event_id <= 0) {
        return 'No event found.';
    }

    // Construct the URLs
    $view_event_url = esc_url(get_permalink($event_id));
    $edit_event_url = esc_url(home_url('/organizer-edit-event/?event_id=' . $event_id));

    // Build the output
    $output = "<div class='event-submission-response'>";
    $output .= "<p>Your event has been created successfully!</p>";
    $output .= "<a href='{$view_event_url}' class='button'>View Event</a> ";
    $output .= "<a href='{$edit_event_url}' class='button'>Edit Event</a>";
    $output .= "</div>";

    return $output;
}

// Register the shortcode
add_shortcode('event_submission_response', 'my_event_submission_response_shortcode');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/**
 * Dynamically generates and processes the [tribe_community_events] shortcode for editing an event
 * based on the 'event_id' query parameter present in the URL. This allows for the dynamic editing of events
 * without hardcoding the event ID in the shortcode, making it versatile for use across different events.
 * If a valid 'event_id' is not present in the URL, the function returns an error message prompting for a valid event ID.
 */
function dynamic_tribe_edit_event_shortcode() {
    // Check if the 'event_id' query parameter is set in the URL
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

    // Check if a valid event_id is provided
    if ($event_id > 0) {
        // Generate the tribe_community_events shortcode with the dynamic event ID
        $shortcode = "[tribe_community_events view='edit_event' id='$event_id']";

        // Execute and return the tribe_community_events shortcode
        return do_shortcode($shortcode);
    }

    // Return an error message or empty string if event_id is not valid
    return 'Please provide a valid event ID in the URL.';
}
add_shortcode('dynamic_edit_event', 'dynamic_tribe_edit_event_shortcode');





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////FUNCTION FOR EXTRA SECTION ON EDIT-EVENT.PHP



////////EDIT EVENT FAQ SECTION FUNCTION
function save_event_faqs($post_id, $post, $update) {
    // Check if it's the correct post type.
    if ($post->post_type !== 'tribe_events') return;

    // Verify the nonce for security.
    if (!isset($_POST['event_faqs_nonce']) || !wp_verify_nonce($_POST['event_faqs_nonce'], 'save_event_faqs')) return;

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) return;

    // Check if doing autosave.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Initialize an array to store clean FAQs data
    $clean_faqs = [];

    // Check if FAQs data is submitted
    if (isset($_POST['event_faqs']) && is_array($_POST['event_faqs'])) {
        // Re-index the FAQs array to ensure numerical indexing without gaps.
        $faqs = array_values($_POST['event_faqs']);

        foreach ($faqs as $faq) {
            // Check if the FAQ has both a question and an answer.
            if (!empty($faq['question']) && !empty($faq['answer'])) {
                // Sanitize the data.
                $question = sanitize_text_field($faq['question']);
                $answer = sanitize_textarea_field($faq['answer']);

                // Add the sanitized FAQ to the clean array.
                $clean_faqs[] = ['question' => $question, 'answer' => $answer];
            }
        }
    }

    // Update the event's FAQs metadata.
    update_post_meta($post_id, 'event_faqs', $clean_faqs);
}

add_action('save_post', 'save_event_faqs', 10, 3);




///function for edit event agenda
function save_event_agendas($post_id, $post, $update) {
    if ($post->post_type !== 'tribe_events') return;
    if (!isset($_POST['admin_agenda_event_agendas_nonce']) || !wp_verify_nonce($_POST['admin_agenda_event_agendas_nonce'], 'save_event_agendas')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $clean_agendas = [];
    if (isset($_POST['event_agendas']) && is_array($_POST['event_agendas'])) {
        $agendas = array_values($_POST['event_agendas']);
        foreach ($agendas as $agenda) {
            if (!empty($agenda['time_from']) && !empty($agenda['time_to']) && !empty($agenda['title'])) {
                $clean_agendas[] = [
                    'time_from' => sanitize_text_field($agenda['time_from']),
                    'time_to' => sanitize_text_field($agenda['time_to']),
                    'title' => sanitize_text_field($agenda['title']),
                ];
            }
        }
    }
    update_post_meta($post_id, 'event_agendas', $clean_agendas);
}
add_action('save_post', 'save_event_agendas', 10, 3);









///function for edit event line ups 
function save_event_line_up($post_id, $post, $update) {
    if ($post->post_type !== 'tribe_events') return;
    if (!isset($_POST['event_line_up_nonce']) || !wp_verify_nonce($_POST['event_line_up_nonce'], 'save_event_line_up')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $clean_line_up = [];
    if (isset($_POST['event_line_up']) && is_array($_POST['event_line_up'])) {
        foreach ($_POST['event_line_up'] as $line_up_item) {
            if (!empty($line_up_item['name'])) {
                $clean_line_up[] = [
                    'name' => sanitize_text_field($line_up_item['name']),
                ];
            }
        }
    }
    update_post_meta($post_id, 'event_line_up', $clean_line_up);
}
add_action('save_post', 'save_event_line_up', 10, 3);




///function for edit event extra options 
function save_event_extra_options($post_id, $post, $update) {
    // Security checks
    if (!isset($_POST['event_extra_options_nonce']) || !wp_verify_nonce($_POST['event_extra_options_nonce'], 'save_event_extra_options')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($post->post_type !== 'tribe_events') return;

    // Save 'over 18' option
    $over18 = isset($_POST['over18']) ? 'on' : ''; // Change to 'on' and '' to align with the checked() function
    update_post_meta($post_id, 'over18', $over18);
    $over14 = isset($_POST['over14']) ? 'on' : '';
    update_post_meta($post_id, 'over14', $over14);

    // Save 'over 15' option
    $over15 = isset($_POST['over15']) ? 'on' : '';
    update_post_meta($post_id, 'over15', $over15);

    // Save 'no refunds' option
    $norefunds = isset($_POST['norefunds']) ? 'on' : '';
    update_post_meta($post_id, 'norefunds', $norefunds);
}
add_action('save_post_tribe_events', 'save_event_extra_options', 10, 3);



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////FUNCTION FOR PENING PAYMENT OR PAID FOR THE EVENT OGINSRZER 
// Add event payment status meta box
// Add event payment status meta box
function add_event_payment_status_meta_box() {
    add_meta_box(
        'event_payment_status_meta_box',
        'Event Payment Status',
        'event_payment_status_meta_box_callback',
        'tribe_events',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_event_payment_status_meta_box');

function event_payment_status_meta_box_callback($post) {
    wp_nonce_field(basename(__FILE__), 'event_payment_status_nonce');
    $payment_status = get_post_meta($post->ID, '_payment_status', true) ?: 'awaiting_event';

    echo '<select name="event_payment_status" id="event_payment_status">
            <option value="awaiting_event"' . selected($payment_status, 'awaiting_event', false) . '>Not Ended</option>
            <option value="pending"' . selected($payment_status, 'pending', false) . '>Pending Payment</option>
            <option value="paid"' . selected($payment_status, 'paid', false) . '>Paid</option>
          </select>';
}

function save_event_payment_status($post_id) {
    if (!isset($_POST['event_payment_status_nonce']) || !wp_verify_nonce($_POST['event_payment_status_nonce'], basename(__FILE__)) ||
        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||
        !current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_payment_status'])) {
        update_post_meta($post_id, '_payment_status', sanitize_text_field($_POST['event_payment_status']));
    }
}
add_action('save_post', 'save_event_payment_status');

// Schedule daily event status updates
function schedule_daily_event_status_update() {
    if (!wp_next_scheduled('daily_event_status_check')) {
        wp_schedule_event(time(), 'daily', 'daily_event_status_check');
    }
}
add_action('wp', 'schedule_daily_event_status_update');

// Automated status update for past events
function update_event_payment_status() {
    $args = array(
        'post_type' => 'tribe_events',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_EventEndDate',
                'value' => current_time('mysql'),
                'compare' => '<',
                'type' => 'DATETIME'
            ),
            array(
                'key' => '_payment_status',
                'compare' => 'NOT IN',
                'value' => array('paid', 'pending') // Only update if status is not already 'paid' or 'pending'
            )
        )
    );

    $query = new WP_Query($args);

    foreach ($query->posts as $post) {
        update_post_meta($post->ID, '_payment_status', 'pending');
    }
}
add_action('daily_event_status_check', 'update_event_payment_status');



// Hook when the payment status is updated to 'Paid'
function update_payment_date_on_paid_status($new_status, $old_status, $post) {
    error_log('update_payment_date_on_paid_status triggered'); // Add this line for debugging

    // Check if the status changed to 'Paid'
    if ($new_status === 'paid' && $old_status !== 'paid') {
        // Update the payment date to the current date and time
        update_post_meta($post->ID, '_payment_date', current_time('mysql'));
    }
}
add_action('transition_post_status', 'update_payment_date_on_paid_status', 10, 3);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////FUNCTION FOR TO ADD USER BANK DETAILS FORM IN S SHORTCODE THE SHOW ON THE BACKEND USER PAGE SECTION AND THE FUNCTION TO DELETE THE DETAILS FOR ADMIN ONLY 

// Function to handle saving bank details
function save_bank_details() {
    if (isset($_POST['save_bank_details'])) {
        $user_id = get_current_user_id();
        $full_name = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
        $shortcode = isset($_POST['shortcode']) ? sanitize_text_field($_POST['shortcode']) : '';
        $account_number = isset($_POST['account_number']) ? sanitize_text_field($_POST['account_number']) : '';

        // Validate input data
        if (empty($full_name) || empty($shortcode) || empty($account_number)) {
            return "<div class='error'><p>Please fill all required fields.</p></div>";
        }

        // Save bank details in user meta
        $bank_details = array(
            'full_name' => $full_name,
            'shortcode' => $shortcode,
            'account_number' => $account_number
        );
        $saved = update_user_meta($user_id, 'bank_details', $bank_details);

        // Send email to site admin
        if ($saved) {
            $to = get_option('admin_email');
            $subject = 'New Bank Details Entry';
            $message = 'A new bank details entry has been added by user ID ' . $user_id . '.';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($to, $subject, $message, $headers);
        }

        if ($saved) {
            return "<div class='updated'><p>Bank details saved successfully.</p></div>";
        } else {
         
        }
    }
}

// Add action to handle form submission
add_action('init', 'save_bank_details');

// Function to display bank details form
function display_bank_details_form() {
    if (!is_user_logged_in()) {
        return 'You must be logged in to add bank details.';
    }

    // Check if the user has already saved bank details
    $user_id = get_current_user_id();
    $bank_details = get_user_meta($user_id, 'bank_details', true);

    // Check if form is submitted and display message accordingly
    $form_message = save_bank_details();

    if (!empty($bank_details)) {
        $message = '<div class="sales-card today_sale_admin_dashboard admin_bank_details_card">';
        $message .= '<h5 class="admin_dashboard_bank_details-label card_admin_dashboard">Bank Details</h5>';
        $message .= '<p class="bank-details-item">Full Name: <span>' . esc_html($bank_details['full_name']) . '</span></p>';
        $message .= '<p class="bank-details-item">Sort Code: <span>' . esc_html($bank_details['shortcode']) . '</span></p>';
        $message .= '<p class="bank-details-item">Account Number: <span>' . esc_html($bank_details['account_number']) . '</span></p>';
        $message .= '<p class="bank-details-message"><strong>Bank details can\'t be edited once entered for security reasons. If you require changes, please <a href="/contact-us/" target="_blank">contact us</a>.</strong></p>';
        $message .= '</div>';
        return $form_message . $message;
    }

    // Display the bank details form
    ob_start();
    ?>
    <div class="sales-card today_sale_admin_dashboard admin_bank_details_card">
        <h5 class="admin_dashboard_bank_details-label card_admin_dashboard">Bank Details</h5>
        <form method="post" action="">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" placeholder="Full Name" required>
            <label for="shortcode">Sort Code:</label>
            <input type="text" name="shortcode" id="shortcode" placeholder="Sort Code" required pattern="[0-9]*">
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" id="account_number" placeholder="Account Number" required pattern="[0-9]*">
            <p>Bank details cannot be changed once saved. <a href="/terms-and-conditions/" target="_blank">Contact support for any updates.</a></p>
            <div class="terms_condtion_bank_details">
                <input type="checkbox" name="terms" id="terms" required>
                <label id="term_bank_details" for="terms">I agree to the <a href="/terms-and-conditions/" target="_blank">Terms and Conditions</a>.</label>
            </div>
            <input class="terms_bank_details_submit_btn" type="submit" name="save_bank_details" value="Save Bank Details">
        </form>
    </div>
    <?php
    return $form_message . ob_get_clean();
}
add_shortcode('bank_details_form', 'display_bank_details_form');

// Function to handle deleting bank details on admin backend
function delete_bank_details_on_admin_backend($user_id) {
    if (isset($_POST['delete_bank_details'])) {
        $deleted = delete_user_meta($user_id, 'bank_details');
        if ($deleted) {
            echo "<div class='updated'><p>Bank details deleted successfully.</p></div>"; // Display success message
        } else {
            echo "<div class='error'><p>Failed to delete bank details.</p></div>"; // Display error message
        }
    }
}
 
add_action('show_user_profile', function($user) {
    delete_bank_details_on_admin_backend($user->ID);
});

add_action('edit_user_profile', function($user) {
    delete_bank_details_on_admin_backend($user->ID);
});

// Function to display bank details in user profile
function add_bank_details_field($user) {
    $bank_details = get_user_meta($user->ID, 'bank_details', true);
    ?>
    <div class="sales-card today_sale_admin_dashboard admin_bank_details_card">
        <h5 class="admin_dashboard_bank_details-label card_admin_dashboard">Bank Details</h5>
        <?php if (!empty($bank_details)) : ?>
            <p class="bank-details-item">Full Name: <span><?php echo esc_html($bank_details['full_name']); ?></span></p>
            <p class="bank-details-item">Sort Code: <span><?php echo esc_html($bank_details['shortcode']); ?></span></p>
            <p class="bank-details-item">Account Number: <span><?php echo esc_html($bank_details['account_number']); ?></span></p>
            <form method="post" action="">
                <input type="submit" name="delete_bank_details" value="Delete Bank Details">
            </form>
        <?php else : ?>
            <p>No bank details found.</p>
        <?php endif; ?>
    </div>
    <?php
}
add_action('show_user_profile', 'add_bank_details_field');
add_action('edit_user_profile', 'add_bank_details_field');




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Add shortcode to display the image upload form
include get_stylesheet_directory() . '/organiser-image-gallery.php';


// Add shortcode to display organiser account settings 
include get_stylesheet_directory() . '/organiser-all-gallery.php';



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////END////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////NEW FUNCTION ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











function add_inline_custom_admin_css() {
    ?>
    <style type="text/css">
    .stellarwp-telemetry-modal {
        position: fixed;
        bottom: 0;
        display: none!important;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999999;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        transition: all 0.3s ease-in-out;
        visibility: hidden;
        pointer-events: none;
        opacity: 0;
    }
    </style>
    <?php
}
add_action('admin_head', 'add_inline_custom_admin_css');
