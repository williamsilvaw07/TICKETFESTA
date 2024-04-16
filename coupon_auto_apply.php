<?php

add_action('init', 'start_session', 1);
function start_session()
{
    if (!session_id()) {
        session_start();
    }

    if (isset($_GET['coupon'])) {
        $_SESSION['applied_coupon'] = sanitize_text_field($_GET['coupon']);
    }

}

// Function to set session variable if coupon parameter is present
function set_coupon_session()
{
    if (isset($_GET['coupon'])) {
        $_SESSION['applied_coupon'] = sanitize_text_field($_GET['coupon']);
    }
}


function add_custom_script_to_footer() {
    if (isset($_GET['coupon'])) {
        // Create a new WC_Coupon object
        $coupon = new WC_Coupon(sanitize_text_field($_GET['coupon']));

        // Get coupon details
        $coupon_amount = $coupon->get_amount();
        $coupon_type = $coupon->get_discount_type();
        $coupon_code = strtoupper($coupon->get_code()); // Ensuring code is uppercase
        $currency_symbol = get_woocommerce_currency_symbol(); // Get currency symbol directly from WooCommerce

        // Get expiration and start dates of the coupon
        $expire_date = $coupon->get_date_expires();
        $formatted_expire_date = $expire_date ? $expire_date->date('Y-m-d H:i') : 'No Expiry';
        $start_date = $coupon->get_date_created();
        $formatted_start_date = $start_date ? $start_date->date('Y-m-d H:i') : 'Start Date Not Set';

        // Assemble coupon details for JSON encoding
        $coupon_details = array(
            'code' => $coupon_code,
            'discount_type' => $coupon_type,
            'amount' => $coupon_amount,
            'currency_symbol' => $currency_symbol,
            'start_date' => $formatted_start_date,
            'expire_date' => $formatted_expire_date,
            'current_time' => current_time('Y-m-d H:i')
        );

        $coupon_json = json_encode($coupon_details);

        // JavaScript to update the frontend with new div classes for coupon notice
        $custom_script = "
      
        



        document.addEventListener('DOMContentLoaded', function() {
            var couponData = JSON.parse('$coupon_json');
            var now = new Date(couponData.current_time);
            var startDate = new Date(couponData.start_date);
            var expireDate = couponData.expire_date !== 'No Expiry' ? new Date(couponData.expire_date) : null;
    
            if (now >= startDate && (!expireDate || now <= expireDate)) {
                var couponNotice = document.querySelector('.coupon_notice');
                if (couponNotice) {
                    var discountTypeDetail = couponData.discount_type === 'fixed_cart' ? couponData.currency_symbol + couponData.amount : couponData.amount + '%';
                    var discountText = 'Get ' + discountTypeDetail + ' off';
                    var couponCodeDisplay = couponData.code.length > 11 ? couponData.code.substring(0, 11) + '...' : couponData.code;
                    var couponText = ' with code <span class=\"couponCodeDisplay\">' + couponCodeDisplay + '</span>';
                    var autoApplyText = ' - Autoapplied at checkout.';
                    var closeButton = '<div class=\"close_icon\">&times;</div>';
    
                    couponNotice.innerHTML = '<div class=\"coupon_details\"><span class=\"discount_detail\">' + discountText + '</span> <span class=\"coupon_code\">' + couponText + '</span><span class=\"auto_apply\">' + autoApplyText + '</span></div>' + closeButton;
                }
    
                document.querySelector('.close_icon').addEventListener('click', function() {
                    this.parentNode.style.display = 'none';
                });
            }
        });
    ";
    
    // Add the JavaScript to the page
    wp_add_inline_script('jquery', $custom_script);
    
        // Add the JavaScript to the page
        wp_add_inline_script('jquery', $custom_script);
    }
}
add_action('wp_enqueue_scripts', 'add_custom_script_to_footer');

// Hook the function to set session variable when the WooCommerce product page loads
//add_action('woocommerce_before_single_product', 'set_coupon_session');

// Function to display the price drop
function display_price_with_discount()
{
    global $product;

    // Check if coupon session variable is set
    if (isset($_SESSION['applied_coupon'])) {
        $coupon = $_SESSION['applied_coupon'];
        $regular_price = $product->get_regular_price(); // Get the regular price of the product
        $discounted_price = $product->get_price(); // Get the discounted price based on the coupon
        // Calculate the price drop
        $price_drop = $regular_price - $discounted_price;

        // Display the price drop information
        echo '<p>Price dropped by ' . wc_price($price_drop) . ' with coupon ' . $coupon . '</p>';
    } else {
        // Display regular price if coupon parameter is not present
        echo '<p>' . $product->get_price_html() . '</p>';
    }
}

// Hook the function to display the price drop to the WooCommerce product page
add_action('woocommerce_single_product_summary', 'display_price_with_discount', 10);


// Function to automatically apply coupon when product is added to cart
function auto_apply_coupon_to_cart($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (empty($cart->get_applied_coupons())) {
        if (isset($_SESSION['applied_coupon'])) {
            $coupon_code = $_SESSION['applied_coupon'];

            $coupon = new WC_Coupon($coupon_code);

            if ($coupon->is_valid()) {
                $cart->apply_coupon($coupon_code);

                $_SESSION['applied_coupon'] = null;
            }
        }
    }
}

// Hook the function to automatically apply coupon to the cart
add_action('woocommerce_before_calculate_totals', 'auto_apply_coupon_to_cart');