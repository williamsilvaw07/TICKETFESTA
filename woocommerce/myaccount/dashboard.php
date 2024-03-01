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

</script>









<style>

h1{



}
.organizer-block{
    margin: 60px 0;
    display: flex;
    flex-direction: column;
    gap: 14px;

}

.event-time{
	display:none
}

.organizer-block_events_inner{
    display: flex;
    align-items: stretch;
    justify-content: flex-start;
    flex-direction: row;
    flex-wrap: nowrap;

}

.organizer-block_inner{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    gap: 14px;
    align-content: center;
    align-items: center;
}

.organizer-block_inner img{
    border-radius: 100px;
    max-width: 81px;
    height: 80px;
    object-fit: cover;
    width: 100%;
    border: 3px solid white;

}
.organizer-block_inner h6{
	text-decoration: none;
    font-weight: 600;
}

.organizer_profile_main_div{
    width:100%;
    position: relative;
}
    .event-day , .event-month , .event-title , .event-title a,  .event-actions , .event-actions span , .event-location , .event-time
{
    color: black!important;

}

 /****END***/
 


.event-card{
    flex: 0 1 calc(33.33% - 10px);
    margin: 5px;
    max-width: calc(33.33% - 10px);
    background-color: #262626;
    border-radius: 10px;
    color: rgb(255, 255, 255);
    max-width: 300px;
}
.event-card .event-title{
    color: rgb(255, 255, 255)!important;
    text-decoration: none;
    font-size:16px

}

.event-card .event-details{
 
    padding: 9px 20px 24px;
    padding: 9px 13px;
    height: fit-content;
    background: white;
    color: black!important;


}

.event-title{
    line-height: 20px;
    font-size: 18px;
    font-weight: 800;
}
.event-title a{
    text-decoration: none;
}
.event-month{
    font-weight: 400;
    font-size: 15px;
}

.event-date{
    font-size: 20px;
    font-weight: 800;
}
.event-time-location{
    display: flex;
    flex-direction: column;
    font-size: 15px;
    margin: 5px 0px;
    margin-top: 5px!important;

}


.event-actions a{
    display:none!important;
    text-decoration: none;
    background-color: #FFD700;
    color: black!important;
    padding: 4px 15px;
    font-size: 14px;
    border-radius: 5px;
    padding: 8px 5px;
    width: 100%;
    display: block;
    text-align: center;
    margin-top: 0px;
    justify-content: center;
    align-items: center;
    align-content: center;
    gap: 6px;
}
.event-actions a:hover{
    background-color: #ffffff;
  
}
.event-actions{
    display: flex;
    flex-direction: row;
    align-items: center;
    align-content: center;
    justify-content: flex-start;
    margin-top: 10px!important;
    gap: 10px!important;
}
.event-actions span{
    white-space: nowrap;
    font-weight: 800;
}
.btn-get-tickets img{
    max-width: 23px;
    position: relative;
    top: 0px;
}
.event-location{
    text-transform: capitalize!important;
}






.event-card {
  overflow: hidden; /* Optional: In case of rounded corners to contain the image */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: For a slight shadow effect */
}

.event-image img {
    height: 200px;
    max-height: 220px;
    margin: auto;
    object-fit: contain;
    display: flex;

}

.event-details {
    flex: 1; 
    height: 100%; 
    display: flex!important;
    flex-direction: column;
}
.from-text{
    font-size: 13px!important;
    font-weight: 400!important;
}
.organizer_navbar {
    font-size: 14px;
    gap: 38px;
    background-color: #1A1A1A;
    display: flex;
    justify-content: center; /* Adjusted to center to bring items closer */
    align-items: center;
    padding: 0 9px!important;
    width: 100%;
    border-radius: 0px;
    margin: 0 auto!important;
    position: relative!important;
}
.organizer_nav-item{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 12px 19px 12px 19px!important;
 
}

.organizer_nav-item.active i{
    color:#d3fa16 !important
}
.profile_icon_nav{
    max-width: 17px!important;
}


.organizer_events_content, .organizer_Gallery_content , .organizer_about_content{
    display: none;
}
.organizer_nav-item.active {
    background-color: #767676!important;
}
.organizer_nav-item {
    transition: background-color 0.2s ease; 
}

.organizer_nav-item:hover {
    background-color: #767676; 
    cursor: pointer;
}


.event-day{
    display: flex;
    gap: 6px;
    align-items: center;
}
.event-timezone{
    display: block!important;
    font-size: 11px!important;
    text-transform: capitalize!important;
    font-weight: 500!important;
    margin-top: 0!important;
    color: black!important;
}
.organizer_main_div h3{
padding-bottom: 15px;
font-size: 26px;
font-weight: 600;
text-align: left;
}
.organizer_about_content h3{
    padding-bottom: 0!important 
}






@media (max-width: 890px) {
    .event-listing {
    display: grid;
    grid-template-columns: 50% 50%;
    justify-content: space-evenly;
    align-items: start;
    justify-items: start;
}
.event-card {

    max-width: inherit;
    width: 100%;
}
}










@media (max-width: 605px) {


    .organizer_profile_bk {
        min-height: 340px;
}
    .single-tribe_organizer .image_profile_text_main_continer img {
        border-radius: 100px;
        max-width: 106px;
        width: 106px;
        height: 106px;
        margin-bottom: -3px;
        border: 3px solid white;
        object-fit: cover;
    }
    .single-tribe_organizer .image_profile_text_main_continer {
        margin-top: inherit;
        gap: 2px;
        flex-direction: column;

    }
    .organizer_title_name{
        position: relative;
        top: 2px;
    }
   /* Hide all .organizer_nav-item span elements by default */
.organizer_nav-item span {
    display: none;
}

/* Show span only when .organizer_nav-item has class 'active' */
.organizer_nav-item.organizer_events.active span {
    display: block;
}

    .organizer_nav-item  img{
        max-width: 21px;
    }
    .profile_icon_nav {
        max-width: 15px!important;
    }
    .images-container_main {
      
        display: grid!important;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 3px 17px!important;
    }
   
.single-tribe_organizer .image_profile_text_main_continer {
    padding-bottom: 28px;
    margin-bottom: 6px;
    
}
.organizer_nav-item {

    padding: 7px 17px!important;
}
.organizer_gallery_category {
    gap: 9px;
}
.organizer_tagline{
    line-height: 18px;
    font-size: 15px;
}
.organizer_title_name h1 {
    padding-bottom: 1px;
    font-size: 24px;
}
.organizer_gallery_category_inner img {
    max-width: 100%!important;
}
.event-listing_type {
    gap: 14px;
    font-size: 13px;
}
.tribe-common .tribe-common-l-container  {
    padding-left: 0!important;
    padding-right: 0!important;
}
.organizer_about_main_inner_text p{
    font-size: 15px;
}
.tribe-events-pro .tribe-events-pro-organizer__meta .tec-events-c-view-box-border {

    padding-left: 15px!important;
    padding-right: 15px!important;
}
.organizer_title_name{
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
    gap: 5px;

}


#galleryDisplayArea button {
   
    font-size: 14px;
    padding: 2px 9px;
    margin-bottom: 21px;
    font-size: 12px;
}.lightbox-back-button svg {
    max-width: 12px;
    max-height: 12px;
}
.image-container img{
    margin: 0;
}
.organizer_navbar {
  
    border-radius: 0px;
    margin: 0 auto!important;
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 3;
    justify-content: space-between;
    padding: 10px 20px!important;
    gap: 13px!important;

}
.organizer_nav-item.active {
   
    border-radius: 2px;
    color: black!important;
}
.organizer_nav-item.organizer_events.active span {
    font-size: 13px;
}
.organizer_nav-item{
    gap: 5px; 
    padding: 4px 13px!important;
}
.organizer_main_div h3{
    font-size: 23px;
    }
    .event-listing {

    grid-template-columns: 100%;
   
}
.event-image img {
    height: auto;
    max-height: 264px;
}
body .event-actions a {
    padding: 8px 13px;
    font-size: 13px!important;
    border-radius: 3px;
}
}
  /****END***/


@media (max-width: 390px) {
 
  
    .single-tribe_organizer .image_profile_text_main_continer img {
        max-width: 88px;
        height: 88px;
        width:88px;
        object-fit: cover;
    
    }
    }






    </style>


<?php
