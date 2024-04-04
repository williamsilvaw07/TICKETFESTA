<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>



<head>
    <meta charset="<?php bloginfo('charset'); ?>">

      <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 -->
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <?php wp_head(); ?>
</head>
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
<body <?php body_class("hold-transition sidebar-mini dark-mode"); ?> <?php generate_do_microdata('body'); ?>>






    <div class="wrapper">

        <!-- Navbar -->
        
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
<!-- Brand Logo -->
<a href="https://ticketfesta.co.uk/" class="brand-link">
                <img src="https://ticketfesta.co.uk/wp-content/uploads/2024/02/Group-195-2.png" alt=""
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light"></span>
            </a>
            
            <!-- Brand Logo -->
            <ul class="navbar-nav ml-0 d-block d-md-none">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown show">
                    <!-- <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a> -->

                    <div class="user-panel d-flex" data-toggle="dropdown" aria-expanded="true">
    <div class="fake_aviter">
        <span>
            <?php if ( is_user_logged_in() ) : ?>
                <?php 
                    $current_user = wp_get_current_user();
                    $first_initial = !empty($current_user->first_name) ? $current_user->first_name[0] : '';
                    $last_initial = !empty($current_user->last_name) ? $current_user->last_name[0] : '';
                    echo esc_html( $first_initial . $last_initial );
                ?>
            <?php else : ?>
                G
            <?php endif; ?>
        </span>
    </div>
    <div class="info d-flex">
        <?php if ( is_user_logged_in() ) : ?>
            <?php echo '<span role="button">' . esc_html( $current_user->first_name ) . '</span>'; ?>
        <?php else : ?>
            <span role="button">Guest</span>
        <?php endif; ?>
        <i class="fas fa-angle-down mt-1 ml-2"></i>
    </div>
</div>

<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
    
    <li class="admin_dashboard-sidebar-item">
        <a href="https://ticketfesta.co.uk/">
            <i class="fas fa-exchange-alt"></i><span class="nav-text">Switch to Attendee</span>
        </a>
    </li>

    <li class="admin_dashboard-sidebar-item">
        <a href="/organisers-setting/">
            <i class="fas fa-cog"></i><span class="nav-text">Settings</span>
        </a>
    </li>
    
    <li class="admin_dashboard-sidebar-item">
        <a href="/orginser-support">
            <i class="fas fa-envelope"></i> <span class="nav-text">Support</span>
        </a>
    </li>
  <span class="line_break"></span>
    <li class="admin_dashboard-sidebar-item">
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
            <i class="fas fa-sign-out-alt"></i><span class="nav-text">Logout</span>
        </a>
        <?php if ( is_user_logged_in() ): ?>
            <?php $current_user = wp_get_current_user(); ?>
            <span class="user-email-address"><?php echo esc_html( $current_user->user_email ); ?></span>
        <?php endif; ?>
    </li>
    

</ul>

            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="https://ticketfesta.co.uk/" class="brand-link">
                <img src="https://ticketfesta.co.uk/wp-content/uploads/2024/02/Group-195-2.png" alt=""
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light"></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Navbar -->
                <nav class="admin_dashboard-sidebar">
                    <ul class="admin_dashboard-sidebar-list">
                        <li class="admin_dashboard-sidebar-item">
                            <a href="https://ticketfesta.co.uk/dashboard/">
                                <i class="fas fa-home"></i><span class="nav-text">Dashboard</span>
                            </a>

                        </li>
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organizer-events/"><i class="fas fa-calendar-alt"></i><span
                                    class="nav-text">Event</span> <span
                                    class="admin_dashboard-notification">2</span></a>
                        </li>

                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organizer-coupons/"><i class="fas fa-ticket-alt"></i><span
                                    class="nav-text">Coupons</span></a>
                        </li>


                    
<!--
                        
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/dashboard/vanues-list/"><i class="fa fa-map-marker"></i><span
                                    class="nav-text">Vanues</span></a>
                        </li>
 -->
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organizer-finance/">
                                <i class="fas fa-university"></i><span class="nav-text">Finance</span>
                            </a>

                        </li>
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organiser-gallery/"><i class="fas fa-image"></i><span
                                    class="nav-text">Gallery</span></a>
                        </li>

                        <li class="admin_dashboard-sidebar-item">
                            <a href="/dashboard/organisation-settings/"><i class="fas fa-cog"></i><span
                                    class="nav-text">Organisation Settings

</span></a>
                        </li>


                        <li class="admin_dashboard-sidebar-item admin_dashboard-coming-soon">
                            <a href="/organizer-eventsdd"><i
                                    class="fas fa-bullhorn"></i><span class="nav-text">Affiliate Marketing</span></a>
                        </li>
                        <li class="admin_dashboard-sidebar-item admin_dashboard-coming-soon">
                            <a href="organizer-eventsdd"><i
                                    class="fas fa-envelope"></i><span class="nav-text">Email Marketing</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- /.navbar -->

                <nav class="lower_admin_dashboard-sidebar">
                    <ul class="admin_dashboard-sidebar-list lower_admin_dashboard-sidebar-list">
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organisers-setting/"><i class="fas fa-cog"></i><span
                                    class="nav-text">Settings</span></a>
                        </li>
                        <li class="admin_dashboard-sidebar-item">
    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><i class="fas fa-sign-out-alt"></i><span class="nav-text">Logout</span></a>
</li>

                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>







        <script>


///function for the orginser seetinmg page 
   // jQuery for switching tabs
   $(document).ready(function () {
        $('.settings-tab-link').click(function (e) {
            e.preventDefault(); // Prevent default anchor behavior

            var target = $($(this).data('target'));

            // Hide all tab content
            $('.settings-tab-content').removeClass('active').hide();

            // Show the selected tab content
            target.addClass('active').show();

            // Update the active state of the tab link
            $('.settings-tab-link').removeClass('active');
            $(this).addClass('active');
        });
        
        // Trigger click on the first tab to display it by default
        $('.settings-tab-link').first().click();
    });












            ////FUNCTION FO RTHE M=SIDE BAR MENU CLICK AND SHOW SUBMENU 
            document.querySelectorAll('.admin_dashboard-has-submenu > a').forEach(function (anchor) {
                anchor.addEventListener('click', function (event) {
                    // Prevent default anchor action
                    event.preventDefault();

                    // Reference to the submenu
                    var submenu = this.nextElementSibling;

                    // Toggle submenu display
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        this.classList.remove('admin_dashboard-arrow-rotated');
                    } else {
                        // Hide all other submenus and remove the 'rotated' class from other arrows
                        document.querySelectorAll('.admin_dashboard-has-submenu > a').forEach(function (otherAnchor) {
                            otherAnchor.classList.remove('admin_dashboard-arrow-rotated');
                            otherAnchor.nextElementSibling.style.display = 'none';
                        });

                        submenu.style.display = 'block';
                        this.classList.add('admin_dashboard-arrow-rotated');
                    }
                });
            });




            document.addEventListener('DOMContentLoaded', (event) => {
                // Get the current path
                const currentPath = window.location.pathname;

                // Get all links in the sidebar
                const links = document.querySelectorAll('.admin_dashboard-sidebar .admin_dashboard-sidebar-item a');

                // Iterate over each link to find a match
                links.forEach(link => {
                    // Check if the link's pathname matches the current path
                    if (link.pathname === currentPath) {
                        // Add the active class to the parent list item
                        link.parentElement.classList.add('admin_dashboard-active');
                    }
                });
            });






            jQuery(document).ready(function ($) {
                // Iterate over each .tribe-list-column-title cell
                $('.tribe-list-column-title').each(function () {
                    // Wrap the image and the title span in a new div with a class 'image-title-wrapper'
                    $(this).find('img, .title').wrapAll('<div class="image-title-wrapper"></div>');
                });
            });
        </script>



        <script>
            jQuery(document).ready(function ($) {
                // Function to add arrow based on the value
                function addArrowAndChangeColor(element, isNegative, isZero) {
                    if (isZero) {
                        // Set color to #777777 if the value is zero, no arrow added
                        element.attr('style', 'color: #aaa !important;');
                    } else {
                        var color = isNegative ? '#fa6464' : '#1bc37d';
                        var arrow = isNegative ? '&#x2193; ' : '&#x2191; ';

                        // Prepend the arrow with the specific color
                        element.prepend('<span style="color: ' + color + ' !important;">' + arrow + '</span>');
                        // Apply color with !important to the text
                        element.attr('style', 'color: ' + color + ' !important;');
                    }
                }

                // Check the percentage change
                $('.admin_dashboard_percentage-change').each(function () {
                    var percentageChange = $(this).text();
                    var isNegativePercentage = percentageChange.includes('-');
                    var isZeroPercentage = parseFloat(percentageChange.replace('%', '')) === 0;
                    addArrowAndChangeColor($(this), isNegativePercentage, isZeroPercentage);
                });

                // Check the amount change
                $('.admin_dashboard_amount-change').each(function () {
                    var amountChange = $(this).text();
                    var isNegativeAmount = amountChange.includes('-');
                    // Improved zero check for currency formatted strings
                    var isZeroAmount = /^-?£0\.00$/.test(amountChange) || amountChange === '0';
                    addArrowAndChangeColor($(this), isNegativeAmount, isZeroAmount);
                });
            });


        </script>








        <style>
            .main-header .brand-link{
                display:none
            }
          .main-header  .img-circle {
                border-radius: inherit!important;
            }
.user-email-address{
    font-size:13px
}
.line_break {
    display: block; 
    width: 100%; 
    height: 1px; 
    background-color: #575757;
    margin: 10px 0; 
}
.dark-mode .dropdown-menu {
    background-color: #19191b;
    color: #fff;
    padding: 19px;
    text-decoration: none;
    list-style: none;
    width: fit-content;
}
.dark-mode .dropdown-menu li {
    text-decoration: none;
    margin:10px 0
}
.dark-mode .dropdown-menu a {
    text-decoration: none;

}
.user-panel .fa-angle-down:before {
    content: "\f107";
    color: white;
    margin-right: 24px;
}
            .fake_aviter{
                display: flex;
    align-items: center;
    font-size: 13px;
    background: white;
    border-radius: 100px;
    width: 36px;
    height: 36px;
    justify-content: center;

            }
            .fake_aviter span{
    color: black !important;
            }      

                      .settings-tab-content {
        display: none;
    }
    
    .settings-tab-content.active {
        display: block;
    }
    
    .settings-navigation ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .settings-navigation ul li{
                list-style: none;
                color: #aaa!important;

            }
  .settings-tab-link{
 text-decoration: none!important;
 color: #aaa!important;
}
            .settings-tab-link.active{
                border-bottom: 2px solid #d3fa16;
                color: white!important;
                padding-bottom: 9px;
             
      color: white;
            }
            .settings-navigation ul{
                margin: 0;
    display: flex;
    gap: 34px;

}
    









            header {
    background-color: inherit!important;
}
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer {
                display: none !important
            }

            /******EDIT ORFANIZSER****/
            .main-sidebar .img-circle {
                border-radius: inherit;

            }

            .brand-link {
                position: fixed;
                padding-bottom: 27px;
    border: 0px!important;
            }


            /***MAIN LAYOUT***/
            .page-template-organizer-template-php .content-wrapper,
            .main-header {
                background: #0d0e0e !important;
            }

            .main-header {
                border-bottom: 1px solid #444;
                padding: 17px;
            }

            .postid-1367 .site-content {
                display: flex;
                flex-direction: column;
            }

            .postid-1367 .tribe-community-events {
                max-width: 800px;
                margin: auto;

            }

            /***END***/
            .postid-1367 form {
                display: flex !important;
                flex-direction: column;
                gap: 20px;
            }

            .postid-1367 form label {
                margin-bottom: 20px !important;
                line-height: 21px;
                font-size: 20px;
                font-weight: 400;
            }

            .postid-1367 .my-events-header a {
                display: none;
            }

            .current-organizer-image img {
                border-radius: 100px;
                max-width: 200px;
                width: 100%;
                height: 200px;
                object-fit: cover;
                width: 100%;
                border: 5px solid white;
            }

            .current-organizer-image {
                display: flex;
                flex-direction: row;
                align-content: center;
                justify-content: flex-start;
                align-items: center;
                gap: 19px;


            }

            .organizer_image_upload_function_container p {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;

            }

            .organizer_image_upload_function_container {
                margin-top: -49px;
            }

            .edit_main_image_banner {

                background: #555;
                border-radius: 100px;
                width: 45px;
                height: auto;
                padding: 12px;
                border: 2px solid white;
            }

            .edit_main_image {
                position: absolute;
                cursor: pointer;
                top: 50%;
                left: 50%;
                background: #555;
                border-radius: 100px;
                width: 45px;
                height: auto;
                padding: 12px;
                transform: translate(-50%, -50%)
            }

            .drop-zone {
                display: none !important;
            }

            .current-organizer-image p {
                display: flex;
                flex-direction: column;
                font-size: 13px;
            }

            .tribe-events-community-footer input {
                margin-bottom: 100px !important;
                margin: 0 auto;
                width: 100%;
                max-width: 300px;
                background-color: #FFD700 !important;
                color: black !important;
                border-radius: 5px;
                font-weight: 600;
                margin-top: 0px !important;
            }

            .tribe-events-community-footer {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #user-organizers-list tbody tr:nth-child(odd) {
                background-color: #19191b !important;
            }

            .organizers-header {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 24px;
                justify-content: space-between;
                max-width: 700px;
                align-items: center;

            }

            #user-organizers-list tbody tr:nth-child(even) {
                background-color: #19191b !important;
            }

            #user-organizers-list .edit-link {
                color: #FFA300 !important;
                border-radius: 6px;
                background: rgba(255, 163, 0, 0.20);
            }

            #user-organizers-list .delete-link {
                color: #E53D3D !important;
                border-radius: 6px;
                background: rgba(166, 28, 28, 0.20);
            }

            #user-organizers-list .profile-link {
                color: #21DAB8 !important;
                border-radius: 6px;
                background: rgba(19, 180, 151, 0.20);
            }


            #user-organizers-list tbody tr td a {
                padding: 4px 14px;
                font-size: 12px;
                text-decoration: none;
                height: fit-content;
            }

            #user-organizers-list tbody tr td img {
                max-width: 66px;
                border-radius: 100px;
            }

            #user-organizers-list td{
                display: flex;
    align-content: center;
    justify-content: flex-start;
    align-items: center;

            }
            #user-organizers-list th,
            #user-organizers-list td {
                text-align: left;
                padding: 20px 18px!important;
            }

            #user-organizers-list tr:nth-child(even) {
                background-color: #19191b;
            }

            element.style {
                width: 100%;
            }

            table {
                margin: 0 0 1.5em;
                width: 100%;
            }

            #user-organizers-list {
                border-collapse: separate;
                border-spacing: 0;
                border-width: 0;
                margin: 0;
                width: 100%;
                background-color: #19191b;
                position: relative;
                padding: 17px;
                border-radius: 10px;
                width: 100%;
                max-width: 900px;
                
            }

            .page-id-1777 .content {
                max-width: 900px !important;
                margin: 0 auto;
            }

            #user-organizers-list tr:nth-child(odd) {
                background-color: #3F3F3F;
            }

            #user-organizers-list th,
            #user-organizers-list td {
                text-align: left;
                padding: 8px;

            }

            #user-organizers-list td {


                text-overflow: ellipsis;
                white-space: nowrap;
                font-size: 14px;
                font-weight: 200;
            }

            .page-id-1840 .container-fluid {
                max-width: 1200px;

            }

            .container-fluid h2 {
                padding-bottom: 50px;
                padding-top: 50px;
                font-weight: 700;
            }

            .edit_main_image_non_image {
                position: relative;
                top: -113px;
                left: 81px;
                cursor: pointer;
            }

            .drop-zone {
                border: 2px dashed #fff;
                width: 100%;
                max-width: 600px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                align-content: center;
                justify-content: center !important;
                align-items: center;
                border-radius: 10px;
                text-align: center;
                margin: 20px 0;
            }

            .drop-zone p {
                margin-bottom: 0;
            }

            .drop-zone button {
                font-size: 14px;
                padding: 5px 21px;
                background: white;
                color: black;
                border-radius: 4px;
            }

            .organizer_image_upload_function_container img {
                max-width: 200px;
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 200px;
                border: 5px solid white
            }


            .events-community-post-title input {
                font-size: 27px;
                font-weight: 600;
                font-family: "Plus Jakarta Sans", Sans-serif;
                text-align: center;
            }

            .organizer_image_upload_function_container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;


            }

            .events-community-post-content label {
                display: block;
            }

            .organizer_image_upload_function_container p {
                text-align: center;
                font-size: 12px;
                padding-top: 10px;
            }

            .tribe-events-community-details {
                display: none;
            }

            .my-events-header a {
                display: none !important;
            }

            .my-events {
                padding-bottom: 0 !important;
            }

            .hidden {
                display: none;
            }

            .banner_image_organizer {
                max-height: 470px;
                width: 1400px;
                object-fit: cover;
                margin: 0 auto;
                border-radius: 6px;
            }

            .banner-image-holding_div {
                display: block;


            }

            .edit_svg_click {
                cursor: pointer;
            }

            .profile_img_svg_div {
                position: relative;
            }

            .banner-image-holding_div {
                position: relative;
            }

            .edit_main_image_banner {
                position: absolute;
                bottom: 0;
                right: 0;
            }

            .banner_image_text_requirments {
                position: relative;
            }

            .banner_image_text_requirments p {
                position: absolute;
                left: 50%;
                top: 50%;
                margin-bottom: 0;
                font-size: 13px;
                text-align: center;
                background: rgb(0 0 0 / 80%);
                padding: 20px;
    
                backdrop-filter: blur(4px);
                border-radius: 10px;
                transform: translate(-50%, -50%);
            }

            .banner-image-upload {
                display: none;
            }

            .organizer_edit_back_btn_main {
                padding-top: 30px;

            }

            .organizer_edit_back_btn {
                background-color: white;
                color: black;
                font-size: 14px;
                padding: 5px 15px;
                border-radius: 6px;
                margin-bottom: 25px;
                display: flex;
                flex-direction: row;
                align-content: center;
                justify-content: flex-start;
                align-items: center;
                gap: 11px;
                width: fit-content;
                cursor: pointer !important;

            }


            .organizer_edit_back_btn p {
                color: black !important;
                margin-bottom: 0;
            }

            .organizer_edit_back_btn svg {
                max-width: 17px;
                max-height: 16px;
            }



            .organizer_title_edit_btn,
            .edit_svg_click {
                position: absolute;
                right: 10px;

            }

            .container-fluid {
                padding-top: 10px
            }

            .container-fluid h2 {
                padding-bottom: 11px;
                padding-top: 13px;
                font-weight: 700;
            }

            .tribe-community-events-content .tribe-nav {
                margin: 10px;
                margin-bottom: 0 !important;
                margin-left: 0 !important;
            }

            @media screen and (max-width: 768px) {
                #user-organizers-list .action-links {
                    flex-wrap: wrap;
                }

                #user-organizers-list tbody tr td img {
                    max-width: 59px;
                    object-fit: cover;
                }
            }

            @media screen and (max-width: 500px) {
                #user-organizers-list .action-links {
                    flex-wrap: wrap;
                }

                #user-organizers-list tbody tr td img {
                    max-width: 59px;
                    object-fit: cover;
                }

                #user-organizers-list tbody tr {
                    display: flex !important;
                    flex-direction: column;
                    border-bottom: 1px solid #444;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border: 0px!important;
                }

                #user-organizers-list tbody tr td {
                    border-width: 0 !important;
                }

                #user-organizers-list thead {
                    display: none;
                }
            }

            /***END****/

            /***.organizer main dashboard setting***/
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
                transition: margin-left .3s ease-in-out;
                margin-left: 190px !important
            }

            .page-template-organizer-template {

                background: #19191b !important
            }

            .page-template-organizer-template .content {
                max-width: 1300px;
                margin: 0 auto;
                background: #0d0e0e
            }

            /***end***/
            /* Sidebar Styles */
            .elevation-4 {
                box-shadow: inherit !important;
            }

            .main-sidebar {
                width: 100%;
                max-width: 200px;
                height: 100vh;
                background-color: #19191b;
                position: fixed;
                overflow: auto;
                padding-left: 15px;

            }

            .admin_dashboard-sidebar {
                width: 100%;
                max-width: 176px;
                height: 100vh;
                background-color: transparent;
                position: fixed;
                overflow: auto;
                top: 119px;
            }


            /* List Styles */
            .admin_dashboard-sidebar-list {
                list-style-type: none;
            }

            .admin_dashboard-sidebar-item i {
                padding-right: 10px;
            }

            .admin_dashboard-sidebar ul {
                margin-left: 0 !important;
            }

            /* Link Styles */
            .admin_dashboard-sidebar-item a {
                color: white;
                padding: 12px;
                text-decoration: none;
                display: block;
                font-size: 14px;
                padding-left: 0 !important;
                white-space: nowrap;

            }

            /* Active Link Styles */
            .admin_dashboard-active a {
                background-color: #444;
                color: white;
            }

            /* Active Link Styles */
            .admin_dashboard-active a {
                background: linear-gradient(270deg, rgba(211, 250, 22, 0.28) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);

                color: white;
                position: relative;
                /* To position the pseudo element */
            }

            /* Active item indicator */
            .admin_dashboard-active a::after {
                content: '';
                position: absolute;
                right: 0;
                top: 0;
                bottom: 0;
                width: 5px;
                /* Width of the active border */
                background-color: #d3fa16;
                /* Color of the active border */
                border-top-right-radius: 4px;
                /* Optional: if you want rounded corners */
                border-bottom-right-radius: 4px;
                /* Optional: if you want rounded corners */
            }



            /* Notification Badge */
            .admin_dashboard-notification {
                display: none;
                background-color: red;
                color: white;
                border-radius: 50%;
                padding: 2px 8px;
                font-size: 12px;
                position: relative;
                top: -2px;
                right: -10px;
                float: right;
            }

            /* Submenu Styles */
            .admin_dashboard-submenu {
                display: none;
                background-color: inherit;
                position: relative;
                margin-left: 0;
                font-size: 13px;
            }

            /* Remove bullet points from submenu items */
            .admin_dashboard-submenu li {
                list-style-type: none;/
            }


            /* Submenu Link Styles */
            .admin_dashboard-submenu a {
                padding-left: 40px;
                padding-top: 5px;
                padding-bottom: 4px;
                background-color: inherit;
                display: block;
                color: #ddd;
                text-decoration: none;
            }

            .admin_dashboard-submenu a:hover {
                background-color: #333;
            }

            /* Coming Soon */
            .admin_dashboard-coming-soon::after {
                content: 'Coming soon';
                color: #000000;
                font-size: 11px;
                margin-left: 10px;
                border-radius: 5px;
                background: #ffffff;
                text-align: center;
                width: 100px;
                position: relative;
                display: none;
                margin-top: -10px;

            }

            .admin_dashboard-coming-soon {
                display: none !important;
            }

            .admin_dashboard-coming-soon,
            .admin_dashboard-coming-soon a {
                cursor: not-allowed;
                color: #6c6c6c !important;
            }

            .admin_dashboard-sidebar-item.admin_dashboard-has-submenu>a {
                position: relative;
                padding-right: 30px;
            }

            .admin_dashboard-sidebar-item.admin_dashboard-has-submenu>a::after {
                content: '';
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%) rotate(0);
                transition: transform 0.3s ease;
                /* Smooth transition for the rotation */
                width: 0;
                height: 0;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                border-top: 5px solid white;
                /* The arrow pointing downwards */
            }

            /* Rotate the arrow when the class 'admin_dashboard-arrow-rotated' is added to the anchor tag */
            .admin_dashboard-sidebar-item.admin_dashboard-has-submenu>a.admin_dashboard-arrow-rotated::after {
                transform: translateY(-50%) rotate(180deg);
                /* Rotate the arrow */
            }




            /* Hover effect for sidebar items */
            .admin_dashboard-sidebar-item a:hover {
                background: linear-gradient(270deg, rgba(211, 250, 22, 0.28) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);
                color: white;
                position: relative;

            }



            .lower_admin_dashboard-sidebar {
                position: fixed;
                bottom: 0;
                width: 175px;
            }

            .admin_dashboard-sidebar-item {
                width: 100%;
                max-width: 175px;
            }

            .lower_admin_dashboard-sidebar-list {
                margin-left: 0;
            }

            @media screen and (max-width: 600px) {
                .admin_dashboard-submenu {
                    position: static;
                }
            }


            /****EVENT LIST****/
            #tribe-community-events-shortcode {
                max-width: 1000px;
                width: 100%;
                margin: 0 auto;
            }

            .main_custom_container_second .tribe-button-primary {
                text-decoration: none !important;
            }

            .tribe-community-events-list-title {

                font-weight: bold;
                font-size: 35px !important;
            }

            .tribe-nav-top .table-menu-wrapper a {
                display: none;

            }


            .summary_tabs_my_events_main_inner {
                display: flex;
                display: flex;
                gap: 20px;
                margin-bottom: 20px;
                margin-top: 20px;
            }

            .tribe-community-events-list tbody tr {
                background: #121212 !important;
    border-radius: 10px;
                color: white !important;
                padding: 20px 18px;
                margin:20px 0
            }
            html .tribe-community-events-list.stripe tbody tr.odd, .tribe-community-events-list.display tbody tr.odd {
    border-bottom: 0px solid #444 !important;
}

            .tribe-community-events-list tbody .odd {
                background: #121212 !important;


            }

            .tribe-community-events-list th {
                color: white !important;
            }

            .tribe-community-events-list th {
                padding: 0 15px !important;
            }


            .image-title-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .row-actions {
                display: block;
                width: 100%;
                margin-top: 10px;
            }


            /****END****/



            /********organizer event list table***/
            .tribe-attendee-report,
            .tribe-sales-report {

                display: none !important;
            }

            .event-status-form select.status-draft {
                background-color: rgba(255, 163, 0, 0.1) !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                border: 1px solid #FFA300 !important;
            }

            .event-status-form select.status-publish {
                background-color: rgba(27, 195, 125, 0.1) !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                border: 1px solid #1bc37c !important;
            }

            .tribe-list-column-title img {
                display: none;
            }

            .tribe-list-column-recurring,
            .tribe-list-column-start_date,
            .tribe-list-column-end_date {
                display: none;
            }

            /*
.event-column , .tribe-list-column-status{
    width: 100%;
    max-width: 350px;
}
html .tickets-sold-column , html .tribe-list-column-title {
    max-width: 200px!important;
    width: 100%!important;
}
 html .gross-column , html .tribe-list-column-organizer{
    max-width: 100px!important;
    width: 100%!important;
    text-align: center;
}
*/
            .tribe-list-column-category,
            .tribe-list-column-venue,
            .tribe-list-column-organizer,
            .tribe-list-column-title {
                display: flex !important;
                justify-content: center !important;
                padding: 0 5px !important;
                color: #d5d5d5 !important;
            }

            .tribe-list-column-title span {
              
                font-size: 15px;

            }
            #tribe-community-events-list span.passcode {
                font-size: 19px;
            }

            .report_gross_income {
                font-size: 15px;
            }

            .tickets-sold-column,
            .gross-column,
            .status-column,
            .status-column {
                text-align: center;
            }

            .tribe-community-events-list {
                display: flex;
                flex-direction: column;
                max-width: 1000px;
                margin-bottom: 200px !important;
            }

            .tribe-community-events-content {
                max-width: 1000px;
                margin-left: 0 !important;
            }

            .status-column,
            .tribe-list-column-venue {
                max-width: 110px;
                width: 100%;
                text-align: center;
            }

            html .tribe-list-column-start_date,
            html .tribe-list-column-recurring,
            html .tribe-list-column-start_date,
            html .tribe-list-column-end_date {
                display: none !important;
            }

            .tribe-community-events-list tbody tr {
                display: grid;
                grid-template-columns: 38% 12% 12% 14% 14% 10%;

                justify-items: stretch;
                justify-content: start;
                align-items: center;
                align-content: center;
                border-bottom: 0px solid #444;

            }

            .tribe-community-events-list.display tbody th,
            .tribe-community-events-list.display tbody td {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .tribe-community-events-list thead tr {
                display: grid;
                grid-template-columns: 38% 12% 12% 14% 14% 10%;

                justify-items: stretch;
                justify-content: start;
                align-items: center;
                align-content: center;
                border-bottom: 1px solid #444;
                padding-bottom: 12px;
                width: 100% !important;

            }

            .event-status-form select {
                font-size: 11px !important;
                padding: 2px 3px !important;
            }

            .event-title-image .title {
                font-size: 15px !important;
                font-weight: 600;
                width: 100%;
                position: relative;
                white-space: break-spaces;
                padding: 0 10px;
                color: #d5d5d5 !important;
            }

            .tribe-community-events-list.stripe tbody tr.odd,
            .tribe-community-events-list.display tbody tr.odd {

                border-bottom: 1px solid #444 !important;
            }

            .tribe-community-events-list {
                border-width: 0 !important;
            }

            .tribe-community-events-list tr th {
                border-bottom-width: 0 !important;
                font-size: 14px;
                color: #aaa !important;
                text-transform: capitalize;
                padding-left: 6px;
                font-weight: 200;
                text-align: l;
            }

            .event-title-image {
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .event-title-image img {
                border-radius: 5px;
                display: none;
            }

            .event-title-image .event-link {
                display: flex;
                align-items: center;
                /* This will ensure the text aligns with the image if wrapped in a link */
            }

            .start-date-label {
                display: none;
            }

            .event-start-date .label,
            .start-date-year {
                display: none;
            }
            .start-date-time{
                line-height: 16px;
            }
            .start-date-time span{
                font-size: 13px;
    text-transform: lowercase;
                font-weight: 500;
                color: #d5d5d5 !important;
            }
       
            .start-date-month .value , .start-date-day  .value {
                font-size: 16px;
                font-weight: 700;
                color: #d3fa16 !important;

            }

            .page-template-organizer-template .start-date-month,
            .page-template-organizer-template .start-date-day {
                line-height: 15px;

            }

            .event-start-date {
                text-align: center;
                display: flex;
                flex-direction: column-reverse;

            }

            .tribe-community-events-list td {
                border-width: 0 !important;
            }

            .event-details-wrapper {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: flex-start;

            }

            .tribe-attendee-report,
            .row-actions strong {
                display: none !important;
            }

            /***main event lisitng action button****/
            .page-template-organizer-template .row-actions,
            .report_Attendees,
            .report_sales {
                display: none;
            }

            /****end*****/
            .row-actions .delete.wp-admin.events-cal:before {

                content: none !important;
            }

            .row-actions {
                display: flex;
                flex-direction: row;
                gap: 18px;

            }

            .row-actions span {
                padding: 6px 9px;
                border-radius: 5px !important;
                line-height: 14px;
                font-size: 12px;
            }

            .row-actions span.delete {
                background: rgba(166, 28, 28, 0.20);
            }

            .row-actions span.edit {
                background: rgba(255, 163, 0, 0.20)
            }

            .row-actions span.view {
                background: rgba(19, 180, 151, 0.20)
            }

            .row-actions span.delete a {
                color: #E53D3D !important;
            }

            .row-actions span.view a {
                color: #1bc37c !important;
            }

            .row-actions span.edit a {
                color: #FFA300 !important;
            }

            .tribe-list-column-status {
                display: flex !important;
                flex-direction: row-reverse;
                align-items: center;
                justify-content: flex-end;

            }

            /*
.tribe-list-column-title , .tribe-list-column-organizer {
    display: flex!important;
    flex-direction: column;
    align-content: center;
    align-items: center;
    justify-content: center; 
    gap: 15px;
}
*/
            .bold_s_heading_btn {
                background: #525A62;
                padding: 6px 9px;
                border-radius: 5px !important;
                line-height: 14px;
                font-size: 12px;
                white-space: nowrap;

            }

#user-organizers-list tbody tr{
    border-radius: 10px!important;
    margin: 20px 0!important;
}
#user-organizers-list tbody tr td:first-child{
    border-radius: 10px 0px 0px 10px;
}
#user-organizers-list tbody tr td:last-child{
    border-radius: 0px 10px 10px 0px;

}
            #user-organizers-list th,
            #user-organizers-list td {
                text-align: left;
    padding: 7px;
    border-top: inherit !important;
    border-bottom: 0px solid #444;
    background-color: #121212 ! Important;
 
            }

            #user-organizers-list thead th {
                font-size: 14px;
                color: #aaa;
                text-transform: capitalize;
                padding-left: 6px;
                font-weight: 300;
                text-align: center;
                white-space: nowrap;
                text-align: left;
            }

            #user-organizers-list td {
                border-right: 0 !important;
            }

            #user-organizers-list .action-links {
                display: flex;
                gap: 10px;
                align-content: center;
                align-items: center;
                flex-direction: row;
            }

            #user-organizers-list th {
                border-right: 0 !important;
            }

            #user-organizers-list tbody tr,
            #user-organizers-list thead tr {
                grid-template-columns: 15% 50% 35%;
                display: grid;
                overflow: visible;
            }

            /****recent orders***/
            .admin_dashboard_main_recent_activity {
                background-color: #1f1f1f;
                border-radius: 4px;
                padding: 20px;
                color: #fff;

            }

            .admin_dashboard_main_recent_activity h2 {
                font-size: 18px;
                margin-bottom: 20px;
                color: #ccc;
            }

            .admin_dashboard_main_recent_activity h2 span {
                font-size: 14px;
            }

            .admin_dashboard_main_activity_list {
                margin-top: 10px;
            }

            .admin_dashboard_main_activity_item {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
                gap: 10px;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #444;
            }

            .admin_dashboard_main_activity_item:last-child {
                border-bottom: none;
            }

            .admin_dashboard_main_customer_info {
                display: flex;
                flex-direction: column;
            }

            .admin_dashboard_main_customer_info strong {
                font-size: 14px;
                color: #fff;
                font-weight: 300;
            }

            .admin_dashboard_main_customer_info span {
                font-size: 13px;
                color: #aaa;
                font-weight: 100;
            }

            .admin_dashboard_main_amount {
                font-size: 16px;
            }

            .admin_dashboard_main_status,
            .admin_dashboard_main_customer_id,
            .admin_dashboard_main_retained {
                font-size: 14px;
                text-align: left;
            }

            .admin_dashboard_main_status .status_result {
                width: fit-content;
                color: #21DAB8;
                border-radius: 6px;
                background: rgba(19, 180, 151, 0.20);
                padding: 4px 9px;
            }

            .admin_dashboard_main_amount {
                font-weight: bold;
                color: #4CAF50;
                /* Or any color you want for the amount */
            }

            /* Add titles */
            .admin_dashboard_main_activity_titles {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
                gap: 10px;
                margin-bottom: 10px;
                border-bottom: 1px solid #444;
                padding-bottom: 12px;
            }

            .admin_dashboard_main_product {
                font-size: 14px;
            }

            .admin_dashboard_main_activity_titles div {
                font-size: 14px;
                color: #aaa;
                text-transform: capitalize;
                padding-left: 6px;
            }








            /****END***/


      /***********Attendees-report**********/
.page-id-1925 .row-actions .trash{
    display:none!important
}
.page-id-1925 .row-actions .edit_attendee{
    background: inherit;
    padding: 0;
    font-size: inherit;
    text-decoration: underline;
}

.page-id-1925 .row-actions {

}
.page-id-1925  .row-actions span.inline a:nth-child(2),
.page-id-1925  .row-actions span.inline a:nth-child(4) {
    display: none!important;
}
.row-actions span.inline > a:nth-of-type(2),
.row-actions span.inline > a:nth-of-type(4) {
    display: none !important;
}







   /**************END********** */




            /****ADMIN- DASHBOARD PAGE***/

            .sales-card.today_sale_admin_dashboard {
                background-color: #19191b;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
                padding: 17px;
                border-radius: 10px;
                width: 100%;
                max-width: 320px;
            }

            .today_sale_admin_dashboard h5 {
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 11px;
            }

            .admin_dashboard_sales-amount {
                font-weight: 700;
                font-size: 26px;
                margin-bottom: 4px;
                color: #d3fa16 !important;
                white-space: nowrap;
            }

            .admin_dashboard_sales_amount_yesterday {
                display: none;
            }

            .admin_dashboard_lower_other_day {
                font-size: 14px;
                font-weight: 300;
                flex-wrap: nowrap;
                display: flex;
                flex-direction: row;
                gap: 14px;
                color: #aaa !important;
            }

            .from_text_price_yesturday {
                font-size: 11px !important;
                font-weight: 300 !important;
                color: #aaa !important;
            }

            .dmin_dashboard_amount-change_p_tag {
                color: #aaa !important;
                margin-bottom: 0;
                display: flex;
                gap: 6px;
                align-items: flex-end;
            }

            .from_text_price_yesturday {
                font-size: 12px;
            }

            .admin_dashboard_sales-amount_span {
                font-weight: 200;
                font-size: 13px;
            }


            .admin_dashboard_sales-amount_view_full_report a {
                text-decoration: underline !important;
                font-size: 14px !important;
                font-weight: 400 !important;
                margin-top: 25px !important;
            }

            .admin_dashboard_sales-amount_view_full_report {
                margin-top: 25px;
            }

            .admin_dashboard_sales-amount_view_full_report img {
                max-width: 23px !important;
                margin-left: 7px !important;

            }

            .admin_dashboard_main_recent_activity {
                background-color: #19191b;
                position: relative;
                padding: 17px;
                border-radius: 10px;
                width: 100%;
            }

            .tribe-community-events-list {
                background-color: #19191b;
                position: relative;
                padding: 17px;
                border-radius: 10px !important;
                width: 100% !important;
            }

            .page-template-organizer-template .my-events-display-options,
            .page-template-organizer-template .table-menu-wrapper:after {

                display: none !important;
            }


            .page-template-organizer-template .wrapper {
                background: #0d0e0e !important;
            }

            .admin_dashboard_event_list_nav {
                max-width: 700px;
                display: flex;
                flex-direction: row-reverse;
                justify-content: flex-end;
                align-content: center;
                align-items: center;
                gap: 20px;

            }


            .admin_dashboard_event_list_nav_lower {
                display: flex;
                flex-direction: row;
                align-content: center;
                align-items: center;
                padding-bottom: 9px;
            }

            .admin_dashboard_event_list_nav_lower select {
                border-width: 0;
                padding: 7px 0px;
                background: #d5d5d5 !important;
                border-radius: 4px;
                color: black !important;
                font-size: 13px;
                text-align: center;
                width: fit-content
            }


            .admin_dashboard_event_list_nav_lower .tribe-button.tribe-button-primary.add-new {
                margin-right: 20px;
                margin-top: 0;
                margin-bottom: 0;
                margin-left: 0;
                display: none;
            }

            .admin_dashboard_event_list_nav_lower .tribe-search-form input[name="event-search"] {
                width: 70%;
                padding: 6px 12px;
                font-size: 13px;
                border-radius: 4px;


            }

            .admin_dashboard_event_list_nav_lower .tribe-search-form #search-submit {
                font-size: 12px;
                padding: 5px 15px !important;
                background: #d5d5d5;
                border-radius: 4px;
                color: black;

            }

            .admin_dashboard_event_lis_search_filter {
                display: flex;
                flex-direction: row;
                width: 100%;
                justify-content: center;
                align-items: center;
            }

            .admin_dashboard_event_list_nav_lower form div {
                width: 100%;
                display: flex;
                flex-direction: row;
                justify-content: flex-end;
                gap: 10px;

            }

            .admin_dashboard_event_list_nav_lower .tribe-event-list-search {
                width: 100%;
            }

            .admin_dashboard_event_list_nav_lower_inner {
                width: 100%;
            }

            .admin_dashboard_event_list_nav_lower_inner span {
                font-size: 13px;
                font-weight: 300;
            }







            /******Add New Event******/

            .my-events {
                padding-bottom: 11px;
                padding-top: 13px;
                font-weight: 700;
                font-size: 35px !important;
            }

            .tribe-community-events {
                background-color: inherit !important;
                color: white !important;
                border-width: 0 !important;
                border-radius: 4px;
                max-width: 1300px;
                margin: 0 auto;
                padding: 0 !important;
            }

            .tribe-community-events form {
                background-color: #19191b !important;
    color: white !important;
    border-width: 0 !important;
    border-radius: 10px;
    margin: 0 auto;
    padding: 17px;
    margin-bottom: 80px !important;
            }

            .ui-widget-content {
                background-color: #19191b !important;
                color: white !important;
            }

            .ui-datepicker .ui-datepicker-title select option {
                font-size: 16px !important;
            }

            .tribe-community-events .tribe-section {
                background: inherit !important;
                border-width: 0 !important;
            }

            .tribe-community-events .tribe-section .tribe-section-header {
                border-bottom: 0px !important;
                margin-bottom: 10px !important;

            }

            .tribe-community-events .events-community-post-title,
            .tribe-community-events .events-community-post-content {
                position: relative;
                margin-left: 0;
            }

            .events-community-post-title input {
                border-radius: 4px !important;
                text-align: left !important;
                font-weight: 300 !important;
                font-size: 16px !important;
            }

            .events-community-post-title label {
                margin-bottom: 0;
            }

            .tribe-community-events .req {
                font-size: 11px;
                font-weight: 300;
            }

            /* Hide the first Quill toolbar */
            #quill-editor .ql-toolbar:first-child {
                display: none;
            }

            .tribe-community-notice p {
                color: black !important;
            }

            .my-events-header h2 {
                padding-top: 15px !important;
            }

            .my-events-header {
                border-bottom: 0 !important;
                margin-bottom: 0 !important;
            }

            .tribe-section-content-field {
                display: flex;
                flex-direction: row;
                align-content: center;
                justify-content: flex-start;
                align-items: center;
            }

            .tribe-section-content-field label,
            .tribe-section-content-label label {
                margin-bottom: 0 !important;
            }

            .recurrence-row {
                display: none !important;
            }

            .tribe-image-upload-area label,
            .tribe-image-upload-area .note p,
            .uploadFile {
                color: black !important;
            }

            .tribe-community-events .tribe-section.tribe-section-image-uploader .tribe-image-upload-area {
                background-position: center !important;
            }

            .tribe-community-events .tribe-section.tribe-section-image-uploader .tribe-image-upload-area .choose-file {
                margin-bottom: 26px !important;
            }


            .tribe-section-taxonomy,
            .tribe-section-website,
            .tribe-button-icon-settings,
            #rsvp_form_toggle,
            .tribe_soft_note,
            .tribe-section-tickets .accordion {
                display: none !important;
            }

            .select2-container--default .select2-selection--single {
                background-color: #3F3F3F !important;
                border: 1px solid #aaa;
                border-radius: 4px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow b {
                border-color: #fff transparent transparent transparent !important;
            }

            .tribe-dropdown .select2-selection--single .select2-selection__rendered {
                line-height: 22px !important;
                padding-right: 25px !important;
            }

            .tribe-dropdown .select2-selection--single .select2-selection__clear,
            .tribe-ea-dropdown .select2-selection--single .select2-selection__clear {
                line-height: 22px !important;
                padding-left: 10px !important;
            }

            .select2-search--dropdown {
                background-color: #3F3F3F !important;
                font-size: 14px !important;

            }

            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 0px solid #aaa !important;
                font-size: 14px !important;
            }

            .select2-container--default .select2-results__option--highlighted[data-selected] {
                background-color: #d3fa16 !important;
                color: rgb(0, 0, 0) !important;
                font-size: 14px !important;
            }

            .tribe-dropdown.select2-container .select2-results ul {
                background-color: #3F3F3F !important;
                color: white !important;
                font-size: 14px !important;
            }

            .select2-container--default .select2-results__option[data-selected=true] {
                background-color: #3F3F3F !important;
                color: white !important;
                font-size: 14px !important;
            }

            .tribe-ui-datepicker .ui-state-highlight,
            .tribe-ui-datepicker.ui-widget-content .ui-state-highlight,
            .tribe-ui-datepicker .ui-widget-header .ui-state-highlight {
                background: #fff;
                color: #363636 !important;
                border: 0;
                background-image: none;
            }

            #rsvp_form_save,
            #ticket_form_save,
            #tribe_settings_form_save,
            .tribe-events-community-footer input {
                margin: 30px auto;
                width: 100%;
                max-width: 400px;
                background: #d3fa16 !important;
                color: #000000 !important;
                text-transform: capitalize !important;
                border-radius: 3px;
                line-height: 1;
                padding: 9px 12px;
                font-weight: 500;
                display: block;
                font-size: 15px !important;
            }

            .tribe-community-events .tribe-section {
                background: inherit !important;
                padding-bottom: 1px !important;
            }


            .tribe-ticket-control-wrap .ticket_form_toggle {
                margin-bottom: 20px !important;
            }


            .event-terms-agree {
                display: inline-block;
                float: left;
                margin-right: 10px !important;
            }

            label:not(.form-check-label):not(.custom-file-label) {
                font-weight: 300 !important;
            }

            /*
.tribe-section-organizer  .tribe-section-content tbody , .tribe-section-venue  .tribe-section-content tbody { 
    display: flex;
    flex-direction: row;
    height: 20px!important;
    margin-bottom: 20px;

}*/
            .tribe-events-status_metabox__container {
                display: flex;
                flex-direction: row;
                align-items: center;
                margin-bottom: 20px;

            }

            .tribe-section-image-uploader .tribe-section-content {
                margin: 0 !important;

            }
            i.social-icon {
                position: absolute;
                font-family: 'FontAwesome'!important;
                font-size: 15px;
                left: 24px;
                border-radius: 4px;
                background: #555;
                color: #d3fa18;
                /* padding: 9px; */
                height: 30px;
                width: 30px;
                text-align: center;
                display: flex;
                align-content: center;
                justify-content: center;
                align-items: center;
            }
            input#organizer_facebook,
            input#organizer_twitter,
            input#organizer_instagram
            {
                margin-left: 60px;
            }
            #eventCouponForm {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
                border: 1px solid #7b7b7b;
                border-radius: 10px;
                padding: 20px 18px;
                margin: 20px 0;
            }

            .tribe-image-upload-area h2 {
                color: black !important;
                font-size: 27px !important;
            }

            .tribe-section-image-uploader .tribe-section-header,
            .events-community-post-title label {
                display: none !important;
            }

            .hover_section_content_show {
                display: none;
                width: 100%;
            }

            .events-community-post-title input[type="text"]::placeholder {
                color: white
            }

            html .page-template-organizer-template-php .events-community-post-title input {
                background: inherit !important;
    border-width: 0 !important;
    font-size: 17px !important;
    font-weight: 400 !important;
    color: white !important;
    box-shadow: inherit !important;
    padding-left: 0;
    margin-bottom: 9px;
    margin-top: 0;

            }

            .tribe-section-content-label {
                padding-left: 0 !important;
            }

            .page-id-1840 .events-community-post-title {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
                background: #121212;
                border-radius: 10px;
                padding: 8px 18px !important;
                margin: 14px auto !important;
                padding-bottom: 2px !important;
                max-width: 500px !important;
            }

            .events-community-post-title,
            .event_decp_div {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
                background: #121212;
                border-radius: 10px;
                padding: 20px 18px;
                margin: 20px 0;
                padding-bottom: 10px !important;

            }

            .event-section .tribe-section-content {
                margin-left: 0 !important;
            }

            .events-community-post-title p,
            .event_decp_div p {
                color: #9d9d9d !important;
                font-size:13px!important
            }

            .event_decp_div h2,
            #eventCouponForm .tribe-section-header {
                font-size: 22px !important;
                font-weight: 700 !important;
                color: white !important;
                margin-bottom: 13px;
                padding: 0;
            }

            .event_decp_div_text_area,
            .evetm_time_date_div_content {
                width: 100%;
            }

            .hover_section:hover {
                border-color: #d3fa16;
                cursor: pointer;
            }

            .hover_section:hover,
            .hover_section.clicked-section {
                border-color: #d3fa16;
                /* This color will remain for clicked sections */
            }

            /* Ensure the clicked section's border color remains even after hover */
            .hover_section.clicked-section {
                border-color: #d3fa16 !important;
                /* Override any other border color styles */
            }

            /* Hide by default */
            html .events-community-post-content,
            .evetm_time_date_div_content {
                display: none;
            }

            /* Show when 'displayed' class is added */
            html .events-community-post-content.displayed,
            .evetm_time_date_div_content.displayed {
                display: block !important;
            }

            .hover_section {
                position: relative;
            }

            .svg_penlic_edit {
                background-color: rgb(87, 87, 87);
                border-radius: 100px !important;
                position: absolute;
                right: 30px;
                padding: 7px;
                width: 34px;
                height: 34px;
            }
            .events-community-post-title.description {
          
            }
            .organizer_title_edit_btn,
            .edit_svg_click {
                background: #555;
                border-radius: 100px;
                width: 45px;
                height: auto;
                padding: 12px;
            }

            .events-community-post-title {
                position: relative;
            }

            .next-section-btn {
                margin: 30px auto;
                width: 100%;
                max-width: 400px;
                background: #d3fa16 !important;
                color: #000000 !important;
                text-transform: capitalize !important;
                border-radius: 3px;
                line-height: 1;
                padding: 9px 12px;
                font-weight: 500;
                display: block;
                font-size: 15px !important;
            }

            .next-section-btn:hover {
                background: #000000 !important;
                color: #d3fa16 !important;
            }

            .tribe-section-image-uploader .tribe-remove-upload {
                background-color: white;
                padding: 13px;
                border-radius: 5px;
                color: black !important;

            }

            .tribe-section-image-uploader .selected-msg {
                font-weight: 600;
            }

            .tribe-community-events .tribe-section.tribe-section-image-uploader .tribe-image-upload-area .form-controls,
            .tribe-section-image-uploader .tribe-remove-upload {
                margin: 0 auto;
                max-width: 250px;
                position: relative;
                width: 100%;
            }

            .tribe-section-image-uploader .tribe-remove-upload a {
                color: black !important;
            }

            .event_decp_div .tribe-section-image-uploader h2 {
                color: black !important;
            }

            .tribe-section-image-uploader #uploadFile {
                white-space: pre-wrap;
                word-wrap: break-word;
                overflow: hidden;
                resize: none;
                height: auto;
                border: 1px solid #ccc;
                background-color: #f5f5f5;
                font-size: 14px;
                padding: 2px 6px;
                border-radius: 4px;
            }

            .tribe-section-image-uploader .selected-msg,
            .tribe-section-image-uploader .uploadFile {
                display: none !important;
            }


            .tribe-section-image-uploader .uploaded {
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                width: 100%;
                max-width: 926px;
                height: 0;
                padding-bottom: 56.25%;
                border-width: 0 !important;
            }

            .tribe-datetime-separator {
                padding: 0 8px;
            }


            .tribe-community-events .tribe-section .tribe-datetime-block label {
                display: block;
                padding-left: 10px;
            }

            .tribe-section-datetime .tribe-section-header,
            .tribe-section-tickets .tribe-section-header,
            .tribe-section-venue .tribe-section-header,
            .tribe-section-organizer .tribe-section-header {
                display: none;
            }

            .tribe-section-datetime {
                margin: 0 !important;
            }

            .tribe-section-datetime .tribe-section-content-field input {
                margin: 0 8px;
            }

            select.tribe-dropdown {
                width: auto !important;
            }

            .tribe-section-venue .saved-linked-post,
            .tribe-section-organizer .saved-linked-post {
                display: flex;
                flex-direction: column;
            }

            .tribe-section-venue .saved-venue-table-cell,
            .tribe-section-venue tfoot tr td,
            .tribe-section-organizer tfoot tr td,
            .tribe-section-organizer .edit-linked-post-link,
            .saved-organizer-table-cell {
                display: none;
            }

            .tribe-section-venue {
                margin: 0 !important;
            }

            .tribe-section-venue .tribe-dropdown {
                margin: 0 !important;
            }

            .tribe-section-organizer,
            .tribe-section-tickets {
                margin: 0 !important;
            }

            .tribe-section-venue select,
            .tribe-section-organizer select {
                width: 300px !important;

            }


            .tribe-section-venue input[type="text"] {
                width: 100% !important;
            }

            #event_tribe_venue,
            #event_organizer {
                width: 100% !important;
            }

            .tribe-section-venue tr {
                display: flex;
                width: 100%;
            }

            .tribe-section-organizer {}

            .ticket_field:hover {
                cursor: pointer !important;
            }


            #eventCouponForm .tribe-section {
                margin: 0 !important;
            }

            .tribe-tickets-editor-table tr,
            .tribe-tickets-editor-table .table-header {
                background-color: #212121 !important;
            }
            .tribe-tickets-editor-table tr td , .tribe-tickets-editor-table thead, .tribe-tickets-editor-table .table-header {
    border-bottom: 1px solid #444;
}
            .ticket_duplicate_text {
                display: none;
            }

            #eventCouponForm .tribe-section-content {
                display: flex;
                flex-direction: column;
            }

            #eventCouponForm label:before {
                content: "Select Ticket";
                font-size: 17px;
                font-weight: 600;
                display: block;
                padding-bottom: 10px;
                padding-top: 13px;
            }



            .tribe-tickets-editor-table thead tr {

                border-bottom: 1px solid #444;

            }

            .tribe-tickets-editor-table .ticket_edit {
                white-space: normal;
                width: 98px !important;
                text-align: center;
            }

            .ticket_table_intro a {
                display: none;
            }

            .tribe-community-events .tribe-community-notice.tribe-community-notice-error {
                border-radius: 5px;
            }

            .uploaded-msg {
                display: none !important;
            }

            .submitdelete {
                color: black !important;
                background: white;
                border: 1px solid black;
                width: fit-content;
                padding: 6px 15px;
                text-decoration: none;
                border-radius: 5px;
                cursor: pointer;
                position: absolute;
                bottom: 8px;
                left: 50%; 
    transform: translateX(-50%); 
            }




            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer {
                background-color: #0d0e0e !important;
                border-width: 0 !important;
                width: 100%;
                margin-left: 0 !important;
                margin-top: 50px !important;
            }

            #add_sponsor_button {
                padding: 7px 15px;
                border-radius: 4px;
                cursor: pointer;
            }

            #add_sponsor_button:hover {
                background-color: #d3fa16;
                color: black;
            }

            .remove_sponsor_logo {
                color: #E53D3D !important;
                border-radius: 6px;
                background: rgba(166, 28, 28, 0.20);
                padding: 4px 14px;
                font-size: 12px;
                text-decoration: none;
                height: fit-content;
            }

            .sponsor_logo_container {
                display: flex;
                flex-direction: row;
                align-content: center;
                align-items: center;
                margin: 20px 0;
                gap: 15px;
            }

            .sponsor_logo_container img {
                max-width: 130px !important;
                max-height: 130px !important;

                margin-top: 0px !important;
                width: 100%;
                height: auto;
                object-fit: cover;


            }

            HTML #event_sponsors form {
                background-color: inherit !important;
                color: inherit !important;
                border-width: inherit !important;
                border-radius: inherit !important;
                margin: inherit !important;
                padding: inherit !important;
                margin-bottom: inherit !important;
            }

            .tribe-community-notice a {
                color: black !important;
            }


            .event-submission-response {
                width: fit-content;
                margin: 0 auto;
                text-align: center;
                margin-top: 100px;
            }

            .event-submission-response a {
                border-width: 0;
                padding: 9px 12px;
                background: #d5d5d5 !important;
                border-radius: 4px;
                color: black !important;
                font-size: 13px;
                text-align: center;
                width: fit-content;
                margin: 0 20px;

            }

            .event-submission-response a:hover {
                background: #d3fa16 !important;
                color: #000000 !important;
            }

            .event-submission-response p {
                font-size: 28px;
                color: #d3fa16 !important;
                font-weight: 700;
                margin-bottom: 10px !important;

            }

            .char-limit-warning {
                color: red !important;
                display: block;
                float: left;
                padding-right: 20px;
                margin-bottom: 0;
            }

            #admin_agenda_add-agenda {
                margin-top: 20px;
                padding: 7px 15px;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 20px;
                margin-top: 20px;
                max-width: fit-content;

            }

            .admin_agenda_accordion-title {
                font-size: 16px !important;
            }

            .admin_agenda_time_contnt {
                display: flex;
                flex-wrap: wrap;
                flex-direction: row;
                gap: 21px;


            }

            .admin_agenda_time_contnt input {
                border-radius: 2px;
                padding: 2px;
                margin-left: 10px !important;
            }




            .admin_add_btn_all {
                margin-top: 20px;
                padding: 7px 15px;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 0px !important;
                margin-top: 20px;
                max-width: fit-content;
            }

            .admin_add_btn_all:hover {
                background-color: #d3fa16;
                color: black;
            }

            .admin_delect_btn_all {
                color: #E53D3D !important;
                border-radius: 6px;
                background: rgba(166, 28, 28, 0.20);
                padding: 4px 14px;
                font-size: 12px;
                text-decoration: none;
                height: fit-content;
                display: block;
            }

            .admin_agenda_remove-agenda {}

            .admin_agenda_event_agendas_title {
                width: 98% !important;
            }

            .admin_agenda_accordion-arrow {
                font-size: 23px !important;
            }

            .line_up_section_admin .line-up-item {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                margin-bottom: 20px;
                justify-content: flex-start;
                align-items: center;
                align-content: center;
            }

            .line_up_section_admin .line-up-item input {
                margin-right: 20px;
            }

            #event_extra_option label {
                margin-bottom: 0 !important;
                position: relative;
                top: -2px;

            }

            .admin_event_extra_info_input {
                margin: 10px 0;
            }



            #tribe-community-events-shortcode {
                padding-bottom: 50px;
            }

            .payout_stutes {
                display: none;
            }

            .payment-status,
            .payment-eta {
                display: none;
            }

            .payout_event_list .payout_stutes {
                display: block;
            }

            .payout_event_list .action_normal_llist,
            .payout_event_list .event-status-form {
                display: none !important;
            }

            .payout_event_list .payment-status {
                display: block;
            }

            .payment-paid {
                background-color: rgba(27, 195, 125, 0.1) !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                border: 1px solid #1bc37c !important;
                font-size: 11px !important;
                padding: 2px 3px !important;
            }

            .payment-pending {
                background-color: rgba(255, 163, 0, 0.1) !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                border: 1px solid #FFA300 !important;
                font-size: 11px !important;
                padding: 2px 3px !important;
            }


            .payment-awaiting {
                background-color: rgba(30, 136, 229, 0.1) !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                border: 1px solid #1E88E5 !important;
                font-size: 11px !important;
                padding: 2px 3px !important;
            }

            .payout_event_list .tribe-list-column-venue {
                display: flex !important;
                flex-direction: column-reverse;
            }

            .payout_event_list .payment-eta {
                display: block;
            }

            #countdown-timer {
                display: none;
            }

            .payment_eta_title_span {}
            .payment-eta {
                font-size: 12px;
                font-weight: 300 !important;
                color: white;
                padding-bottom: 10px;
            }

            #term_bank_details {
                display: block !important;
                font-size: 12px;
                margin-bottom: 0;
            }

            .admin_bank_details_card label {
                display: none;
            }

            .admin_bank_details_card input {
                padding: 7px;
                margin: 5px 0;
                font-size: 16px;
                width: 100%;

            }

            .admin_bank_details_card input::placeholder {
                font-size: 12px;

            }

            .admin_bank_details_card p {
                font-size: 12px;
                font-weight: 300 !important;
                color: #aaa !important;
                text-align: left;
                margin-bottom: 5px;
            }

            .admin_bank_details_card a {
                text-decoration: underline !important;
                color: #aaa !important;
            }

            .terms_condtion_bank_details {
                display: flex;
                align-content: center;
                align-items: center;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 5px;

            }

            .terms_condtion_bank_details input {
                width: fit-content !important;
            }

            .terms_bank_details_submit_btn {
                margin-top: 20px !important;
                font-size: 12px !important;
                border-radius: 3px;
                max-width: fit-content !important;
                margin: 20px auto 0 auto !important;
            }




            .terms_bank_details_submit_btn:hover {
                background-color: #d3fa16 !important;
                color: black !important;
            }

            .admin_bank_details_card form {
                display: flex;
                flex-direction: column;
            }


            .payout_event_list .tribe-community-events-content {
                display: none;
            }

            .payout_event_list #tribe-community-events-shortcode {
                margin-left: 0 !important;
                max-width: 1500px;
            }

            .payout_event_list #tribe-community-events-list {
                max-width: 1500px !important;

            }

            .admin_bank_details_card strong {
                font-weight: 300 !important;
            }

            .delete-btn {
                position: relative !important;
            }


            .elementor-button-link_custom span {
                color: black !important
            }
            .account_storage{
                margin-bottom:0px
            }
.category-gallery{
    box-sizing: border-box;
    display: flex!important;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
    align-content: center;
    gap:20px;
    margin-top:30px
}
            .category-item {
                position: relative;
            }

            .category-item img {
                display: block;
                width: 100%;
                height: auto;
                max-width: 350px;

            }

            .overlay {
                position: absolute;
    bottom: 0%;
    background: rgba(0, 0, 0, 0.5);
    color: #ffffff;
    width: 100%;
    opacity: 1;
    color: white;
    text-align: center;
    padding: 20px;
    transition: .5s ease;
    display: block;
    height: fit-content;
            }

            .category-item:hover .overlay {
                opacity: 0;
            }

            .overlay h2,
            .overlay h3 {
                margin: 0;
                padding: 0;
            }
            .overlay h4{
    font-size: 18px;
    margin-bottom: 8px;
}
.overlay h5{
    font-size: 16px;
    margin-bottom: 0px;

} 

            .overlay h3 {
                font-size: 15px;
                font-weight: 300 !important;
                margin-top: 10px
            }

            .overlay h2 {
                font-size: 18px;
            }


            .category-images {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 10px;
            }

            .category-images img {
                max-width: 250px;
                object-fit: cover;
                width: 100% !important;

                flex: 1 1 22%;

            }

         
.category_main{
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 45px;
    margin-bottom:40px
}
.category_main_title .category {
    font-weight: 800;
    font-size: 30px;

}
.elementor-element-c668104{
    max-width: 1000px;
    margin-bottom: 200px !important;
}

.category_main_title .organizer {
    font-weight: 300;
    font-size: 17px;
    color: #aaa;
}
            #delete-category-form input {
                width: fit-content;
  
    padding: 7px 0px;
    border-radius: 4px;
    color: white !important;
    background: #ff4d4d !important;

            }

.elementor-element-c668104 {
    background-color: #19191b;
    position: relative;
    padding: 17px;
    border-radius: 10px;
    width: 100%;
}

.page-template-organizer-template  .main-selector-image-upload-div input{
    background: #121212!important;
}

        /*****setting page***/ 

.
        .setting_page_admin{
            padding-top: 50px;
            max-width:900px;
            margin:0 auto
        }
.orgerinser_settings_form{
    background-color: #19191b;
    position: relative;
    padding: 17px;
    border-radius: 10px !important;
    width: 100% !important;
}

.orgerinser_settings_form button{
    background: #d3fa16!important;
    color: #000000!important;
    font-size:12px!important;
    margin-top:10px;
    border:0px!important

}
        /******end */


        /****admin settings page */

        .page-template-organizer-template-php .orgerinser_settings_form input{
            background: #121212 !important;
        }

        /****end */

            /********sales and atendde rports page **** */

            #tribe-tickets-plus-woocommerce-orders-report {}




            /*********end*** */


            @media (max-width: 768px) {

                /* Adjustments for tablets */
                .overlay {
                    position: relative;
                    background: #0000;
                }

                .overlay h2,
                .overlay h3 {
                    color: #000;
                    /* Change text color for better visibility */
                }
            }

            @media (max-width: 550px) {

                /* Adjustments for mobile phones */
                .overlay {
                    position: relative;
                    /* Position overlay relative to its container */
                    background: transparent;
                    /* Optional: make the background transparent */
                }

                .category-images {
                    display: grid !important;
                    grid-template-columns: 50% 50% !important;


                }

                .overlay h2,
                .overlay h3 {
                    color: #000;
                    /* Change text color for better visibility */
                }
            }

            /****END*****/


            /****MEIDA QURRYS***/

            @media screen and (max-width: 992px) {

                .container-fluid {
    padding-top: 26px;
}
.brand-link .brand-image {
margin:0!important;
    max-height: 26px;

}.fake_aviter {
    font-size: 11px;
    width: 31px;
    height: 31px;
    line-height: 21px;
  
}.dark-mode .dropdown-menu {
    padding: 10px;
 
}.dark-mode .dropdown-menu  a {

    padding: 3px;

}
.dark-mode .dropdown-menu  a i{
display:block!important
}
                .main-header .brand-link{
                display:block
            }
            .brand-link {
                position: relative;
                padding-bottom: 0px;
    border: 0px!important;
            }
.profile-notification .nav-text{
    display:block!important
}
.main-header ul:first-child{
    display:none!important
}
                .admin_dashboard-sidebar-item a {
                    display: flex;
                    align-items: center;
                    width: fit-content;
                }

                .admin_dashboard-sidebar-item a .nav-text {
                    display: none;
                    margin-left: 8px;
                    /* Adjust as needed */
                }

                .admin_dashboard-sidebar-item a:hover .nav-text {
                    display: none;
                    position: absolute;
                    left: 49px;
                    background-color: white;
                    color: black !important;
                    padding: 10px;
                    border-radius: 4px;
                }

                .admin_dashboard-active a::after {
                    content: '';
                    position: absolute;
                    right: -10px;
                    top: 0;
                    bottom: 0;
                    width: 10px;
                    background-color: #d3fa16;
                    border-top-right-radius: 4px;
                    border-bottom-right-radius: 4px;
                }

                /* Always show text for active menu item */
                .admin_dashboard-sidebar-item a.active .nav-text {
                    display: inline;
                }

                .admin_dashboard-sidebar-item i {
                    padding-right: 10px;
                    font-size: 21px;
                    margin: 10px 0;
                }

                /* Existing Styles */
                .sidebar-mini.sidebar-collapse .main-sidebar,
                .sidebar-mini.sidebar-collapse .main-sidebar::before {
                    margin-left: 0;
                    width: 60px;
                    padding: 0 5px;
                }

                .sidebar-mini.sidebar-collapse .brand-text,
                .sidebar-mini.sidebar-collapse .sidebar .nav-sidebar .nav-link p,
                .sidebar-mini.sidebar-collapse .sidebar .user-panel>.info {
                    -webkit-animation-name: inherit !important;
                    visibility: visible !important;
                }

                .admin_dashboard-sidebar-item a {

                    width: fit-content;
                }

                .admin_dashboard-sidebar-item i {
                    padding-right: 10px;
                    font-size: 21px;
                    margin: 10px 0;
                }

                .main-sidebar {
                    padding-left: 0;
                }

                .brand-link {
                    display: none;
                }

                .admin_dashboard-sidebar {
                    width: 100%;
                    max-width: 52px;
                    height: 100vh;
                    background-color: transparent;
                    position: fixed;
                    overflow: auto;
                    top: 119px;
                    left: 9px;
                }

                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
                    transition: margin-left .3s ease-in-out;
                    margin-left: 57px !important;
                }
                .main-sidebar {
    max-width: 62px;

}
            }



            @media screen and (max-width: 953px) {
                .main_dashboard_stats_div .live_event_count_admin_dashboard {
                    display: none;
                }

                .admin_dashboard_stats_inner_div {
                    width: 33.33% !important;
                }

                .admin_dashboard_event_list_nav_lower a.tribe-button.tribe-button-primary.add-new {
                    display: none;
                }
            }


            @media screen and (max-width: 768px) {

                .admin_dashboard_main_activity_titles,
                .admin_dashboard_main_activity_item .admin_dashboard_title {
                    display: block;
                }

                .admin_dashboard_main_activity_item {
                    display: grid;
                    grid-template-columns: repeat(1, 1fr);
                    gap: 10px;
                    margin-bottom: 20px;
                    justify-items: center;
                }

                .admin_dashboard_main_activity_item>div {
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                }

                .admin_dashboard_main_activity_item .admin_dashboard_title {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 4px;
                }

                .admin_dashboard_main_customer_info {
                    margin-bottom: 15px;
                }

                .admin_dashboard_main_product {
                    margin-bottom: 15px;
                }

                .admin_dashboard_main_status {
                    margin-bottom: 15px;
                }

                .admin_dashboard_main_retained {
                    margin-bottom: 15px;
                }

                .admin_dashboard_main_amount {
                    margin-bottom: 15px;
                }

                .admin_dashboard_main_activity_titles {
                    display: none;
                }

                .admin_dashboard_main_activity_item .title {
                    font-size: 14px;
                    color: #aaa;
                    text-transform: capitalize;
                    padding-left: 6px;
                }
            }

            @media screen and (min-width: 769px) {
                .admin_dashboard_main_activity_item .title {
                    display: none;
                }

            }



            /* Responsive Styles */
            @media (max-width: 768px) {
                .main_dashboard_stats_div {
                    display: flex;
                    flex-wrap: wrap;
                }


                .main_dashboard_stats_div>.admin_dashboard_stats_inner_div:nth-child(-n+2) {
                    flex: 1 0 50%;
                }


                .main_dashboard_stats_div>.admin_dashboard_stats_inner_div:nth-child(n+3) {
                    flex-basis: 50%;
                }

                .main_dashboard_stats_div .live_event_count_admin_dashboard {
                    display: block;
                }

                .sales-card.today_sale_admin_dashboard {
                    background-color: #19191b;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    position: relative;
                    padding: 17px;
                    border-radius: 10px;
                    width: 100%;
                    max-width: inherit;
                }


                .admin_dashboard_main_activity_item {
                    grid-template-columns: 1fr;
                    text-align: center;
                    padding: 3px 0;
                    gap: 0px;
                }

                .admin_dashboard_main_activity_titles {
                    display: none;
                    /* Hide titles on small screens */
                }

                .admin_dashboard_main_activity_item>div {
                    padding: 1px;
                    align-items: center;
                }

                .admin_dashboard_main_activity_item:last-child>div {
                    border-bottom: none;
                }

                .lower_admin_dashboard-sidebar,
                .lower_admin_dashboard-sidebar-list {
                    width: fit-content;

                }

                .admin_dashboard-sidebar-item {
                    width: 100%;
                    max-width: fit-content;
                }

                .tribe-list-column-organizer,
                .gross-column {}

                .tribe-community-events-list tbody tr,
                .tribe-community-events-list thead tr {
                    grid-gap: 5px;
                }
            }


            @media (max-width: 768px) {


            }


            @media (max-width: 707px) {
                .category_main {
 gap: 10px;
 flex-direction: column;
}
#delete-category-form input {

    margin: 0 !important;
}.category_main_title .organizer {
    font-size: 15px;
    margin:10px 0
  
}
                .tribe-community-events-list tbody tr,
                .tribe-community-events-list thead tr {
                    grid-template-columns: 42% 14% 16% 16% 9%;
                }

                .summary_tabs_my_events_main_inner {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    grid-gap: 20px;
                    padding: 0px;
                    margin-top: 9px;

                }

                .event-title-image .title {
                    font-size: 16px !important;
                    margin-right: 29px;
                    line-height: 19px;
                    position: relative;
    top: 3px;
                }

                .sales-card {

                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;

                    border-radius: 8px;
                    background-color: #19191b;
                }

                .event-start-date {
                    flex-direction: row;
                    gap: 3px;
                    align-items: center;
                    line-height: 19px;
                }

                .summary_tabs_my_events_main_inner .sales-card:nth-child(3) {
                    grid-column: 1 / -1;
                }

                .admin_dashboard_event_list_nav_lower select {
                    font-size: 12px;
                    max-width: 96px;
                }

                .admin_dashboard_event_list_nav_lower .tribe-search-form #search-submit {
                    font-size: 11px;
                    padding: 3px 12px !important;
                }

                .admin_dashboard_sales-amount_view_full_report {
                    margin-top: 8px;
                }

                .tribe-list-column-title,
                .tribe-list-column-organizer {}
            }


            @media (max-width: 655px) {
                .tribe-community-events-list thead {
                    display: none;
                }

                .tribe-community-events-list thead tr {
                    pointer-events: none;
                }

                a.tribe-button.tribe-button-primary.add-new {
                    margin-top: -6px;
                }

                .tribe-community-events-list tbody tr {
                    display: grid;
                    grid-template-columns: repeat(1, 1fr);
                    grid-column-gap: 5px;
                    grid-row-gap: 5px;
                    justify-items: start;
                }

                .admin_view_more_setting .dropbtn {

                    position: absolute;
                    right: 10px;
                }

                .tribe-list-column-venue {
                    justify-content: flex-start !important;
                }

                .tribe-community-events-list tbody tr td {
                    padding: 0;
                }

                .tribe-community-events-list tbody tr {
                    padding-bottom: 20px;
                }

                .tribe-community-events-list tbody .tribe-list-column-status {
                    grid-area: 1 / 1 / 2 / 2;
                    margin-top: 10px;
                    margin-bottom: 16px;
                }

                .tribe-community-events-list tbody .tribe-list-column-passcode {
                    grid-area: 2 / 1 / 3 / 2;

                }
                .tribe-community-events-list tbody .tribe-list-column-title {
                    grid-area: 3 / 1 / 4 / 2;

                }

                .tribe-community-events-list tbody .tribe-list-column-title::after {
                    content: "Ticket";

                }

                .tribe-community-events-list tbody .tribe-list-column-organizer::after {
                    content: "Sales";

                }

                .tribe-community-events-list tbody .tribe-list-column-organizer::after,
                .tribe-community-events-list tbody .tribe-list-column-title::after {
                    padding-left: 5px;
                    font-size: 13px;
                    font-weight: 300;
                    position: relative;
          top: 2px;
                }

                .tribe-community-events-list tbody .tribe-list-column-title,
                .tribe-community-events-list tbody .tribe-list-column-organizer {
                    font-size: 14px;
                    font-weight: 600;

                }

                .tribe-community-events-list tbody .tribe-list-column-organizer {
                    grid-area: 4 / 1 / 5 / 2;

                }

                .tribe-community-events-list tbody .tribe-list-column-venue {
                    grid-area: 5 / 1 / 6 / 2;

                }

                .tribe-community-events-list tbody .tribe-list-column-category {
                    grid-area: 1 / 2 / 2 / 3;
                }

                .event-section__form_link a:not(:first-child):before {
                    display: none;
                }

                .event-section__form_link {

                    gap: 0px !important;
                }

                .event-section__form_link a {
                    text-align: center;
                    align-items: center;
                    display: flex;
                }

                .hover_svg {
                    display: none !important;
                }


            }




            @media (max-width: 550px) {
                .brand-link {
    padding: 0;
  
}
                .elementor-element-ba1dafd{
                    margin-bottom: 0 !important;
                }
                .admin_dashboard_main_recent_activity{
                    margin-bottom:100px
                }
                a.tribe-button.tribe-button-primary.add-new {
    margin: 0;
    margin-left:20px!important
}
                .user-panel .info {
    padding: 5px 5px 0px 10px;
}
                body .dashboard_main_page_title_div{
                    margin-bottom: 10px !important;
                }
                .lower_admin_dashboard-sidebar {
                    display: none;
                }

                .admin_dashboard-sidebar {
                    overflow: visible;
                }

                .admin_dashboard-sidebar-list {
                    position: absolute;
                    display: flex;
                    width: 100%;
                    justify-content: space-evenly;
                    align-items: center;
                    padding: 0 10px;
                    align-content: center;
                    flex-direction: row;
                    margin-bottom: 0 !important;
                    gap: 13px;
                }

                .sidebar-mini.sidebar-collapse .main-sidebar,
                .sidebar-mini.sidebar-collapse .main-sidebar::before {
                    min-height: 0 !important;
                }

                .admin_dashboard-sidebar {
                    width: 100%;
                    max-width: 100%;
                    height: 76px;
                    background-color: #ffffff;
                    position: fixed;
                    top: 91.1%;
                    left: 0px;
                    padding: 4px 4px;
                    padding-top: 0;
                }
                .user-panel .fa-angle-down:before {
  
     margin-right: 0; 
}
                .admin_dashboard-sidebar-item a {

                    padding: 0px;

                }

                .admin_dashboard-active a {
                    background: linear-gradient(180deg, rgba(211, 250, 22, 1) 0.01%, rgba(211, 250, 22, 0.00) 99.96%);
                    width: 37px;
                    padding-top: 5px;
                }

                .admin_dashboard-active a::after {
                    content: '';
                    position: absolute;
                    right: 0;
                    top: 0;
                    height: 5px;
                    /* This will set the green bar's height */
                    left: 0;
                    width: 100%;
                    background-color: #d3fa16;
                    border-top-right-radius: 5px;
                    border-top-left-radius: 5px;
                }

                .admin_dashboard-sidebar-item i {
                    font-size: 21px;
                    margin: 10px 0;
                    text-align: center;
                    width: 100%;
                    padding: 0;
                    color: #19191b;
                }
                .profile-notification .admin_dashboard-sidebar-item i {
              
                    color: #ffff;
                }

                .page-template-organizer-template-php .nav-link {
                    display: none;
                }

                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
                    transition: margin-left 0s ease-in-out;
                    margin-left: 0px !important;
                }

                .admin_dashboard-sidebar-item a:hover {
                    background: inherit !important
                }

                .page-template-organizer-template h2,
                .tribe-community-events-list-title {
                    font-size: 20px !important;
                    margin-top: 0px !important;
                }

                .elementor-1661 .elementor-element.elementor-element-8e8b78b .elementor-heading-title {
                    font-family: "Plus Jakarta Sans", Sans-serif;
                    font-weight: 100;
                    font-size: 15px;
                }

                .admin_dashboard_main_recent_activity h2 {
                    font-size: 15px !important;

                }

                .admin_dashboard_event_lis_search_filter {
                    flex-direction: column;
                    width: 100%;
                    justify-content: center;
                    align-content: flex-start;
                    margin-top: 23px;
                }

                .admin_dashboard_event_list_nav_lower form div {
                    width: 100%;
                    display: flex;
                    flex-direction: row-reverse;
                    justify-content: flex-end;
                    gap: 10px;
                    margin-top: 20px;

                }

                .admin_dashboard_event_list_nav_lower .tribe-search-form input[name="event-search"] ,  .admin_dashboard_event_list_nav_lower .tribe-search-form input{
                    border-radius: 4px !important;

                }

                input[type="search"] {
                    font-size: 16px !important;
                }

                input[type="search"]::placeholder {
                    font-size: 14px !important;

                }

                .search-box:focus {
                    outline: none !important;
                }

                .admin_dashboard_event_list_nav,
                .dashboard_main_page_title_div {
                    margin-bottom: 25px !important;
                }

                .organizer_image_upload_function_container img {
                    max-width: 122px;
                    width: 100%;
                    height: auto;
                }

                .edit_main_image {
                    position: absolute;
                    cursor: pointer;
                    top: 50%;
                    right: 47%;
                }

                .my-events-header h2 {}

                .banner_image_text_requirments p {

                    width: 93%;
                }

                .profile_img_svg_div {
                    position: relative;
                    width: fit-content;
                    margin: 0 auto;
                }

                html .page-template-organizer-template-php .events-community-post-title input {

                    font-size: 20px !important;

                }
                /**Gallery page */
                .elementor-element-c668104{
                    margin-bottom:100px
                }
                .elementor-element-1eb84e4{
                    padding-top:0!important
                }
                .elementor-element-4ca953c{
                    margin-bottom:100px
                }
                .page-template-organizer-template #image-upload-form input {
 
    width: 100%!important;

}
#drop-zone {

    width: 100%;
    padding: 33px !important;
    height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    align-content: center;
}
#image-upload-form .fa-stack-1x, .fa-stack-2x {
  position: relative;

}
            }




            @media (max-width: 500px) {
                .main_dashboard_stats_div {
                    display: flex;
                    flex-direction: column !important;
                }

                .admin_dashboard_stats_inner_div,
                .admin_dashboard_stats_inner_div_revenue,
                .live_event_count_admin_dashboard,
                .live_event_count_admin_dashboard {
                    flex-basis: 100% !important;
                    width: 100% !important;
                }

                .admin_dashboard_sales-amount_view_full_report {
                    margin-top: 9px;
                }


                .admin_dashboard_sales-amount {
                    font-weight: 700;
                    font-size: 21px;
                    margin-bottom: 4px;
                    color: #d3fa16 !important;
                    white-space: nowrap;
                }

                .today_sale_admin_dashboard h5 {
                    font-size: 14px;

                }

                .admin_dashboard_lower_other_day {
                    font-size: 13px;
                }

                .admin_dashboard_main_customer_info span {
                    font-size: 14px;
                }

                .admin_dashboard_main_customer_info strong,
                .admin_dashboard_main_status,
                .admin_dashboard_main_customer_id,
                .admin_dashboard_main_retained,
                .admin_dashboard_main_amount {
                    font-size: 15px !important;

                }

                .admin_dashboard_main_status .status_result {

                    font-size: 12px;
                }
            }

            @media (max-width: 480px) {

                /* On mobile screens, we adjust the text size for better readability */
                .admin_dashboard_main_recent_activity {
                    padding: 15px;
                }

                .admin_dashboard_main_recent_activity h2 {
                    font-size: 16px;
                }

                .admin_dashboard_main_recent_activity h2 span {
                    font-size: 12px;
                    font-weight: 100;
                }

                .admin_dashboard_main_customer_info strong,
                .admin_dashboard_main_status,
                .admin_dashboard_main_customer_id,
                .admin_dashboard_main_retained,
                .admin_dashboard_main_amount {
                    font-size: 12px;
                    font-family: "Plus Jakarta Sans", Sans-serif !important;
                }
            }





            @media (max-width: 480px) {
                .admin_dashboard_lower_other_day {
                    flex-wrap: wrap;
                    gap: 7px;

                }
            }



            @media (max-width: 400px) {
                .organizers-header {
                    display: flex;
                    flex-direction: column;
                    flex-wrap: wrap;
                    gap: 0px;
                    justify-content: center;
                    max-width: 700px;
                    align-items: flex-start;
                    align-content: flex-start;
                    margin-bottom: 29px;
                }

                body .organizers_add_new_btn {
                    margin-top: -7px !important;
                }
            }
        </style>






<script>


///finvtion for the svg  loader
jQuery(document).ready(function($) {
    // Wait for 1 second after the document is ready
    setTimeout(function() {
        // Select the SVG div and add the 'hidden' class
        $('.loading_svg_div').addClass('hidden_loading_svg');
        console.log('SVG should now be hidden');

        // After hiding the SVG, wait another 1 second to perform further actions
        setTimeout(function() {
            console.log('Performing another action 1 second after hiding the SVG');
            // Any subsequent actions can be placed here
        }, 1000);
    }, 1200);
});








jQuery(document).ready(function($) {
    $('.row-actions span.inline a').each(function() {
        var text = $(this).text();
        if (text.includes('Check In') || text.includes('Undo Check In') || text.includes('PDF Ticket') || text.includes('Download Apple Wallet pass')) {
            $(this).hide();
        }
    });
});



</script>




<?php
