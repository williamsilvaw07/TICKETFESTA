<?php
// Don't load directly
defined('WPINC') or die;

/**
 * My Events Column for Venue Display
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/columns/venue.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 4.5
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

// Check user permission
if (current_user_can('edit_posts')) :

    // Get the current event's post status
    $post_status = get_post_status($event->ID);

    // Create the dropdown HTML for event status
    $status_dropdown = '<form method="post" action="" class="event-status-form">';
    $status_dropdown .= '<select name="event_status" onchange="this.form.submit();">';
    $status_dropdown .= '<option value="draft"' . selected($post_status, 'draft', false) . '>Draft</option>';
    $status_dropdown .= '<option value="publish"' . selected($post_status, 'publish', false) . '>Published</option>';
    $status_dropdown .= '</select>';

    // Add a nonce field for security and hidden input for event ID
    $status_dropdown .= wp_nonce_field('event_status_update', 'event_status_nonce', true, false);
    $status_dropdown .= '<input type="hidden" name="event_id" value="' . esc_attr($event->ID) . '">';

    // Close the form tag
    $status_dropdown .= '</form>';

    // Print the dropdown form
    echo $status_dropdown;

    // Fetch and display the payment status for the event
    $payment_status = get_post_meta($event->ID, '_payment_status', true);

    // Determine the payment status text based on the payment status value
    switch ($payment_status) {
        case 'paid':
            $payment_status_text = 'Paid';
            $payment_status_class = 'payment-paid';

            // Display the date when it was paid
            $payment_date = get_post_meta($event->ID, '_payment_date', true);
            if (!empty($payment_date)) {
                $formatted_payment_date = date('d/m/Y', strtotime($payment_date)); // Format the date as "day/month/year"
                echo '<div class="payment-date">Paid on: ' . $formatted_payment_date . '</div>';
            }
            break;
        case 'pending':
            // Calculate the countdown to payment
            $event_end_date = get_post_meta($event->ID, '_EventEndDate', true);
            $payment_due_date = strtotime($event_end_date . ' + 4 days');

            $formatted_payment_due_date = date('d/m/Y', $payment_due_date); // Format the date as "day/month/year"

            echo '<div id="countdown-timer"></div>';
            echo '<div class="payment-eta">Payment ETA: ' . $formatted_payment_due_date . '</div>'; // Display formatted Payment ETA
            echo "<script>
                var paymentDueDate = '" . date('Y-m-d H:i:s', $payment_due_date) . "';
                var current_time = new Date().getTime();
                var countdownTimer = setInterval(function() {
                    var now = new Date().getTime();
                    var timeLeft = new Date(paymentDueDate).getTime() - now;
                    var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                    var countdownElement = document.getElementById('countdown-timer');
                    if (countdownElement) {
                        countdownElement.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
                    }
                    if (timeLeft < 0) {
                        clearInterval(countdownTimer);
                        if (countdownElement) {
                            countdownElement.innerHTML = 'Payment is being processed';
                        }
                    }
                }, 1000);
            </script>";

            $payment_status_text = 'Pending Payout';

            $payment_status_class = 'payment-pending';
            break;
        case 'awaiting_event':
        default:
            $payment_status_text = 'Not Ended';
            $payment_status_class = 'payment-awaiting';
            break;
    }

    // Display Payment Status
    echo '<div class="payment-status"><a class="' . $payment_status_class . '">' . $payment_status_text . '</a></div>';

endif;
?>
