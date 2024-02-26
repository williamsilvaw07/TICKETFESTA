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



// Get the ID of the organizer
$organizer_id = $organizer->ID;

// Set up the arguments for WP_Query
$args = array(
    'post_type'      => 'tribe_events', // The Events Calendar post type
    'posts_per_page' => -1, // Retrieve all events
    'post_status'    => 'publish', // Only published events
    'meta_query'     => array(
        array(
            'key'   => '_EventOrganizerID', // Meta key for the organizer ID
            'value' => $organizer_id, // The actual organizer ID
        ),
    ),
    'orderby' => 'meta_value', // Order by meta value (event start date)
    'meta_key' => '_EventStartDate', // Meta key for event start date
    'order' => 'ASC', // Order ascending (earliest first)
    // Custom 'date_query' to include all events regardless of date
    'date_query' => array(
        'inclusive' => true // Include all dates
    ),
);

// Perform the query
$organizer_events = new WP_Query($args);

// Count the number of events
$event_count = $organizer_events->found_posts;

// Reset post data
wp_reset_postdata();



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

<div class="organizer_profile_main_div">

    <!-- Background Wrapper with Overlay -->
    <div class="organizer_profile_bk_wrapper">
        <div class="organizer_profile_bk" style="
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
        } else {
            // Use default image if no specific image is set
            $banner_image_url = '/wp-content/uploads/2024/02/antoine-j-r3XvSBEQQLo-unsplash-2-min.jpg';
        }
        echo 'background-image: url(' . esc_url($banner_image_url) . ');';
        ?>
        background-size: cover; background-position: center;">
        </div>
        <div class="glass_effect_overlay"></div>
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
    $follower_text = 'following';
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
			<p class="organizer_tagline"></p>

            <div class="organizer_text_dec_info">

			<p class="followers">Followers <span class="followers-count"><?php echo $follower_count;?></span> </p>
            <span class="spancer"></span>
            <p class="organizer_event_count">Total events<span class="event-count"><?php echo $event_count; ?></span> </p>
       

        </div>
        <form method="POST">
            <input type="hidden" name="follow" value="<?php echo $follower_text;?>">
            <input type="submit" value="<?php echo ucfirst($follower_text); ?>" nanme="submit" class="follow-button"> 
        </form>
</div>
<?php 

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( isset( $_POST['follow'] ) ) {
        if (!is_user_logged_in() )  {
            // $my_account_url = esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));
            // echo "<a href='$my_account_url' class='login-first'> Please login first. </a>" ;

            $shortcode = '[xoo_el_action type="login" display="button"]';

            // Execute the shortcode
            echo do_shortcode( $shortcode );
        }
    } 
}
?>
</div>
<!-- organizer name end -->
</div>
</div>
</div>

<!-- organizer profile nav -->
<div class="organizer_navbar">
	<div class="organizer_nav-item organizer_events">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/calendar-1.png" alt="Events Icon" class="organizer_nav-icon" width="21">
	  <span>Events</span>
	</div>
	<div class="organizer_nav-item organizer_Gallery">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/image-gallery-1.png" alt="Gallery Icon" class="organizer_nav-icon" width="21">
	  <span>Gallery</span>
	</div>
	<div class="organizer_nav-item organizer_about">
	  <img src="https://thaynna-william.co.uk/wp-content/uploads/2023/12/user-1-1.png" alt="About Icon" class="organizer_nav-icon profile_icon_nav" width="21">
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
    <div class="past_event_listing_div">
        <div class="event-listing">
            <?php
            $current_organizer_id = get_the_ID(); // Get the current organizer ID
            $current_time = current_time('Y-m-d H:i:s');

            // Query for past events
            $past_events_args = array(
                'post_type' => 'tribe_events',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_EventEndDate',
                        'value' => $current_time,
                        'compare' => '<',
                        'type' => 'DATETIME',
                    ),
                    array(
                        'key' => '_EventOrganizerID',
                        'value' => $current_organizer_id,
                        'compare' => '=',
                    ),
                ),
                'orderby' => 'meta_value',
                'meta_key' => '_EventEndDate',
                'order' => 'DESC',
            );

            $past_events = new WP_Query($past_events_args);

            if ($past_events->have_posts()) :
                while ($past_events->have_posts()) : $past_events->the_post();
                    include 'single-event-card.php'; // Include the event card template
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No past events found.</p>';
            endif;
            ?>
        </div>
    </div>
    <!-- End Event past -->

    <!-- Event live -->
    <div class="live_event_listing_div">
        <div class="event-listing">
            <?php
            // Query for live events
            $live_events_args = array(
                'post_type' => 'tribe_events',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_EventOrganizerID',
                        'value' => $current_organizer_id,
                        'compare' => '=',
                    ),
                    array(
                        'key' => '_EventEndDate',
                        'value' => $current_time,
                        'compare' => '>=',
                        'type' => 'DATETIME',
                    ),
                ),
                'orderby' => 'meta_value',
                'meta_key' => '_EventStartDate',
                'order' => 'ASC',
            );

            $live_events = new WP_Query($live_events_args);

            if ($live_events->have_posts()) :
                while ($live_events->have_posts()) : $live_events->the_post();
                    include 'single-event-card.php'; // Include the event card template
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No live events found.</p>';
            endif;
            ?>
        </div>
    </div>
    <!-- End Event live -->
</div>
<!-- End Event LISTING -->









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
            $attachment_src = wp_get_attachment_image_src($attachment_id, 'large')[0];
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









	






