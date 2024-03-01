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
    'dashboard'       => '<i class="fas fa-home"></i>',
    'orders'          => '<i class="fas fa-ticket-alt"></i>',
    'downloads'       => '<i class="fas fa-download"></i>',
    'following'       => '<i class="fas fa-heart"></i>',
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
                    <?php echo isset($icons[$endpoint]) ? $icons[$endpoint] . ' ' : ''; ?><span class="nav-label"><?php echo esc_html( $label ); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>









<style>



/* Target the active link */
.woocommerce-MyAccount-navigation-link.is-active a {
    background: linear-gradient(270deg, rgba(211, 250, 22, 0.28) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);
    color: white;
    position: relative;
}

.woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link.is-active a:after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background-color: #d3fa16;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    z-index: 1; /* Ensure the pseudo-element is above the link background */
}

/* Ensure icons and text within the active link are white */
.woocommerce-MyAccount-navigation-link.is-active a i,
.woocommerce-MyAccount-navigation-link.is-active a .nav-label {
    color: white;
}









@media (max-width: 700px) {
	#custom-welcome-message{
		display:none!important
	}
	.woocommerce-MyAccount-navigation{
		width: 100%!important;
    max-width: 100%;
    height: 76px;
    background-color: #000000;
    position: fixed;
    top: 91.1%;
    left: 0px;
    padding: 4px 4px;
    padding-top: 0;
    z-index: 99;
	}
	.woocommerce-MyAccount-navigation ul{
	    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
    padding: 0 4%;
	}
	.woocommerce-MyAccount-navigation li{
		width: fit-content;
	}

.woocommerce-MyAccount-navigation .nav-label {
    display: none; 
}

}








	</style>