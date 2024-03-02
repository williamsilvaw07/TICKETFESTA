<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<p>
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url() )
	);
	?>
</p>

<p>
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	}
	printf(
		wp_kses( $dashboard_desc, $allowed_html ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */









function display_upcoming_events_for_user_with_view_order_button() {
    $user_id = get_current_user_id();
    $displayed_event_ids = array();
    $customer_orders = wc_get_orders(array(
        'meta_key' => '_customer_user',
        'meta_value' => $user_id,
        'post_status' => array('wc-completed'),
    ));


    function truncate_title($title, $maxLength = 30) {
        // Break the title into lines with a maximum length, without breaking words
        $wrapped = wordwrap($title, $maxLength, "\n", true);
        // Split the string into lines
        $lines = explode("\n", $wrapped);
        // Use the first line, if there are multiple lines, append '...'
        return count($lines) > 1 ? $lines[0] . '...' : $title;
    }

    echo '<h2>Upcoming Events You Have Tickets For:</h2>';


    echo '<div class="loadingAnimation">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1366 768" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;stroke:#d3fa16;stroke-width:9;stroke-miterlimit:10;}
            .st1{fill:none;stroke:#d3fa16;stroke-width:9;stroke-miterlimit:10;}
        </style>
        <g>
            <path class="st0 grey" d="M772.5,347c-6.2-14-2.4-29.5,8.4-35.8c1.1-0.6,1.4-2.2,0.8-3.7l-8.5-19.1c-3.4-7.6-11.2-11.4-17.5-8.6
                l-201,89.5c-6.3,2.8-8.7,11.2-5.3,18.8c0,0,6.4,14.3,8.5,19.1c0.6,1.4,2,2.2,3.3,1.8c12-3.8,26,3.7,32.3,17.7s2.4,29.5-8.4,35.8
                c-1.1,0.6-1.4,2.2-0.8,3.7l8.5,19.1c3.4,7.6,11.2,11.4,17.5,8.6l201-89.5c6.3-2.8,8.7-11.2,5.3-18.8l-8.5-19.1
                c-0.6-1.4-2-2.2-3.3-1.8C792.8,368.5,778.7,361,772.5,347z"></path>
            <path class="st1 blue" d="M772.5,347c-6.2-14-2.4-29.5,8.4-35.8c1.1-0.6,1.4-2.2,0.8-3.7l-8.5-19.1c-3.4-7.6-11.2-11.4-17.5-8.6
                l-201,89.5c-6.3,2.8-8.7,11.2-5.3,18.8c0,0,6.4,14.3,8.5,19.1c0.6,1.4,2,2.2,3.3,1.8c12-3.8,26,3.7,32.3,17.7s2.4,29.5-8.4,35.8
                c-1.1,0.6-1.4,2.2-0.8,3.7l8.5,19.1c3.4,7.6,11.2,11.4,17.5,8.6l201-89.5c6.3-2.8,8.7-11.2,5.3-18.8l-8.5-19.1
                c-0.6-1.4-2-2.2-3.3-1.8C792.8,368.5,778.7,361,772.5,347z"></path>
        </g>
    </svg>
</div>';


    
    
    
    
  
    echo '<div class="allTicketsContainer">'; // Open the main container for all tickets here



    if (!empty($customer_orders)) {
        foreach ($customer_orders as $customer_order) {
            $order_url = $customer_order->get_view_order_url();
            $items = $customer_order->get_items();
            $order_paid_date = $customer_order->get_date_paid() ? $customer_order->get_date_paid()->date('d/m/y') : 'N/A';


            foreach ($items as $item_id => $item) {
                $event_id = get_post_meta($item->get_product_id(), '_tribe_wooticket_for_event', true);
                if (in_array($event_id, $displayed_event_ids) || empty($event_id)) {
                    continue;
                }

                $event_start_date = get_post_meta($event_id, '_EventStartDate', true);
                if (strtotime($event_start_date) > current_time('timestamp')) {
                    $event_title = get_the_title($event_id);
                    $event_url = get_permalink($event_id);
                    $event_image_url = get_the_post_thumbnail_url($event_id, 'full') ?: 'https://ticketfesta.co.uk/wp-content/uploads/2024/02/placeholder-4.png';
                    $ticket_quantity = $item->get_quantity();
                    $order_total = $customer_order->get_formatted_order_total();
                    $event_address = tribe_get_address($event_id);
                    // Encode the address for URL use
                    $map_link = "https://maps.google.com/?q=" . urlencode($event_address);

                    ?>
                    


                    
                        <div class="ticket">
                            <div class="ticketImage">
                                <img src="<?php echo $event_image_url; ?>" alt="Event Image">
                            </div>

                             <div class="ticket_inner_div ">
                             <div class="ticketTitle"><?php echo truncate_title($event_title, 30); ?></div>
                            <div class="eventaddress"><?php echo $event_address; ?> <a class="opne_on_map_link" href="<?php echo $map_link; ?>" target="_blank">Open on Map</a></div>
                            <hr>
                            <div class="ticketDetail">
    <div><span class="ticket-detail-title">Event Date:</span>&ensp;<?php echo date_i18n('F j, Y, g:i a', strtotime($event_start_date)); ?></div>
    <div><span class="ticket-detail-title">Ticket Quantity:</span>&ensp;<?php echo $ticket_quantity; ?></div>
    <div>
    <span class="ticket-detail-title">Order Total:</span>
    <span class="woocommerce-Price-amount amount"><bdi><?php echo $order_total; ?></bdi></span>
</div>

</div>

                            </div>
                            <div class="ticketRip">
                                <div class="circleLeft"></div>
                                <div class="ripLine"></div>
                                <div class="circleRight"></div>
                            </div>
                            <div class="ticketSubDetail">
                                <div class="code"><?php echo $customer_order->get_order_number(); ?></div>
                                <div><span class="ticket-detail-title">Paid:</span>&ensp;<?php echo $order_paid_date; ?></div> <!-- Displaying the order paid date -->
                            </div>
                            <div class="ticketlowerSubDetail">
                                <a href="<?php echo $order_url; ?>"><button class="view_ticket_btn">View Ticket</button></a>
                                <a href="<?php echo $event_url; ?>"><button class="view_event_btn">Event Details</button></a>
                            </div>
                        </div>
                 
                    <?php

                    $displayed_event_ids[] = $event_id;
                }
            }
        }
    } else {
        echo "<p>You currently have no tickets for upcoming events.</p>";
    }
}
echo '</div>'; // Close the main container for all tickets









?>





<script>



	////JS TO ADD THE MAIN PRODUCT IMAGE ON THE BACKGROUND AND ADD THE LOCATION ON THE CUSTOM DIV 
    document.addEventListener('DOMContentLoaded', function() {
    var organizerProfileBkElement = document.querySelector('.organizer_profile_bk');
    var titleElement = document.querySelector('.event-listing-main-div_main');

    if (organizerProfileBkElement && titleElement) {
        // Extracting the background image style from the organizer_profile_bk element
        var backgroundImageStyle = organizerProfileBkElement.style.backgroundImage;

        // Setting the extracted background image as the background for the tribe_organizer-template-default element
        titleElement.style.backgroundImage = backgroundImageStyle;
        titleElement.classList.add('organiser_background');
    }
});

///////////END

































// Make the entire event card clickable without affecting interactive elements like buttons and links
jQuery(document).ready(function($) {
   // Find each .event-card element
   $('.event-card').each(function() {
        // Get the href attribute of the first <a> tag found within the .event-card
        var link = $(this).find('a').attr('href');

        // Check if the link is not undefined or empty
        if (link) {
            // Create a new <a> tag that wraps the entire .event-card contents
            $(this).wrapInner('<a class="event-card-link" href="' + link + '"></a>');
        }
    });
});













jQuery(document).ready(function($) {
    // Initially show the loading animation
    $('.loadingAnimation').css('display', 'block');

    var totalImages = $('.ticketImage img').length;
    var loadedImages = 0;

    // Function to check if all images are loaded
    function checkAllImagesLoaded() {
        if (loadedImages === totalImages) {
            // Once all images are loaded, fade out the loading animation and then display the tickets container
            $('.loadingAnimation').fadeOut('fast', function() {
                // Set the tickets container to display flex after it's visible to ensure layout is correct
                $('.allTicketsContainer').css('display', 'flex').hide().fadeIn('slow');
            });
        }
    }

    // If there are images to load, set up a load event listener for each
    if (totalImages > 0) {
        $('.ticketImage img').each(function() {
            var imgSrc = $(this).attr('src');
            $('<img/>').on('load', function() {
                loadedImages++;
                // Apply background styling and glass effect after each image is loaded
                var parentTicketImage = $('.ticketImage img[src="' + imgSrc + '"]').closest('.ticketImage');
                parentTicketImage.css({
                    'background-image': 'url(' + imgSrc + ')',
                    'background-size': 'cover',
                    'background-position': 'center center',
                    'position': 'relative',
                    'overflow': 'hidden'
                });

                var glassEffect = $('<div></div>').css({
                    'position': 'absolute',
                    'top': '0',
                    'left': '0',
                    'height': '100%',
                    'width': '100%',
                    'background': 'rgba(255, 255, 255, 0.4)',
                    'backdrop-filter': 'blur(8px)',
                    'z-index': '1'
                });

                parentTicketImage.append(glassEffect);
                parentTicketImage.find('img').css('position', 'relative').css('z-index', '2');

                // Check if all images are loaded
                checkAllImagesLoaded();
            }).attr('src', imgSrc); // This triggers the load event
        });
    } else {
        // If there are no images, directly fade in the ticket containers
        $('.loadingAnimation').fadeOut('fast', function() {
            $('.allTicketsContainer').css('display', 'flex').hide().fadeIn('slow');
        });
    }
});

</script>








<style>

	.loadingAnimation{
		display:block
	}
.grey {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_0 3200ms infinite, fade 3200ms infinite;
}

.blue {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_1 3200ms infinite, fade 3200ms infinite;
}

@keyframes fade {
  0% {
    stroke-opacity: 1;
  }
  80% {
    stroke-opacity: 1;
  }
  100% {
    stroke-opacity: 0;
  }
}

@keyframes draw_0 {
  9.375% {
    stroke-dashoffset: 789
  }
  39.375% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes draw_1 {
  35.625% {
    stroke-dashoffset: 789
  }
  65.625% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

.allTicketsContainer{
    
    gap: 25px;
    align-items: flex-start;
    align-content: flex-start;
    justify-content: flex-start;
    flex-wrap: wrap;

}

.allTicketsContainer{
    display: none; /* Initially hide the ticket container intill js is loadded */
}

	.ticket_inner_div{
	    padding: 21px 16px 5px 16px;
	}
hr {
	width: 90%;
    border: 1px solid #efefef;
    margin: 17px auto 11px auto;
}
/* Main Ticket Style */
.ticketContainer{
   
    flex-direction: column;
    align-items: center;
}
.ticketImage, .ticketImage img{
    max-height: 130px;
	border-radius: 12px 12px 0px 0;
}
	.ticketImage img{
		width: 200px;
    margin: 0 auto;
	object-fit: contain!important;

	}
	.ticketImage{
		    display: flex;
	}
.ticket{

    background-color: white;
    color: #1a1a1a!important;
    border-radius: 12px;
    max-width: 280px;
	height: fit-content;
    width: 100%;


}
.ticketShadow{
display:none;
    margin-top: 4px;
    width: 95%;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.4);
    filter: blur(12px);
}

/* Ticket Content */
.ticketTitle{
	font-size: 15px;
	line-height: 19px;
    font-weight: 700;
    margin-bottom: 10px;
}

.ticketDetail , .ticketSubDetail , .eventaddress{
    font-size: 14px!important;
    font-weight: 500;
   
}
.ticketSubDetail{
    display: flex;
    justify-content: space-between;
    font-size: 1rem;
    padding: 12px 16px;
}
.ticketSubDetail .code{
    margin-right: 24px;
}

/* Ticket Ripper */
.ticketRip{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.circleLeft{
    width: 12px;
    height: 24px;
    background-color: #1a1a1a;
    border-radius: 0 12px 12px 0;
}
.ripLine{
    width: 100%;
    border-top: 3px solid #1a1a1a;
    border-top-style: dashed ;
}
.circleRight{
    width: 12px;
    height: 24px;
    background-color: #1a1a1a;
    border-radius: 12px 0 0 12px;
}

.opne_on_map_link{
	color: black!important;
    text-decoration: none;
    font-size: 12px;
    border: 1px solid black;
    border-radius: 3px;
    padding: 3px 6px;
}
.ticketDetail .woocommerce-Price-amount bdi , .ticketDetail .woocommerce-Price-currencySymbol{
	color:black!important
}
.ticket-detail-title{
	color: black!important;
    font-size: 13px;
    font-weight: 300;

}
.view_ticket_btn{
	background:#d3fa16;
	color:black;
}
.view_event_btn {
   
	background:black;
	color:white;
}
.view_event_btn  , .view_ticket_btn{
    white-space: nowrap;
    font-size: 12px!important;
    padding: 5px 15px !important;
    border-radius: 4px!important;
    padding-bottom: 3px!important;

}

.ticketlowerSubDetail{
	padding: 5px 10px 21px 10px;
    display: flex;
    justify-content: space-around;
}












@media (max-width: 600px) {
    .allTicketsContainer {
    justify-content: center;
    }

}


    </style>


<?php
