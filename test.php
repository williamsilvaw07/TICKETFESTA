<?php


function custom_qr_scanner_shortcode() {
    enqueue_custom_frontend_js();
    ob_start();
    ?>
    <style>
   
    </style>
    <!-- <div id="qr-reader" style="width: 100%; height: auto;"></div>
    <div id="qr-reader-results"></div>

    -->

    <div class="scanner_login_div"> 
    <h3>Log in to scan ticket QR codes.</h3>
<p>You can locate the event passcode on the organizer's dashboard under the events section.</p>
    <input type="text" id="event-pass" name="event-pass" placeholder="Event Passcode">
    <button id="check-passcode">
    <i class="fas fa-sign-in-alt"></i> Login
</button>
    <span id="event_not_found" style='display:none'>Event not found. Please verify the Passcode</span>
</div>

    <?php 

    ?>

            <div class="tabs-container" style="display: none">
            <div class="event_data">
            <div class="event-container ">
                        <div class="name"><span> </span>  </div>
                        <div class="date"><span> </span> </div>
</div>
</div>
                <ul class="tabs-nav">
  <li class="tab tab1 active"><a href="#tab1"><i class="fas fa-info-circle"></i> Event Details</a></li>
<li class="tab tab2"><a href="#tab2"><i class="fas fa-barcode"></i> Scan QR Code</a></li>


                </ul>
           




                

            <div class="tab-content-container" style="display: none">
                <div class="tab-content tab-conent-1 active" id="tab1">





                <div class="main_stats">

                <div class="ticket_sold_main_stats  main_stats_block">
                <div class="ticket-progress-container_main">
               <div class="ticket-progress-container">
               <svg class="progress-ring" width="72" height="72">
    <circle class="progress-ring__circle-bg" cx="36" cy="36" r="31" stroke-width="6"></circle> <!-- Background circle -->
    <circle class="progress-ring__circle" cx="36" cy="36" r="31" stroke-width="6"></circle> <!-- Foreground circle -->
</svg>
        <div class="progress-percentage">0%</div>
    </div>
    

    <div class="ticket-info info_div">
        <h6>Total Ticket Sold</h6>
        <p class="stats_count_main ticket-count">0<span>/</span>0</p>
       
        </div>
        </div>
    <i class="fas fa-ticket-alt"></i>

</div>

<div class="ticket_checkedin_main_stats main_stats_block event-container">
    <i class="fas fa-check-circle"></i>
    <div class="checkedin_ticket-info info_div">
        <h6>Checked-in Tickets</h6>
        <p class="stats_count_main checkedin_ticket-count"><span></span></p>
       
        </div>
    <div class="checkedin-progress-ring-container">
       
    </div>

</div>  


                </div>









                    <div class="event-container">
                        <img src="#" alt="" class="event-image">
                      
               <!-- <div class="location">Location: </div>-->

           

               <div class="ticket-info-container_main">
         




        <div class="ticket-info_hidden_all">
            <h6>Ticket Information:</h6>
            <ul>
                <!-- Ticket list will be dynamically populated here -->
            </ul>
            
        </div>

        <div class="ticketnewewew">
         
        </div>
            
 
    </div>
             
                    </div>
                </div>







                <div class="tab-content tab-conent-2" id="tab2">
                    <div class="checkin-details"  style='display:none'>
                        <span id="qr_error" style='display:none'>Event not found. Please verify the Passcode</span>
                        <div class="name"></div>
                        <div class="email"></div>
                        <div class="checkin-time"></div>
                        <div class="scaned-by"> Scaned by: <span> </span> </div>
                    </div>
                    <div id="video-container">
                        <!-- <input type="text" id="event-pass" name="event-pass" placeholder="enter event pass"> -->
                        <!-- <video id="video" playsinline style="width: 500px"></video> -->
                        <div id="qr-reader" class="qr-reader"></div>
                        <!-- <button id="scan-button" >Scan QR Code</button> -->
                        
                    </div>
                </div>
            </div>
            </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_qr_scanner', 'custom_qr_scanner_shortcode');


add_action('wp_ajax_validate_event_pass', 'validate_event_pass');
add_action('wp_ajax_nopriv_validate_event_pass', 'validate_event_pass'); // If you want to allow non-logged-in users to access the AJAX endpoint


function validate_event_pass() {
    $event_pass = isset($_POST['event_pass']) ? esc_attr($_POST['event_pass']) : false;
    $events = get_posts_by_event_pass($event_pass);
    $match = false;
    $event_id = null;
    $event_data = [];
    $shortcode_output = '';
    

    foreach ($events as $event) {
        $ticket_list = []; // Reset ticket list for each event

        if (isset($event->ID)) {
            $match = true;
            $event_id = $event->ID;
            $total_capacity = apply_filters('tribe_tickets_total_event_capacity', null, $event_id);

            $total_issued_tickets = 0; // Total issued tickets for the ratio calculation
            if (null === $total_capacity) {
                $tickets = Tribe__Tickets__Tickets::get_all_event_tickets($event_id);
                $total_capacity = 0;

                foreach ($tickets as $ticket) {
                    $ticket_capacity = tribe_tickets_get_capacity($ticket->ID); // Retrieve ticket capacity
                    $total_capacity += $ticket_capacity;

                    // Retrieve the number of issued tickets for this ticket
                    $issued_tickets_message = tribe_tickets_get_ticket_stock_message($ticket, __('issued', 'event-tickets'));
                    preg_match('/\d+/', $issued_tickets_message, $matches);
                    $issued_tickets = isset($matches[0]) ? intval($matches[0]) : 0;

                    $total_issued_tickets += $issued_tickets; // Summing up issued tickets

                    // Add each ticket's name, capacity, and issued tickets to the ticket list
                    $ticket_list[] = [
                        'name' => $ticket->name,
                        'capacity' => $ticket_capacity,
                        'issued_tickets' => $issued_tickets,
                    ];
                }
            }

            // Assuming an instance creation and method call similar to before for checking attendance
            $attendance_totals = new Tribe__Tickets__Attendance_Totals($event_id);
            $total_checked_in = $attendance_totals->get_total_checked_in();

            // Format the data for checked in total / total issued tickets
            $checked_in_format = sprintf('%d / %d', $total_checked_in, $total_issued_tickets);

            $start_date = get_post_meta($event_id, '_EventStartDate', true);
            $start_date_timestamp = strtotime($start_date);
            $day_of_week = date('D', $start_date_timestamp);
            $day_of_month = date('jS', $start_date_timestamp);
            $month = date('M', $start_date_timestamp);
            $time = date('H:i', $start_date_timestamp);
            $formatted_start_date = "$day_of_week, $day_of_month $month at $time";

            $event_data = [
                'start_date' => $formatted_start_date,
                'issued_tickets' => $total_issued_tickets,
                'total_tickets_available' => $total_capacity,
                'ticket_list' => $ticket_list,
                'name' => get_the_title($event_id),
                'thumbnail_url' => get_the_post_thumbnail_url($event_id, 'medium'),
                'checked_in' => $checked_in_format, //"checked in / total" format
            ];

            // Generate shortcode output for attendees report
            $shortcode_output = do_shortcode('[tribe_community_tickets view="attendees_report" id="' . $event_id . '"]');
        }
    }

    $response = [
        'match' => $match,
        'event_id' => $event_id,
        'event_data' => $event_data,
        'shortcode_output' => $shortcode_output, // Include the shortcode output in the response
    ];

    wp_send_json($response);
    wp_die();
}



// Remember to properly hook your function to WordPress AJAX actions if it's intended for AJAX.


add_action('wp_ajax_custom_check_in_ticket', 'checkinTicket');
add_action('wp_ajax_nopriv_custom_check_in_ticket', 'checkinTicket'); 



function checkinTicket(){
    $ticket_id = isset(  $_POST['ticket_id'] ) ? esc_attr( $_POST['ticket_id']) : false;
    if ($ticket_id){
        $is_checked = get_post_meta( $ticket_id, '_tribe_wooticket_checkedin', true);
        
        if($is_checked != '1'){
            $ticket_var = new Tribe__Tickets_Plus__Commerce__EDD__Main();
            $ticket_var->checkin($ticket_id, true);
            update_post_meta( $ticket_id, '_tec_tickets_commerce_checked_in', 1 );
            update_post_meta( $ticket_id, '_tribe_wooticket_checkedin', 1 );
            update_post_meta( $ticket_id, '_tribe_rsvp_checkedin', 1 );
            update_post_meta( $ticket_id, '_tribe_qr_status', 1 );
            update_post_meta( $ticket_id, '_tribe_eddticket_checkedin', 1 );
            update_post_meta( $ticket_id, '_tribe_tpp_checkedin', 1 );

            $now = new DateTime();
     
            $formatted_datetime = $now->format('d F Y H:i:s');

            $checkin_details = [
                'date'      => $formatted_datetime,
                'source'    => 'qr-code',
            ];
            $scaned_by = '';
            $current_user = wp_get_current_user();
            if ( $current_user->ID != 0 ) {
                $scaned_by = $current_user->user_email;
                $checkin_details['scaned_by'] = $user_email;
            }

            update_post_meta( $ticket_id, '_tribe_wooticket_checkedin_details', $checkin_details );
            $fullname = get_post_meta( $ticket_id, '_tribe_tickets_full_name', true);
            $email = get_post_meta( $ticket_id, '_tribe_tickets_email', true);
            $response = [
                'success'      => true,
                'message'      => 'Successfully checked in.',
                'fullname'     => $fullname,
                'email'        => $email,
                'scaned_by'    => $scaned_by,
                'checkin_time' => $formatted_datetime,
            ];
            wp_send_json($response);

        } else{
            $checkin_details = get_post_meta( $ticket_id, '_tribe_wooticket_checkedin_details', true);
            $fullname = get_post_meta( $ticket_id, '_tribe_tickets_full_name', true);
            $email = get_post_meta( $ticket_id, '_tribe_tickets_email', true);
            $checkin_details = maybe_unserialize( $checkin_details );
            $response = [
                'success'      => false,
                'fullname'     => $fullname,
                'email'        => $email,
                'message'      => 'Already Checked In.',
                'checkin_time' => $checkin_details['date'],             // willam
                'scaned_by'    => $checkin_details['scaned_by'],
            ];
            wp_send_json($response);
        }


    } else {
        $response = [
            'success'   => false,
            'message' => 'No ticket id found.',
        ];
        wp_send_json($response);
    }


}
function get_posts_by_event_pass($event_pass) {
    $args = array(
        'post_type' => 'tribe_events',
        'meta_query' => array(
            array(
                'key' => 'event_pass',
                'value' => $event_pass,
            )
        ),
    );

    $query = new WP_Query($args);
    return $query->posts;
}

// generate hash event pass

add_action('save_post', 'generate_event_pass_on_update', 10, 3);
function generate_event_pass_on_update($post_id, $post, $update) {
    // Check if it's a 'tribe_events' post type and the post is being updated
    if ($post->post_type == 'tribe_events') {
        // Check if the post doesn't have the 'event_pass' metadata
        $event_pass = get_post_meta($post_id, 'event_pass', true);
        if (empty($event_pass)) {
            // Generate a unique 8-digit hash
            $event_pass = generate_unique_random_hash(8);
            // Set the 'event_pass' metadata for the post
            update_post_meta($post_id, 'event_pass', $event_pass);
        }
    }
}

function generate_unique_random_hash($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $unique_hash = '';

    // Shuffle the characters to ensure uniqueness
    $shuffled_characters = str_shuffle($characters);

    // Generate the hash
    for ($i = 0; $i < $length; $i++) {
        $unique_hash .= $shuffled_characters[rand(0, $characters_length - 1)];
    }

    return $unique_hash;
}

