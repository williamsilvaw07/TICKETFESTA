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


 // Trim the event title here before displaying it
$trimmed_title = mb_strimwidth(get_the_title($event->ID), 0, 60, '...');


?>

    <!-- Overlay Background -->
    <div class="overlay" style="display: none;"></div>



<?php

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
 <button class="share_btn">
  <i class="fas fa-share-alt"></i>
</button>

    
    <?php if ( has_post_thumbnail($event->ID) ) : ?>
        <?php $this->template( 'photo/event/featured-image', [ 'event' => $event ] ); ?>
    <?php else : ?>
        <div class="event-featured-image-placeholder">
            <img src="https://ticketfesta.co.uk/wp-content/uploads/2024/02/placeholder-1-1.png" alt="Placeholder Image">
        </div>
    <?php endif; ?>

    <!-- Popup div for sharing link -->

    <div class="share_btn_event" style="display: none;">
    <button class="close_popup" aria-label="Close">&times;</button>
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
            <button class="copyButton" aria-label="Copy URL">
                <i class="fas fa-copy"></i>
            </button>
        </div>
    </div>
    <span class="copyMessage" style="display: none;">Link copied!</span>
</div>


    <div class="tribe-events-pro-photo__event-details-wrapper">
        <?php $this->template( 'photo/event/date-tag', [ 'event' => $event ] ); ?>

        <div class="tribe-events-pro-photo__event-details">
        <h3 class="tribe-events-pro-photo__event-title tribe-common-h6">
                <a href="<?php echo esc_url( tribe_get_event_link($event) ); ?>" 
                   title="<?php echo esc_attr($trimmed_title); ?>" 
                   rel="bookmark" 
                   class="tribe-events-pro-photo__event-title-link tribe-common-anchor-thin">
                    <?php echo esc_html($trimmed_title); ?>

<!-- Event Day and Time -->
<div class="event-day">
    <?php 
    $$event_id = $event->ID;
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

    // Output the start date and time along with the timezone abbreviation in a span with a class
    echo $event_start_date_time . ' <span class="event-timezone">' . $timezone_abbr . '</span>';
    ?>
</div>

         <!-- Venue and City -->
         <div class="event-venue-city-organizer">
<div class="event-venue-city">
    <?php
    if ( ! empty( $venue_name ) && ! empty( $venue_city ) ) {
        echo esc_html( $venue_name ) . ' - ' . esc_html( $venue_city );
    } elseif ( ! empty( $venue_name ) ) {
        echo esc_html( $venue_name );
    } elseif ( ! empty( $venue_city ) ) {
        echo esc_html( $venue_city );
    }
    ?>
</div>

<!-- Organizer Name -->
<div class="event-organizer">
    <?php echo esc_html( implode(', ', $organizer_names) ); ?>
</div>
</div>
            <!-- Get Tickets Button -->
            <div class="event-actions">
                <div class="event_actions_inner">
                    <?php $this->template( 'photo/event/cost', [ 'event' => $event ] ); ?>
                     <!--   <a href="<?php echo esc_url( tribe_get_event_link($event) ); ?>" class="btn-get-tickets">
                        <img src="/wp-content/uploads/2023/12/Group-188.png" alt="Get Tickets" style="vertical-align: middle;"> Get Tickets
                    </a> -->
                </div>
            </div>
            <!-- End Get Tickets Button -->
        </div>
    </div>

    <script>


// Make the entire event card clickable without affecting interactive elements like buttons and links
document.addEventListener('DOMContentLoaded', function() {
    var articles = document.querySelectorAll('.tribe-events-pro-photo__event');

    articles.forEach(function(article) {
        // Add click event listener to each article
        article.addEventListener('click', function(e) {
            // Check if the click was on interactive elements or their descendants
            if (e.target.closest('a, button, .share_btn, .share_btn_event, .close_popup, .copyButton')) {
                // Do nothing if the click is on interactive elements or their descendants
                return;
            }

            // Redirect to the URL specified in the data-href attribute of the article
            var url = article.querySelector('a').getAttribute('href');
            if (url) {
                window.location.href = url;
            }
        });

        // Change the cursor to pointer to indicate clickable area
        article.style.cursor = 'pointer';
    });
});



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
               // console.log('Tickets left:', ticketsLeft);

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
    //console.log('Document ready, starting to process featured image wrappers...');

    $('.tribe-events-pro-photo__event-featured-image-wrapper').each(function(index) {
        var $wrapper = $(this); // Cache the current wrapper element
       // console.log('Processing wrapper #' + (index + 1));

        if ($wrapper.children('.blur-background').length === 0) { // Check if blur-background already exists
            var imgSrc = $wrapper.find('img').attr('src');
           // console.log('Image source for wrapper #' + (index + 1) + ':', imgSrc);

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
                'filter': 'blur(30px)',
                'z-index': '0'
            });

            // Insert the blur div as the first child of the wrapper
            $wrapper.prepend(blurDiv);
            //console.log('Blur background added to wrapper #' + (index + 1));
        } else {
          //  console.log('Blur background already exists for wrapper #' + (index + 1));
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
           // console.log('Dark overlay added to wrapper #' + (index + 1));
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

/*****SOLD OUT EVENTS */
.home .tribe-events-c-small-cta__sold-out{
    color: white !important;
    background: red;
    font-size: 14px;
    font-weight: 400;
    padding: 5px 10px;
    margin-right: 20px;
    border-radius: 2px;
}
/****Tags */
.tribe-events .tribe-events-c-small-cta__stock {
    color: #000!important;
    position: absolute;
    top: 6px;
    z-index: 9;
    left: 6px;
    letter-spacing: 0.2px;
    font-size: 12px;
    font-weight: 400;
    background: #d3fa16;
    padding: 6px 12px;
    border-radius: 3px;
 
    display:none;
}
.tribe-events-pro-photo__event-title:hover , .tribe-events-pro-photo__event-title a:hover{
    text-decoration-color: white!important;
}
.tribe-events-pro-photo__event-title-link:hover {
    text-decoration-color: white!important;
}
/*******END */
html .tribe-events-pro-photo__event-featured-image-link img{
    height: 200px;
    max-height: 220px;
    margin: auto;
    object-fit: contain;
    border-radius:0!important
}
.event-venue-city , .event-organizer{
    font-weight: 300;
}
.event-featured-image-placeholder img{
    max-height: 200px;
    max-width: 400px!important;
    width: 100%;
    object-fit: cover;
}

    
.tribe-events-c-small-cta__link , .tribe-events-c-subscribe-dropdown__container , .tribe-events-pro-photo-nav{
    display:none!important
}
    .copyButton img{
        max-width: 20px;
    }
.tribe-events-c-small-cta__stock{
    display:flex
}


.event-featured-image-placeholder img , .tribe-events-pro-photo__event-featured-image-link img  {
    border-radius: 7px 7px 0px 0px!important;

}

.event-timezone{
    display: block!important;
    font-size: 11px!important;
    text-transform: capitalize!important;
    font-weight: 500!important;
    margin-top: 0!important;
    color: white!important;
}
.event-day{
    display: flex;
    gap: 6px;
    align-items: center;
}






@media (max-width: 960px) {
    .tribe-events-pro-photo__event {
        flex: 0 1 calc(50% - 10px); /* Adjusted to 50% for 2 items per row */
        margin: 5px;
        max-width: calc(50% - 10px); /* Adjusted to 50% for 2 items per row */
    }
    .share_btn{
        display:block!important
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
    max-height:200px

}
.tribe-common .tribe-common-g-row {
    display: flex!important;
    justify-content: space-between;
    margin: 0 2%!important;
    gap: 9px;
}
}

</style>
