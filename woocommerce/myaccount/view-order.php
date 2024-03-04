<?php
defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<p>

<?php if ( $notes ) : ?>
  
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
