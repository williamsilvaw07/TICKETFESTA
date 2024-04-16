<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Metabox For Organizers
 * This is used to add a metabox to the event submission form to allow for choosing or
 * creating an organizer for user submitted events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/organizer.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since  2.1
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

// If the user cannot create new organizers *and* if there are no organizers
// to select from then there's no point in generating this UI
if ( ! tribe( 'community.main' )->event_form()->should_show_linked_posts_module( Tribe__Events__Organizer::POSTTYPE ) ) {
	return;
}

if ( ! isset( $event ) ) {
	$event = Tribe__Events__Main::postIdHelper();
}
?>

<div class="event_decp_div hover_section">
<h2>
Event Organizer
</h2>
<p>To add or edit an organizer, please vist <a href="/dashboard/organisers-list/"> Organizer Page</a>.</p>

<div id="event_tribe_organizer" class="tribe-section tribe-section-organizer hover_section_content_show">
	<div class="tribe-section-header">
		<h3 class="<?php echo tribe_community_events_field_has_error( 'organizer' ) ? 'error' : ''; ?>">
			<?php
			printf( __( '%s Details', 'tribe-events-community' ), tribe_get_organizer_label_singular() );
			echo tribe_community_required_field_marker( 'organizer' );
			?>
		</h3>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_organizer' );
	?>

	<table class="tribe-section-content">
		<colgroup>
			<col class="tribe-colgroup tribe-colgroup-label">
			<col class="tribe-colgroup tribe-colgroup-field">
		</colgroup>

		<?php
		tribe_community_events_organizer_select_menu( $event );

		// The organizer meta box will render everything within a <tbody>
		$organizer_meta_box = new Tribe__Events__Linked_Posts__Chooser_Meta_Box( $event, Tribe__Events__Organizer::POSTTYPE );
		$organizer_meta_box->render();
		?>
	</table>

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_organizer' );
	?>
</div>
</div>

<!-- Event Status -->

<div class="event_decp_div hover_section">
	<h2>
	Select Event Status
	</h2>

	<div id="event_tribe_status" class="tribe-section tribe-section-status hover_section_content_show">
		<div class="tribe-section-header">
			<select name="event_status" id="event_status">
				<option value="publish">published</option>
				<option value="draft">draft</option>
			</select>
		</div>
	</div>
</div>