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
</script>




<?php
