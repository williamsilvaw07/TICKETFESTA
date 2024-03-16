<?php
// Don't load directly
defined( 'WPINC' ) or die;

// Event details
$community = tribe('community.main');
$canEdit = $community->user_can_edit_their_submissions($event->ID);
$canView = (get_post_status($event->ID) == 'publish' || $canEdit);
$canDelete = $community->user_can_delete_their_submissions($event->ID);

// Get the event image
$event_image = get_the_post_thumbnail($event->ID, 'thumbnail');

// Event start date components
$start_datetime = new DateTime(tribe_get_start_date($event->ID, false, 'Y-m-d'));
$start_day = $start_datetime->format('d');
$start_month = $start_datetime->format('M');
$start_year = $start_datetime->format('Y');

// Start new wrapper div for event title, image, and actions
echo '<div class="event-details-wrapper">';

// Event title and image
echo '<div class="event-title-image">';
if ($canEdit) {
   
    echo $event_image;
   
    echo '</a>';
} else {
    echo $event_image;
    echo '<span class="title">' . get_the_title($event) . '</span>';
}
echo '</div>'; // End event-title-image div

// Row actions
?>
<div class="row-actions">
    <?php
    if (get_post_status($event->ID) === 'draft' && $canEdit) {
        $event_link = get_preview_post_link($event->ID);
    } else {
        $event_link = tribe_get_event_link($event);
    }

    if ($canView) {
        echo '<span class="view"><a href="' . esc_url($event_link) . '">' . esc_html__('View', 'tribe-events-community') . '</a></span>';
    }

    if ($canEdit) {
        echo tribe('community.main')->getEditButton($event, __('Edit', 'tribe-events-community'), '<span class="edit wp-admin events-cal"> ', '</span>');
    }

    if ($canDelete) {
        echo tribe('community.main')->getDeleteButton($event);
    }

    do_action('tribe_events_community_event_list_table_row_actions', $event);
    ?>
</div> <!-- End row-actions div -->

<?php
echo '</div>'; // End event-details-wrapper div

// Event start date outside of the wrapper
echo '<div class="event-start-date">';
echo '<div class="start-date-day"><span class="label">Day: </span><span class="value">' . $start_day . '</span></div>';
echo '<div class="start-date-month"><span class="label">Month: </span><span class="value">' . $start_month . '</span></div>';
echo '<div class="start-date-year"><span class="label">Year: </span><span class="value">' . $start_year . '</span></div>';
echo '</div>'; // End event-start-date div
?>
