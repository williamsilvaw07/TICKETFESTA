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






<script>


document.addEventListener('DOMContentLoaded', function() {
    // Select the email input field by its ID
    var emailInput = document.getElementById('account_email');

    // Check if the element exists to avoid errors
    if (emailInput) {
        // Set the input field to read-only
        emailInput.readOnly = true;

        // Optionally, disable autocomplete which some browsers may ignore
        emailInput.autocomplete = 'off';
    }
});
</script>

<style>

.woocommerce-MyAccount-navigation{
    min-height: 100%;
    position: relative;
 padding-top:50px;
 height: auto;
    background-color: rgb(26, 26, 26);
    overflow: auto;
    padding-left: 15px;
    padding-right: 15px;
    flex: 0 0 auto!important;
    width: fit-content!important;
}
.my-account-welcome-message {
  
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;

}


.woocommerce-MyAccount-navigation li a{
text-decoration: none;
list-style: none;
font-size: 14px;

}

.woocommerce-MyAccount-navigation i {
    padding-right: 10px;
}
.woocommerce-MyAccount-navigation-link--payment-methods{
    display:none!important
}

#custom-welcome-message{
    margin-top: 20px;
    text-align: left;
    text-transform: capitalize;
    color:white!important
}

/* Target the active link */
.woocommerce-MyAccount-navigation-link.is-active a {
    background: linear-gradient(270deg, rgba(211, 250, 22, 0.28) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);
    color: white;
    position: relative;
}

.woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link.is-active a:before {
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
#account_email {
    background-color: #303030;
    color: #686868; /* Darker text for better readability */
    cursor: not-allowed; /* Show a 'not allowed' cursor on hover */
}
/* Remove borders from all input fields */
.woocommerce-MyAccount-content input   {
    border: none; /* Removes border */
}

/* Hide display name input and its description */
#account_display_name,
#account_display_name + span , label[for="account_display_name"] , .woocommerce-error {
    display: none!important;
}
body .woocommerce-table__product-name{
    display: flex;
    flex-direction: column;
    align-items: flex-start !important;
    justify-content: center;
}

.woocommerce-MyAccount-content {
    color: white; /* This will change the text color of all child elements to white */
}

.woocommerce-MyAccount-content a {
    color: white; /* This ensures that links are also white */
}





@media (max-width: 950px) {
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
    .woocommerce-MyAccount-navigation li {
    width: 40px;
}
.woocommerce-MyAccount-navigation i {
    padding-right: 0px;
}
.woocommerce-MyAccount-navigation li.is-active a {
    text-align: center!important;
}
.woocommerce-MyAccount-navigation .nav-label {
    display: none; 
}
.woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link.is-active a:before {
    left: 0;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 5px;
    border-radius: 6px;

}
.woocommerce-MyAccount-navigation-link.is-active a {
    background: linear-gradient(180deg, rgba(211, 250, 22, 0.28) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);
 

}
.woocommerce-MyAccount-navigation li a {

    text-align: center;
}
}







	</style>



















<script>


/////////FUNCTIONS AND STYLES FOR THE FOLOWING TAB ON MY ACCOUNT SECTION 



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






////FUNCTION TO ADD THE EVENT IMAGE AS A BACKGROUND 
jQuery(document).ready(function($) {
    $('.event-image').each(function() {
        // Get the src of the img element
        var imgSrc = $(this).find('img').attr('src');

        // Set the background image of the .event-image div to the src of the img
        $(this).css({
            'background-image': 'url(' + imgSrc + ')',
            'background-size': 'cover',
            'background-position': 'center center',
            'position': 'relative',
            'overflow': 'hidden'
        });

        // Create a glass effect overlay
        var glassEffect = $('<div></div>').css({
            'position': 'absolute',
            'top': '0',
            'left': '0',
            'height': '100%',
            'width': '100%',
            'background': 'rgba(0, 0, 0, 0.4)',
            'backdrop-filter': 'blur(8px)',
            'z-index': '1'
        });

        // Append the glass effect overlay to the .event-image div
        $(this).append(glassEffect);

        // Ensure the img element stays visible on top of the glass effect
        $(this).find('img').css({
            'position': 'relative',
            'z-index': '2'
        });
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
	margin-bottom: 6px;
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
    height: 148px;
    max-height: 148px;
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






/****FOLLOWING PAGE  */
h2{
    font-weight: 700;
}
.organiser-following-item img{
    border: 2px solid white;
    border-radius: 100px;
    max-width: 90px;
    width: 100%;
    height: auto;
    object-fit: cover; 
}

.organiser-following-item{
    display: flex;
    gap: 15px;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    margin: 17px 0 41px 0
}

.organiser-details strong{
    font-size: 20px;
    text-transform: capitalize;
}
.organiser-following-item .unfollow-button{
    color: #ffffff;
    background-color: #ea4335;
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 14px;
    text-transform: capitalize;

}
.organiser-following-item .profile-link-button{
    color: black!important;
    background-color: #fff;
    border-radius: 4px;
    padding: 5px 10px!important;
    font-size: 14px;
    text-transform: capitalize;
    text-decoration: none;
    display: block;
    width: fit-content;
    line-height: 24px;
}

.organiser-actions{
    display: flex;
    gap: 14px;
    margin-top: 10px; 
}






/*********END */



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







