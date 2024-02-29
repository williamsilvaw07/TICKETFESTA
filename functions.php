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

