<?php


/**
 * View: Photo Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/photo/event.php
 *
 * See more documentation about our views templating system.
 * @link https://evnt.is/1aiy
 * @version 5.0.0
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 * @var string $placeholder_url The url for the placeholder image if a featured image does not exist.
 * @see tribe_get_event() For the format of the event object.
 */

$classes = get_post_class( [ 'tribe-common-g-col', 'tribe-events-pro-photo__event' ], $event->ID );
if ( ! empty( $event->featured ) ) {
    $classes[] = 'tribe-events-pro-photo__event--featured';
}

// Retrieve venue and organizer details
$venue_id = tribe_get_venue_id($event->ID);
$venue_name = tribe_get_venue($event->ID);
$venue_city = tribe_get_city($event->ID);
$organizer_ids = tribe_get_organizer_ids($event->ID);
$organizer_names = array_map('tribe_get_organizer', $organizer_ids);
?>
<article <?php tribe_classes( $classes ) ?>>
 <!-- Share Button -->
 <button class="share_btn"><img src="https://thaynna-william.co.uk/wp-content/uploads/2024/02/share-ios-chunky_svg__eds-icon-share-ios-chunky_svg-1.png"></button>
    <?php $this->template( 'photo/event/featured-image', [ 'event' => $event ] ); ?>

   

 <!-- Event live -->
<div class="event-listing live_event_listing_div">
    <div class="event-listing">
        <?php
        // Define the query arguments to get events for this organizer.
        $organizer_events_args = array(
            'post_type'      => 'tribe_events',
            'posts_per_page' => -1, // Retrieve all events; adjust as needed.
            'meta_query'     => array(
                array(
                    'key'   => '_EventOrganizerID',
                    'value' => $organizer->ID,
                ),
            ),
        );

        // Perform the query.
        $organizer_events = new WP_Query($organizer_events_args);

        // Check if the organizer has events.
        if ($organizer_events->have_posts()) :
            echo '<h3>Events by this Organizer</h3>';

            while ($organizer_events->have_posts()) : $organizer_events->the_post();
                // Get the event URL
                $event_url = get_the_permalink();

                // Get the cost of the event
                $ticket_price = tribe_get_cost(null, true);

                // Format the button text to include the price
                $button_text = !empty($ticket_price) ? esc_html($ticket_price) : "";

                ?>
                <div class="event-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="event-image">
                            <a href="<?php echo esc_url($event_url); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="event-image">
                            <a href="<?php echo esc_url($event_url); ?>">
                                <img src="https://ticketfesta.co.uk/wp-content/uploads/2024/02/placeholder-4.png" alt="Placeholder Image" style="width: 100%; height: auto;">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="event-details">
                        <div class="event-content">
                            <h2 class="event-title">
                                <a href="<?php echo esc_url($event_url); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="event-day">
                                <?php echo tribe_get_start_date(null, false, 'D, d M, H:i'); ?>
                            </div>
                            <div class="event-time-location">
                                <span class="event-time"><?php echo tribe_get_start_date(null, false, 'g:i a'); ?> - <?php echo tribe_get_end_date(null, false, 'g:i a'); ?></span>
                                <span class="event-location"><?php echo tribe_get_venue(); ?></span>
                            </div>
                            <div class="event-actions">
                                <a href="<?php echo esc_url($event_url); ?>" class="btn-get-tickets"><img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/Group-188.png">Get Tickets</a><span><?php echo $button_text; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;

            // Reset post data to avoid conflicts with the main query.
            wp_reset_postdata();
        else :
            echo '<p>No events found.</p>';
        endif;
        ?>
    </div>
</div>
<!-- Event live end -->
    <script>





///////ticket amount left tag
jQuery(document).ready(function($) {
    // Function to check and update ticket info based on the number of tickets left
    function checkAndUpdateTicketInfo() {
        $('.tribe-events-c-small-cta__stock').each(function() {
            var ticketInfo = $(this).text().trim(); // Example: "255 tickets left"
            var matches = ticketInfo.match(/\d+/); // Use regex to extract the first number found

            if (matches && matches.length > 0) {
                var ticketsLeft = parseInt(matches[0], 10); // Convert the extracted string to an integer

                // Log the number of tickets left for debugging
                console.log('Tickets left:', ticketsLeft);

                // Check if the number of tickets left is 259 or fewer
                if (ticketsLeft <= 10) {
                    // Show the ticket info if there are 259 or fewer tickets left
                    $(this).css('display', 'block');
                } else {
                    // Hide the ticket info if there are more than 259 tickets left
                    $(this).css('display', 'none');
                }
            }
        });
    }

    // Call the function initially and whenever necessary (e.g., after loading new event data dynamically)
    checkAndUpdateTicketInfo();

    // Example: To re-check the ticket info after 2 seconds (you can adjust or remove this part based on your needs)
    setTimeout(checkAndUpdateTicketInfo, 500);
});










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
  $(document).on('click', '.copyButton', function() {
    var eventUrlText = $(this).siblings('.eventUrl').text();
    console.log('Copy button clicked, text to copy:', eventUrlText);

    var $button = $(this); // Save the reference to 'this' (the clicked button)

    navigator.clipboard.writeText(eventUrlText).then(function() {
        console.log('Text successfully copied to the clipboard'); 
        $button.siblings('.copyMessage').text('Link copied!').css('display', 'block').delay(3000).fadeOut(400, function() {
            console.log('Copy message should now be hidden');
        });
    }).catch(function(error) {
        console.error('Error copying text to clipboard:', error);
    });
});





    $('.tribe-events-pro-photo__event-featured-image-wrapper').hover(
        function() {
            // Mouse enters the area
            $(this).closest('.tribe-events-pro-photo__event').find('.share_btn').css('display', 'block');
        }, function() {
            // Mouse leaves the area
            $(this).closest('.tribe-events-pro-photo__event').find('.share_btn').css('display', 'none');
        }
    );
});







///FUNCTION TO GET THE EVENT IMAGE AND USE AS A BACKEND IMAGE ON THE DIV CONTAISN 
jQuery(document).ready(function($) {
    console.log('Document ready, starting to process featured image wrappers...');

    $('.tribe-events-pro-photo__event-featured-image-wrapper').each(function(index) {
        var $wrapper = $(this); // Cache the current wrapper element
        console.log('Processing wrapper #' + (index + 1));

        if ($wrapper.children('.blur-background').length === 0) { // Check if blur-background already exists
            var imgSrc = $wrapper.find('img').attr('src');
            console.log('Image source for wrapper #' + (index + 1) + ':', imgSrc);

            // Create a new div for the blurred background
            var blurDiv = $('<div class="blur-background"></div>').css({
                'position': 'absolute',
                'top': 0,
                'left': 0,
                'width': '100%',
                'height': '100%',
                'background-image': 'url(' + imgSrc + ')',
                'background-size': 'cover',
                'background-position': 'center center',
                'filter': 'blur(40px)',
                'z-index': '0'
            });

            // Insert the blur div as the first child of the wrapper
            $wrapper.prepend(blurDiv);
            console.log('Blur background added to wrapper #' + (index + 1));
        } else {
            console.log('Blur background already exists for wrapper #' + (index + 1));
        }

        // Check if dark overlay already exists to avoid duplicates
        if ($wrapper.children('.dark-overlay').length === 0) {
            // Create a new div for the dark overlay
            var darkOverlay = $('<div class="dark-overlay"></div>').css({
                'position': 'absolute',
                'top': '0px',
                'left': '0px',
                'width': '100%',
                'height': '100%',
                'background-color': 'rgba(0, 0, 0, 0.3)', // Semi-transparent black
                'z-index': '1' // Above the blur background but below the image
            });

            // Insert the dark overlay div just after the blur background div
            $wrapper.prepend(darkOverlay);
            console.log('Dark overlay added to wrapper #' + (index + 1));
        }

        // Ensure the wrapper is positioned relatively and overflow is hidden
        $wrapper.css({
            'position': 'relative',
            'overflow': 'hidden'
        });

        // Make sure the image remains clear and above both the blurred background and dark overlay
        $wrapper.find('img').css({
            'position': 'relative',
            'z-index': '2'
        }); 
    });
});
</script>

</article>

<style>

/****Tags */
.tribe-events .tribe-events-c-small-cta__stock {
    color: #ffffff!important;
    position: absolute;
    top: 6px;
    z-index: 9;
    left: 6px;
    letter-spacing: 0.2px;
    font-size: 12px;
    font-weight: 400;
    background: #00000099;
    padding: 6px 12px;
    border-radius: 3px;
    border: 1px solid red!important;
    display:none;
}


/*******END */
.tribe-events-pro-photo__event-featured-image-link img{
    height: 200px;
    max-height: 220px;
    margin: auto;
    object-fit: contain;
}


    
.tribe-events-c-small-cta__link , .tribe-events-c-subscribe-dropdown__container , .tribe-events-pro-photo-nav{
    display:none!important
}
    .copyButton img{
        max-width: 20px;
    }
.share_btn_event {
    background: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px); /* For Safari */
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Light black box shadow */

}
.share_btn{
    z-index: 9; 
}

.overlay {

    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 1000;
    
    /* Overlay blur - this could be adjusted if you want the background content to be blurred as well */
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px); /* For Safari */
}


.copyButton {
    cursor: pointer;
    margin-left: 10px;
}

.copyMessage {
    margin-left: 10px;
    color: #219f00!important;
    font-size: 0.9em;
    display: inline-block;
    margin-top: 10px;

}

.close_popup {
    display: block;
    margin-top: 10px;
    position: absolute;
    right: 11px;
    top: 6px;
    font-size: 22px;
}
.share_btn_event h3{
    color: black!important;
    font-size: 20px;
    margin-bottom: 20px;
    background:white!important
}
.share_btn_event{
    padding: 29px!important;
    
}
.tribe-events-c-small-cta__stock{
    display:flex
}











@media (max-width: 960px) {
    .tribe-events-pro-photo__event {
        flex: 0 1 calc(50% - 10px); /* Adjusted to 50% for 2 items per row */
        margin: 5px;
        max-width: calc(50% - 10px); /* Adjusted to 50% for 2 items per row */
    }
}

@media (max-width: 700px) {
    .tribe-events-pro-photo__event {
        flex: 0 1 100%; /* Sets the item to take the full width */
        margin: 5px 0; /* Adjusted to have only top and bottom margins */
        max-width: 100%; /* Ensures the item's maximum width is the full container width */
    }
    body .tribe-events-pro-photo__event-featured-image-link img{
    height: inherit!important;
    max-height:300px

}
.tribe-common .tribe-common-g-row {
    display: flex!important;
    justify-content: space-between;
    margin: 0 2%!important;
    gap: 9px;
}
}

</style>
