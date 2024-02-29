<?php
/**
 * New Organizer Form Template
 * This is used to create a new event organizer.
 *
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    die('-1');
}
?>

<!-- Back Button -->
<a href="/dashboard/organisers-list/">
    <div class="organizer_edit_back_btn_main">
        <div class="organizer_edit_back_btn">
            <!-- SVG code for the back icon -->
        </div>
    </div>
</a>

<div id="tribe-community-events" class="form organizer">
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('ecp_organizer_submission'); ?>

        <!-- Banner Image Upload -->
        <div class="banner-image-upload">
            <label for="bannerInput">Upload Banner Image:</label>
            <input type="file" id="bannerInput" name="bannerInput" accept="image/jpeg,image/png">
        </div>

        <!-- Banner Image Display -->
        <div class="banner-image-holding_div">
            <img class="banner_image_organizer" src="https://thaynna-william.co.uk/wp-content/uploads/2024/01/Group-189-5.jpg" alt="Organizer Banner Image" />
            <!-- SVG code for the edit icon -->
        </div>

        <!-- Organizer Image Upload -->
        <div class="organizer_image_upload_function_container">
            <div class="organizer_image_upload_function">
                <label>Current Organizer Image:</label>
                <div class="profile_img_svg_div">
                    <img src="https://thaynna-william.co.uk/wp-content/uploads/2024/01/default-avatar-photo-placeholder-profile-icon-vector.jpg" alt="Organizer Image" />
                    <!-- SVG code for the edit icon -->
                </div>
                <p>
                    <span>Maximum file size: 300KB.<br>Accepted formats: JPEG or PNG only.</span>
                </p>
            </div>
        </div>

        <!-- Drag and Drop Image Upload -->
        <div id="drop_zone" class="drop-zone">
            <!-- SVG and HTML for drag and drop -->
        </div>
        <input type="file" id="fileInput" name="fileInput" accept="image/jpeg" style="display:none;" onchange="validateAndDisplayImage(this.files)">

        <!-- Organizer Title -->
        <div class="events-community-post-title">
            <label for="post_title">
                Organizer Name:
                <small class="req">(required)</small>
            </label>
            <input type="text" name="post_title" id="post_title_input" />
            <!-- SVG code for the edit icon -->
        </div>

        <!-- Organizer Description -->
        <div class="events-community-post-content">
            <label for="post_content">Organizer Description:</label>
            <textarea name="tcepostcontent"></textarea>
        </div>

        <!-- Form Submit Button -->
        <div class="tribe-events-community-footer">
            <input type="submit" class="button submit events-community-submit" value="Create Organizer" name="community-event" />
        </div>
    </form>
</div>
