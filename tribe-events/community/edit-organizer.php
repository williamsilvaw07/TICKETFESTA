<?php
/**
 * Edit Organizer Form (requires form-organizer.php)
 * This is used to edit an event organizer.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-organizer.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 3.1
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 *
 * @var int $organizer_id The ID of the Organizer being edited.
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$organizer_label_singular = tribe_get_organizer_label_singular();
$organizer_id = get_the_ID(); // Get the organizer post ID



?>
<div class="organizer_title">
<h2>Edit Organiser</h2>
</div>
<a href="/dashboard/organisers-list/">
    <!--
<div class="organizer_edit_back_btn_main">
<div class="organizer_edit_back_btn"> <svg xmlns="http://www.w3.org/2000/svg" width="79" height="69" viewBox="0 0 79 69" fill="none">
            <path d="M73.3483 29.4643H15.7033L33.3467 8.27265C34.1717 7.28007 34.5687 6.0004 34.4502 4.71517C34.3317 3.42993 33.7075 2.24441 32.7149 1.4194C31.7223 0.594395 30.4426 0.19748 29.1574 0.315977C27.8721 0.434474 26.6866 1.05868 25.8616 2.05126L1.55931 31.214C1.39581 31.446 1.2496 31.6897 1.12187 31.9431C1.12187 32.1861 1.12187 32.3319 0.781639 32.575C0.561332 33.1323 0.445981 33.7255 0.441406 34.3247C0.445981 34.924 0.561332 35.5172 0.781639 36.0745C0.781639 36.3175 0.781638 36.4633 1.12187 36.7064C1.2496 36.9598 1.39581 37.2035 1.55931 37.4354L25.8616 66.5982C26.3186 67.1469 26.8909 67.5881 27.5377 67.8905C28.1846 68.1929 28.8901 68.3491 29.6042 68.348C30.7398 68.3502 31.8404 67.9547 32.7149 67.2301C33.207 66.822 33.6139 66.3209 33.9121 65.7554C34.2103 65.1899 34.394 64.5711 34.4527 63.9345C34.5114 63.2979 34.4439 62.656 34.2541 62.0455C34.0643 61.435 33.756 60.8679 33.3467 60.3768L15.7033 39.1852H73.3483C74.6374 39.1852 75.8737 38.6731 76.7852 37.7616C77.6967 36.8501 78.2088 35.6138 78.2088 34.3247C78.2088 33.0357 77.6967 31.7994 76.7852 30.8879C75.8737 29.9764 74.6374 29.4643 73.3483 29.4643Z" fill="#231F20"/>
        </svg><p>Back</p></div></div></a> -->
<?php
// Check if the form has been submitted
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    // Include WordPress file handling functions
    require_once(ABSPATH . 'wp-admin/includes/file.php'); 

    // Handle Featured Image Upload
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $featured_return = wp_handle_upload($_FILES['fileInput'], array('test_form' => false));
        if (!isset($featured_return['error']) && !isset($featured_return['upload_error_handler'])) {
            $featured_filename = $featured_return['file'];
            $featured_attachment = array(
                'post_mime_type' => $featured_return['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', basename($featured_filename)),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'guid'           => $featured_return['url']
            );
            $featured_attachment_id = wp_insert_attachment($featured_attachment, $featured_return['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $featured_attachment_data = wp_generate_attachment_metadata($featured_attachment_id, $featured_filename);
            wp_update_attachment_metadata($featured_attachment_id, $featured_attachment_data);
            set_post_thumbnail($organizer_id, $featured_attachment_id);
        }
    }

    // Handle Banner Image Upload
    if (isset($_FILES['bannerInput']) && $_FILES['bannerInput']['error'] === UPLOAD_ERR_OK) {
        $banner_return = wp_handle_upload($_FILES['bannerInput'], array('test_form' => false));
        if (!isset($banner_return['error']) && !isset($banner_return['upload_error_handler'])) {
            $banner_filename = $banner_return['file'];
            $banner_attachment = array(
                'post_mime_type' => $banner_return['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', basename($banner_filename)),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'guid'           => $banner_return['url']
            );
            $banner_attachment_id = wp_insert_attachment($banner_attachment, $banner_return['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $banner_attachment_data = wp_generate_attachment_metadata($banner_attachment_id, $banner_filename);
            wp_update_attachment_metadata($banner_attachment_id, $banner_attachment_data);
            update_post_meta($organizer_id, 'banner_image_id', $banner_attachment_id);
        }
    }

    if (isset($_POST['post_title'])) {
        $organizer_name = sanitize_text_field($_POST['post_title']);
        wp_update_post(array(
            'ID' => $organizer_id,
            'post_title' => $organizer_name
        ));
    }
    ?>
    <script>
    // Specify the URL you want to redirect to
    var redirectUrl = 'https://ticketlocation.com/dashboard/organisation-settings/?organizer_updated=true';

        // Perform the redirect
        window.location.href = redirectUrl;

    </script>
    <?php
    // Redirect after form submission
    // wp_redirect('https://ticketfesta.co.uk/dashboard/organisers-list/?organizer_updated=true');
    exit;
}


$organizer_thumbnail_id = get_post_thumbnail_id($organizer_id); // Get the featured image attachment ID
$organizer_thumbnail_url = wp_get_attachment_image_url($organizer_thumbnail_id, 'medium'); // Get the URL of the featured image
// Retrieve the banner image URL from the custom field
$banner_image_id = get_post_meta($organizer_id, 'banner_image_id', true);
$banner_image_url = $banner_image_id ? wp_get_attachment_image_url($banner_image_id, 'full') : '';

?>

<div class="edit_organizer_main">



<div id="tribe-community-events" class="form organizer">
    <?php tribe_get_template_part( 'community/modules/header-links' ); ?>

    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'ecp_organizer_submission' ); ?>




        <!-- Banner Image Upload -->
        <div class="banner-image-upload">
            <label for="bannerInput">Upload Banner Image:</label>
            <input type="file" id="bannerInput" name="bannerInput" accept="image/jpeg,image/png">
        </div>



      <!-- Check if there's a banner image URL -->
      <?php
// Set the default banner image URL
$default_banner_image = 'https://ticketlocation.com/wp-content/uploads/2024/04/antoine-j-r3XvSBEQQLo-unsplash-2-min.jpg';

// Get the banner image ID from post meta
$banner_image_id = get_post_meta($organizer_id, 'banner_image_id', true);

// Check if a banner image has been uploaded
if ($banner_image_id) {
    // Get the URL of the uploaded banner image
    $banner_image_url = wp_get_attachment_image_url($banner_image_id, 'full');
} else {
    // Use the default banner image URL
    $banner_image_url = $default_banner_image;
}
?>

<!-- Banner Image Display -->
<div class="banner-image-holding_div">
    <div class="banner_image_text_requirments">
    <p>Recommended size: 1400 x 600.<br> Maximum file size: 300KB. <br> Accepted formats: JPEG or PNG only.</p>
            <img class="banner_image_organizer" src="<?php echo esc_url($banner_image_url); ?>" alt="<?php esc_attr_e( 'Current Organizer Banner Image', 'tribe-events-community' ); ?>" /></div>
            <svg class="edit_main_image_banner" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>

</div>

 
        <div class="organizer_image_upload_function_container">
    <div class="organizer_image_upload_function">
        <label><?php esc_html_e( '', 'tribe-events-community' ); ?></label>

        <!-- Organizer image element -->
        <?php 
        $default_image = 'https://ticketlocation.com/wp-content/uploads/2024/04/default-avatar-photo-placeholder-profile-icon-vector-1.jpg';
        $image_src = !empty($organizer_thumbnail_url) ? $organizer_thumbnail_url : $default_image;
        ?>
        <div class="profile_img_svg_div">
        <img src="<?php echo esc_url($image_src); ?>" alt="<?php esc_attr_e( 'Current Organizer Image', 'tribe-events-community' ); ?>" />
        <svg class="edit_svg_click edit_main_image" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>
        
                  </div>

        <p>
     
            <span>Maximum file size: 300KB.<br>Accepted formats: JPEG or PNG only.</span>
        </p>
    </div>
</div>

<!-- Drag and Drop Image Upload --> 
<div id="drop_zone" class="drop-zone">
    

<svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                    <path d="M19.7736 17.5644C19.4827 17.2793 19.0918 17.1196 18.6845 17.1196C18.2773 17.1196 17.8863 17.2793 17.5955 17.5644L12.9283 22.076C12.7632 22.2122 12.628 22.3811 12.5311 22.5719C12.4343 22.7628 12.3778 22.9716 12.3653 23.1852C12.3528 23.3989 12.3846 23.6128 12.4585 23.8137C12.5325 24.0145 12.6471 24.1979 12.7952 24.3524C12.9433 24.507 13.1217 24.6293 13.3192 24.7117C13.5167 24.7941 13.7291 24.8349 13.9431 24.8316C14.1571 24.8282 14.3681 24.7807 14.5629 24.692C14.7577 24.6033 14.9321 24.4755 15.0752 24.3163L17.1132 22.3405V31.1149C17.1132 31.5276 17.2771 31.9233 17.5689 32.215C17.8607 32.5068 18.2564 32.6707 18.669 32.6707C19.0816 32.6707 19.4773 32.5068 19.7691 32.215C20.0608 31.9233 20.2247 31.5276 20.2247 31.1149V22.4183L22.2317 24.4408C22.3763 24.5866 22.5483 24.7023 22.7379 24.7813C22.9275 24.8603 23.1309 24.901 23.3362 24.901C23.5416 24.901 23.745 24.8603 23.9345 24.7813C24.1241 24.7023 24.2962 24.5866 24.4408 24.4408C24.5866 24.2961 24.7024 24.1241 24.7814 23.9345C24.8603 23.7449 24.901 23.5416 24.901 23.3362C24.901 23.1308 24.8603 22.9275 24.7814 22.7379C24.7024 22.5483 24.5866 22.3762 24.4408 22.2316L19.7736 17.5644Z" fill="white"/>
                    <path d="M27.4901 10.8901C26.8553 9.05596 25.6645 7.46531 24.0835 6.33948C22.5025 5.21365 20.6099 4.60864 18.669 4.60864C16.7281 4.60864 14.8354 5.21365 13.2544 6.33948C11.6734 7.46531 10.4827 9.05596 9.84786 10.8901C8.4501 11.0773 7.12953 11.641 6.0274 12.5208C4.92528 13.4007 4.08308 14.5636 3.59089 15.8851C3.0987 17.2067 2.97503 18.6372 3.23313 20.0237C3.49122 21.4101 4.12137 22.7003 5.05615 23.7562C5.16906 23.9551 5.32444 24.1266 5.51122 24.2586C5.698 24.3906 5.91158 24.4798 6.13675 24.5198C6.36193 24.5599 6.59317 24.5498 6.81399 24.4902C7.03482 24.4307 7.23981 24.3232 7.41436 24.1754C7.5889 24.0276 7.72872 23.8432 7.82385 23.6352C7.91899 23.4272 7.96709 23.2008 7.96474 22.9721C7.9624 22.7434 7.90966 22.5181 7.81028 22.3121C7.7109 22.1061 7.56732 21.9245 7.38978 21.7804C6.78788 21.1075 6.39407 20.2744 6.25608 19.3822C6.11809 18.49 6.24184 17.5769 6.61233 16.7535C6.98282 15.9302 7.58415 15.232 8.34344 14.7436C9.10273 14.2552 9.9874 13.9974 10.8902 14.0016H11.0458C11.4098 14.009 11.7648 13.8884 12.049 13.661C12.3333 13.4336 12.5288 13.1137 12.6015 12.757C12.8872 11.3503 13.6504 10.0855 14.7619 9.17707C15.8733 8.26863 17.2646 7.77237 18.7001 7.77237C20.1356 7.77237 21.5269 8.26863 22.6383 9.17707C23.7498 10.0855 24.513 11.3503 24.7986 12.757C24.8714 13.1137 25.0669 13.4336 25.3512 13.661C25.6354 13.8884 25.9904 14.009 26.3544 14.0016H26.4477C27.3506 13.9974 28.2352 14.2552 28.9945 14.7436C29.7538 15.232 30.3551 15.9302 30.7256 16.7535C31.0961 17.5769 31.2199 18.49 31.0819 19.3822C30.9439 20.2744 30.5501 21.1075 29.9482 21.7804C29.8111 21.9341 29.706 22.1134 29.6388 22.308C29.5716 22.5027 29.5437 22.7087 29.5567 22.9142C29.5697 23.1197 29.6234 23.3206 29.7146 23.5052C29.8059 23.6898 29.9328 23.8544 30.0882 23.9895C30.3718 24.2397 30.7368 24.3779 31.115 24.3785C31.3359 24.3782 31.5542 24.3309 31.7554 24.2397C31.9566 24.1485 32.136 24.0155 32.2818 23.8495C33.2425 22.7954 33.8949 21.4975 34.1677 20.0976C34.4405 18.6977 34.3232 17.2497 33.8286 15.912C33.334 14.5743 32.4811 13.3983 31.3632 12.5127C30.2453 11.627 28.9055 11.0657 27.4901 10.8901Z" fill="white"/>
                    </svg>

    Drag & Drop files here<br>or<br>
    <button type="button" onclick="document.getElementById('fileInput').click();">Browse Files</button>
</div>
<input type="file" id="fileInput" name="fileInput" accept="image/jpeg" style="display:none;" onchange="validateAndDisplayImage(this.files)">

        


        <!-- Organizer Title -->
        <?php 
            $organizer_name        = esc_attr( tribe_get_organizer() ); 
            $organizer_id          = isset($_GET['id']) ? $_GET['id'] : ''; 
            $organizer_description = get_post_meta( $organizer_id, 'organizer_description', true ) ? get_post_meta( $organizer_id, 'organizer_description', true ) : ''; 
            $organizer_email       = get_post_meta( $organizer_id, '_OrganizerEmail', true ) ? get_post_meta( $organizer_id, '_OrganizerEmail', true ) : 'example@gmail.com'; 
            $organizer_facebook    = get_post_meta( $organizer_id, 'organizer_facebook', true ) ? get_post_meta( $organizer_id, 'organizer_facebook', true ) : 'facebook.com'; 
            $organizer_twitter     = get_post_meta( $organizer_id, 'organizer_twitter', true ) ? get_post_meta( $organizer_id, 'organizer_twitter', true ) : 'twitter.com'; 
            $organizer_instagram   = get_post_meta( $organizer_id, 'organizer_instagram', true ) ? get_post_meta( $organizer_id, 'organizer_instagram', true ) : 'instagram.com'; 

        ?>
        <div class="events-community-post-title">
            <label for="post_title" class="<?php echo ( $_POST && empty( $organizer_name ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s Name:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>
            <input type="text" placeholder="Organiser Name" name="post_title" id="post_title_input" value="<?php echo esc_attr( $organizer_name ); ?>" readonly/>
            <svg class="edit_svg_click organizer_title_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>

            
        </div>

        <div class="events-community-post-title description ">
            <label for="organizer_description_input"  class="<?php echo ( $_POST && empty( $organizer_description ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s Description:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>

            <textarea type="textarea" placeholder="Organiser Description" name="organizer_description" id="organizer_description_input"  readonly > <?php echo esc_attr( $organizer_description ); ?> </textarea>
            <svg class="edit_svg_click organizer_description_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>

        </div>

        <div class="events-community-post-title email">
            <label for="organizer_email" class="<?php echo ( $_POST && empty( $organizer_email ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s Email:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>

            <input type="email" placeholder="Organiser Email" name="organizer_email" id="organizer_email" value="<?php echo esc_attr( $organizer_email ); ?>" readonly/>
            <svg class="edit_svg_click organizer_email_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>
        </div>
        <div class="events-community-post-title facebook">
            <label for="organizer_facebook" class="<?php echo ( $_POST && empty( $organizer_facebook ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s facebook:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>
            <i class="social-icon fa fa-facebook" aria-hidden="true"></i>
            <input type="text" name="organizer_facebook" id="organizer_facebook" value="<?php echo esc_url( $organizer_facebook ); ?>" readonly/>
            <svg class="edit_svg_click organizer_facebook_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>
        </div>

        <div class="events-community-post-title twitter">
            <label for="organizer_twitter" class="<?php echo ( $_POST && empty( $organizer_twitter ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s twitter:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>
            <i class="social-icon fa fa-twitter" aria-hidden="true"></i>
            <input type="text" name="organizer_twitter" id="organizer_twitter" value="<?php echo esc_url( $organizer_twitter ); ?>" readonly/>
            <svg class="edit_svg_click organizer_twitter_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>
        </div>

        <div class="events-community-post-title instagram">
            <label for="organizer_instagram" class="<?php echo ( $_POST && empty( $organizer_instagram ) ) ? 'error' : ''; ?>">
                <?php printf( __( '%s instagram:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"><?php esc_html_e( '(required)', 'tribe-events-community' ); ?></small>
            </label>
            <i class="social-icon fa fa-instagram" aria-hidden="true"></i>
            <input type="text" name="organizer_instagram" id="organizer_instagram" value="<?php echo  esc_url( $organizer_instagram ); ?>" readonly/>
            <svg class="edit_svg_click organizer_instagram_edit_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d3fa16" viewBox="0 0 24 24"><path d="M4 16.668V20h3.333l9.83-9.83-3.333-3.332zm15.74-9.075a.885.885 0 0 0 0-1.253l-2.08-2.08a.885.885 0 0 0-1.253 0L14.78 5.886l3.333 3.333zM6 17l8-8 1 1-8 8z"></path></svg>
        </div>



        
        <script type="text/javascript">

            ///FUNCTION TO DON'T ALLOW SAME Organizer Title  AND ON SVG ICON CLICK ALLOW TO EDIT AND ON SVG ICON CLICK CLEAR THE INPUT
document.addEventListener('DOMContentLoaded', function() {
 
    remove_read_only('input[name="post_title"]', '.organizer_title_edit_btn');
    remove_read_only('textarea[name="organizer_description"]', '.organizer_description_edit_btn');
    remove_read_only('input[name="organizer_email"]', '.organizer_email_edit_btn');
    remove_read_only('input[name="organizer_facebook"]', '.organizer_facebook_edit_btn');
    remove_read_only('input[name="organizer_twitter"]', '.organizer_twitter_edit_btn');
    remove_read_only('input[name="organizer_instagram"]', '.organizer_instagram_edit_btn');

    function remove_read_only(inputTitle, editIcon){
        var inputTitle = document.querySelector(inputTitle);
        var editIcon = document.querySelector(editIcon);
        var isEditIconClicked = false;
        // Event listener for the SVG icon click
        if (editIcon && inputTitle) {
            editIcon.addEventListener('click', function() {
                // Toggle the readonly attribute and the isEditIconClicked flag
                if (inputTitle.hasAttribute('readonly')) {
                    inputTitle.removeAttribute('readonly'); // Enable editing
                    inputTitle.focus(); // Optionally, focus on the input field
                    isEditIconClicked = true;
                    inputTitle.value = '';
                } else {
                    inputTitle.setAttribute('readonly', 'readonly'); // Disable editing
                    isEditIconClicked = false;
                }
            });
        } else {
            console.error('Edit icon or input field not found');
        }
    
    }

    var form = document.querySelector('form');
    // Event listener for the form submission
    form.addEventListener('submit', function(e) {
        if (isEditIconClicked) {
            e.preventDefault(); // Prevent default form submission only if edit icon clicked

            var titleValue = document.querySelector('input[name="post_title"]').value.trim();
            // AJAX request to check the title
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/wp-admin/admin-ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    if (this.responseText === '') {
                        // Name is unique, proceed to submit the form
                        form.submit();
                    } else {
                        // Name is not unique, show error message
                        alert(this.responseText);
                        isEditIconClicked = false; // Reset flag
                    }
                }
            };
            xhr.send('action=check_organizer_name&organizer_name=' + encodeURIComponent(titleValue));
        }
        // If edit icon not clicked, form submits normally
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
         // Collect form data
        var formData = new FormData(this);

        // Send AJAX request to the WordPress backend
        var xhr = new XMLHttpRequest();
        xhr.open('POST', ajaxurl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        var organizer_description = document.querySelector('textarea[name="organizer_description"]').value.trim();
        var organizer_email = document.querySelector('input[name="organizer_email"]').value.trim();
        var organizer_facebook = document.querySelector('input[name="organizer_facebook"]').value.trim();
        var organizer_twitter = document.querySelector('input[name="organizer_twitter"]').value.trim();
        var organizer_instagram = document.querySelector('input[name="organizer_instagram"]').value.trim();
        // Get the query string portion of the URL
        var queryString = window.location.search;

        // Parse the query string into an object
        var queryParams = new URLSearchParams(queryString);
        var organizer_id = queryParams.get('id');
        // Handle AJAX response
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Success
                console.log(xhr.responseText);
                form.submit();
            } else {
                // Error
                console.error('Request failed:', xhr.statusText);
            }
        };

        // Send the request
        xhr.send('action=update_organizer_information&organizer_description=' + organizer_description 
            +'&organizer_id=' + organizer_id
            +'&organizer_email=' + organizer_email
            +'&organizer_facebook=' + organizer_facebook
            +'&organizer_twitter=' + organizer_twitter
            +'&organizer_instagram=' + organizer_instagram
        );
    });
});


document.addEventListener("DOMContentLoaded", function() {
    var editIcon = document.querySelector('.organizer_title_edit_btn');
    var inputField = document.querySelector('input[name="post_title"]');

    if (editIcon && inputField) {
        editIcon.addEventListener('click', function() {
            // Clear the input field
            inputField.value = '';

            // Remove readonly attribute and focus on the input field
            inputField.removeAttribute('readonly');
            inputField.focus();
        });
    } else {
        console.error('Edit icon or input field not found');
    }


});

</script>

        
        
        
        
        
        
        
        
        
        <!-- .events-community-post-title -->








        <!-- Organizer Description -->
        <div class="events-community-post-content">
            <label for="post_content">
                <?php printf( __( '%s Description:', 'tribe-events-community' ), $organizer_label_singular ); ?>
                <small class="req"></small>
            </label>
            <?php
            $content = tribe_community_events_get_organizer_description();
            if ( tribe( 'community.main' )->useVisualEditor && function_exists( 'wp_editor' ) ) {
                $settings = [
                    'wpautop'       => true,
                    'media_buttons' => false,
                    'editor_class'  => 'frontend',
                    'textarea_rows' => 5,
                ];
                wp_editor( $content, 'tcepostcontent', $settings );
            } else {
                echo '<textarea name="tcepostcontent">' . esc_textarea( $content ) . '</textarea>';
            }
            ?>
        </div><!-- .events-community-post-content -->

        <?php tribe_get_template_part( 'community/modules/organizer-fields' ); ?>

        <!-- Form Submit -->
        <div class="tribe-events-community-footer">
            <input type="submit" class="button submit events-community-submit" value="<?php
            echo esc_attr( $organizer_id ? sprintf( __( 'Update %s', 'tribe-events-community' ), $organizer_label_singular ) : sprintf( __( 'Submit %s', 'tribe-events-community' ), $organizer_label_singular ) );
            ?>" name="community-event"/>
            <a class="back-organizer-setting" href="dashboard/organisation-settings/">Back</a>
        </div>
        
        <!-- .tribe-events-community-footer -->
    </form>
</div>
</div>
<script>
// Function to validate and display the uploaded image
function validateAndDisplayImage(files) {
    var file = files[0];

    if (file.size > 204800) {
        alert("The file size should be less than 200KB.");
        return;
    }

    if (file.type !== "image/jpeg") {
        alert("Invalid file format. Please upload a JPEG image.");
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var imageElement = document.querySelector('.organizer_image_upload_function img');
        if (imageElement) {
            // Update the src of the existing image
            imageElement.src = e.target.result;
        } else {
            console.error("Image element not found.");
        }
    };
    reader.readAsDataURL(file);
}

// DOMContentLoaded event listener
document.addEventListener("DOMContentLoaded", function() {
    // Set up file input change event
    var fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            validateAndDisplayImage(this.files);
        });
    }

    // Set up drag and drop events
    var dropZone = document.getElementById('drop_zone');
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.classList.remove('drop-zone--over');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('drop-zone--over');
            var files = e.dataTransfer.files;
            fileInput.files = files;
            validateAndDisplayImage(files);
        });
    }

    // Set up click event on the edit icon
    var editMainImage = document.querySelector(".edit_main_image");
    var dropZoneButton = document.querySelector(".drop-zone button");
    if (editMainImage && dropZoneButton) {
        editMainImage.addEventListener("click", function() {
            dropZoneButton.click();
        });
    }

    // Check if an image exists and adjust the display of the drop zone
    var image = document.querySelector('.organizer-image');
    if (!image || image.src === "") {
        if (dropZone) {
            dropZone.style.display = 'block';
        }
    }




////FUNCTION TO AUTO CLICK THE BANNER UPLOAD FILE BUTTON 
	// When the 'edit_main_image_banner' element is clicked
    $('.edit_main_image_banner').click(function() {
        // Trigger a click on the 'bannerInput' element
        $('#bannerInput').click();
    });
	function updateBannerImage(files) {
    var file = files[0];

    // Check for file size and type
    if (file.size > 307200) { // 300KB in bytes
        alert("The file size should be less than 300KB.");
        return;
    }
    if (file.type !== "image/jpeg" && file.type !== "image/png") {
        alert("Invalid file format. Please upload a JPEG or PNG image.");
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        // Update the banner image source
        var bannerImageElement = document.querySelector('.banner_image_organizer');
        if (bannerImageElement) {
            bannerImageElement.src = e.target.result;
        } else {
            console.error("Banner image element not found.");
        }
    };
    reader.readAsDataURL(file);
}

// Set up event listener for banner image input
var bannerInput = document.getElementById('bannerInput');
if (bannerInput) {
    bannerInput.addEventListener('change', function() {
        updateBannerImage(this.files);
    });
}



});
</script>





<style>
.edit_organizer_main{
        background-color:#19191b !important;
    position: relative;
    padding: 17px;
    border-radius: 10px !important;
    width: 100% !important;
}
#organizer_description_input{
    background: transparent !important;
    color: white;
    width: 100%;
    border: none !important;
    min-height: 120px;
}
.edit_organizer_main input{
font-size:15px;
font-weight:300
}
</style>

</div>
