<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- Include stylesheet -->
    <?php wp_head(); ?>
</head>
<body <?php body_class("hold-transition sidebar-mini dark-mode"); ?> <?php generate_do_microdata('body'); ?>>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Brand Logo -->
            <a href="https://ticketfesta.co.uk/" class="brand-link">
                <img src="https://ticketfesta.co.uk/wp-content/uploads/2024/02/Group-195-2.png" alt="" class="brand-image  elevation-3">
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
                <!-- User panel dropdown -->
                <li class="nav-item dropdown show">
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
                    <!-- Dropdown menu -->
                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                       <!-- Organiser Dashboard (added for organisers and administrators) -->
                       <?php if (current_user_can('organiser') || current_user_can('administrator')) : ?>
                            <li class="admin_dashboard-sidebar-item">
                                <a href="/dahsboard">
                                    <i class="fas fa-home"></i> <span class="nav-text">Organiser Dashboard</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        
                        <!-- Switch to Attendee -->
                        <li class="admin_dashboard-sidebar-item">
                            <a href="https://ticketfesta.co.uk/">
                                <i class="fas fa-exchange-alt"></i><span class="nav-text">Switch to Attendee</span>
                            </a>
                        </li>
                        <!-- Settings -->
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/organisers-setting/">
                                <i class="fas fa-cog"></i><span class="nav-text">Settings</span>
                            </a>
                        </li>
                        <!-- Support -->
                        <li class="admin_dashboard-sidebar-item">
                            <a href="/orginser-support">
                                <i class="fas fa-envelope"></i> <span class="nav-text">Support</span>
                            </a>
                        </li>
                        <span class="line_break"></span>
                        <!-- Logout -->
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
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <!-- Your main sidebar code goes here -->
    </div>
    <?php wp_footer(); ?>
</body>
</html>