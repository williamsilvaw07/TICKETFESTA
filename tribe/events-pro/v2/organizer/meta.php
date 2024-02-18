<?php
/**
 * View: Organizer meta
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/organizer/meta.php
 *
 * See more documentation about our views templating system.
 *
 * @link    https://evnt.is/1aiy
 *
 * @version 6.2.0
 * @since   6.2.0 Significantly reworked the logic to support the updated organizer meta and featured image rendering.
 *
 * @var WP_Post $organizer The organizer post object.
 *
 */
$organizer_facebook = get_post_meta($organizer->ID, '_organizer_facebook', true);
$organizer_instagram = get_post_meta($organizer->ID, '_organizer_instagram', true);


$classes = [ 'tribe-events-pro-organizer__meta', 'tribe-common-g-row' ];

$content            = tribe_get_the_content( null, false, $organizer->ID );
$url                = tribe_get_organizer_website_url( $organizer->ID );
$email              = tribe_get_organizer_email( $organizer->ID );
$phone              = tribe_get_organizer_phone( $organizer->ID );
$categories         = tec_events_pro_get_organizer_categories( $organizer->ID );
$has_featured_image = $organizer->thumbnail->exists;

$has_content  = ! empty( $content );
$has_details  = ! empty( $url ) || ! empty( $email ) || ! empty( $phone );
$has_taxonomy = ! empty( $categories );

if ( ! $has_content && ! $has_details && ! $has_featured_image && ! $has_taxonomy ) {
	return;
}

$classes['tribe-events-pro-organizer__meta--has-content']        = $has_content;
$classes['tribe-events-pro-organizer__meta--has-featured-image'] = $has_featured_image;
$classes['tribe-events-pro-organizer__meta--has-details']        = $has_details;
$classes['tribe-events-pro-organizer__meta--has-taxonomy']       = $has_taxonomy;

$conditionals = compact( 'has_content', 'has_details', 'has_featured_image', 'has_taxonomy' );
$template_vars = array_merge( [ 'organizer' => $organizer, ], $conditionals )
?>











<div <?php tribe_classes( $classes ); ?>>


<div class="organizer_profile_bk">

<?php
// Ensure that $organizer_id is defined. Use $organizer->ID if available.
if ( isset( $organizer ) && isset( $organizer->ID ) ) {
    $organizer_id = $organizer->ID;
} else {
    // Handle the case where $organizer or $organizer->ID is not available
    $organizer_id = get_the_ID(); // Fallback to get current post ID
}

$banner_image_id = get_post_meta($organizer_id, 'banner_image_id', true);
if ($banner_image_id) {
    $banner_image_url = wp_get_attachment_image_url($banner_image_id, 'full');
    echo '<img class="organizer_profile_bk_img" src="' . esc_url($banner_image_url) . '">';
} else {
    // Display default image or nothing
    echo '<img class="organizer_profile_bk_img" src="https://thaynna-william.co.uk/wp-content/uploads/2024/01/Group-189-5.jpg">';
}
?>
</div>
	<div class="tec-events-c-view-box-border">






	<div class="image_profile_text_main_continer">
	
	<!-- IMAGE -->
		<?php $this->template( 'organizer/meta/featured-image', $template_vars ); ?>

	<!-- IMAGE END-->

    <?php 
$follower_text = 'follow';
$follower_count = 0;
$current_post_id = get_the_ID();
$user_id = wp_get_current_user()->id; 

$followers_array = get_post_meta( $current_post_id, 'followers', true );
$followers_array = json_decode( $followers_array, true );
if ( json_last_error() !== JSON_ERROR_NONE ) {
    $followers_array = array();
}

if ( in_array( $user_id, $followers_array ) ) {
    $follower_text = 'unfollow';
}else{
    $follower_text = 'follow';
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( isset( $_POST['follow'] ) ) {
        if ( is_user_logged_in() ) {
            $user_id = wp_get_current_user()->id; 

            $followers_array = get_post_meta( $current_post_id, 'followers', true );
            $followers_array = json_decode( $followers_array, true );
            if ( json_last_error() !== JSON_ERROR_NONE ) {
                $followers_array = array();
            }

            $following_array = get_user_meta( $user_id, 'following', true );
            $following_array = json_decode( $following_array, true );

            if ( json_last_error() !== JSON_ERROR_NONE ) {
                $following_array = array();
            }

            if ( $_POST['follow'] === 'follow' ) {
                // user following organiser
                if ( !in_array( $current_post_id, $following_array ) ) {
                    $following_array[] = $current_post_id;
                }

                // user added as follower
                if ( !in_array( $user_id, $followers_array ) ) {
                    $followers_array[] = $user_id;
                }
                $follower_text = 'unfollow';

            } elseif ( $_POST['follow'] === 'unfollow' ){

                // user removed as follower
                if ( in_array( $user_id, $followers_array ) ) {
                    $key = array_search( $user_id, $followers_array );
                    unset( $followers_array[$key] );
                    $followers_array = array_values( $followers_array ); // Re-index array after removal
                }
                
                // user unfollowing as organiser
                if ( in_array( $current_post_id, $following_array ) ) {
                    $key = array_search( $current_post_id, $following_array );
                    unset( $following_array[$key] );
                    $following_array = array_values( $following_array ); // Re-index array after removal
                } 
                $follower_text = 'follow';
            }
            $follower_count = count($followers_array);
            update_user_meta( $user_id, 'following', json_encode($following_array ));
            update_post_meta( $current_post_id, 'followers', json_encode( $followers_array ) );
        }
    }
}
$follower_count = count($followers_array);
?>
	<!-- organizer name -->
<div class="organizer_title_name">
    <?php
    // Assuming you have the organizer ID stored in $organizer->ID
    // Get the organizer's title/name
    $organizer_title = get_the_title( $organizer->ID );

    // Output the organizer's title/name wrapped in an h1 tag
    echo '<h1>' . esc_html( $organizer_title ) . '</h1>';
    ?>
		<div class="organizer_text_dec">
			<p class="organizer_tagline">Tag Link of the type of events</p>
			<p class="organizer_tagline followers">Followers: <span class="followers-count"><?php echo $follower_count;?></span> </p>
        <form method="POST">
            <input type="hidden" name="follow" value="<?php echo $follower_text;?>">
            <input type="submit" value="<?php echo ucfirst($follower_text); ?>" nanme="submit" class="follow-button"> 
        </form>
</div>
<?php 

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( isset( $_POST['follow'] ) ) {
        if (!is_user_logged_in() )  {
            $my_account_url = esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));
            echo "<a href='$my_account_url' class='login-first'> Please login first. </a>" ;
        }
    } 
}
?>
</div>
<!-- organizer name end -->
</div>



<!-- organizer profile nav -->
<div class="organizer_navbar">
	<div class="organizer_nav-item organizer_events">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/calendar-1.png" alt="Events Icon" class="organizer_nav-icon" width="30">
	  <span>Events</span>
	</div>
	<div class="organizer_nav-item organizer_Gallery">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/image-gallery-1.png" alt="Gallery Icon" class="organizer_nav-icon" width="30">
	  <span>Gallery</span>
	</div>
	<div class="organizer_nav-item organizer_about">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/user-1-1.png" alt="About Icon" class="organizer_nav-icon profile_icon_nav" width="30">
	  <span>About</span>
	</div>
  </div>
  <!-- organizer profile nav END -->






<!-- Event LISTING -->
<div class="event-listing-main-div organizer_profile_main_div_all organizer_main_div organizer_events_content">
	<h3>Events</h3>
<div class="event-listing_type"> 
	<p class="live_events_link">Live Events </p>
	<p class="past_events_link">Past Events</p>
</div>



<!-- Event past -->
<div class="event-listing past_event_listing_div">

    <div class="event-listing">
        <?php
        // Replace this with your method of obtaining the current organizer's ID
        $current_organizer_id = get_the_ID(); // Example: get_the_ID() or another method

        // Current date and time
        $current_time = current_time('Y-m-d H:i:s');

        // Define the query arguments to get past events for the current organizer
        $past_events_args = array(
            'post_type'      => 'tribe_events',
            'posts_per_page' => -1, // Adjust number of posts per page as needed
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => '_EventEndDate',
                    'value'   => $current_time,
                    'compare' => '<',
                    'type'    => 'DATETIME'
                ),
                array(
                    'key'     => '_EventOrganizerID',
                    'value'   => $current_organizer_id,
                    'compare' => '=',
                ),
            ),
            'orderby'        => 'meta_value',
            'meta_key'       => '_EventEndDate',
            'order'          => 'DESC',
        );

        // Perform the query for past events
        $past_events = new WP_Query($past_events_args);

        // Check if there are past events for the current organizer
        if ($past_events->have_posts()) :
            while ($past_events->have_posts()) : $past_events->the_post();
                $event_url = get_the_permalink();
                $ticket_price = tribe_get_cost(null, true);
                $button_text = !empty($ticket_price) ? esc_html($ticket_price) : '';
                ?>
                <div class="event-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="event-image">
                            <a href="<?php echo esc_url($event_url); ?>">
                                <?php the_post_thumbnail('medium'); ?>
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
                                <a href="<?php echo esc_url($event_url); ?>" class="btn-get-tickets">View Event</a>
                             
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;

            // Reset post data to avoid conflicts with the main query
            wp_reset_postdata();
        else :
            echo '<p>No events found.</p>';
        endif;
        ?>
    </div>
</div>
<!-- Event past end -->



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
    $organizer_events = new WP_Query( $organizer_events_args );

    // Check if the organizer has events.
    if ( $organizer_events->have_posts() ) :
        echo '<h3>Events by this Organizer</h3>';

        while ( $organizer_events->have_posts() ) : $organizer_events->the_post();
            // Get the event URL
            $event_url = get_the_permalink();

            // Get the cost of the event
            $ticket_price = tribe_get_cost( null, true );

            // Format the button text to include the price
            $button_text = !empty($ticket_price) ? "" . esc_html($ticket_price) : "";

            ?>
            <div class="event-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="event-image">
                        <a href="<?php echo esc_url( $event_url ); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="event-details">
                    
                    <div class="event-content">
                        <h2 class="event-title">
                            <a href="<?php echo esc_url( $event_url ); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="event-day">
    <?php echo tribe_get_start_date(null, false, 'D, d M, H:i'); ?>
</div>
                        <div class="event-time-location">
                            <span class="event-time"><?php echo tribe_get_start_date( null, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( null, false, 'g:i a' ); ?></span>
                            <span class="event-location"><?php echo tribe_get_venue(); ?></span>
                        </div>
                        <div class="event-actions">
                            <a href="<?php echo esc_url( $event_url ); ?>" class="btn-get-tickets"><img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/Group-188.png">Get Tickets</a><span><?php echo $button_text; ?></span>
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
</div>


<!-- Event LISTING END -->








<!-- Event Gallery -->
<div class="organizer_gallery_main organizer_main_div organizer_Gallery_content">
<h3>Gallery</h3>
<?php 
    $categories = get_categories(array(
        'taxonomy' => 'tec_organizer_category',
        'hide_empty' => false,
        'meta_query' => array(
            array(
                'key' => 'category_owner_id',
                'value' => get_post_field('post_author', $organizer->ID)                ,
                'compare' => '='
            ),
            array(
                'key' => 'category_organiser',
                'value' => $organizer->ID,
                'compare' => '='
            )
        )
    ));

    // category_organiser

?>
    <!-- Event Gallery Category -->
    <div class="organizer_gallery_category">
        <?php foreach($categories as $category){ 
            $cat_title = $category->name;
            $category_image_array = get_term_meta($category->term_id, 'category_images', true); // get category images
            $category_images = explode(',', $category_image_array);
            $attachment_id = attachment_url_to_postid($category_images[0]);
            $attachment_src = wp_get_attachment_image_src($attachment_id, 'medium')[0];
            ?>
          
            <div class="organizer_gallery_category_inner" data-category="<?php echo $category->slug ?>">
                <h6 class="organizer_gallery_category_inner_title"><?php echo  $title; ?></h6>
                <img class="organizer_gallery_category_inner_image" src="<?php echo esc_url( $attachment_src ); ?>" >
            </div>
        <?php } ?>

        <?php 
        
        echo '<script>';
        echo "const imageData = {";
        foreach ($categories as $category) {
            $cat_title = $category->name;
            $category_image_array = get_term_meta($category->term_id, 'category_images', true); // get category images
            $category_images = explode(',', $category_image_array);

            echo "'$category->slug': [";
            foreach ($category_images as $image) {
                echo "'$image',";
            }
        
            echo "],";
        }
        echo "};";
        echo "</script>";

        ?>

        <!-- Additional categories as needed -->
    </div>
    <!-- Event Gallery Category END -->

    <!-- Image Display Area (Initially Hidden) -->
    <div id="galleryDisplayArea"></div>

</div>
<!-- Event Gallery END -->






<!-- Event about -->
<div class="organizer_about_main organizer_main_div organizer_about_content">

    <div class="organizer_about_main_inner">
        <h3>About</h3>

        <div class="organizer_about_main_inner_text">
            <?php echo apply_filters('the_content', $organizer->post_content); ?>
        </div>

        <div class="organizer_about_main_inner_social">
            <?php
            // Fetching social media links from the organizer metadata
            $organizer_facebook = get_post_meta($organizer->ID, '_organizer_facebook', true);
            $organizer_instagram = get_post_meta($organizer->ID, '_organizer_instagram', true);

            // Display Facebook link if available
            if (!empty($organizer_facebook)) {
                echo '<a href="' . esc_url($organizer_facebook) . '" target="_blank">
                    <img src="https://thaynna-william.co.uk/wp-content/uploads/2024/01/facebook-1.png" alt="Facebook">
                </a>';
            }

            // Display Instagram link if available
            if (!empty($organizer_instagram)) {
                echo '<a href="' . esc_url($organizer_instagram) . '" target="_blank">
                    <img src="https://thaynna-william.co.uk/wp-content/uploads/2024/01/instagram-1.png" alt="Instagram">
                </a>';
            }
            ?>
        </div>
    </div>

</div>
<!-- Event about END -->









	
</div>








<script>



	////JS TO ADD THE MAIN PRODUCT IMAGE ON THE BACKGROUND AND ADD THE LOCATION ON THE CUSTOM DIV 
	document.addEventListener('DOMContentLoaded', function() {
    var imageElement = document.querySelector('.tribe-events-pro-organizer__meta-featured-image-wrapper img');
    var titleElement = document.querySelector('.tribe_organizer-template-default');

    if (imageElement && titleElement) {
        var imageUrl = imageElement.getAttribute('src');
        titleElement.style.backgroundImage = 'url("' + imageUrl + '")';
        titleElement.classList.add('organiser_background');
    }
});

///////////END


//////ON TICKET BTN SHOW ONLY THE LOWEST PRICE 
jQuery(document).ready(function($) {
  // Select all spans within 'Get Tickets' buttons
  $('.event-actions span').each(function() {
    // Get the span text
    var text = $(this).text();

    // Match prices and extract the lowest price
    var prices = text.match(/£\d+\.?\d*/g);
    if (prices && prices.length) {
      var lowestPrice = prices[0]; // assuming the first one is the lowest

      // Update the span text to include only the lowest price
      // and wrap 'From' in a span with a class
      $(this).html('<span class="from-text">From</span> ' + lowestPrice);
    }
  });
});


















////TABS NAV

jQuery(document).ready(function($) {
  // Initially hide all content
  $('.organizer_events_content, .organizer_Gallery_content, .organizer_about_content').hide();

  // Function to remove active class from all items and hide their spans
  function resetActive() {
    $('.organizer_nav-item').removeClass('active').css('background-color', ''); // Reset background
    $('.organizer_nav-item span').hide(); // Hide all spans
  }

  // Click event for Events nav item
  $('.organizer_events').on('click', function() {
    resetActive();
    $(this).addClass('active').css('background-color', 'red'); // Set background to red for active
    $(this).find('span').show(); // Show span for this tab
    $('.organizer_events_content').show();
    $('.organizer_Gallery_content, .organizer_about_content').hide();
  });

  // Click event for Gallery nav item
  $('.organizer_Gallery').on('click', function() {
    resetActive();
    $(this).addClass('active').css('background-color', 'red');
    $(this).find('span').show(); // Show span for this tab
    $('.organizer_Gallery_content').show();
    $('.organizer_events_content, .organizer_about_content').hide();
  });

  // Click event for About nav item
  $('.organizer_about').on('click', function() {
    resetActive();
    $(this).addClass('active').css('background-color', 'red');
    $(this).find('span').show(); // Show span for this tab
    $('.organizer_about_content').show();
    $('.organizer_events_content, .organizer_Gallery_content').hide();
  });

  // Trigger the 'click' event on the first tab to set it as the default open tab
  $('.organizer_events').trigger('click');
});






////FUNCTION TO SHOW ANND HIDE THE LIVE EVENTS AND PAST

jQuery(document).ready(function($) {
    // Initially hide the past events and mark live events as active
    $('.past_event_listing_div').hide();
    $('.live_events_link').addClass('event_type_active');

    // When "Live Events" is clicked
    $('.live_events_link').click(function() {
        $('.past_event_listing_div').hide();
        $('.live_event_listing_div').show();
        $('.past_events_link').removeClass('event_type_active');
        $(this).addClass('event_type_active');
    });

    // When "Past Events" is clicked
    $('.past_events_link').click(function() {
        $('.live_event_listing_div').hide();
        $('.past_event_listing_div').show();
        $('.live_events_link').removeClass('event_type_active');
        $(this).addClass('event_type_active');
    });
});










//FUNCTION TO DISPLAY Gallery Category IMAGES 
document.addEventListener('DOMContentLoaded', function() {
    // const imageData = {
    //     'category1': [
    //         'https://thaynna-william.co.uk/wp-content/uploads/2024/01/jk-placeholder-image-1.jpg',
    //         'https://thaynna-william.co.uk/wp-content/uploads/2024/01/jk-placeholder-image-1.jpg',

    //     ],
    //     'category2': [
    //         'https://thaynna-william.co.uk/wp-content/uploads/2024/01/jk-placeholder-image-1.jpg',
    //     ],
       
    // };

    const galleryCategory = document.querySelector('.organizer_gallery_category');
    const galleryDisplayArea = document.getElementById('galleryDisplayArea');


	function displayImages(category) {
    // Create backButton with icon (SVG) and text
    const backButton = document.createElement('button');
    backButton.className = 'lightbox-back-button';

    // SVG for the back icon
    const backIconSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" width="79" height="69" viewBox="0 0 79 69" fill="none">
            <path d="M73.3483 29.4643H15.7033L33.3467 8.27265C34.1717 7.28007 34.5687 6.0004 34.4502 4.71517C34.3317 3.42993 33.7075 2.24441 32.7149 1.4194C31.7223 0.594395 30.4426 0.19748 29.1574 0.315977C27.8721 0.434474 26.6866 1.05868 25.8616 2.05126L1.55931 31.214C1.39581 31.446 1.2496 31.6897 1.12187 31.9431C1.12187 32.1861 1.12187 32.3319 0.781639 32.575C0.561332 33.1323 0.445981 33.7255 0.441406 34.3247C0.445981 34.924 0.561332 35.5172 0.781639 36.0745C0.781639 36.3175 0.781638 36.4633 1.12187 36.7064C1.2496 36.9598 1.39581 37.2035 1.55931 37.4354L25.8616 66.5982C26.3186 67.1469 26.8909 67.5881 27.5377 67.8905C28.1846 68.1929 28.8901 68.3491 29.6042 68.348C30.7398 68.3502 31.8404 67.9547 32.7149 67.2301C33.207 66.822 33.6139 66.3209 33.9121 65.7554C34.2103 65.1899 34.394 64.5711 34.4527 63.9345C34.5114 63.2979 34.4439 62.656 34.2541 62.0455C34.0643 61.435 33.756 60.8679 33.3467 60.3768L15.7033 39.1852H73.3483C74.6374 39.1852 75.8737 38.6731 76.7852 37.7616C77.6967 36.8501 78.2088 35.6138 78.2088 34.3247C78.2088 33.0357 77.6967 31.7994 76.7852 30.8879C75.8737 29.9764 74.6374 29.4643 73.3483 29.4643Z" fill="#231F20"/>
        </svg>
    `;
    backButton.innerHTML = backIconSVG;

    const backText = document.createTextNode('Back to Gallery');
    backButton.appendChild(backText);

    backButton.onclick = function() {
        galleryCategory.style.display = 'block';
        galleryDisplayArea.style.display = 'none';
    };

    // Clear previous content and add backButton
    galleryDisplayArea.innerHTML = '';
    galleryDisplayArea.appendChild(backButton);
    galleryDisplayArea.style.display = 'block';
    galleryCategory.style.display = 'none';

    // Create a container for images
    const imagesContainer = document.createElement('div');
    imagesContainer.className = 'images-container_main'; // Class for the container

    // Iterate over each image in the category and add to the container
    imageData[category].forEach(imageSrc => {
        const img = document.createElement('img');
        img.src = imageSrc;
        img.style.width = '100%';
        img.style.height = 'auto';
        img.style.margin = '10px 0';
        img.style.maxWidth = '350px';
        img.setAttribute("data-category", category);

        const imageDiv = document.createElement('div');
        imageDiv.className = 'image-container'; // Class for individual image div
        imageDiv.appendChild(img);
        imagesContainer.appendChild(imageDiv);
    });

    // Append the container with images to galleryDisplayArea
    galleryDisplayArea.appendChild(imagesContainer);
}




    document.querySelectorAll('.organizer_gallery_category_inner').forEach(categoryDiv => {
        categoryDiv.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            displayImages(category);
        });
    });
});


function createLightbox(imageSrc, category) {
        // Create lightbox elements
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        document.body.appendChild(lightbox);

        const img = document.createElement('img');
        img.src = imageSrc;
        img.className = 'lightbox-image';
        lightbox.appendChild(img);

        const closeButton = document.createElement('button');
        closeButton.textContent = 'X';
        closeButton.className = 'lightbox-close';
        lightbox.appendChild(closeButton);

        const prevButton = document.createElement('span');
        prevButton.className = 'prev-image';
        prevButton.innerHTML = '<';
        prevButton.onclick = function() {
            console.log("Previous button clicked!");
            imgSrc = document.querySelector('.lightbox-image').getAttribute('src');
            index = imageData[category].indexOf(imgSrc);
            length = imageData[category].length - 1

            nextIndex = ( index - 1 )  < 0 ? length : index - 1;
            nextImgSrc = imageData[category][nextIndex]
            lightboxImage = document.querySelector('.lightbox-image');
            lightboxImage.src = nextImgSrc;
            currentDownload = document.querySelector('.lightbox-download');
            currentDownload.href = nextImgSrc;
            currentDownload.download = nextImgSrc.split('/').pop(); // Extract filename from URL
        };
        lightbox.appendChild(prevButton);

        const nextButton = document.createElement('span');
        nextButton.className = 'next-image';
        nextButton.innerHTML = '>';
        nextButton.onclick = function() {
            console.log("Previous button clicked!");
            imgSrc = document.querySelector('.lightbox-image').getAttribute('src');
            index = imageData[category].indexOf(imgSrc);
            length = imageData[category].length - 1

            nextIndex = ( index + 1 )  > length ? 0 : index + 1;
            nextImgSrc = imageData[category][nextIndex]
            lightboxImage = document.querySelector('.lightbox-image');
            lightboxImage.src = nextImgSrc;
            currentDownload = document.querySelector('.lightbox-download');
            currentDownload.href = nextImgSrc;
            currentDownload.download = nextImgSrc.split('/').pop(); // Extract filename from URL
        };
        lightbox.appendChild(nextButton);

        const downloadButton = document.createElement('a');
        downloadButton.href = imageSrc;
        downloadButton.download = imageSrc.split('/').pop(); // Extract filename from URL
        downloadButton.textContent = 'Download';
        downloadButton.className = 'lightbox-download';
        lightbox.appendChild(downloadButton);

        // Close lightbox on click outside the image or on the close button
        lightbox.addEventListener('click', function(e) {
            if (e.target !== img && e.target !== downloadButton && e.target !== prevButton && e.target !== nextButton) {
                lightbox.remove();
            }
        });

        closeButton.addEventListener('click', function() {
            lightbox.remove();
        });
    }

    galleryDisplayArea.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG') {
            createLightbox(e.target.src , e.target.getAttribute('data-category'));
        }
    });










///FUNCTION TO GET THE EVENT IMAGE AND USE AS A BACKEND IMAGE ON THE DIV CONTAISN 
jQuery(document).ready(function($) {
    console.log('Document ready, processing event images...');

    $('.event-card .event-image').each(function(index) {
        var $eventImageDiv = $(this); // Cache the current event image div
        console.log('Processing event image div #' + (index + 1));

        var $image = $eventImageDiv.find('img.wp-post-image');
        if ($image.length > 0) {
            var imgSrc = $image.attr('src'); // Get the image source from .wp-post-image
            console.log('Image source for event image div #' + (index + 1) + ':', imgSrc);

            // Create a new div for the blurred background image
            var blurredBackground = $('<div></div>').css({
                'position': 'absolute',
                'top': '0px',
                'left': '0px',
                'width': '100%',
                'height': '100%',
                'background-image': 'url(' + imgSrc + ')',
                'background-size': 'cover',
                'background-position': 'center center',
                'filter': 'blur(40px)',
                'z-index': '0' // Ensure the blurred background is behind everything
            });

            // Prepend the blurred background div to the .event-image div
            $eventImageDiv.prepend(blurredBackground);

            // Create a new div for the dark overlay if it doesn't already exist
            if ($eventImageDiv.children('.dark-overlay').length === 0) {
                var darkOverlay = $('<div class="dark-overlay"></div>').css({
                    'position': 'absolute',
                    'top': '0px',
                    'left': '0px',
                    'width': '100%',
                    'height': '100%',
                    'background-color': 'rgba(0, 0, 0, 0.3)',
                    'z-index': '1' // Ensure the dark overlay is above the blurred background but below the original image
                });

                // Insert the dark overlay div just after the blurred background div
                $eventImageDiv.prepend(darkOverlay);
                console.log('Dark overlay added to event image div #' + (index + 1));
            }

            // Ensure the .event-image div is positioned relatively to contain the absolute positioned children
            $eventImageDiv.css({
                'position': 'relative',
                'overflow': 'hidden' // Hide any overflow from the blur effect
            });

            // Keep the original image on top without modifying its z-index
            $image.css({
                'position': 'relative',
                'z-index': '2' // Ensure the original image is above the overlay and the blurred background
            });
        } else {
            console.log('No .wp-post-image found in event image div #' + (index + 1));
        }
    });
});

</script>









<style>
    .event-day , .event-month , .event-title , .event-title a,  .event-actions , .event-actions span , .event-location , .event-time
{
    color: black!important;

}
span.prev-image {
    padding: 10px 20px;
    font-size: 32px;
    cursor: pointer;
    position: absolute;
    left: 0;
}
span.next-image {
    padding: 10px 20px;
    font-size: 32px;
    cursor: pointer;
    position: absolute;
    right: 0;
}

span.prev-image:hover, span.next-image:hover{
    background-color: #3f4047;
}
 /*****organiser dashboard font-end ***/
 .tribe-events-view{
    background:inherit!important
 }
 .single-tribe_organizer  .tribe-events-header{
margin: 0;
padding: 1px;
 }
 .main_custom_container{
    display: flex;
}
.organiser_dashboard_link{
    flex: 0 20%;
}
.organiser_dashboard_link{

    flex: 0 80%; 
}

 /****END***/
 



 /*****organiser profile**/
 .organizer_profile_main_div_all h2{
   
 }
 .organiser_background {
    background-size:   cover;
background-position: center top;
    background-repeat: no-repeat!important;
    position: relative;
    z-index: 2;
    overflow-x: hidden!important;
    width: 100%;
}
.event-listing h3{
    display: none;
}
.event-listing{
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}
.organiser_background:before {
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
    width: 100%;
}

.single-tribe_organizer .tribe-events-header__content-title , .single-tribe_organizer  .tribe-events-header__top-bar , .single-tribe_organizer  .tribe-events-calendar-list , .single-tribe_organizer .tribe-events-calendar-list-nav , .single-tribe_organizer  .tribe-events-c-subscribe-dropdown__container , .organizer-events h3 , .single-tribe_organizer .tribe-events-header__title-text , .single-tribe_organizer .tribe-events-c-breadcrumbs__list{
    display: none!important;
}
.tribe-events-view--organizer .tribe-common-l-container{
    padding-top: 5px!important;
}
.organizer_profile_bk_img{
    border-radius: 6px;
}


.single-tribe_organizer  .image_profile_text_main_continer img{
    border-radius: 100px;
    max-width: 200px;
    width: 100%;
    border: 5px solid white;
}
.single-tribe_organizer  .image_profile_text_main_continer .tribe-events-pro-organizer__meta-featured-image-wrapper {
width: fit-content!important;
}

.single-tribe_organizer  .image_profile_text_main_continer a{
    max-width: 200px;
}
.single-tribe_organizer .image_profile_text_main_continer{
    display: flex;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 27px;
    margin-top: -67px;
    margin-bottom: 20px;
    width: 100%;
}
.single-tribe_organizer  .tribe-events-pro-organizer__meta .tec-events-c-view-box-border {
    display: flex;
    flex-wrap: wrap;
    width: 100%!important;
    flex-direction: column;
    align-content: flex-start;
    gap: 22px;
}
.event-card{
    flex: 0 1 calc(33.33% - 10px);
    margin: 5px;
    max-width: calc(33.33% - 10px);
    background-color: #262626;
    border-radius: 10px;
    color: rgb(255, 255, 255);
}
.event-card .event-title{
    color: rgb(255, 255, 255)!important;
    text-decoration: none;
    font-size:16px

}

.event-card .event-details{
 
    padding: 9px 20px 24px;
    padding: 9px 13px;
    height: fit-content;
    background: white;
    color: black!important;


}

.event-title{
    line-height: 20px;
    font-size: 18px;
    font-weight: 800;
}
.event-title a{
    text-decoration: none;
}
.event-month{
    font-weight: 400;
    font-size: 15px;
}

.event-date{
    font-size: 20px;
    font-weight: 800;
}
.event-time-location{
    display: flex;
    flex-direction: column;
    font-size: 15px;
    margin: 5px 0px;
    margin-top: 5px!important;

}

.event-actions a{
    text-decoration: none;
    background-color: #FFD700;
    color: black!important;
    padding: 4px 15px;
    font-size: 14px;
    border-radius: 5px;
    padding: 8px 5px;
    width: 100%;
    display: block;
    text-align: center;
    margin-top: 0px;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
    gap: 6px;
}
.event-actions a:hover{
    background-color: #ffffff;
  
}
.event-actions{
    display: flex;
    flex-direction: row;
    align-items: center;
    align-content: center;
    justify-content: flex-start;
    margin-top: 10px!important;
    gap: 10px!important;
}
.event-actions span{
    white-space: nowrap;
    font-weight: 800;
}
.btn-get-tickets img{
    max-width: 23px;
    position: relative;
    top: 0px;
}
.event-location{
    text-transform: capitalize!important;
}






.event-card {
  overflow: hidden; /* Optional: In case of rounded corners to contain the image */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: For a slight shadow effect */
}

.event-image img {
    height: 200px;
    max-height: 220px;
    margin: auto;
    object-fit: contain;
    display: flex;

}

.event-details {
    flex: 1; 
    height: 100%; 
    display: flex!important;
    flex-direction: column;
}
.from-text{
    font-size: 13px!important;
    font-weight: 400!important;
}
.organizer_navbar{
    background-color: #2C2C2C;
    display: flex;
    justify-content: space-around;
    align-content: center;
    padding: 0 20px!important;
    width: 100%;
    align-items: center;
    border-radius: 8px;
    margin: 0 auto!important;
}
.organizer_nav-item{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 13px 20px!important;
}
.profile_icon_nav{
    max-width: 25px!important;
}


.organizer_events_content, .organizer_Gallery_content , .organizer_about_content{
    display: none;
}
.organizer_nav-item.active {
    background-color: #767676!important;
}
.organizer_nav-item {
    transition: background-color 0.2s ease; 
}

.organizer_nav-item:hover {
    background-color: #767676; 
    cursor: pointer;
}


.organizer_nav-item.active {
    background-color: #767676; 
    transition: background-color 0.2s ease;
}


.past_event_listing_div {
    display: none;
}
.live_event_listing_div {
    display: block;
}

.event-listing_type{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    gap: 20px;
    font-size: 19px;
    margin-bottom: 21px!important;
    font-weight: 400;
}

.event_type_active{
    text-decoration: underline;
    font-weight: 700!important;
    
}
.event-listing_type p{
    cursor: pointer;
}
.organizer_gallery_category_inner_image{
    max-width: 300px!important;

}
.organizer_gallery_category_inner {
    position: relative;
    display: inline-block;
    overflow: hidden;
    cursor: pointer;
}

.organizer_gallery_category_inner::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); 
    z-index: 1;
}

.organizer_gallery_category_inner img {
    display: block; 
    width: 100%; 
    height: auto;
    max-width: 300px!important;
    border-radius: 6px;
}


.organizer_gallery_category{
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
}
/* Hover effects */
.organizer_gallery_category_inner:hover::after {
    background: rgba(0, 0, 0, 0); /* Remove overlay */
    transition: opacity 0.1s ease;
}

.organizer_gallery_category_inner:hover .organizer_gallery_category_inner_title {
    opacity: 0;
}
.organizer_gallery_category_inner_title{
    position: absolute!important;
    bottom: 0!important;
    padding: 0 14px 12px 14px!important;
    font-size: 16px!important;
    font-weight: 400!important;
    position: relative;
    z-index: 2; /* Ensures the title is above the overlay */
    transition: opacity 0.1s ease;
}
.organizer_gallery_category{
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;

}
.images-container_main{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 12px;
}
#galleryDisplayArea button{
    background-color: white;
    color: black;
    font-size: 14px;
    padding: 5px 15px;
    border-radius: 6px;
    margin-bottom: 25px;

    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 11px;
}
.lightbox-back-button svg{

    max-width: 17px;
    max-height: 16px;
}

.organizer_about_main_inner_social img {
    width: 30px; 
    height: 30px;
    margin-right: 10px;
}


.organizer_about_main_inner_social .fa {
    font-size: 30px; /* Adjust icon size as needed */
    margin-right: 10px;
}
.organizer_text_dec p{
    text-transform: capitalize!important;
}


.organizer_main_div h3{
padding-bottom: 15px;
font-size: 26px;
font-weight: 600;
}
.organizer_about_content h3{
    padding-bottom: 0!important 
}




.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.lightbox-image {
    max-width: 80%;
    max-height: 80%;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 30px;
    color: white;
    background: none;
    border: none;
    cursor: pointer;
}

.lightbox-download {
    position: absolute;
    bottom: 0px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    background-color: white;
    color: black!important;
    font-size: 15px;
    padding: 4px;
    border-radius: 10px;
    width: 100%;
    max-width: 167px;
    text-align: center;
}
.image-container {
    position: relative;
    cursor: pointer;
}

.image-container:hover img {
    opacity: 0.9;
}


.image-container::after {
    content: '';
    background: url('https://thaynna-william.co.uk/wp-content/uploads/2024/01/expand.png') no-repeat center center;
    background-size: cover; /* Adjust as needed */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px; /* Adjust the size of the icon as needed */
    height: 30px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.image-container:hover::after {
    opacity: 1; /* Show icon on hover */
}
.single-tribe_organizer .image_profile_text_main_continer img {
    border-radius: 100px;
    max-width: 200px;
    width: 200px;
    height: 200px;
    object-fit: cover;
}

.organizer_about_main_inner{
    text-align: center;
    max-width: 900px;
    margin: 0 auto!important;
    display: flex;
    flex-direction: column;
    gap: 25px;
}
.organizer_title_name h1{
    padding-bottom: 8px;
}

.tribe-events-header__breadcrumbs{
    display: none;
}


  /****media responsive ***/
  @media (min-width: 840px) {

    .organizer_profile_bk img{
        max-height: 470px;
        width: 1400px;
        object-fit: cover;
    }
    
    
}





@media (max-width: 839px) {

    .organizer_profile_bk img{
        max-height: 650px;
        width: 100%;
        object-fit: cover;
    }
    
    
}






@media (max-width: 1000px) {
    .single-tribe_organizer .image_profile_text_main_continer img {
        border-radius: 100px;
        max-width: 160px;
        width: 160px;
        height: 160px;
        object-fit: cover;
        border: 5px solid white;
    }
    .organizer_about_main_inner {
        max-width: inherit;
    }
    
}




@media (max-width: 750px) {
  .tribe-events-pro .tribe-events-pro-organizer__meta .tec-events-c-view-box-border {
 
    padding-left: 0;
    padding-right: 0;
}
.organizer_navbar span{
    font-size: 14px;
}
    
}

@media (max-width: 550px) {
 
    .single-tribe_organizer .image_profile_text_main_continer img {
        border-radius: 100px;
        max-width: 106px;
        width: 106px;
        height: 106px;
        margin-bottom: -3px;
        border: 3px solid white;
        object-fit: cover;
    }
    .single-tribe_organizer .image_profile_text_main_continer {
        margin-top: -52px;
        gap: 2px;
        flex-direction: column;

    }
    .organizer_title_name{
        position: relative;
        top: 2px;
    }
   /* Hide all .organizer_nav-item span elements by default */
.organizer_nav-item span {
    display: none;
}

/* Show span only when .organizer_nav-item has class 'active' */
.organizer_nav-item.organizer_events.active span {
    display: block;
}

    .organizer_nav-item  img{
        max-width: 21px;
    }
    .profile_icon_nav {
        max-width: 17px!important;
    }
    .images-container_main {
      
        display: grid!important;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 3px;
    }
   
.single-tribe_organizer .image_profile_text_main_continer {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2)!important;
    padding-bottom: 28px;
    margin-bottom: 6px;
    
}
.organizer_nav-item {

    padding: 7px 17px!important;
}
.organizer_gallery_category {
    gap: 9px;
}
.organizer_tagline{
    line-height: 18px;
    font-size: 15px;
}
.organizer_title_name h1 {
    padding-bottom: 1px;
    font-size: 24px;
}
.organizer_gallery_category_inner img {
    max-width: 100%!important;
}
.event-listing_type {
    gap: 14px;
    font-size: 13px;
}
.tribe-common .tribe-common-l-container  {
    padding-left: 0!important;
    padding-right: 0!important;
}
.organizer_about_main_inner_text p{
    font-size: 15px;
}
.tribe-events-pro .tribe-events-pro-organizer__meta .tec-events-c-view-box-border {

    padding-left: 15px!important;
    padding-right: 15px!important;
}
.organizer_title_name{
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
    gap: 5px;

}
.organizer_profile_bk img{
    border-radius: 0;
}

#galleryDisplayArea button {
   
    font-size: 14px;
    padding: 2px 9px;
    margin-bottom: 21px;
    font-size: 12px;
}.lightbox-back-button svg {
    max-width: 12px;
    max-height: 12px;
}
.image-container img{
    margin: 0;
}
.organizer_navbar {
  
    border-radius: 0px;
    margin: 0 auto!important;
    position: fixed;
    bottom: 0;
    left: 0;
    height: 65px;
    border-top: 2px solid white!important;
    z-index: 3;
    padding: 10px 20px!important;

}
.organizer_nav-item.active {
    background: rgba(255, 163, 0, 0.40)!important;
    border-radius: 20px;
}
.organizer_nav-item.organizer_events.active span {
    font-size: 13px;
}
.organizer_nav-item{
    gap: 5px; 
    padding: 4px 13px!important;
}
.organizer_main_div h3{
    font-size: 23px;
    }
}
  /****END***/


@media (max-width: 390px) {
 
  
    .single-tribe_organizer .image_profile_text_main_continer img {
        max-width: 88px;
        height: 88px;
        width:88px;
        object-fit: cover;
    
    }
    }






    </style>