<?php
// Don't load directly.
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Image Uploader Block
 * Renders the image upload field in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/image.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since  3.1
 * @since  4.7.1 Now using new tribe_community_events_field_classes function to set up classes for the input.
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

$upload_error = tribe( 'community.main' )->max_file_size_exceeded();
$size_format  = size_format( tribe( 'community.main' )->max_file_size_allowed() );
$image_upload_label = sprintf( __( '%s Image', 'tribe-events-community' ), tribe_get_event_label_singular() );
?>
<div class="event_decp_div hover_section">
<h2>
Add images
</h2>
<p>Add photos to show what your event will be about.
</p>

<div class="tribe-section tribe-section-image-uploader hover_section_content_show">
	<div class="tribe-section-header">
		<?php
		tribe_community_events_field_label( 'event_image', $image_upload_label ); ?>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_featured_image' );
	?>

	<div class="tribe-section-content">
		<?php
		$class = '';
		if ( get_post() && has_post_thumbnail() ) {
			$class = 'has-image';
		}
		?>
		<div class="tribe-image-upload-area <?php echo esc_attr( $class ); ?>">
			<input type="hidden" name="detach_thumbnail" id="tribe-events-community-detach-thumbnail" value="false">

			<div class="note">
			<h2>
					Event Image
				</h2>
				<p>
    <?php
    $allowed_html = array(
        'br' => array()
    );
    echo wp_kses(
        sprintf(
            __('Recommended image size: 1920 x 1080px<br> Supported image files: JPEG or PNG.<br>Maximum file size: 1MB', 'tribe-events-community'),
            $size_format
        ),
        $allowed_html
    );
    ?>
</p>
			</div>

			<?php if ( get_post() && has_post_thumbnail() ) { ?>
				<div class="tribe-community-events-preview-image">
					<?php the_post_thumbnail( 'medium' ); ?>

					<div>
						<label for="uploadFile" class="uploaded-msg">
							<?php esc_html_e( 'Uploaded:', 'tribe-events-community' ); ?>
						</label>
						<span class="current-image"><?php echo esc_html( basename( get_attached_file( get_post_thumbnail_id() ) ) ); ?></span>
					</div>

					<?php tribe_community_events_form_image_delete(); ?>
				</div>
			<?php } ?>

			<div class="form-controls">

				<label for="uploadFile" class="selected-msg">
					<?php esc_html_e( 'Selected:', 'tribe-events-community' ); ?>
				</label>

				<input id="uploadFile" class="uploadFile" placeholder="" disabled="disabled"/>

				<label for="event_image" class="screen-reader-text <?php echo esc_attr( $upload_error ? 'error' : '' ); ?>">
					<?php esc_html_e( 'Event Image', 'tribe-events-community' ); ?>
				</label>

				<div class="choose-file tribe-button tribe-button-secondary"><?php esc_html_e( 'Choose Image', 'tribe-events-community' ); ?></div>

				<label for="uploadFile" class="screen-reader-text">
					<?php esc_html_e( 'Upload File', 'tribe-events-community' ); ?>
				</label>

				<input
					id="event_image"
					type="file"
					name="event_image"
					class="event_image <?php tribe_community_events_field_classes( 'event_image', [] ); ?>"
				>

			</div>

			<div class="tribe-remove-upload"><a href="#"><?php esc_html_e( 'Remove image', 'tribe-events-community' ); ?></a></div>
		</div>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_featured_image' );
	?>
</div>
</div>






<script>
	
</script>