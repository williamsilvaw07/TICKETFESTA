<?php
/*
Template Name: Custom Role Control Template
*/

// Dynamically choose the header based on user role
if (is_user_logged_in() && (current_user_can('organiser') || current_user_can('administrator'))) {
    get_header('organizer'); // Use the custom header for organisers/administrators
} else {
    get_header(); // Use the default header for other users
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            // Check user's role and display content accordingly
            if (is_user_logged_in() && (current_user_can('organiser') || current_user_can('administrator'))) {
                // Display page content if user has the correct role
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
            } else {
                // Show different messages or actions based on user's login status
                if (is_user_logged_in()) {
                    echo '<p>This page is limited to organizers only. Please change your account role to \'organizer\' to view this content. Note that this change is irreversible.</p>';
                    echo '<button onclick="switchUserRole()">Switch My Account to Organiser</button>';
                } else {
                    echo '<p>This page is for organisers only. Please log in.</p>';
                    echo do_shortcode('[xoo_el_inline_form tabs="login" active="login"]');
                }
            }
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Include Toastr and SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@latest/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastr@latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
// Function to switch user role with Toastr notification
function switchUserRole() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/wp-admin/admin-ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            toastr.success("Your account has been updated to organiser.");
            location.reload(); // Reload the page to reflect the role change
        }
    }
    xhr.send("action=switch_to_organiser");
}

// Function to update role with SweetAlert2 for handling responses
function updateRole() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/wp-admin/admin-ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status >= 200 && this.status < 300) {
            var response = JSON.parse(this.responseText);
            Swal.fire('Success!', response.data, 'success');
            location.reload();
        } else {
            Swal.fire('Error!', 'Failed to update role. Please try again.', 'error');
        }
    };
    xhr.onerror = function() {
        Swal.fire('Error!', 'Network Error. Please check your connection and try again.', 'error');
    };
    xhr.send("action=switch_to_organiser");
}
</script>

<?php
// Include the custom footer
get_footer();
?>
