<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );

/**
 * Allows filtering of the event ID.
 *
 * @since 6.0.1
 *
 * @param int $event_id
 */
$event_id = apply_filters( 'tec_events_single_event_id', $event_id );

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array  $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 */





 
$title = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, false ), $event_id );
$cost  = tribe_get_formatted_cost( $event_id );

?>




<div class="loading_svg_div">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1366 768" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;stroke:#d3fa16;stroke-width:9;stroke-miterlimit:10;}
            .st1{fill:none;stroke:#d3fa16;stroke-width:9;stroke-miterlimit:10;}
        </style>
        <g>
            <path class="st0 grey" d="M772.5,347c-6.2-14-2.4-29.5,8.4-35.8c1.1-0.6,1.4-2.2,0.8-3.7l-8.5-19.1c-3.4-7.6-11.2-11.4-17.5-8.6
                l-201,89.5c-6.3,2.8-8.7,11.2-5.3,18.8c0,0,6.4,14.3,8.5,19.1c0.6,1.4,2,2.2,3.3,1.8c12-3.8,26,3.7,32.3,17.7s2.4,29.5-8.4,35.8
                c-1.1,0.6-1.4,2.2-0.8,3.7l8.5,19.1c3.4,7.6,11.2,11.4,17.5,8.6l201-89.5c6.3-2.8,8.7-11.2,5.3-18.8l-8.5-19.1
                c-0.6-1.4-2-2.2-3.3-1.8C792.8,368.5,778.7,361,772.5,347z"></path>
            <path class="st1 blue" d="M772.5,347c-6.2-14-2.4-29.5,8.4-35.8c1.1-0.6,1.4-2.2,0.8-3.7l-8.5-19.1c-3.4-7.6-11.2-11.4-17.5-8.6
                l-201,89.5c-6.3,2.8-8.7,11.2-5.3,18.8c0,0,6.4,14.3,8.5,19.1c0.6,1.4,2,2.2,3.3,1.8c12-3.8,26,3.7,32.3,17.7s2.4,29.5-8.4,35.8
                c-1.1,0.6-1.4,2.2-0.8,3.7l8.5,19.1c3.4,7.6,11.2,11.4,17.5,8.6l201-89.5c6.3-2.8,8.7-11.2,5.3-18.8l-8.5-19.1
                c-0.6-1.4-2-2.2-3.3-1.8C792.8,368.5,778.7,361,772.5,347z"></path>
        </g>
    </svg>
</div>

<div class="main_content_loading_div">


    <!-- Overlay Background -->
    <div class="overlay" style="display: none;"></div>





     <p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<div class="main_single_event_div">





	<div class="top_flex_section_single_event single_event_sections">
<!-- Event featured image, but exclude link -->
       <?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
           <?php 
                $tickets = Tribe__Tickets__Tickets::get_event_tickets( get_the_ID(  ) );
                foreach($tickets as $ticket){
				
                    $currentDateTime = new DateTime();
                    $start_dateTime = $ticket->start_date . ' ' . $ticket->start_time;
                    $end_dateTime = $ticket->end_date. ' ' .$ticket->end_time;
                    $date = new DateTime($start_dateTime);
                    $date->setTimezone(new DateTimeZone('Europe/London'));
                    $EventStartDate = $date->format('d M, H:i');
                    $startDatedPassed = $date < $currentDateTime;
				
                    $date = new DateTime($end_dateTime);
                    $date->setTimezone(new DateTimeZone('Europe/London'));
                    $EventEndDate = $date->format('d M, H:i');
				
                    $endDatedPassed = $date < $currentDateTime;
					if($ticket->end_date == ''){
						  // Format for the date and time
          $event_start_date_time = tribe_get_start_date( $event_id, true, 'D, j M, H:i' );
          
          // Get the event's timezone object
          $timezone = Tribe__Events__Timezones::get_event_timezone_string( $event_id );

          // Create a DateTimeZone object from the event's timezone string
          $dateTimeZone = new DateTimeZone($timezone);

          // Create a DateTime object for the event's start date/time in the event's timezone
          $dateTime = new DateTime( tribe_get_start_date( $event_id, false, 'Y-m-d H:i:s' ), $dateTimeZone );

          // Format the DateTime object to get the timezone abbreviation
          // Handles cases like BST/GMT dynamically based on the event's date and timezone
          $timezone_abbr = $dateTime->format('T');
						$EventEndDate = $event_start_date_time . ' ' . $timezone_abbr;
					}
                    echo "<div style='display:none' class='ticket-date-container' data-ticket-id='$ticket->ID'> 
                        <span class='pick_start_date' data-passed='$startDatedPassed'>$EventStartDate</span> 
                        <span class='pick_end_date' data-passed='$endDatedPassed' >$EventEndDate</span>
                    </div>";
                }
           ?>
            <button class="share_btn">
  <i class="fas fa-share-alt"></i>
</button>
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

    <!-- Popup div for sharing link -->

     <!-- Share Button -->


    <div class="share_btn_event" style="display: none;">
    <span class="close_popup" aria-label="Close">&times;</span>
    <h3>Share with friends</h3>
    <div class="social_sharing_links">
        <!-- Facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(esc_url( tribe_get_event_link($event) )); ?>" target="_blank" aria-label="Share on Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <!-- Twitter -->
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(esc_url( tribe_get_event_link($event) )); ?>&text=Check%20out%20this%20event!" target="_blank" aria-label="Share on Twitter">
            <i class="fab fa-twitter"></i>
        </a>
        <!-- Messenger -->
        <a href="fb-messenger://share?link=<?php echo urlencode(esc_url( tribe_get_event_link($event) )); ?>" target="_blank" aria-label="Share on Messenger">
            <i class="fab fa-facebook-messenger"></i>
        </a>
        <!-- WhatsApp -->
        <a href="https://wa.me/?text=<?php echo urlencode(esc_url( tribe_get_event_link($event) )); ?>" target="_blank" aria-label="Share on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    <div class="share_event_url">
        <span class="share_popup_box_title">Event URL</span>
        <div class="share_event_url_inner">
            <span class="eventUrl"><?php echo esc_url( tribe_get_event_link($event) ); ?></span>
            <span class="copyButton" aria-label="Copy URL">
                <i class="fas fa-copy"></i>
            </span>
        </div>
    </div>
    <span class="copyMessage" style="display: none;">Link copied!</span>
</div>



<!-- Event featured image, END -->
      </div>

      <!-- sticky button for mobile   -->
      <div id="sticky-button-container" style="display: none;">
    <button id="scroll-to-tickets"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.9653 16.7465C18.5679 16.0528 21.6812 13.9865 22.8702 12.1175L20.6832 10.1855C20.3924 10.5734 19.8259 10.9195 19.371 11.0603C18.9161 11.2011 18.2894 11.0004 17.8401 10.8416C17.3907 10.6828 17.0932 10.2025 16.817 9.80332C16.5407 9.40414 16.3922 8.92572 16.3921 8.43499C16.3921 7.78501 17.0592 6.77067 17.0592 6.77067L14.9969 5.15533C14.4505 5.99078 13.3486 6.92551 11.909 8.03083C11.2461 8.53997 10.7359 9.21138 9.9668 9.52938" fill="#3D54FF"/><path d="M2.09375 10.6229C5.49369 13.5561 7.58317 15.5691 8.79872 16.3643C10.6218 17.5571 12.1641 17.7487 14.1652 17.5571C16.1659 17.3651 20.9196 15.0433 22.8705 12.1123L20.6668 10.1177C20.4418 10.4042 20.1546 10.6357 19.8268 10.7947C19.499 10.9536 19.1393 11.0358 18.775 11.0349C17.4532 11.0349 16.3816 9.97642 16.3816 8.67077C16.3816 8.34387 16.4499 8.02059 16.5823 7.72168C16.7146 7.42278 16.908 7.15487 17.1501 6.93515L14.9412 4.93665C14.1031 6.16269 12.79 7.25926 11.6069 8.16206" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4975 7.77977C11.2241 7.53219 10.2662 6.3149 9.72028 5.81888C9.53416 6.02108 9.308 6.18235 9.05619 6.29244C8.80438 6.40253 8.53243 6.45904 8.2576 6.45837C7.16497 6.45837 6.27966 5.58225 6.27966 4.50098C6.27942 4.00795 6.46712 3.53338 6.80455 3.1739L4.40713 1C2.25948 3.33399 1.06362 5.82194 1.00238 7.97572C0.941142 10.1295 2.07271 10.8167 3.17934 10.9789C6.42794 11.4548 9.52083 9.75989 11.9349 7.97572" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4145 13.5295C17.3359 13.6138 17.2747 13.7129 17.2345 13.821C17.1944 13.929 17.1759 14.044 17.1803 14.1592C17.1847 14.2744 17.2119 14.3877 17.2602 14.4924C17.3085 14.5971 17.377 14.6912 17.4618 14.7693C17.5466 14.8474 17.646 14.908 17.7543 14.9476C17.8626 14.9871 17.9777 15.0049 18.0929 14.9998C18.2081 14.9948 18.3212 14.967 18.4256 14.9181C18.53 14.8692 18.6237 14.8001 18.7013 14.7148C18.857 14.5439 18.9386 14.3184 18.9285 14.0875C18.9183 13.8565 18.8172 13.639 18.6472 13.4824C18.4772 13.3258 18.2521 13.2429 18.0211 13.2517C17.7902 13.2605 17.5721 13.3604 17.4145 13.5295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.8021 11.3295C14.7215 11.4135 14.6585 11.5127 14.6168 11.6213C14.5751 11.7299 14.5554 11.8458 14.559 11.9621C14.5626 12.0784 14.5894 12.1928 14.6377 12.2986C14.6861 12.4045 14.755 12.4996 14.8406 12.5784C14.9262 12.6573 15.0266 12.7183 15.136 12.7578C15.2455 12.7974 15.3617 12.8147 15.4779 12.8088C15.5941 12.8029 15.7079 12.7738 15.8128 12.7234C15.9176 12.6729 16.0114 12.602 16.0885 12.5149C16.2402 12.3434 16.3187 12.1193 16.3071 11.8906C16.2954 11.6619 16.1946 11.4469 16.0262 11.2918C15.8578 11.1366 15.6353 11.0537 15.4064 11.0607C15.1776 11.0678 14.9606 11.1643 14.8021 11.3295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.6043 9.1554C12.5265 9.23996 12.4661 9.33901 12.4265 9.44691C12.387 9.55482 12.369 9.66945 12.3738 9.78427C12.3785 9.8991 12.4059 10.0119 12.4542 10.1161C12.5025 10.2204 12.5709 10.3141 12.6555 10.3919C12.74 10.4698 12.8391 10.5302 12.947 10.5697C13.0549 10.6093 13.1695 10.6272 13.2843 10.6225C13.3992 10.6177 13.5119 10.5904 13.6162 10.542C13.7205 10.4937 13.8142 10.4253 13.892 10.3408C14.0492 10.17 14.1321 9.9438 14.1225 9.7119C14.1129 9.48 14.0116 9.26142 13.8408 9.10423C13.6701 8.94704 13.4439 8.86412 13.212 8.87372C12.9801 8.88332 12.7615 8.98464 12.6043 9.1554Z" fill="#282828"/></svg>Get Tickets</button>
</div>

	
	  <div class="tribe-events-schedule tribe-clearfix">
		
		
		<?php echo $title; ?>



<!-- Event Location &  date and time  -->
<!-- Event Location & Date and Time -->
<div class="single_event_page_location ">

<div class="location_div_js">📍<span class="location_name"></span> - <span class="location_postcode"></span></div>
  
<?php if ( tribe_get_venue_id( $event_id ) ): // Check if there's a venue ID associated with the event ?>
  <div class="time_div emoji_div_main">
    <span class="time_emoji">⏰</span>
    <span class="time_text">
      <h2 class="tribe-event-date-start">
        <?php 
          // Format for the date and time
          $event_start_date_time = tribe_get_start_date( $event_id, true, 'D, j M, H:i' );
          
          // Get the event's timezone object
          $timezone = Tribe__Events__Timezones::get_event_timezone_string( $event_id );

          // Create a DateTimeZone object from the event's timezone string
          $dateTimeZone = new DateTimeZone($timezone);

          // Create a DateTime object for the event's start date/time in the event's timezone
          $dateTime = new DateTime( tribe_get_start_date( $event_id, false, 'Y-m-d H:i:s' ), $dateTimeZone );

          // Format the DateTime object to get the timezone abbreviation
          // Handles cases like BST/GMT dynamically based on the event's date and timezone
          $timezone_abbr = $dateTime->format('T');

          // Output the start date and time along with the timezone abbreviation
          echo $event_start_date_time . ' ' . $timezone_abbr;
        ?>
      </h2>
    </span>
  </div>
<?php endif; ?>

<!--  <div class="door_open_time__div emoji_div_main"><span class="door_open_time__emoji">🚪</span> <span class="door_open_time__text">Doors open </span><span class="door_open_time_number"></span></div> -->
       
</div>



 <!-- Render the ticket form  -->
 <div class="get_tickets_div_single_event_form_new"> 
</div>
<div class="get_tickets_div_single_event">
<div class="get_tickets_div_single_event_inner_left">

<h5 class="ticketpricebtnsection"><span class="fromspansingleevent">From</span><?php if ( ! empty( $cost ) ) : ?>
			<span class="tribe-events-cost"><?php echo esc_html( $cost ) ?></span>
		<?php endif; ?></h5>
		</div></div>

<!-- MOBILE TICKET BUTTON  -->
<div class=buttonticket_for_mobile>
            <div class="buttonticket_for_mobile_text">
<span class="btn_from_span">From </span><span class="btn_price_span"> </span>
</div>
        <button id="getticketbtn1" class="getticketbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9653 16.7465C18.5679 16.0528 21.6812 13.9865 22.8702 12.1175L20.6832 10.1855C20.3924 10.5734 19.8259 10.9195 19.371 11.0603C18.9161 11.2011 18.2894 11.0004 17.8401 10.8416C17.3907 10.6828 17.0932 10.2025 16.817 9.80332C16.5407 9.40414 16.3922 8.92572 16.3921 8.43499C16.3921 7.78501 17.0592 6.77067 17.0592 6.77067L14.9969 5.15533C14.4505 5.99078 13.3486 6.92551 11.909 8.03083C11.2461 8.53997 10.7359 9.21138 9.9668 9.52938" fill="#3D54FF"/>
  <path d="M2.09375 10.6229C5.49369 13.5561 7.58317 15.5691 8.79872 16.3643C10.6218 17.5571 12.1641 17.7487 14.1652 17.5571C16.1659 17.3651 20.9196 15.0433 22.8705 12.1123L20.6668 10.1177C20.4418 10.4042 20.1546 10.6357 19.8268 10.7947C19.499 10.9536 19.1393 11.0358 18.775 11.0349C17.4532 11.0349 16.3816 9.97642 16.3816 8.67077C16.3816 8.34387 16.4499 8.02059 16.5823 7.72168C16.7146 7.42278 16.908 7.15487 17.1501 6.93515L14.9412 4.93665C14.1031 6.16269 12.79 7.25926 11.6069 8.16206" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M11.4975 7.77977C11.2241 7.53219 10.2662 6.3149 9.72028 5.81888C9.53416 6.02108 9.308 6.18235 9.05619 6.29244C8.80438 6.40253 8.53243 6.45904 8.2576 6.45837C7.16497 6.45837 6.27966 5.58225 6.27966 4.50098C6.27942 4.00795 6.46712 3.53338 6.80455 3.1739L4.40713 1C2.25948 3.33399 1.06362 5.82194 1.00238 7.97572C0.941142 10.1295 2.07271 10.8167 3.17934 10.9789C6.42794 11.4548 9.52083 9.75989 11.9349 7.97572" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4145 13.5295C17.3359 13.6138 17.2747 13.7129 17.2345 13.821C17.1944 13.929 17.1759 14.044 17.1803 14.1592C17.1847 14.2744 17.2119 14.3877 17.2602 14.4924C17.3085 14.5971 17.377 14.6912 17.4618 14.7693C17.5466 14.8474 17.646 14.908 17.7543 14.9476C17.8626 14.9871 17.9777 15.0049 18.0929 14.9998C18.2081 14.9948 18.3212 14.967 18.4256 14.9181C18.53 14.8692 18.6237 14.8001 18.7013 14.7148C18.857 14.5439 18.9386 14.3184 18.9285 14.0875C18.9183 13.8565 18.8172 13.639 18.6472 13.4824C18.4772 13.3258 18.2521 13.2429 18.0211 13.2517C17.7902 13.2605 17.5721 13.3604 17.4145 13.5295Z" fill="#282828"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8021 11.3295C14.7215 11.4135 14.6585 11.5127 14.6168 11.6213C14.5751 11.7299 14.5554 11.8458 14.559 11.9621C14.5626 12.0784 14.5894 12.1928 14.6377 12.2986C14.6861 12.4045 14.755 12.4996 14.8406 12.5784C14.9262 12.6573 15.0266 12.7183 15.136 12.7578C15.2455 12.7974 15.3617 12.8147 15.4779 12.8088C15.5941 12.8029 15.7079 12.7738 15.8128 12.7234C15.9176 12.6729 16.0114 12.602 16.0885 12.5149C16.2402 12.3434 16.3187 12.1193 16.3071 11.8906C16.2954 11.6619 16.1946 11.4469 16.0262 11.2918C15.8578 11.1366 15.6353 11.0537 15.4064 11.0607C15.1776 11.0678 14.9606 11.1643 14.8021 11.3295Z" fill="#282828"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6043 9.1554C12.5265 9.23996 12.4661 9.33901 12.4265 9.44691C12.387 9.55482 12.369 9.66945 12.3738 9.78427C12.3785 9.8991 12.4059 10.0119 12.4542 10.1161C12.5025 10.2204 12.5709 10.3141 12.6555 10.3919C12.74 10.4698 12.8391 10.5302 12.947 10.5697C13.0549 10.6093 13.1695 10.6272 13.2843 10.6225C13.3992 10.6177 13.5119 10.5904 13.6162 10.542C13.7205 10.4937 13.8142 10.4253 13.892 10.3408C14.0492 10.17 14.1321 9.9438 14.1225 9.7119C14.1129 9.48 14.0116 9.26142 13.8408 9.10423C13.6701 8.94704 13.4439 8.86412 13.212 8.87372C12.9801 8.88332 12.7615 8.98464 12.6043 9.1554Z" fill="#282828"/>
</svg>Get Tickets</button>
</div>

</div>




	
      </div>







<div class="div_lower_seconnd_section">



    
 
<!-- Event Line-up -->
<?php
$line_up = get_post_meta(get_the_ID(), 'event_line_up', true);
if (!empty($line_up) && is_array($line_up)) {
    echo '<div class="single_event_page_line_up single_event_sections">';
    echo '<h3>Lineup</h3>';
    echo '<ul>';
    foreach ($line_up as $line_up_item) {
        echo '<li>' . esc_html($line_up_item['name']) . '</li>';
    }
    echo '</ul>';
    echo '</div>';
}
?>



<!-- Event Agenda -->
<?php
$agendas = get_post_meta($event_id, 'event_agendas', true);
// Check if there are any agenda items
if (!empty($agendas) && is_array($agendas)) {
    $has_valid_agenda_items = false;

    // Check each agenda item to see if it has the required details
    foreach ($agendas as $agenda) {
        if (!empty($agenda['time_from']) && !empty($agenda['time_to']) && !empty($agenda['title'])) {
            $has_valid_agenda_items = true;
            break; // Exit the loop as soon as one valid agenda item is found
        }
    }

    // Only display the agenda section if there are valid agenda items
    if ($has_valid_agenda_items) {
        ?>
        <!-- Event Agenda -->
        <div class="single_event_page_agenda single_event_sections">
            <h3>Agenda</h3>
            <div class="agenda_main">
                <?php
                foreach ($agendas as $index => $agenda) {
                    if (!empty($agenda['time_from']) && !empty($agenda['time_to']) && !empty($agenda['title'])) {
                        echo '<div class="agenda_inner">';
                        echo '<span class="time_agenda">' . esc_html($agenda['time_from']) . ' - ' . esc_html($agenda['time_to']) . '</span> ';
                        echo '<span class="title_agenda">' . esc_html($agenda['title']) . '</span>';
                        echo '</div>'; // Close .agenda_inner
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
}
?>








<?php
$event_description = get_post_meta($event_id, 'event_description', true);
$event_description = wp_kses_post($event_description);
$event_description = str_replace('src="image','src="data:image',$event_description);
?>


<div class="event-description">
<?php echo $event_description; ?>
</div>



<div class="single_event_page_about_event single_event_sections">
        <h3>About this event</h3>
<div class="about_event_inner">
<div class="eticket_div"><span class="ticket_emoji">🎟️</span> <span class="eticket_text">Mobile eTicket</span></div>
<?php
$event_id = get_the_ID(); // Get the current event ID

// Retrieve age restrictions
$allage = get_post_meta($event_id, 'allage', true);
$over14 = get_post_meta($event_id, 'over14', true);
$over15 = get_post_meta($event_id, 'over15', true);
$over18 = get_post_meta($event_id, 'over18', true);
$norefunds = get_post_meta($event_id, 'norefunds', true);
?>


<?php if ($allage === 'on'): ?>
    <div class="all_age_div"><span class="14+_div_emoji">👪</span> <span class="14+_div_text">All Ages</span></div>
<?php endif; ?>

<?php if ($over14 === 'on'): ?>
    <div class="14+_div"><span class="14+_div_emoji">⚠️</span> <span class="14+_div_text">Over 14+ ONLY</span></div>
<?php endif; ?>

<?php if ($over15 === 'on'): ?>
    <div class="15+_div"><span class="15+_div_emoji">⚠️</span> <span class="15+_div_text">Over 15+ ONLY</span></div>
<?php endif; ?>

<?php if ($over18 === 'on'): ?>
    <div class="18+_div"><span class="18+_div_emoji">🔞</span> <span class="18+_div_text">NO ID NO ENTRY 18+ ONLY</span></div>
<?php endif; ?>

<?php if ($norefunds === 'on'): ?>
    <div class="refunds_div"><span class="refunds_emoji">🚫</span> <span class="refunds_text">NO REFUNDS</span></div>
<?php endif; ?>

</div>

 </div>




<div id="tribe-events-content" class="tribe-events-single">

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	

	

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->




			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>





<!-- Event Venue -->

<div class=" single_event_sections .single-tribe_events tribe-events-event-meta_venue">
        <h3>Venue</h3>

<!-- Event meta -->
<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

 </div>
			




<!-- Event organizer -->
<div class="organizer-details_main single_event_sections">
    <?php
    $event_id = get_the_ID();
    $organizer_ids = tribe_get_organizer_ids( $event_id );
    $organizer_count = count( $organizer_ids );
    // Add 's' to 'Organiser' if there is more than one organizer
    $organiser_title = $organizer_count > 1 ? 'Event Organisers' : 'Event Organiser';
    ?>
    <h3><?php echo $organiser_title; ?></h3>
    <div class="all-organizers-container"> <!-- Main wrapper for all organizers -->
        <?php
        if ( tribe_has_organizer( $event_id ) ) {
            foreach ( $organizer_ids as $organizer_id ) {
                $organizer_post = get_post( $organizer_id );
                if ( ! is_null( $organizer_post ) ) {
                    echo '<div class="organizer-details">'; // Individual organizer wrapper
                    echo '<div class="organizer-title">';
                    echo '<div class="organizer-name">' . esc_html( tribe_get_organizer( $organizer_id ) ) . '</div>';
                    $organizer_link = get_permalink( $organizer_id );
                    if ( $organizer_link ) {
                        echo '<div class="organizer-profile-link"><a class="button" href="' . esc_url( $organizer_link ) . '">View Profile</a></div>';
                    }
                    echo '</div>';

                    if ( has_post_thumbnail( $organizer_id ) ) {
                        echo '<div class="organizer-image">' . get_the_post_thumbnail( $organizer_id, 'thumbnail' ) . '</div>';
                    } else {
                        echo '<div class="organizer-image-placeholder"></div>';
                    }

                    $organizer_website = tribe_get_organizer_website_link( $organizer_id, false );
                    if ( $organizer_website ) {
                        echo '<div class="organizer-website">Website: <a href="' . esc_url( $organizer_website ) . '">' . esc_html( $organizer_website ) . '</a></div>';
                    }
                    echo '</div>'; // Close individual organizer wrapper
                } else {
                    echo "No detailed information available for the organizer.";
                }
            }
        } else {
            echo "No organizer for this event.";
        }
        ?>
    </div> <!-- Close main wrapper for all organizers -->
</div>





<!-- Event FAQ  -->
<?php
$event_id = get_the_ID(); // Ensure this is outside the loop if not using the loop's ID
$faqs = get_post_meta($event_id, 'event_faqs', true);

if (!empty($faqs) && is_array($faqs)) {
    echo '<div class="single_event_page_faq single_event_sections">';
    echo '<div class="faq-section">';
    echo '<h3>Event Frequently Asked Questions</h3>';

    foreach ($faqs as $faq) {
        // Ensure the FAQ item has both a question and an answer
        if (!empty($faq['question']) && !empty($faq['answer'])) {
            echo '<div class="faq-item">';
            echo '<button class="accordion">' . esc_html($faq['question']) . '<span class="arrow"></span></button>';
            echo '<div class="panel">';
            echo '<p>' . esc_textarea($faq['answer']) . '</p>';
            echo '</div>'; // Close .panel
            echo '</div>'; // Close .faq-item
        }
    }

    echo '</div>'; // Close .faq-section
    echo '</div>'; // Close .single_event_page_faq
}
?>



<?php


?>


<?php
$sponsor_logos_ids = get_post_meta(get_the_ID(), 'event_sponsor_logo');
if (!empty($sponsor_logos_ids)) : ?>
    <!-- Event Sponsors -->
    <div class="single_event_page_Sponsors single_event_sections">
        <h3>Event Sponsors</h3>
        <div class="sponsors_main">
            <?php foreach ($sponsor_logos_ids as $logo_id) :
                $logo_url = wp_get_attachment_url($logo_id); ?>
                <div class="sponsors_inner"><img src="<?php echo esc_url($logo_url); ?>"></div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
    

    
            </div>
















</div><!-- #tribe-events-content -->





</div>



</div><!-- main conatiner end div div_lower_seconnd_section -->

</div>

<script>


//FUNCTION TO SHOW LOADING EFFECT AND WHEN JS IS FULLY LOADED  HIDE AND SHOW CONTENT
document.addEventListener("DOMContentLoaded", function() {
        // Wait for 500 milliseconds after the document is fully loaded before showing main content
        setTimeout(showMainContent, 1000);
    });

    function showMainContent() {
        // Hide the loading animation
        var loadingDiv = document.querySelector('.loading_svg_div');
        if (loadingDiv) {
            loadingDiv.style.display = 'none';
        }

        // Show the main content
        var mainContentDiv = document.querySelector('.main_content_loading_div');
        if (mainContentDiv) {
            mainContentDiv.style.display = 'block'; // Or 'flex', 'grid' etc. depending on your layout
        }
    }

    ////END










jQuery(document).ready(function($) {
    var element = $('.buttonticket_for_mobile'); // Your target element
    var originalOffset = element.offset().top; // Original offset top position
    var elementHeight = element.outerHeight(); // Height of the element
    var isSticky = false; // Flag to track if sticky styling is applied

    // Function to check if the element is in the viewport
    function isInViewport() {
        var scrollPos = $(window).scrollTop(); // Current scroll position
        var windowHeight = $(window).height(); // Window height
        var elementTopPos = originalOffset; // Top position of the element
        var elementBottomPos = originalOffset + elementHeight; // Bottom position of the element

        // Element is in viewport if its bottom is greater than the scroll position
        // and its top is less than the scroll position plus the window height
        return elementBottomPos > scrollPos && elementTopPos < (scrollPos + windowHeight);
    }

    // Function to apply or remove fixed style based on element's visibility
    function updateElementStyle() {
        if (!isInViewport() && !isSticky) {
            // Apply fixed style if the element is not in the viewport and sticky styling hasn't been applied yet
            element.css({
                position: 'fixed',
                bottom: '0',
                left: '0', // Ensure the element spans the full width from the left
                right: '0', // Ensure the element spans the full width to the right
                'z-index': '999',
                'border-radius': '0',
                'padding-bottom': '40px'
            });
            isSticky = true; // Set the flag to true as sticky styling is applied
        } else if (isInViewport() && isSticky) {
            // Remove fixed style if the element is back in the viewport and sticky styling has been applied
            element.removeAttr('style');
            isSticky = false; // Reset the flag as sticky styling is removed
        }
    }

    // Initial check to update element style on page load
    updateElementStyle();

    // Update element style on scroll
    $(window).scroll(updateElementStyle);

    // Update element style on window resize to account for changes in layout
    $(window).resize(function() {
        // Recalculate original offset in case the layout has changed
        originalOffset = element.offset().top;
        // Reset isSticky flag to ensure correct behavior after layout change
        isSticky = false;
        updateElementStyle();
    });
});





//Function if the ticket price is 00.00 then show the text free

jQuery(document).ready(function(){
    $('.tribe-tickets__tickets-item').each(function() {
        var price = $(this).find('.tribe-amount').text();
        if (price === '0.00') {
            $(this).find('.tribe-tickets__tickets-sale-price').html('<span class="free-text">Free</span>');
        }
    });

    // Apply CSS styles with !important to the "Free" text
    $('.free-text').each(function(){
        $(this).attr('style', 'color: #d3fa16 !important; font-size: 22px !important; font-weight: 600 !important;');
    });
});




///FUNCTION FOR MOBILE TICKET POPUP AND CALCUTATE THE LOWEST ANDD HIGHT PRICE RANGE AND IF ITS 0.00 SHOW FREE, IF NO TICKET HIDE THE SECTION 

jQuery(document).ready(function() {



    let minPrice = Infinity;
    let maxPrice = 0;
    let priceFound = false; // Flag to track if any valid price was found

    $('.tribe-tickets__tickets-item').each(function() {
        let price = parseFloat($(this).data('ticket-price'));
        if (!isNaN(price)) { // Check if price is a valid number
            priceFound = true; // Valid price found
            if (price < minPrice) {
                minPrice = price;
            }
            if (price > maxPrice) {
                maxPrice = price;
            }
        }
    });

    // Determine the price range or "Free" label and update or hide price section
    if (priceFound) {
        let priceText;
        if (minPrice === 0 && maxPrice !== 0) {
            priceText = 'Free - £' + maxPrice.toFixed(2);
        } else if (minPrice === 0 && maxPrice === 0) {
            priceText = 'Free';
        } else {
            priceText = '£' + minPrice.toFixed(2) + ' - £' + maxPrice.toFixed(2);
        }

        $('.btn_price_span').text(priceText);
    } else {
        // Hide the price section if no valid prices found
        $('.buttonticket_for_mobile').hide();
    }




    
    var btns = jQuery('.getticketbtn, #scroll-to-tickets');  // Selecting elements with class 'getticketbtn' and the ID 'scroll-to-tickets'
    var linkViewAttendee = jQuery('.tribe-link-view-attendee');
    var ticketsForm = jQuery('.tribe-common.event-tickets.tribe-tickets__tickets-wrapper');
    var originalLocation = ticketsForm.parent();

    

    // Event listener for buttons and scroll-to-tickets
    btns.each(function() {
        jQuery(this).on('click', function() {
            if (ticketsForm.length) {
                // Show the form and link view attendee elements
                linkViewAttendee.show();
                ticketsForm.show();

                showPopup();
            } else {
                console.log("Required elements not found");
            }
        });
    });

    function showPopup() {
        var popupBackground = jQuery('<div class="popup-background"></div>');
        var popupContent = jQuery('<div class="popup-content"></div>');

        popupBackground.append(popupContent);
        popupContent.append(linkViewAttendee);
        popupContent.append(ticketsForm);

        var closeButton = jQuery('<button class="popup-close-btn">×</button>');
        closeButton.on('click', function() {
            closePopup();
        });

        popupContent.append(closeButton);
        jQuery('body').append(popupBackground);

        // Close popup when clicking outside the content area
        popupBackground.on('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Add event listener to the 'tribe-tickets__tickets-buy' button inside the popup
        popupContent.find('.tribe-tickets__tickets-buy').on('click', function() {
            closePopup();
        });
    }

    function closePopup() {
    // Hide the form in its current location
    ticketsForm.hide();

    // Move the form back to its original location and show it
    originalLocation.append(ticketsForm).show();

    // Remove the popup background
    jQuery('.popup-background').remove();
}
});




//VENUE
jQuery(document).ready(function($) {
    // Get the text from the elements
    var localityText = $('.tribe-locality').text(); // This is the postcode
    var venueText = $('.tribe-venue').text(); // This is the location name

    // Insert the text into the specified HTML structure
    $('.location_div_js .location_name').text(venueText);
    $('.location_div_js .location_postcode').text(localityText);
});











//FAQ
jQuery(document).ready(function($) {
    $('.accordion').click(function() {
        // Get the panel related to this accordion
        var panel = $(this).next('.panel');

        // Toggle the 'active' class on the clicked accordion
        $(this).toggleClass('active');

        // Slide up all panels except the one related to the clicked accordion
        $('.panel').not(panel).slideUp();
        // Remove 'active' class from all other accordions
        $('.accordion').not(this).removeClass('active');

        // Slide toggle the clicked accordion's panel
        panel.slideToggle();
    });
});



jQuery(document).ready(function($) {
    $('.top_flex_section_single_event .tribe-event-date-start').each(function() {
        var dateTimeText = $(this).text().trim(); // Trim to remove any trailing whitespace
        console.log("Original dateTimeText:", dateTimeText); 

        // Adjusted regex to match the time part 'HH:MM'
        var regex = /\d{1,2}:\d{2}$/;

        var regexTestResult = regex.test(dateTimeText);
        console.log("Regex Test Result:", regexTestResult);

        if (regexTestResult) {
            var formattedDateTime = dateTimeText.replace(regex, function(match) {
                console.log("Matched Time:", match); // Log the matched time
                return '<span class="time-part">' + match + '</span>';
            });

            console.log("Formatted dateTimeText:", formattedDateTime);
            $(this).html(formattedDateTime);
        }
    });

    $('.top_flex_section_single_event h2').css('display', 'block');
});




////JS TO ADD THE MAIN PRODUCT IMAGE ON THE BACKGROUND AND ADD THE LOCATION ON THE CUSTOM DIV 
       document.addEventListener('DOMContentLoaded', function() {
    var imageElement = document.querySelector('.tribe-events-event-image img');
    var titleElement = document.querySelector('.single-tribe_events');

    if (imageElement && titleElement) {
        var imageUrl = imageElement.getAttribute('src');
        titleElement.style.backgroundImage = 'url("' + imageUrl + '")';
        titleElement.classList.add('single_event_background');
    }
});






jQuery(document).ready(function($) {


    // Select the ticket form element
    var ticketsForm = $('.tribe-common.event-tickets.tribe-tickets__tickets-wrapper');
    // Select the 'View your Tickets' link
    var viewAttendeeLink = $('.tribe-link-view-attendee');
    // Select the target element where you want to move these elements
    var targetElement = $('.get_tickets_div_single_event_form_new');

    // Check if the tickets form exists and move it to the target element
    if (ticketsForm.length && targetElement.length) {
        targetElement.append(ticketsForm);
    }

    // Check if the 'View your Tickets' link exists and move it to the target element
    if (viewAttendeeLink.length && targetElement.length) {
        targetElement.append(viewAttendeeLink);
    }
});







jQuery(document).ready(function() {
    // Find the 'Buy Tickets' button
    var buyButton = jQuery('.tribe-tickets__tickets-buy');

    // Update the button text to 'Buy Now'
    buyButton.text('Get Tickets');

    // SVG HTML
     // Add SVG before the button text
	 var svgHtml = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.9653 16.7465C18.5679 16.0528 21.6812 13.9865 22.8702 12.1175L20.6832 10.1855C20.3924 10.5734 19.8259 10.9195 19.371 11.0603C18.9161 11.2011 18.2894 11.0004 17.8401 10.8416C17.3907 10.6828 17.0932 10.2025 16.817 9.80332C16.5407 9.40414 16.3922 8.92572 16.3921 8.43499C16.3921 7.78501 17.0592 6.77067 17.0592 6.77067L14.9969 5.15533C14.4505 5.99078 13.3486 6.92551 11.909 8.03083C11.2461 8.53997 10.7359 9.21138 9.9668 9.52938" fill="#3D54FF"/><path d="M2.09375 10.6229C5.49369 13.5561 7.58317 15.5691 8.79872 16.3643C10.6218 17.5571 12.1641 17.7487 14.1652 17.5571C16.1659 17.3651 20.9196 15.0433 22.8705 12.1123L20.6668 10.1177C20.4418 10.4042 20.1546 10.6357 19.8268 10.7947C19.499 10.9536 19.1393 11.0358 18.775 11.0349C17.4532 11.0349 16.3816 9.97642 16.3816 8.67077C16.3816 8.34387 16.4499 8.02059 16.5823 7.72168C16.7146 7.42278 16.908 7.15487 17.1501 6.93515L14.9412 4.93665C14.1031 6.16269 12.79 7.25926 11.6069 8.16206" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4975 7.77977C11.2241 7.53219 10.2662 6.3149 9.72028 5.81888C9.53416 6.02108 9.308 6.18235 9.05619 6.29244C8.80438 6.40253 8.53243 6.45904 8.2576 6.45837C7.16497 6.45837 6.27966 5.58225 6.27966 4.50098C6.27942 4.00795 6.46712 3.53338 6.80455 3.1739L4.40713 1C2.25948 3.33399 1.06362 5.82194 1.00238 7.97572C0.941142 10.1295 2.07271 10.8167 3.17934 10.9789C6.42794 11.4548 9.52083 9.75989 11.9349 7.97572" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4145 13.5295C17.3359 13.6138 17.2747 13.7129 17.2345 13.821C17.1944 13.929 17.1759 14.044 17.1803 14.1592C17.1847 14.2744 17.2119 14.3877 17.2602 14.4924C17.3085 14.5971 17.377 14.6912 17.4618 14.7693C17.5466 14.8474 17.646 14.908 17.7543 14.9476C17.8626 14.9871 17.9777 15.0049 18.0929 14.9998C18.2081 14.9948 18.3212 14.967 18.4256 14.9181C18.53 14.8692 18.6237 14.8001 18.7013 14.7148C18.857 14.5439 18.9386 14.3184 18.9285 14.0875C18.9183 13.8565 18.8172 13.639 18.6472 13.4824C18.4772 13.3258 18.2521 13.2429 18.0211 13.2517C17.7902 13.2605 17.5721 13.3604 17.4145 13.5295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.8021 11.3295C14.7215 11.4135 14.6585 11.5127 14.6168 11.6213C14.5751 11.7299 14.5554 11.8458 14.559 11.9621C14.5626 12.0784 14.5894 12.1928 14.6377 12.2986C14.6861 12.4045 14.755 12.4996 14.8406 12.5784C14.9262 12.6573 15.0266 12.7183 15.136 12.7578C15.2455 12.7974 15.3617 12.8147 15.4779 12.8088C15.5941 12.8029 15.7079 12.7738 15.8128 12.7234C15.9176 12.6729 16.0114 12.602 16.0885 12.5149C16.2402 12.3434 16.3187 12.1193 16.3071 11.8906C16.2954 11.6619 16.1946 11.4469 16.0262 11.2918C15.8578 11.1366 15.6353 11.0537 15.4064 11.0607C15.1776 11.0678 14.9606 11.1643 14.8021 11.3295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.6043 9.1554C12.5265 9.23996 12.4661 9.33901 12.4265 9.44691C12.387 9.55482 12.369 9.66945 12.3738 9.78427C12.3785 9.8991 12.4059 10.0119 12.4542 10.1161C12.5025 10.2204 12.5709 10.3141 12.6555 10.3919C12.74 10.4698 12.8391 10.5302 12.947 10.5697C13.0549 10.6093 13.1695 10.6272 13.2843 10.6225C13.3992 10.6177 13.5119 10.5904 13.6162 10.542C13.7205 10.4937 13.8142 10.4253 13.892 10.3408C14.0492 10.17 14.1321 9.9438 14.1225 9.7119C14.1129 9.48 14.0116 9.26142 13.8408 9.10423C13.6701 8.94704 13.4439 8.86412 13.212 8.87372C12.9801 8.88332 12.7615 8.98464 12.6043 9.1554Z" fill="#282828"/></svg>';


    // Add SVG before the button text
    buyButton.prepend(svgHtml);
});




/***STICKY TICKET FORM FUNCTION****/
/*
jQuery(document).ready(function($) {
    var stickyElement = $('.get_tickets_div_single_event_form_new');
    var stickyOffset = stickyElement.offset().top;
    var buffer = 0; // Pixels of buffer before the class is added/removed
    var isSticky = false;

    $(window).scroll(function() {
        var currentScroll = $(window).scrollTop();

        if (currentScroll >= stickyOffset - buffer && !isSticky) {
            stickyElement.addClass('ticket_form_sticky');
            stickyElement.stop().animate({ top: '100px' }, 00);
            isSticky = true;
        } else if (currentScroll < stickyOffset - buffer && isSticky) {
            stickyElement.removeClass('ticket_form_sticky');
            stickyElement.stop().animate({ top: '' }, 00);
            isSticky = false;
        }
    });
});

*/







/*
//TIME CALACUTIONS 
jQuery(document).ready(function($) {
    // Function to extract time from the text
    function extractTime(text) {
        var timeMatch = text.match(/\d{1,2}:\d{2}/);
        return timeMatch ? timeMatch[0] : null;
    }

    // Extracting start and end times
    var startTimeText = extractTime($('.tribe-event-date-start').text());
    var endTimeText = extractTime($('.tribe-event-date-end').text());

    // Function to calculate duration
    function calculateDuration(startTime, endTime) {
        var start = moment(startTime, 'HH:mm');
        var end = moment(endTime, 'HH:mm');

        // Check if end time is the next day
        if (end.isBefore(start)) {
            end.add(1, 'day');
        }

        var duration = moment.duration(end.diff(start));
        var hours = duration.asHours();
        var minutes = duration.minutes();

        var result = '';
        if (hours >= 1) {
            result += Math.floor(hours) + ' hours ';
        }
        if (minutes > 0) {
            result += minutes + ' minutes';
        }
        return result.trim();
    }

    if (startTimeText && endTimeText) {
        // Display duration
        var eventDuration = calculateDuration(startTimeText, endTimeText);
        $('.time_counter_text').text(eventDuration);
    } else {
        console.log('Error parsing event times');
    }
});
*/





//DOORS OPEN FUNCTION
jQuery(document).ready(function($) {
    // Function to extract time from the text
    function extractStartTime(text) {
        var timeMatch = text.match(/(\d{1,2}:\d{2})/);
        return timeMatch ? timeMatch[1] : null;
    }

    // Extracting start time
    var startTimeText = extractStartTime($('.tribe-event-date-start').text());

    if (startTimeText) {
        // Display start time
        $('.door_open_time_number').text( startTimeText);
    } else {
        console.log('Error parsing start time');
    }
});






/////FUNCTION TO ADD THE EVENT MAIN IMAGE TO THE MANIN IMAGE DIV BACKGROUND 
jQuery(document).ready(function() {
    $('.tribe-events-event-image').each(function() {
        // Extract the src attribute from the img element
        var imgUrl = $(this).find('img').attr('src');

        // Set the background image
        $(this).css('background-image', 'url(' + imgUrl + ')');

        // Add the 'glass-effect' class to apply the glass effect styling
        $(this).addClass('glass-effect');

     

    });
});






////SHARE BTUTOTN FUNCTION 





jQuery(document).ready(function($) {
    // Show the popup when the share button is clicked
    $('.share_btn').click(function() {
        $('.overlay').show();
        $(this).nextAll('.share_btn_event').first().show().css({
            'position': 'fixed',
            'top': '50%',
            'left': '50%',
            'transform': 'translate(-50%, -50%)',
            'z-index': '1001'
        });
    });

    // Close the popup and hide the overlay when the close button is clicked
    $('.close_popup').click(function() {
        $('.share_btn_event').hide();
        $('.overlay').hide();
    });

    // Also close the popup and hide the overlay when clicking outside of the popup (on the overlay)
    $(document).on('click', '.overlay', function() {
        $('.share_btn_event').hide();
        $('.overlay').hide();
    });

    // The section for copying the URL has been removed



    

  // Copy to clipboard functionality
  $(document).ready(function() { // Ensure the DOM is fully loaded
    $(document).on('click', '.copyButton', function() {
        var eventUrlText = $(this).siblings('.eventUrl').text();
        var $button = $(this); // Reference to the clicked button

        navigator.clipboard.writeText(eventUrlText).then(function() {
            // Attempt to display the message directly without relying on siblings, for troubleshooting
            $('.copyMessage').text('Link copied!').css('display', 'block').delay(3000).fadeOut(400);
        }).catch(function(error) {
            console.error('Error copying text:', error);
        });
    });
});

})









jQuery(document).ready(function($) {
    // Function to toggle display of available ticket quantities.
    // It sets .tribe-tickets__tickets-item-extra-available to display:block
    // if the available quantity is less than 15, otherwise hides it.
    
    // Iterate over each ticket item on the page
    $('.tribe-tickets__tickets-item').each(function() {
        // Parse the available quantity text to an integer
        var availableQuantity = parseInt($(this).find('.tribe-tickets__tickets-item-extra-available-quantity').text(), 10);
        
        // Check if availableQuantity is a number and less than 15
        if (!isNaN(availableQuantity) && availableQuantity < 15) {
            // If conditions are met, show the available quantity element
            $(this).find('.tribe-tickets__tickets-item-extra-available').css('display', 'block');
        } else {
            // Otherwise, hide the available quantity element
            $(this).find('.tribe-tickets__tickets-item-extra-available').css('display', 'none');
        }
    });
});





    </script>


<style>

/****LOADING  ANIMATION STYLES*****/
.loading_svg_div {
        display: block; /* Or whatever display mode you prefer */
    }

    .main_content_loading_div {
        display: none;
    }
.grey {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_0 3200ms infinite, fade 3200ms infinite;
}

.blue {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_1 3200ms infinite, fade 3200ms infinite;
}

@keyframes fade {
  0% {
    stroke-opacity: 1;
  }
  80% {
    stroke-opacity: 1;
  }
  100% {
    stroke-opacity: 0;
  }
}

@keyframes draw_0 {
  9.375% {
    stroke-dashoffset: 789
  }
  39.375% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes draw_1 {
  35.625% {
    stroke-dashoffset: 789
  }
  65.625% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}


/*****END******/

/***SHARE BUTTON*/
.share_btn{
    display: block!important;
    z-index: 9;
}
.type-tribe_events {
    position: relative;
}
/*end***/


.glass-effect {
    background-size: cover;
    background-position: center;; 
    backdrop-filter: blur(50px)!important;
    -webkit-backdrop-filter: blur(50px)!important;
    background-color: rgba(255, 255, 255, 0.4); 
    border-radius: 10px; 
}


.tribe-currency-symbol , .tribe-amount , .btn_price_span {
    color: #d3fa16!important;
    font-size:22px!important;
}

#tribe-events-pg-template{
    width: 100%;

}

.location_div_js span , .time_text span {
    font-size: 18px!important; 
}
.emoji_div_main   .time_emoji{
    display: flex;
    align-items: center!important; 
    flex-direction: row!important; 
    gap: 10px;
    font-size: 18px!important; 
}
.emoji_div_main{
    margin-bottom:0!important
}
/*****SINGLE EVENT PAGE****/
.tribe-events-back{
    display: none;
}

.future_tickets_item{
    opacity: 0.4;
}
.future_tickets_item .enddate{
    display: none
}

/****Event organizer***/
.organizer-details{
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 14px;
    align-items: center;
}
.organizer-image img{
    border-radius: 50%;
    object-fit: cover;
    width: 80px;
    height: 80px; 

}
.tribe-events-single .tribe-events-status-single {
   
    padding-left: 0;
    font-size: 22px;
}
.organizer-profile-link a{
    text-decoration: none;
    border-radius: 6px;
    background: #ffffff;
    font-size: 13px;
    line-height: 23px;
    padding: 1px 19px;
    color: black!important;
    font-weight: 400;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.organizer-profile-link{
    width: fit-content;
}


html .organizer-profile-link:hover {
    background-color: rgb(26, 26, 26);
    color: white!important; 
}
.organizer-name span{
    font-weight: 300;
    font-size: 15px;
    text-transform: capitalize!important;
}
.organizer-name{
    text-transform: uppercase;
}
.organizer-title{
    display: flex!important;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.organizer-image-placeholder{
    width: 80px;
    height: 80px;
    background-color: #a3a3a3;
    border-radius: 100px;
}
.all-organizers-container{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 40px;
}
/****end***/

/****DATE AND LOCATION***/
.div_fordate_and_loaction{
    display: flex;
    gap: 38px;
    flex-direction: row;
}
.single_event_page_location .emoji_div_main{
    margin: 15px 0;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;

}
html .location_div_js.single_event_sections {
    border:0px solid rgba(255, 255, 255, 0.2)!important
}
.location_div_js .tribe-events-meta-group-venue dl{
    display: flex;
    flex-wrap: wrap;
    gap: 1px;
    align-items: flex-start;
    flex-direction: column;
    align-content: flex-start;
    margin-bottom: 15px;
}
.location_div_js{
margin-top:20px;
text-transform: capitalize!important;
}

.tribe-street-address , .tribe-locality , .tribe-postal-code {
    line-height: 24px;
}
/***END***/
.single_event_sections h3 , .event-tickets .tribe-tickets__tickets-title{
    margin-bottom: 20px;
    line-height: 21px;
    font-size: 26px;
    font-weight: 600;



}


.tribe-tickets__tickets-item.outofstock{
    opacity: 1!important;
}
.tribe-events-notices{
    font-size: 26px;
    list-style: none;
    background: #1A1A1A;
    color: #d3fa16;
    line-height: 34px;
    margin-bottom: 39px;
    padding: 20px 10px 13px 20px;
    border-radius: 3px;
    text-align: center;
 
}
.tribe-events-notices li{
    list-style: none;
}
.tribe-tickets__tickets-item-quantity-unavailable{
    color: red;
    font-weight: 600!important;
    opacity: 1;
    z-index: 9;
    position: relative!important;
    font-size: 17px!important;
}
.event-tickets .tribe-tickets__tickets-item-details-content, .entry .entry-content .event-tickets .tribe-tickets__tickets-item-details-content {
    color: #ffff!important;
    font-size: 13px!important;
    letter-spacing: 1px;
    font-weight: 500;

}
.tribe-tickets__tickets-item-extra .tribe-tickets__tickets-item-extra-price{
    text-align: left;
}
.tribe-tickets__tickets-item-extra-price{
    text-align: center;
    font-size: 20px!important;
}
html body .single_event_sections {
 padding-bottom: 40px;
 margin-bottom: 40px;
    font-weight: 400!important;
  font-size: 15px!important;
  width: 100%;
  margin-left: 0;
    margin-right: 0;
   
    }
    
    body .tribe-events-event-meta_venue
    {
        border-top: 1px solid rgba(255, 255, 255, 0.2)!important;
        padding-top: 30px;
        border-bottom:0px solid!important;
        padding-bottom: 0!important;
    }

    .tribe-events-venue-map{
        max-width: 700px!important;
    width: 100%!important;
    }



    .tribe-events-event-meta_venue .tribe-events-meta-group-details , .tribe-events-meta-group-organizer  , .tribe-events-meta-group-organizer{
display:none!important
    }


    
.single_event_sections h2{
    margin-bottom: 0px;
    line-height: 21px;
    
    }
    .timezone{
        margin-left: -7px;
    }
body .single_event_sections .tribe-event-date-start , .tribe-event-time , .timezone , body .tribe-event-date-end
 {
    color: white!important;
    font-weight: 400!important;
    font-size: 15px!important;
}
html .single_event_page_location .tribe-event-time{
    color:white!important
}
html .single_event_page_location .tribe-event-time:before{
    content:"-";
    margin:0 5px
}
html .single_event_page_location .tribe-event-date-start{
font-size:18px!important
}
.single_event_background {
    background-size:   contain;
background-position: center top;
    background-repeat: no-repeat;
    position: relative;
    z-index: 2;
}

.single_event_background:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    -webkit-backdrop-filter: blur(80px); /* for Safari */
    backdrop-filter: blur(80px);
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
}


/*
.tribe-common.event-tickets.tribe-tickets__tickets-wrapper,
.tribe-link-view-attendee {
    display: none;
}
*/

.single_event_sections:last-child{
    border-bottom: 0!important;
}

.tribe-tickets__tickets-item-content-title{
    text-transform: capitalize!important;
}
  .tribe-events-event-image{

    margin-bottom:0!important;


  }
  .tribe-events-single-event-title {
    margin-top:20px!important
  }
.tribe-events-event-image img {
    display: block;
    max-width: 1052px;
    width: 100%!important;
    border-radius: 11px;
    margin-bottom: 0px!important;
    margin: 0;
    max-height: 475px;
    object-fit: contain;
    backdrop-filter: blur(100px)!important;
    -webkit-backdrop-filter: blur(100px)!important;
}
.main_single_event_div{
    display: flex;
    flex-direction: column;
    max-width: 900px;
    margin: 0 auto;
}
.top_flex_section_single_event{
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-top: 47px!important;
    max-width: 900px;
    margin: 0 auto;
}
.top_flex_section_single_event .type-tribe_events{
    flex: 0 0 55%;

}
.div_lower_seconnd_section{
    max-width: 100%;
}
.single_event_listing_page_left_side{
    min-width: 0;
    flex: 0 0 50%;

}
.tribe-events-schedule{
    display: flex;
    flex-direction: column;
}

.tribe-event-time:before{
    content:"-";
    margin:0 5px
}
.tribe-tickets__tickets-form{
    border-radius: 7px;
background: #2C2C2C!important;
}

.single-tribe_events .tribe-event-date-start , .single-tribe_events .tribe-event-time , .single-tribe_events .timezone,  .single-tribe_events  .tribe-event-date-end{
    position: relative;
    top: -3px;
    text-transform: capitalize;
    font-size: 17px;

}
.single_event_page_short_dec{
    margin-top: 11px;

}

.single-tribe_events .tribe-events-nav-pagination {
    display: none!important;
}
.single-tribe_events .tribe-events-footer  , .single-tribe_events .tribe-events-cost , .tribe-events-c-subscribe-dropdown__button ,html .top_flex_section_single_event .tribe-event-date-end{
    display: none!important;
}

.tribe-events-cost{
    margin: 0!important;
    font-size: 22px;
    font-weight: 600;
}
.fromspansingleevent{
    font-weight: 300;
    font-size: 15px;
}
.tribe-events-schedule{
    margin: 0;
    margin-top: -15px;
}

.ticketpricebtnsection{
    margin: 0!important;
}

.get_tickets_div_single_event{
    display: none;
    flex-direction: row;
    align-content: center;
    background-color: rgb(26, 26, 26);
    align-items: center;
    padding: 12px 18px;
    width: 100%;
    justify-content: space-between;
    border-radius: 7px;
    margin-top: 15px;
}
.buttonticket_for_mobile{
    display: none;
    flex-direction: row;
    align-content: center;
    background-color: #1A1A1A;
    align-items: center;
    padding: 12px 18px;
    width: 100%;
    justify-content: space-between;
    border-radius: 7px;
    margin-top: 20px;
    margin-bottom: -16px;
    
}
.tribe-events-single-event-description h2 {
    text-transform: capitalize;
    font-size: 23px;
    background-color: inherit!important;
}
.tribe-events-single-event-description p{
    font-weight: 300;
}
.tribe-events-single-event-description  span , .tribe-events-single-event-description p {
    background-color: inherit!important;
}
.tribe-common .tribe-common-h7{
    color: white!important;
}

#getticketbtn1{
    display: flex;
    gap: 14px;
    align-content: center;
    align-items: center;
    background: #d3fa16;
    color: black;
    font-size: 15px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    border-radius: 4px;
    transition: background-color 0.3s ease, color 0.3s ease;
    padding: 6px 12px;
}

#getticketbtn1:hover{
    background-color: rgb(255, 255, 255);
    color: #000000; 

}


.single-tribe_events .tribe-events-meta-group-venue,.single-tribe_events .tribe-events-single-section-title ,.single-tribe_events .tribe-venue-tel-label, .single-tribe_events .tribe-venue-tel , .single-tribe_events .tribe-country-name , .tribe-address .tribe-delimiter{
    display: none;
}
.single-tribe_events .tribe-venue{
    margin-bottom: 5px!important;
    margin: 0!important;
    text-transform: capitalize;
    font-size: 20px;
    font-weight: 600;
}
.single-tribe_events .tribe-postal-code , .tribe-locality{
    
    padding-left: 5px;
}
.single-tribe_events .tribe-postal-code{
    text-transform: uppercase;
}
.single-tribe_events .tribe-venue a{
    text-transform: capitalize!important;
    text-decoration: none;
    cursor:auto
}

.single-tribe_events .tribe-events-meta-group-venue{
    display: block;
    width: 100%;
    margin: 0!important;
    margin-top: 9px!important;
    padding: 0;
    flex: inherit
}
.single-tribe_events .tribe-events-address , .tribe-venue-location{
    margin: 0!important;
}
.single-tribe_events .tribe-events-address .tribe-address{
    display: flex;
    flex-direction: row;
    text-transform: capitalize!important;
}
.single-tribe_events .tribe-events-address{
    display: flex;
    flex-direction: row;
    gap: 20px;
}

html .single-tribe_events .tribe-events-gmap{
    text-decoration: none;
    border-radius: 3px;
    background: inherit;
    border:1px solid #ffffff;
    font-size: 13px;
    line-height: 23px;
    padding: 1px 11px;
    color: #ffffff!important;
    font-weight: 400;
    transition: background-color 0.3s ease, color 0.3s ease; 
}

.single-tribe_events .tribe-events-gmap:hover {
    background-color: rgb(26, 26, 26);
    color: white!important; 
}


.single-tribe_events .tribe-venue:hover{
    color: white!important;
}


 html .tribe-events .tribe-events-c-subscribe-dropdown__container{
    display: none!important;
}
.tribe-tickets__tickets-item-extra-available{
    width: fit-content;
    color: #ffffff !important;
    background: rgba(211, 250, 22, 0.2) !important;
    padding: 3px 7px!important;;
    border-radius: 2px;
}
.tribe-tickets__tickets-item-extra-available-quantity{
    color: #ffffff !important
}
.tribe-tickets__tickets-item-content-title{
    font-weight: 400!important;
}

.site-fee-container{
    text-align: right;
}


span.site-fee-container, span.site-fee-container span.ticket_site_fee  , .enddate , .startdate{
    color: #bcbcbc !important;
    font-size: 13px;
    font-weight: 300;
}
/**ticket popup**/

.popup-background {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: #1A1A1A;
    padding: 8px;
    border-radius: 0px;
    position: relative;
    width: 100%;
}

.popup-close-btn {
    position: absolute;
    top: -8px;
    right: 0px;
    border: none;
    background: transparent;
    color: white;
    font-size: 27px;
    cursor: pointer;
}
#tribe-tickets__tickets-form{
    border: 0;
    color: white;
    background-color: #1A1A1A!important;
    width: 100%;
    margin: 0;
max-width:900px
}

.single_event_sections{
    border-bottom: 1px solid rgba(255, 255, 255, 0.2)!important;
}
.organizer-details_main{
    border-top: 1px solid rgba(255, 255, 255, 0.2)!important;
  
    padding-top: 40px;
    margin-top: 40px;

}
.agenda_inner{
    background-color: rgb(26, 26, 26)!important;
    width: 100%;
    padding: 15px 20px;
}
.agenda_main .agenda_inner{
    border-radius: 4px;
    border-left: 4px solid;
}
.agenda_main .agenda_inner:nth-child(1) {
    border-color: #FF5733; 
}
.agenda_main .agenda_inner:nth-child(2) {
    border-color: #58ff05; 
}
.agenda_main .agenda_inner:nth-child(3) {
    border-color: #001eff; 
}
.agenda_main .agenda_inner:nth-child(4) {
    border-color: #d0ff00; 
}
.agenda_main .agenda_inner:nth-child(5) {
    border-color: #ff00ae; 
}
.agenda_main .agenda_inner:nth-child(6) {
    border-color: #ff0000; 
}
.agenda_main .agenda_inner:nth-child(7) {
    border-color: #ffffff; 
}
.agenda_main .agenda_inner:nth-child(8) {
    border-color: #00ffcc; 
}

.about_event_inner{
    margin-bottom: 0!important;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 31px;
}

.agenda_main{
    display: flex;
    gap: 7px;
    flex-direction: column;
    margin-top: 20px;
}

.single_event_page_about_event{
    border-bottom: 0px!important
}
.single_event_page_about_event div{
    margin-bottom: 10px ;
}
.single_event_page_about_event {
    padding-bottom: 0!important;
}
.single_event_page_about_event div:last-child{
    margin-bottom: 0!important;
}
.ticket_form_sticky {
    position: fixed;
    top: 1000px; 
    width: 41%!important;
    z-index: 100; 
    background-color: white; 
    box-shadow: 0px 2px 5px rgba(0,0,0,0.2); 
}


.tribe-link-view-attendee {
    display:none!important;
    margin: 0;
    padding: 0 15px;
    margin-bottom: 30px;
}
.get_tickets_div_single_event_form_new{
    width: 100%;
    transition: all 0.3s ease;
    color: white;
    background-color: rgb(26, 26, 26)!important;
    margin-top: 30px;
    border-radius: 10px;
}

.event-tickets .tribe-tickets__form input[type=number].tribe-tickets__tickets-item-quantity-number-input {
    color: white!important;
}
.entry .entry-content .event-tickets .tribe-tickets__tickets-item-quantity-add, .entry .entry-content .event-tickets .tribe-tickets__tickets-item-quantity-remove, .event-tickets .tribe-tickets__tickets-item-quantity-add, .event-tickets .tribe-tickets__tickets-item-quantity-remove {
    font-size: 27px!important;
}


.entry .entry-content .event-tickets .tribe-dialog__wrapper.tribe-modal__wrapper--ar, .event-tickets .tribe-dialog__wrapper.tribe-modal__wrapper--ar , .entry .entry-content .event-tickets .tribe-tickets__attendee-tickets-item, .event-tickets .tribe-tickets__attendee-tickets-item  {
    background-color:rgb(26, 26, 26)!important;
    color: white!important;
}


body .tribe-tickets__tickets-buy{
    max-width: 200px!important;
    width: 100%!important;
    display: flex!important;
    justify-content: center;
    align-items: center;
    align-content: center;
    gap: 20px!important;
    background-color: #d3fa16!important;
    color: black!important;
}

.event-tickets .tribe-tickets__commerce-checkout-cart-item-details-button--more, .event-tickets .tribe-tickets__rsvp-actions-button-not-going, .event-tickets .tribe-tickets__rsvp-form-button, .event-tickets .tribe-tickets__tickets-item-quantity button {

    height: 10px;
    position: relative;
    top: -15px;
}


.entry .entry-content .event-tickets .tribe-tickets__tickets-item-quantity-number, .event-tickets .tribe-tickets__tickets-item-quantity-number  {
    height: 26px!important;

    width: fit-content!important;
}



.entry .entry-content .event-tickets .tribe-tickets__tickets-item, .event-tickets .tribe-tickets__tickets-item , .entry .entry-content .event-tickets .tribe-tickets__tickets-footer, .event-tickets .tribe-tickets__tickets-footer  {

    border-top: 1px solid rgba(255, 255, 255, 0.2)!important;
   
}
.entry .entry-content .event-tickets .tribe-tickets__tickets-footer, .event-tickets .tribe-tickets__tickets-footer{
    border-top: 2px solid rgba(255, 255, 255, 0.2)!important;
}
.entry .entry-content .event-tickets .tribe-tickets__tickets-item, .event-tickets .tribe-tickets__tickets-item  {

   
}

.single_event_page_line_up ul {
    list-style-type: none; 
    padding: 0;
    margin: 0; 
    display: flex;
    flex-wrap: wrap;
}

.single_event_page_line_up ul li {
    margin-right: 10px; 
}

.single_event_page_line_up ul li:not(:last-child)::after {
    content: " | "; 
    margin-left: 10px; 
}


/****STICKY BUTTON FOR BUY TICKET****/
.fixed-position {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: white; /* Or any other color */
    z-index: 10; /* Ensure it's above other content */
}


#scroll-to-tickets{
    display: none!important;
justify-content: center;
align-items: center;
align-content: center;
gap: 11px!important;
background-color: #FFD700!important;
color: black!important;
padding: 11px 10px;
border-radius: 5px;
font-size: 15px;
font-weight: 600;
width: 100%;
}
.price-value {
    color: black!important;
    font-weight: 500!important;
    margin-left: -3px;
  
}
.price-value {
    font-size: 17px;
    font-weight: 700!important;
}
.tribe-tickets__tickets-buy{
    margin-top: 14px!important;
}
.btn_from_span{
    font-size: 13px;
}
.btn_price_span{
    font-weight: 800;
}


/****END****/


/****FAQ****/
.faq-section h3{
    margin-bottom: 30px;
}
.faq-item{
    margin-top: 8px;
}
.accordion {
    background-color: rgb(26, 26, 26)!important;

    color: #ffffff;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
    position: relative;
    font-size: 18px!important;
    font-weight: 500;


}

.active, .accordion:hover {
    background-color: #ccc;
}

.panel {
    padding: 0 18px;
    display: none;
    background-color: rgb(26, 26, 26)!important;
    overflow: hidden;
}

.arrow {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    border: solid rgb(255, 255, 255);
    border-width: 0 2px 2px 0;
    display: inline-block;
    padding: 3px;
    transition: 0.4s;
}

.accordion.active .arrow {
    transform: translateY(-50%) rotate(-135deg);
}

.accordion .arrow {
    transform: translateY(-50%) rotate(45deg);
}

.accordion{
    border-radius: 4px;
    border-left: 4px solid;
}


.faq-item:nth-child(1) .accordion {
    border-color: #00ffcc; 
}

.faq-item:nth-child(2) .accordion {
    border-color: #ffffff; 
}

.faq-item:nth-child(3) .accordion {
    border-color: #ff0000;
}

.faq-item:nth-child(4) .accordion {
    border-color: #ff00ae; 
}

.faq-item:nth-child(5) .accordion {
    border-color: #d0ff00;
}

.faq-item:nth-child(6) .accordion {
    border-color: #001eff;
}

.faq-item:nth-child(7) .accordion {
    border-color: #58ff05; 
}

.faq-item:nth-child(8) .accordion {
    border-color: #FF5733; 
}
/****END****/


/*****END*****/







 /**Event Sponsors**/
.sponsors_main{
    display: flex;
    gap: 19px;
    flex-direction: row;
    flex-wrap: wrap;
}
.sponsors_inner img {
    max-width: 150px;
    width: 100%;
    max
}



 /****END****

 /****Single event page media querys***/
@media screen and (max-width: 1000px) {
    .top_flex_section_single_event {
        flex-direction: column;
    }
    .top_flex_section_single_event{
        margin-top: 0;
    }
   .top_flex_section_single_event .tribe-events-schedule{
    margin-top: -35px;

   }
   .ticket_form_sticky{
    position: inherit!important;
   }
   .div_lower_seconnd_section{
    max-width: 100%!important;
   }
   .tribe-events-event-image img {
border-radius: 9px;
  
}
.buttonticket_for_mobile{
    display: flex;
}
.get_tickets_div_single_event_form_new{
    display: none;
}


.single_event_background {
    background-size: 300% auto;
}
}





@media screen and (max-width: 767px) {
  .tribe-tickets__tickets-title , .single_event_sections h3{
    font-size: 24px;
    font-weight: 600;
  }
  html body .tribe-tickets__tickets-buy{
    
    margin-left: 0!important;
  margin-top: 10px!important;
    grid-column: 1 / -1;
    width: 100%!important;
    max-width: 350px!important;
    margin: 0 auto!important;
  }
  .tribe-link-view-attendee {
    font-size: 12px;
}
html .single-tribe_events .tribe-tickets__tickets-footer{
    grid-template-columns: 1fr 1fr;
    display: grid;
    grid-gap: 7px;

}

.event-tickets .tribe-tickets__tickets-footer--active .tribe-tickets__tickets-footer-total {
    margin: 0x!important;
}
#sticky-button-container {
   visibility: visible!important
}
.single_event_page_location {
    text-align: left;
    width: 100%;
}
.btn_price_span {
    font-size: 19px!important;
    padding-left: 4px;
}


.event-tickets .tribe-tickets__tickets-item{
    gap: 5px;
}
.event-tickets .tribe-tickets__tickets-item-quantity {
    gap: 7px;
    margin-top: 10px;
}
}


@media screen and (max-width: 670px) {
    .about_event_inner {
        flex-direction: column;
        gap: 1px;
    }
  
    .tribe-events-single-event-description {
        font-size: 15px!important;
    }
    .single_event_sections h3{
        margin-bottom: 19px;
    }
    .tribe-events-event-image img{
        max-height: 500px!important;
    }
    html h1 {
    font-size: 27px;
    font-weight: bold;
    line-height: 32px;
}
.tribe-events-content h1{
    font-size: 26px;
    line-height: 28px;
}
.tribe-events-notices li{
    font-size: 20px;
}
.tribe-events-single-event-description h2 {
    text-transform: none;
    font-size: 22px;
}
.tribe-events-event-meta {
    margin-top: -25px;
}

.tribe-events-single-event-title {
    margin-top: 35px!important;
    font-size: 27px;
}
.tribe-tickets__tickets-item-extra-price {
    text-align: left;
    
}
.popup-content .tribe-currency-symbol, .popup-content  .tribe-amount, .popup-content .btn_price_span {
    color: #d3fa16!important;
    font-size: 19px!important;
}
.tribe-tickets__tickets-item-extra-available {
    font-size: 11px;
    margin-top: 5px !important;
}
  }

  @media screen and (max-width: 450px) {
    .tribe-events-event-image img{
        max-height: 350px!important;
    }
    .tribe-tickets__tickets-title , .single_event_sections h3{
        font-size: 20px!important;
        font-weight: 600!important;
      }
      .single-tribe_events .tribe-venue {
        font-size: 16px;
    }
    .single-tribe_events .tribe-events-address {
        flex-direction: column;
        gap: 6px;
    }
    html .single-tribe_events .tribe-events-gmap {
        width: 100%;
    max-width: 111px;
    }
    html h1 {
        font-size: 30px;
        line-height: 33px;
    }
    .top_flex_section_single_event {

        gap: 20px;
       
    }
   
    .get_tickets_div_single_event_form_new {
        margin-top: 16px;
    }
    .top_flex_section_single_event   .tribe-common .tribe-common-h7 {
        font-size: 15px;
    }
    .top_flex_section_single_even .tribe-formatted-currency-wrap{
        font-weight: 700;
    }
    .top_flex_section_single_even  .tribe-currency-symbol{
        margin-right: -4px;
    }
    html .top_flex_section_single_even h2.tribe-tickets__tickets-title{
        margin-bottom: 10px!important;
    }
    .tribe-events-single-event-title{
        margin-top: 10px;
    }
    body .single_event_sections {
        padding-bottom: 30px;
        margin-bottom: 30px;
    }
    .organizer-details_main {
        padding-top: 30px;
        margin-top: 30px;
    }
    .accordion {
        font-size: 16px!important;
        font-weight: 600;
    }
    .accordion   .panel{
        font-size: 13px;
    }
    .event-tickets .tribe-tickets__tickets-item {
        padding: 9px 0 5px;
    }
  /**Event Sponsors**/

.sponsors_inner img {
    max-width: 100px;
    width: 100%;
} /****end***/
.all-organizers-container{

    gap: 15px;
}
.getticketbtn svg{
    display:none
}

  }






</style>
