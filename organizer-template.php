<?php
/*
Template Name: Custom Access Control Template
*/

// Include the custom header
get_header();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            // Check if the user is logged in and has the 'organiser' or 'administrator' role
            if (is_user_logged_in() && (current_user_can('organiser') || current_user_can('administrator'))) {
                // User is logged in and has the required role, display the content
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        the_content(); // The main content of the page
                    endwhile;
                endif;
            } else {
                // User is not logged in or does not have the required role, show login form
                echo do_shortcode('[xoo_el_inline_form tabs="login" active="login"]');
            }
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include the custom footer
get_footer();
?>







