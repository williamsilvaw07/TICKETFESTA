<?php
defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<p>
<?php
printf(
    esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
    '<mark class="order-number">' . esc_html( $order->get_order_number() ) . '</mark>',
    '<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
    '<mark class="order-status">' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</mark>'
);
?>
</p>

<?php
// Loop through order items to find linked events and display their images
$items = $order->get_items();
foreach ( $items as $item_id => $item ) {
    $event_id = wc_get_order_item_meta( $item_id, '_event_id', true ); // Custom meta key for event ID
    if ( !empty( $event_id ) ) {
        $event_image_url = get_the_post_thumbnail_url( $event_id, 'medium' ); // Get event's featured image
        if ( $event_image_url ) {
            echo '<div class="event-image" style="margin-bottom: 20px;">';
            echo '<img src="' . esc_url( $event_image_url ) . '" alt="' . esc_attr( get_the_title( $event_id ) ) . '" style="width: 100%; height: auto;">';
            echo '</div>';
        }
    }
}
?>

<?php if ( $notes ) : ?>
    <h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
    <ol class="woocommerce-OrderUpdates commentlist notes">
        <?php foreach ( $notes as $note ) : ?>
            <li class="woocommerce-OrderUpdate comment note">
                <div class="woocommerce-OrderUpdate-inner comment_container">
                    <div class="woocommerce-OrderUpdate-text comment-text">
                        <p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
                        <div class="woocommerce-OrderUpdate-description description">
                            <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
