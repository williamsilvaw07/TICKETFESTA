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













<?php
