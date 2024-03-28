<?php

function add_attendee_enqueue_custom_frontend_js(){

    wp_enqueue_script('custom-event-main-js', get_stylesheet_directory_uri() . '/event-custom-features.js', array('jquery'), time(), true);
    
    wp_localize_script(
        'custom-event-main-js',
        'tribe_ajax',
        array(
                'ajax_url' => admin_url('admin-ajax.php'),
            )
    );
    ?>
    <script>
        jQuery(document).ready(function() {
            console.log('add_attendee 99');
            jQuery('.add_attendee').on('click', request_add_attendee());
        });

        
        function request_add_attendee(){
            let eventID = jQuery('.add_attendee').data('event-id');
            jQuery.ajax({
                url: window.tribe_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'custom_add_event_attendee',
                    event_id : eventID
                },
                success: function(response) {
                    console.log('response ', response)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

    </script>
    <?php
}

add_action('wp_enqueue_scripts', 'add_attendee_enqueue_custom_frontend_js', 99);


add_action('wp_ajax_custom_add_event_attendee', 'custom_add_event_attendee');
add_action('wp_ajax_nopriv_custom_add_event_attendee', 'custom_add_event_attendee');

function custom_add_event_attendee(){
    $event_id = isset($_POST['event_id']) ?  esc_attr($_POST['event_id']) : null;
    var_dump(get_post_meta( $event_id));
    $result = [
        'event_id' => $event_id,
        'data' => get_post_meta( $event_id),
    ];
    var_dump( $result);
    die();
}