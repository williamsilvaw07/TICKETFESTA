<?php
/*
Template Name: Custom Role Control Template
*/

// Check if the user is logged in and has the correct role
$is_logged_in = is_user_logged_in();
$is_organizer = $is_logged_in && (current_user_can('organiser') || current_user_can('administrator'));

// Choose the appropriate header
get_header($is_organizer ? 'organizer' : '');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper <?php echo !$is_logged_in ? 'not-logged-in' : ($is_organizer ? '' : 'not-logged-in'); ?>">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            if ($is_organizer) {
                // Loop to show content if the user has the correct role
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content(); // Display the content of the post
                    endwhile;
                endif;
            } else {
                // Content for non-qualified users
                echo '<div class="organizer-access-content">';
                if ($is_logged_in) {
                    echo '<p>This page is limited to organizers only. Please contact admin to change your account role to "organizer".</p>';
                } else {
                    echo '<h4 class="login_form_title">This page is for organisers only. Please log in or register.</h4>';
                    echo do_shortcode('[xoo_el_inline_form tabs="login" active="login"]');
                }
                echo '</div>'; // Close the main container div
            }
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
get_footer($is_organizer ? 'organizer' : '');
?>


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
