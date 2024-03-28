<?php


add_action('wp_ajax_custom_add_event_attendee', 'custom_add_event_attendee');
add_action('wp_ajax_nopriv_custom_add_event_attendee', 'custom_add_event_attendee');

function custom_add_event_attendee(){

    $event_id = isset($_POST['event_id']) ?  esc_attr($_POST['event_id']) : null;
    // var_dump(get_post_meta( $event_id));
    $result = [
        'event_id' => $event_id,
        'data' => get_post_meta( $event_id),
    ];
    var_dump( $result);
    die();
}