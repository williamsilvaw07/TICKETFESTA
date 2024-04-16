<?php
/*
Template Name: Organizer Scanner
*/

?>

<div class="loading_svg_div">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1366 768" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;stroke:#ffff;stroke-width:3;stroke-miterlimit:10;}
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
</div>

<?php

// Include the appropriate header based on user role
$custom_header_path = get_stylesheet_directory() . '/scanner/header-organizer-scanner.php';
if (file_exists($custom_header_path)) {
    require_once($custom_header_path);
} else {
    get_header();  // Default site header for other users
}
?>



<div class="content-wrapper main_content_loading_div">
    <div class="content">
        <div class="container-fluid">
            <?php
            // Adjusted conditional logic to grant access to 'administrator', 'verifier', and 'organiser'
            if (is_user_logged_in() && (current_user_can('administrator') || current_user_can('organiser') || current_user_can('verifier'))) {
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        the_content();  // Display the main content of the page
                    }
                }
            } else {
                // Different messages based on user status
                if (is_user_logged_in()) {
                    echo '<div class="scanner_login_divs_before"><h2>Access Denied</h2><p>You do not have the necessary permissions to access this page. Please contact the support if you believe this is an error.</p></div>';
                } else {
                    echo '<div class="scanner_login_divs_before"><div class="login_prompt"><h4 class="login_form_title">Attendees Check-in:</h4></div>';
                    echo do_shortcode('[xoo_el_inline_form tabs="login" active="login"]');
                    echo '</div>';
                }
            }
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include the custom footer
$custom_footer_path = get_stylesheet_directory() . '/scanner/footer-organizer-scanner.php';
if (file_exists($custom_footer_path)) {
    require_once($custom_footer_path);
} else {
    // Fallback to the default footer if your custom footer is not found
    get_footer();
}
?>

<script>


///finvtion for the svg  loader
jQuery(document).ready(function($) {
    // Wait for 1 second after the document is ready
    setTimeout(function() {
        // Select the SVG div and add the 'hidden' class
        $('.loading_svg_div').addClass('hidden_loading_svg');
       // console.log('SVG should now be hidden');

        // After hiding the SVG, wait another 1 second to perform further actions
        setTimeout(function() {
            //console.log('Performing another action 1 second after hiding the SVG');
            // Any subsequent actions can be placed here
        }, 1000);
    }, 1500);
});


///function for when clicked login button adds a loading icon 
jQuery(document).ready(function($) {


    $('#check-passcode').click(function() {
    //    console.log("Button clicked!"); // Check if button click event is triggered

        var button = $(this);
        var icon = button.find('i');

        // Add spinner icon
        icon.removeClass('fa-sign-in-alt').addClass('fa-spinner fa-spin');
       // console.log("Spinner added!"); // Check if spinner icon is added

        // Check for the visibility of the elements
        checkElementsVisibility();
    });

    function checkElementsVisibility() {
        // Check if either element is displayed
        if ($('#event_not_found').css('display') === 'block' || $('.tabs-container').css('display') === 'block') {
            // Stop the spinner if either element is displayed
            var icon = $('#check-passcode').find('i');
            icon.removeClass('fa-spinner fa-spin').addClass('fa-sign-in-alt');
          //  console.log("Spinner stopped!"); // Check if spinner icon is stopped
        } else {
            // If neither element is displayed, check again after a short delay
            setTimeout(checkElementsVisibility, 100);
        }
    }
});




</script>





<style>
/****LOADING  ANIMATION STYLES*****/
.loading_svg_div {
        display: block; /* Or whatever display mode you prefer */
    }

    .main_content_loading_div {
    
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


/*****END******/

.wrapper{
    min-height: 0 !important;
}
    html .container-fluid{
        padding-top: 34px !important;
    }
 .xoo-el-tabs{
    display:none!important
}

.brand-link img{
    max-width: 170px
}
.scanner_login_divs_before h2{
    margin: 0 auto;
    width: fit-content;
    font-weight: 400 !important;
}
    .xoo-el-form-container.xoo-el-form-inline {
    max-width: 400px;
    margin: 0px auto;
    padding-top: 17px;
}
.main-header .d-block{
    display:none!important
}
footer{
    display:none!important
}
.main-header{
    padding-left: 0;
    padding-right: 0;
}
body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {

    margin-left: inherit;
}
.main-header {
    background-color: #19191b!important;
    border-bottom: 1px solid #444!important;
}
.fake_aviter {
    display: flex;
    align-items: center;
    font-size: 13px;
    background: white;
    border-radius: 100px;
    width: 36px;
    height: 36px;
    justify-content: center;
}

.dark-mode .content-wrapper , .dark-mode {
    background: #0d0e0e !important;
    height: 100vh;

}


.html body .container-fluid{
    background: #0d0e0e !important;
    height: 100vh;
}
.fake_aviter span {
    color: black !important;
}
.user-panel .fa-angle-down:before {
    content: "\f107";
    color: white;
    margin-right: 24px;
}

.dark-mode .dropdown-menu {
    background-color: #19191b;
    color: #fff;
    padding: 19px;
    text-decoration: none;
    list-style: none;
    width: fit-content;
}
.admin_dashboard-sidebar-item a {
    color: white;
    padding: 12px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    padding-left: 0 !important;
    white-space: nowrap;
}
.admin_dashboard-sidebar-item i {
    padding-right: 10px;
}
.scanner_login_divs{
    display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
    gap: 40px;
   padding-bottom:20px
}
.line_break {
    display: block;
    width: 100%;
    height: 1px;
    background-color: #575757;
    margin: 10px 0;
}



.tribe-community-events-list-title {
    font-weight: bold;
    font-size: 35px !important;
}



.container-fluid h2 {
    padding-bottom: 0;
    font-weight: 700;
    margin-bottom:0!important
}



.scanner_login_div h3 {
    margin-bottom: 10px;
    font-size: 21px;
    font-weight: 700;
}
.scanner_login_div{
    background-color: #19191b;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 17px;
    border-radius: 10px;
    width: fit-content;
    margin: 0 4%;

}
.scanner_login_div p{
    font-weight: 300;
    color: #aaa !important;
    font-size: 15px;
    max-width: 500px;
}

.dark-mode input:-webkit-autofill, .dark-mode input:-webkit-autofill:focus, .dark-mode input:-webkit-autofill:hover, .dark-mode select:-webkit-autofill, .dark-mode select:-webkit-autofill:focus, .dark-mode select:-webkit-autofill:hover, .dark-mode textarea:-webkit-autofill, .dark-mode textarea:-webkit-autofill:focus, .dark-mode textarea:-webkit-autofill:hover {
    -webkit-text-fill-color: #000000!important;
}
.main-header {
    padding-left: 3%;
    padding-right: 3%;
}
#check-passcode{
    background: white;
    color: black;
    font-size: 14px;
    padding: 10px 20px;
    border: 0px;
    border-radius: 4px;
    position: relative;
    top: -2px;
}
input#event-pass {
    border: 0px;
    width: 100%;
    max-width: 180px;
    border-radius: 4px;
    margin-right: 11px;
}

.event_data{
    border-radius: 10px;
    background-color: #19191b;
    padding: 7px;
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}
.event_data .name span{
    color: #d3fa16 !important;
    font-size: 20px;
    font-weight: 500;
    text-align: center;
    text-transform: capitalize;
}
.event-container {
    text-align: center;  
}
.event_data .date span{
    text-align: center;
    font-size: 14px;
    color:#ffffff !important;
    font-weight: 400;
}

#video-container {
        width: 100%;
        text-align: center;
    }

    #video {
        width: 100%;
        max-width: 600px;
    }
    /* span#html5-qrcode-anchor-scan-type-change {
        display: none !important;
    } */


    #result {
        margin-top: 20px;
        font-weight: bold;
    }
#qr_error{
    font-weight: 700;
    font-size: 18px;
}
.scaned-by{
    display:none!important
}
.checkin-details{
    background-color: red;
    text-align: center;
    border-radius: 10px;
    max-width: 350px;
    margin: 0 auto;
    padding: 5px;
    font-size: 13px;
}

    div#video-container {
    display: flex;
    flex-direction: column;
    padding: 30px;
        align-items: center;
        padding-top: 5px;
        margin-bottom: 100px;
    }
    input#event-pass {
        margin-bottom: 30px;
    }
    input#event-pass.error {
        border: 2px solid #ea4335 !important;
    }
.main_div_event_data{
    padding:0 10px
}
        /* Style the tabs container */
    .tabs-container {
        display: flex;
    flex-direction: column !important;
    margin: 0 auto;

    position: relative;
    border-radius: 10px;
    width: 100%;
    max-width: 900px;
    }

    /* Style the tabs navigation list */
    .tabs-nav {
        display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    border-bottom: 0px solid #ddd;
    justify-content: center;
    }

    /* Style the individual tabs */
    .tabs-nav li.tab {
        padding: 10px 20px;
        cursor: pointer;
        font-size:14px
    }

    /* Style the active tab */
    .tabs-nav li.tab.active {
        background-color: #fff;
    border-radius: 4px;
    }

    /* Style the tabs navigation links */
    .tabs-nav li.tab a {
        text-decoration: none;
        color: #333;
    }

    /* Style the tab content container */
    .tab-content-container {
        flex: 1; /* Allow content to fill remaining space */
    }

    /* Style the individual tab content sections */
    .tab-content {
        padding: 20px;
        display: none; /* Hide all content initially */
    }

    /* Style the active tab content */
    .tab-content.active {
        display: block;
    }
    li.tab.active a {
        color: #000 !important;
    }
   



    .change_event_btn {
 

}
.change_event_btn  .fa-sign-in-alt:before {
    color: #ff3b3b;
}

button i {
    margin-right: 5px; /* Space between the icon and the text */
}

#event_not_found{
        color: red !important;

}
.main_stats i{
    opacity: 0.06;
    transform: rotate(302deg) !important;
    font-size: 46px;
    position: absolute;
    top: 20%;
    right: 0;
}

.main_stats_block{
    background-color: #19191b;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 9px;
    border-radius: 10px;
    width: 100%;
    max-width: fit-content;
    flex-direction: row-reverse!important;
    display: flex!important;
    gap: 10px;
    padding-top: 17px;
    padding-bottom: 17px;
}



.tab-content{
    max-width: 500px;
    margin: 0 auto;
    padding: 0;
    margin-top: 10px;
}
.event-container img{
    display:none!important
}
.event-container-details{
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.tickets_total_sections {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    gap: 49px;
}

.ticket-info-container_main{
    display: flex;
    gap: 15px;
    flex-direction: row;
}

.ticket-progress-container {
    position: relative;
    display: flex;
    gap: 14px;
}

.progress-ring {
    transform: rotate(-90deg);
}

.progress-ring__circle-bg {
    fill: transparent;
    stroke: #3a3a3a;
    stroke-width: 4;
}

.progress-ring__circle {
    fill: transparent;
    stroke: #4CAF50; 
    stroke-width: 4; 
    stroke-dasharray: 365; 
    stroke-dashoffset: 365;
    transition: stroke-dashoffset 0.35s;
}
.progress-percentage_individual{
    font-size: 12px;
}
.progress-percentage {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    color: white;
    font-weight: bolder;
    font-weight: 500 !important;
}
.ticket-progress-container_main{
    display: flex;
    gap: 6px;
    height: fit-content;
    align-items: center;

}
.ticket_checkedin_main_stats i {
    opacity: 0.1;
    transform: rotate(0deg) !important;
    font-size: 46px;
    position: absolute;
    top: 20%;
    right: 0;
}
.ticket-info {
    text-align: left;
    color: white;
}
.ticket_checkedin_main_stats {
    margin-top:0!important
}
.info_div h6{
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.main_stats{
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
}
.stats_count_main{
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}.stats_count_main span{
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}

.ticket-progress-container_svg{
    width: fit-content;
    position: relative;
    height: fit-content;
}

.progress-percentage_individual {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}


.ticket-info_hidden_all{
    display: flex;
    flex-direction: column;
    gap: 23px;
    text-align: left!important;

}

.container-fluid , .content-wrapper>.content{
    padding:0!important
}


li.tab a{
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
}
.ticket_dropdown{
    display: flex;
    justify-content: space-between;
    width: 100%;
    cursor: pointer;
}
.ticket_dropdown h6{
    margin-bottom:0;
    font-weight: 600;
}
.single_ticket_section_inner{
    width: 100%;
    display:none
}

.display-block{
    display:block
}
.single_ticket_section {
    background: #19191b;
    position: relative;
    padding: 20px 17px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    display: flex;
    gap: 35px;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    margin: 0 auto 100px;
    margin-top: 11px;
}
.ticket-count{
    margin-bottom:0;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}





    /* Media query for responsive behavior (tablet and mobile) */
    @media (max-width: 768px) {
        .tabs-container {
            flex-direction: column; /* Stack tabs vertically on mobile */
        }
        .tribe-community-events-list-title {
    font-weight: bold;
    font-size: 25px !important;
}.scanner_login_divs {

    align-content: center;
    justify-content: flex-start;
 
}

.tabs-nav {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 25px;
    border-bottom: 0px solid #ddd;
    justify-content: center;
    position: fixed;
    bottom: 0;
    background: #121212 !important;
    width: 100%;
    z-index: 999;
    padding-top: 14px;
    padding-bottom: 15px;

}
.tabs-container {

    padding: 0px;
 
}
.tabs-nav li.tab {
    padding: 6px 9px;
    cursor: pointer;
    font-size: 14px;
}
.brand-link .brand-image {
  
    width: 100px;
}
.user-panel .info{
    font-size: 14px;
}.fake_aviter {
    font-size: 12px;
    width: 30px;
    height: 30px;

}
.brand-link img {
    max-width: 140px;
}
.login_prompt h2{
    font-size: 29px;
}
    }

    /* Media query for desktop (optional, for more control) */
    @media (min-width: 768px) {
        .tabs-container {
            flex-direction: row;  /* Tabs side-by-side on desktop */
        }
    }






    
</style>