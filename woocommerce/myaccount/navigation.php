<?php
/**
 * My Account navigation
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_account_navigation' );

$icons = [
    'dashboard'       => '<i class="fas fa-tachometer-alt"></i>',
    'orders'          => '<i class="fas fa-shopping-bag"></i>',
    'downloads'       => '<i class="fas fa-download"></i>',
    'following'       => '<i class="fas fa-download"></i>',
    'edit-address'    => '<i class="fas fa-address-card"></i>',
    'edit-account'    => '<i class="fas fa-user-cog"></i>',
    'customer-logout' => '<i class="fas fa-sign-out-alt"></i>',
];
?>

<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                    <?php echo isset($icons[$endpoint]) ? $icons[$endpoint] . ' ' : ''; ?><?php echo esc_html( $label ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
