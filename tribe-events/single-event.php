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



     <p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<div class="main_single_event_div">





	<div class="top_flex_section_single_event single_event_sections">
<!-- Event featured image, but exclude link -->
       <?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>
<!-- Event featured image, END -->
      </div>

      <!-- sticky button for mobile   -->
      <div id="sticky-button-container" style="display: none;">
    <button id="scroll-to-tickets"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.9653 16.7465C18.5679 16.0528 21.6812 13.9865 22.8702 12.1175L20.6832 10.1855C20.3924 10.5734 19.8259 10.9195 19.371 11.0603C18.9161 11.2011 18.2894 11.0004 17.8401 10.8416C17.3907 10.6828 17.0932 10.2025 16.817 9.80332C16.5407 9.40414 16.3922 8.92572 16.3921 8.43499C16.3921 7.78501 17.0592 6.77067 17.0592 6.77067L14.9969 5.15533C14.4505 5.99078 13.3486 6.92551 11.909 8.03083C11.2461 8.53997 10.7359 9.21138 9.9668 9.52938" fill="#3D54FF"/><path d="M2.09375 10.6229C5.49369 13.5561 7.58317 15.5691 8.79872 16.3643C10.6218 17.5571 12.1641 17.7487 14.1652 17.5571C16.1659 17.3651 20.9196 15.0433 22.8705 12.1123L20.6668 10.1177C20.4418 10.4042 20.1546 10.6357 19.8268 10.7947C19.499 10.9536 19.1393 11.0358 18.775 11.0349C17.4532 11.0349 16.3816 9.97642 16.3816 8.67077C16.3816 8.34387 16.4499 8.02059 16.5823 7.72168C16.7146 7.42278 16.908 7.15487 17.1501 6.93515L14.9412 4.93665C14.1031 6.16269 12.79 7.25926 11.6069 8.16206" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4975 7.77977C11.2241 7.53219 10.2662 6.3149 9.72028 5.81888C9.53416 6.02108 9.308 6.18235 9.05619 6.29244C8.80438 6.40253 8.53243 6.45904 8.2576 6.45837C7.16497 6.45837 6.27966 5.58225 6.27966 4.50098C6.27942 4.00795 6.46712 3.53338 6.80455 3.1739L4.40713 1C2.25948 3.33399 1.06362 5.82194 1.00238 7.97572C0.941142 10.1295 2.07271 10.8167 3.17934 10.9789C6.42794 11.4548 9.52083 9.75989 11.9349 7.97572" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4145 13.5295C17.3359 13.6138 17.2747 13.7129 17.2345 13.821C17.1944 13.929 17.1759 14.044 17.1803 14.1592C17.1847 14.2744 17.2119 14.3877 17.2602 14.4924C17.3085 14.5971 17.377 14.6912 17.4618 14.7693C17.5466 14.8474 17.646 14.908 17.7543 14.9476C17.8626 14.9871 17.9777 15.0049 18.0929 14.9998C18.2081 14.9948 18.3212 14.967 18.4256 14.9181C18.53 14.8692 18.6237 14.8001 18.7013 14.7148C18.857 14.5439 18.9386 14.3184 18.9285 14.0875C18.9183 13.8565 18.8172 13.639 18.6472 13.4824C18.4772 13.3258 18.2521 13.2429 18.0211 13.2517C17.7902 13.2605 17.5721 13.3604 17.4145 13.5295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.8021 11.3295C14.7215 11.4135 14.6585 11.5127 14.6168 11.6213C14.5751 11.7299 14.5554 11.8458 14.559 11.9621C14.5626 12.0784 14.5894 12.1928 14.6377 12.2986C14.6861 12.4045 14.755 12.4996 14.8406 12.5784C14.9262 12.6573 15.0266 12.7183 15.136 12.7578C15.2455 12.7974 15.3617 12.8147 15.4779 12.8088C15.5941 12.8029 15.7079 12.7738 15.8128 12.7234C15.9176 12.6729 16.0114 12.602 16.0885 12.5149C16.2402 12.3434 16.3187 12.1193 16.3071 11.8906C16.2954 11.6619 16.1946 11.4469 16.0262 11.2918C15.8578 11.1366 15.6353 11.0537 15.4064 11.0607C15.1776 11.0678 14.9606 11.1643 14.8021 11.3295Z" fill="#282828"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.6043 9.1554C12.5265 9.23996 12.4661 9.33901 12.4265 9.44691C12.387 9.55482 12.369 9.66945 12.3738 9.78427C12.3785 9.8991 12.4059 10.0119 12.4542 10.1161C12.5025 10.2204 12.5709 10.3141 12.6555 10.3919C12.74 10.4698 12.8391 10.5302 12.947 10.5697C13.0549 10.6093 13.1695 10.6272 13.2843 10.6225C13.3992 10.6177 13.5119 10.5904 13.6162 10.542C13.7205 10.4937 13.8142 10.4253 13.892 10.3408C14.0492 10.17 14.1321 9.9438 14.1225 9.7119C14.1129 9.48 14.0116 9.26142 13.8408 9.10423C13.6701 8.94704 13.4439 8.86412 13.212 8.87372C12.9801 8.88332 12.7615 8.98464 12.6043 9.1554Z" fill="#282828"/></svg>Get Tickets</button>
</div>

	
	  <div class="tribe-events-schedule tribe-clearfix">
		
		
		<?php echo $title; ?>



<!-- Event Location &  date and time  -->
<div class="single_event_page_location ">

<div class="location_div_js">📍<span class="location_name"></span> - <span class="location_postcode"></span></div>
  
<div class="time_div emoji_div_main "><span class="time_emoji">⏰<span class="time_text"> <?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?></span></div>
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


<!-- Event ABOUT FULL DECP -->



<div class="single_event_page_about_event single_event_sections">
        <h3>About this event</h3>
<div class="about_event_inner">
<div class="eticket_div"><span class="ticket_emoji">🎟️</span> <span class="eticket_text">Mobile eTicket</span></div>
<?php
$event_id = get_the_ID(); // Get the current event ID

// Retrieve age restrictions
$over14 = get_post_meta($event_id, 'over14', true);
$over15 = get_post_meta($event_id, 'over15', true);
$over18 = get_post_meta($event_id, 'over18', true);
$norefunds = get_post_meta($event_id, 'norefunds', true);
?>

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



<script>

jQuery(document).ready(function() {
    var btns = jQuery('.getticketbtn, #scroll-to-tickets');  // Selecting elements with class 'getticketbtn' and the ID 'scroll-to-tickets'
    var linkViewAttendee = jQuery('.tribe-link-view-attendee');
    var ticketsForm = jQuery('.tribe-common.event-tickets.tribe-tickets__tickets-wrapper');
    var originalLocation = ticketsForm.parent();

    // Function to get the lowest ticket price
    function getLowestTicketPrice() {
        var lowestPrice = null;

        // Loop through each ticket item
        jQuery('.tribe-tickets__tickets-item').each(function() {
            // Get the price of the current ticket
            var price = parseFloat(jQuery(this).data('ticket-price'));

            // Check if this price is lower than the current lowest price
            if (lowestPrice === null || price < lowestPrice) {
                lowestPrice = price;
            }
        });

        return lowestPrice;
    }

    // Function to display the lowest price
    function displayLowestPrice() {
        var lowestPrice = getLowestTicketPrice();
        if (lowestPrice !== null) {
            // Display the lowest price in elements with class .btn_price_span
            jQuery('.btn_price_span').text('£' + lowestPrice.toFixed(2));
        }
    }

    // Call the function to display the lowest price
    displayLowestPrice();

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
    // Process each '.tribe-event-date-start' element within '.top_flex_section_single_event'
    $('.top_flex_section_single_event .tribe-event-date-start').each(function() {
        var dateTimeText = $(this).text();
        var dateParts = dateTimeText.split(' ');

        // Check if there are enough parts to form the date
        if (dateParts.length >= 4) {
            var dateOnly = dateParts[0] + ' ' + dateParts[1] + ' ' + dateParts[2] + ' ' + dateParts[3];
            $(this).text(dateOnly);
        }
    });

    // Remove the "-" from the date in the h2 element and hide time and timezone elements
    $('.top_flex_section_single_event h2').each(function() {
        // Remove hyphen text nodes
        $(this).contents().filter(function() {
            return this.nodeType === 3 && $.trim(this.nodeValue) === '-';
        }).remove();

        // Hide the time and timezone elements
        //$(this).find('.tribe-event-time, .timezone').hide();

        // Show the h2 element after modifications
        $(this).css('display', 'block');
    });
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








///STICKY BUY TICKET FUNCTION FOR MOBILE 

///STICKY BUY TICKET FUNCTION FOR MOBILE 

$(document).ready(function() {
    function isElementInView(element) {
        var elementTop = element.offset().top;
        var elementBottom = elementTop + element.outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    }

    function checkTicketButtonVisibility() {
        var ticketButton = $('.buttonticket_for_mobile');
        var stickyContainer = $('#sticky-button-container');

        if (!isElementInView(ticketButton)) {
            stickyContainer.show();
        } else {
            stickyContainer.hide();
        }
    }

    // Check on scroll and on page load
    $(window).scroll(checkTicketButtonVisibility);
    checkTicketButtonVisibility();

    // Scroll to ticket form on sticky button click
    $('#scroll-to-tickets').click(function() {
        // Removed the scroll to top functionality
        // $('html, body').animate({
        //     scrollTop: $(".tribe-events-event-image").offset().top
        // }, 400); // Smooth scroll duration
    });

    // Extracting the lowest price
    var priceElement = $('.top_flex_section_single_event .tribe-events-cost');
    if (priceElement.length) {
        var fullPriceText = priceElement.text();
        var firstPrice = fullPriceText.split('–')[0].trim(); // Extracts the first part of the price range

        // Creating a span element for the price with a class
        var priceSpan = $('<span>').text(firstPrice).addClass('- price-value');

        // Updating the button text by appending the spans
        $('#scroll-to-tickets').append(priceSpan);
    }
});


    </script>


<style>

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
    display: flex;
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
.event-tickets .tribe-tickets__tickets-item-details-content, .entry .entry-content .event-tickets .tribe-tickets__tickets-item-details-content {
    color: #878787!important;
    font-size: 13px!important;
    letter-spacing: 1px;

}
html body .single_event_sections {
 padding-bottom: 40px;
 margin-bottom: 40px;
    font-weight: 400!important;
  font-size: 15px!important;
   
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
    .tribe-events-event-meta_venue .tribe-events-meta-group-details , .tribe-events-meta-group-organizer{
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


  .tribe-events-event-image{

    margin-bottom:0!important;


  }
  .tribe-events-single-event-title {
    margin-top:10px!important
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
}
.main_single_event_div{
    display: flex;
    flex-direction: column;
}
.top_flex_section_single_event{
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-top: 47px!important;
    max-width: 800px;
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
    background-color: rgb(26, 26, 26);
    align-items: center;
    padding: 12px 18px;
    width: 100%;
    justify-content: space-between;
    border-radius: 7px;
    margin-top: 20px;
    margin-bottom: -16px;
    
}

.tribe-common .tribe-common-h7{
    color: white!important;
}

#getticketbtn1{
    display: flex;
    gap: 14px;
    align-content: center;
    align-items: center;
    background: #FFD700;
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



.tribe-tickets__tickets-item-extra-available , html .tribe-events .tribe-events-c-subscribe-dropdown__container{
    display: none!important;
}
.tribe-tickets__tickets-item-content-title{
    font-weight: 400!important;
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
    background-color:rgb(26, 26, 26);
    padding: 20px;
    border-radius: 5px;
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
    background-color: rgb(26, 26, 26)!important;
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
#sticky-button-container {
    position: fixed;
    bottom: 10px; 
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000; 
    background-color: rgb(26, 26, 26)!important;
    padding: 12px 30px;
    width: 100%;
    margin: 0 auto;
    text-align: center;
    height: 79px;
    bottom: 0px;
   visibility: hidden!important
}


#scroll-to-tickets{
    display: flex!important;
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
    margin-bottom: 40px;
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

.time_div , .door_open_time__div{
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

}

.event-tickets .tribe-tickets__tickets-footer--active .tribe-tickets__tickets-footer-total {
    margin: 0x!important;
}
#sticky-button-container {
   visibility: visible!important
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
        max-height: inherit!important;
    }
  }

  @media screen and (max-width: 450px) {
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
        max-width: 102px;
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
        margin-top: -10px;
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
  }



</style>