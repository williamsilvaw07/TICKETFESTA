<?php


add_action('wp_ajax_add_event_attendee', 'add_event_attendee');
add_action('wp_ajax_nopriv_add_event_attendee', 'add_event_attendee');

function add_event_attendee(){

    $event_id = isset($_POST['event_id']) ?  esc_attr($_POST['event_id']) : null;
    var_dump(get_post_meta( $event_id));
    $result = [
        'event_id' => $event_id
    ];
    wp_send_json_success( );
}