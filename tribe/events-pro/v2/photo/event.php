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

   

    <!-- Overlay Background -->
    <div class="overlay" style="display: none;"></div>

    <!-- Popup div for sharing link -->
    <div class="share_btn_event" style="display: none;">
    <button class="close_popup" aria-label="Close">
    &times;
</button>

<h3>Share with friends</h3>
<div class="share_event_url">
    <span class="share_popup_box_title">Event URL</span>
    <div class="share_event_url_inner">
  <span class="eventUrl"><?php echo esc_url( tribe_get_event_link($event) ); ?></span>
  <button class="copyButton"><img src="https://thaynna-william.co.uk/wp-content/uploads/2024/02/copy.png" alt="Copy URL"></button></div>

</div>
<span class="copyMessage" style="display: none;">Link copied!</span>

</div>
    <div class="tribe-events-pro-photo__event-details-wrapper">
        <?php $this->template( 'photo/event/date-tag', [ 'event' => $event ] ); ?>

        <div class="tribe-events-pro-photo__event-details">
            <?php $this->template( 'photo/event/title', [ 'event' => $event ] ); ?>

            <!-- Event Day and Time -->
            <div class="event-day">
                <?php echo tribe_get_start_date( $event, true, 'D, j M, H:i' ); ?>
            </div>

            <!-- Venue, City, and Organizer Name -->
            <div class="event-venue-city-organizer">
                <?php
                if ( ! empty( $venue_name ) && ! empty( $venue_city ) ) {
                    echo esc_html( $venue_name ) . ' - ' . esc_html( $venue_city );
                } elseif ( ! empty( $venue_name ) ) {
                    echo esc_html( $venue_name );
                } elseif ( ! empty( $venue_city ) ) {
                    echo esc_html( $venue_city );
                }
                ?>
                <br>
                <?php echo esc_html( implode(', ', $organizer_names) ); ?>
            </div>

            <!-- Get Tickets Button -->
            <div class="event-actions">
    <div class="event_actions_inner">
    <?php $this->template( 'photo/event/cost', [ 'event' => $event ] ); ?>
        <a href="<?php echo esc_url( tribe_get_event_link($event) ); ?>" class="btn-get-tickets">
            <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/Group-188.png" alt="Get Tickets" style="vertical-align: middle;">
            Get Tickets
        </a>
    </div>
</div>
            <!-- End Get Tickets Button -->
        </div>
    </div>

    <script>





///////ticket amount left tag
jQuery(document).ready(function($) {
    setTimeout(function() {
        console.log('Timeout function executed');
        // Find the element that contains the number of tickets left
        var $stockElement = $('.tribe-events .tribe-events-c-small-cta__stock');

        if ($stockElement.length) {
            console.log('Stock element found');
            // Extract the text that contains the tickets information
            var ticketsText = $stockElement.text().trim();
            console.log('Tickets text:', ticketsText);
            // Use a regular expression to find the first number in the text, which represents the tickets left
            var matches = ticketsText.match(/\d+/);
            if (matches && matches.length > 0) {
                console.log('Matches found:', matches);
                var ticketsLeft = parseInt(matches[0], 10); // Convert to integer using base 10
                console.log('Tickets left:', ticketsLeft);

                // Assuming the dynamic threshold is represented by the tickets left
                var dynamicThreshold = ticketsLeft;

                // Here, instead of comparing ticketsLeft < dynamicThreshold, you might want to use this dynamic value in a different logic
                // For example, you might want to check if ticketsLeft is less than a certain percentage of the dynamicThreshold
                // Adjust the logic here based on your specific requirements

                // Example logic: Show the element if the number of tickets left is less than 90% of the dynamicThreshold
                if (ticketsLeft < dynamicThreshold * 0.9) {
                    console.log(`Less than 90% of ${dynamicThreshold} tickets left, showing element`);
                    // If yes, show the element by changing its 'display' style
                    $stockElement.css('display', 'block');
                } else {
                    console.log(`More than 90% of ${dynamicThreshold} tickets left, element remains hidden`);
                    // Optionally, you can hide the element if the condition is not met
                    $stockElement.css('display', 'none');
                }
            } else {
                console.log('No numerical matches found in tickets text');
            }
        } else {
            console.log('Stock element not found');
        }
    }, 2000); // Wait for 2 seconds before executing the code
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
