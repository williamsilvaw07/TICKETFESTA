<?php
/*
Template Name: Custom Role Control Template
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
                // Different messages based on user status
                if (is_user_logged_in()) {
                    // User is logged in but does not have the correct role
                    echo '<p>This page is restricted. Please switch your account to organiser to access this content.</p>';
                    // Provide a button to switch the role to 'organiser'
                    echo '<button onclick="switchUserRole()">Switch My Account to Organiser</button>';
                } else {
                    // User is not logged in
                    echo '<p>This page is for organisers only.</p>';
                    echo do_shortcode('[xoo_el_inline_form tabs="login" active="login"]');
                }
            }
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
function switchUserRole() {
    // AJAX call to server to change user role
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/wp-admin/admin-ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            alert("Your role has been updated to organiser.");
            location.reload(); // Reload the page to update content
        }
    }
    xhr.send("action=switch_to_organiser");
}
</script>

<?php
// Include the custom footer
get_footer();
?>







