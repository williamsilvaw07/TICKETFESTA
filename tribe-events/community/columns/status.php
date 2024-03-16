<?php
// Security check to prevent direct access
defined( 'WPINC' ) or die;

// Retrieve event details and permissions
$community = tribe('community.main');
$canEdit = $community->user_can_edit_their_submissions($event->ID);
$canView = (get_post_status($event->ID) == 'publish' || $canEdit);
$canDelete = $community->user_can_delete_their_submissions($event->ID);

// Fetch the event image
$event_image = get_the_post_thumbnail($event->ID, 'thumbnail');

// Extract and format event start date
$start_datetime = new DateTime(tribe_get_start_date($event->ID, false, 'Y-m-d'));
$start_day = $start_datetime->format('d');
$start_month = $start_datetime->format('M');
$start_year = $start_datetime->format('Y');

// Begin event details wrapper
echo '<div class="event-details-wrapper">';

// Display event title and image
echo '<div class="event-title-image">';
if ($canEdit || $canView) {
    // Limit event title to 50 characters, appending "..." if longer
    $title = get_the_title($event);
    $limited_title = mb_substr($title, 0, 50) . (mb_strlen($title) > 50 ? '...' : '');
    echo $event_image;
    echo '<span class="title">' . $limited_title . '</span>';
}
echo '</div>'; // Close event-title-image div

// Display row actions
?>
<div class="row-actions">
    <?php
    // Determine appropriate link based on event status
    $event_link = get_post_status($event->ID) === 'draft' && $canEdit ? get_preview_post_link($event->ID) : tribe_get_event_link($event);

    // Display View, Edit, and Delete actions based on permissions
    if ($canView) {
        echo '<span class="view"><a href="' . esc_url($event_link) . '">' . esc_html__('View', 'tribe-events-community') . '</a></span>';
    }
    if ($canEdit) {
        echo tribe('community.main')->getEditButton($event, __('Edit', 'tribe-events-community'), '<span class="edit wp-admin events-cal"> ', '</span>');
    }
    if ($canDelete) {
        echo tribe('community.main')->getDeleteButton($event);
    }

    // Hook for additional actions
    do_action('tribe_events_community_event_list_table_row_actions', $event);
    ?>
</div> <!-- Close row-actions div -->
<?php
echo '</div>'; // Close event-details-wrapper div

// Display event start date
// Extract event start time components
$start_time = $start_datetime->format('h:i A'); // Format for 12-hour time with AM/PM

// Display event start date and time
echo '<div class="event-start-date">';
echo '<div class="start-date-day"><span class="label">Day: </span><span class="value">' . $start_day . '</span></div>';
echo '<div class="start-date-month"><span class="label">Month: </span><span class="value">' . $start_month . '</span></div>';
echo '<div class="start-date-year"><span class="label">Year: </span><span class="value">' . $start_year . '</span></div>';
echo '<div class="start-date-time"><span class="label">Time: </span><span class="value">' . $start_time . '</span></div>'; // Added line for start time
echo '</div>'; // Close event-start-date div

?>
