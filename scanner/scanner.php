<?php
/*
Template Name: Organizer Scanner
*/

// Check if the current user has the required role to access this page
if ( ! current_user_can( 'organiser' ) && ! current_user_can( 'administrator' ) && ! current_user_can( 'verifier' ) ) {
    // Redirect users without the required role to the homepage or any other page
    wp_redirect( home_url() );
    exit;
}

// Include the custom header
$custom_header_path = get_stylesheet_directory() . '/scanner/header-organizer-scanner.php';
if ( file_exists( $custom_header_path ) ) {
    require_once( $custom_header_path );
} else {
    // Fallback to the default header if your custom header is not found
    get_header();
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Your content goes here -->
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include the custom footer
$custom_footer_path = get_stylesheet_directory() . '/scanner/footer-organizer-scanner.php';
if ( file_exists( $custom_footer_path ) ) {
    require_once( $custom_footer_path );
} else {
    // Fallback to the default footer if your custom footer is not found
    get_footer();
}
?>