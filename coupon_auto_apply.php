<?php

add_action('init', 'start_session', 1);
function start_session() {
    if (!session_id()) {
        session_start();
    }

    if (isset($_GET['coupon'])) {
        $_SESSION['applied_coupon'] = sanitize_text_field($_GET['coupon']);
    }
    
}

// Function to set session variable if coupon parameter is present
function set_coupon_session() {
    if (isset($_GET['coupon'])) {
        $_SESSION['applied_coupon'] = sanitize_text_field($_GET['coupon']);
    }
}

// Hook the function to set session variable when the WooCommerce product page loads
//add_action('woocommerce_before_single_product', 'set_coupon_session');

// Function to display the price drop
function display_price_with_discount() {
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
function auto_apply_coupon_to_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (empty($cart->get_applied_coupons())) {
        if (isset($_SESSION['applied_coupon'])) {
            $coupon_code = $_SESSION['applied_coupon'];
            
            $coupon = new WC_Coupon($coupon_code);
            var_dump($coupon->is_valid());
                exit();
            if ($coupon->is_valid()) {
                $cart->apply_coupon($coupon_code);
                
                $_SESSION['applied_coupon'] = null;
            }
        }
    }
}

// Hook the function to automatically apply coupon to the cart
add_action('woocommerce_before_calculate_totals', 'auto_apply_coupon_to_cart');