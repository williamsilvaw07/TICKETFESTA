<?php
/*
Template Name: Organizer Scanner
*/

// Include the custom header
$custom_header_path = get_stylesheet_directory() . '/scanner/header-organizer-scanner.php';
if (file_exists($custom_header_path)) {
    require_once($custom_header_path);
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

        <div class="scanner_login_divs"> 

</div>
            <p class="scanner_vrsion">Version 1.0</p>

        <h2 class="tribe-community-events-list-title">Ticket Scanner</h2>
        <button class="change_event_btn" style="display:none"><i class="fas fa-sign-in-alt"></i> Change Event</button>
            <?php
            if (have_posts()) :
                while (have_posts()) :
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
if (file_exists($custom_footer_path)) {
    require_once($custom_footer_path);
} else {
    // Fallback to the default footer if your custom footer is not found
    get_footer();
}
?>






<style>
    
</style>