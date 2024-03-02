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
    $('.loadingAnimation').show();

    // Counter to keep track of loaded images
    var totalImages = $('.ticketImage img').length;
    var loadedImages = 0;

    // Check if there are images to load
    if (totalImages > 0) {
        $('.ticketImage img').each(function() {
            var imgSrc = $(this).attr('src');
            // Create a temporary image to preload
            $('<img/>').on('load', function() {
                loadedImages++;
                // When an image is loaded, update its parent .ticketImage with a background
                var parentTicketImage = $('.ticketImage img[src="' + imgSrc + '"]').closest('.ticketImage');
                parentTicketImage.css({
                    'background-image': 'url(' + imgSrc + ')',
                    'background-size': 'cover',
                    'background-position': 'center center',
                    'position': 'relative',
                    'overflow': 'hidden'
                });

                // Create and append the glass effect overlay
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
                // Ensure the img element stays visible on top of the glass effect
                parentTicketImage.find('img').css({
                    'position': 'relative',
                    'z-index': '2'
                });

                // If all images are loaded, fade out the loading animation and fade in the ticket containers
                if (loadedImages === totalImages) {
                    $('.loadingAnimation').fadeOut('slow', function() {
                        $('.ticketContainer').fadeIn('slow');
                    });
                }
            }).attr('src', imgSrc); // Trigger the load event
        });
    } else {
        // If there are no images to load, directly transition from loading to tickets
        $('.loadingAnimation').fadeOut('slow', function() {
            $('.ticketContainer').fadeIn('slow');
        });
    }
});



</script>









<style>
/* Loading Animation */
.loadingAnimation {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* or adjust based on your layout */
}

.loadingAnimation:before {
  content: '';
  width: 50px;
  height: 50px;
  border: 5px solid rgba(255, 2550, 255, 0.1);
  border-top-color: #000;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}




.ticketContainer {
    display: none; /* Initially hide the ticket container intill js is loadded */
}




	.ticket_inner_div{
		padding:5px 10px
	}
hr {
    width: 100%;
    border: 1px solid #efefef;
	margin-bottom: 11px;
    margin-top: 11px;
}
/* Main Ticket Style */
.ticketContainer{
   
    flex-direction: column;
    align-items: center;
}
.ticketImage, .ticketImage img{
	max-height:150px
}
	.ticketImage img{
		width: 200px;
    margin: 0 auto;

	}
	.ticketImage{
		    display: flex;
	}
.ticket{

    background-color: white;
    color: #1a1a1a!important;
    border-radius: 12px;
	max-width: 350px;

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
font-size: 18px;
    line-height: 22px;
    font-weight: 700;
}
hr{
    width: 90%;
    border: 1px solid #efefef;
}
.ticketDetail , .ticketSubDetail{
    font-size: 15px!important;
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
    </style>


<?php
