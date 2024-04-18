<?php
// Don't load directly
defined( 'WPINC' ) || die;

/**
 * My Events List Template
 * The template for a list of a users events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/event-list.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 2.1
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */


 $events_label_plural_lowercase = 'events'; // Assign a default value

$columns = tribe_community_events_list_columns();
/**
 * Allows filtering for which columns cannot be hidden by users
 *
 * @param array $blocked
 */








// Assuming you have the current user's ID
?>
<div class="admin_dashboard_event_list_nav">


<div class="main_custom_container_second">
<h2 class="tribe-community-events-list-title"><?php echo esc_html__( 'My Events', 'tribe-events-community' ); ?></h2>

<a
	class="tribe-button tribe-button-primary add-new"
	href="/organizer-new-event/">Create New Event
</a>
</div>
</div>
<div class="summary_tabs_my_events_main">
    <div class="summary_tabs_my_events_main_inner">
        <?php echo do_shortcode('[todays_sales]'); ?>
        <?php echo do_shortcode('[todays_tickets_sold]'); ?>
      
        <?php echo do_shortcode('[revenue]'); ?>
    </div>
    
</div>
</div>

<?php

$blocked_columns = apply_filters( 'tribe_community_events_list_columns_blocked', [ 'title' ] );
?>

<div class="admin_dashboard_event_list_nav_lower">


<div class="admin_dashboard_event_lis_search_filter">

<div class="admin_dashboard_event_list_nav_lower_inner">
    <span for="filter-events">Sort by:</span>
    <select name="filter-events" id="filter-events">
    <option value="all" selected>All Events</option>
    <option value="upcoming">Upcoming Events</option>
        <option value="published">Published Events</option>
        <option value="draft">Draft Events</option>
        <option value="past">Past Events</option>
    </select>
</div>

<div class="tribe-event-list-search">

	<form role="search" method="get" class="tribe-search-form" action="">
		<div>
			<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'tribe-events-community' ); ?></label>
			<input type="search" value="<?php echo isset( $_GET['event-search'] ) ? esc_attr( $_GET['event-search'] ) : ''; ?>" name="event-search" placeholder="<?php esc_attr_e( 'Search Event Titles', 'tribe-events-community' ); ?>" />
			<input type="hidden" value="<?php echo empty( $_GET['eventDisplay'] ) ? 'list' : esc_attr( $_GET['eventDisplay'] ); ?>" name="eventDisplay">
			<input type="submit" id="search-submit" value="Search"/>
		</div>
	</form>
</div>
</div>

</div>

<?php
/**
 * Allow developers to hook and add content to the begining of this section of content
 */
do_action( 'tribe_community_events_before_list_navigation' );
?>


<div class="tribe-nav tribe-nav-top">
	<div class="my-events-display-options ce-top">
		<?php tribe_community_events_prev_next_nav(); ?>
	</div>
	<div class="table-menu-wrapper ce-top">
		<?php if ( $events->have_posts() ) : ?>
			<a
				class="table-menu-btn button tribe-button tribe-button-tertiary tribe-button-activate"
				href="#"
			>
				<?php echo apply_filters( 'tribe_community_events_list_display_button_text', __( 'Display Option', 'tribe-events-community' ) ); ?>
			</a>
		<?php endif; ?>

		<?php
		/**
		 * Allow developers to hook and add content to the end of this section of content
		 */
		do_action( 'tribe_community_events_after_list_navigation_buttons' );
		?>

		<div class="table-menu table-menu-hidden">
			<ul>
				<?php foreach ( $columns as $column_slug => $column_label ) : ?>
					<?php $i = array_search( $column_slug, array_keys( $columns ) ); ?>
					<li>
						<label
							class="<?php echo sanitize_html_class( in_array( $column_slug, $blocked_columns ) ? 'tribe-hidden' : '' ) ?>"
							for="<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
						>
							<input class="tribe-toggle-column" type="checkbox" id="<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"  checked />
							<?php echo esc_html( $column_label ); ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php // list pagination
	echo tribe_community_events_get_messages();
	echo $this->pagination( $events, $paged, $this->paginationRange );
	?>
</div>

<?php
/**
 * Allow developers to hook and add content to the begining of this section of content
 */
do_action( 'tribe_community_events_before_list_table' );
?>

<?php if ( $events->have_posts() ) : ?>
	<div class="tribe-responsive-table-container">
		<table
			id="tribe-community-events-list"
			class="tribe-community-events-list my-events display responsive stripe"
		>
			<thead>
			
    <th class="event-column">
        Event
    </th>
    <th class="tickets-passcode-column">
        Ticket Passcode
    </th>
    <th class="tickets-sold-column">
        Ticket Sold
    </th>
    <th class="gross-column">
        Gross
    </th>
    <th class="status-column">
     
        <span class="action_normal_llist">Status</span>
       <span class="payout_stutes">Payout Status</span>
    </th>
    <th class="status-column">
       Action
       
    </th>
</tr>

			</thead>

			<tbody>
				
    <?php while ( $events->have_posts() ) : $events->the_post(); ?>
        <tr class="<?php echo sanitize_html_class( 1 === $events->current_post % 2 ? 'odd' : '' ); ?>">
            <?php foreach ( $columns as $column_slug => $column_label ) : ?>
				
                <td
                    data-depends="#<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
                    data-condition-is-checked
                    class="tribe-dependent tribe-list-column <?php echo sanitize_html_class( 'tribe-list-column-' . $column_slug ); ?>"
                >
                    <?php   
                     

                    if ( 'title' === $column_slug ) {
                        // Display the event image
                        if ( has_post_thumbnail() ) {
                            echo get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
                        }
                        // Display the title or other column content
                        tribe_get_template_part( 'community/columns/' . sanitize_key( $column_slug ), null, [
                            'column_slug' => $column_slug,
                            'column_label' => $column_label,
                            'event' => $events->post,
                        ] );
                    } else {
                       
                        // Display other columns as usual
                        tribe_get_template_part( 'community/columns/' . sanitize_key( $column_slug ), null, [
                            'column_slug' => $column_slug,
                            'column_label' => $column_label,
                            'event' => $events->post,
                        ] );
                    }
                 
                    if ( 'status' === $column_slug ) {
                        $event_id = get_the_ID();
                        $event_pass = get_post_meta($event_id, 'event_pass', true);
                        echo "</td><td class='tribe-list-column-passcode'><span class='passcode'>$event_pass</span>";
                    }
                    
                    ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endwhile; ?>
</tbody>
		</table>
	</div>
<?php else : ?>
	<div class="tribe-community-events-list tribe-community-no-items">
    <?php
    if ( isset( $_GET['eventDisplay'] ) && 'past' === $_GET['eventDisplay'] ) {
        $text = esc_html__( 'You have no past %s', 'tribe-events-community' );
    } else {
        $text = esc_html__( 'You have no upcoming %s', 'tribe-events-community' );
    }
    echo sprintf( $text, $events_label_plural_lowercase );
    ?>
</div>
<?php endif; ?>

<?php
/**
 * Allow developers to hook and add content to the end of this section of content
 */
do_action( 'tribe_community_events_after_list_table' );
?>

<div class="tribe-nav tribe-nav-bottom">
	<?php
	echo tribe_community_events_get_messages();
	echo $this->pagination( $events, '', $this->paginationRange );
	?>
</div>

</div>



<script type="text/javascript">


//FUNCTION TO ADD CLASS TO THE STATUS SECTION
function updateDropdownStyle() {
    var select = document.querySelector('.event-status-form select[name="event_status"]');
    select.className = ''; // Clear previous classes
    if (select.value === 'draft') {
        select.classList.add('status-draft');
    } else if (select.value === 'publish') {
        select.classList.add('status-publish');
    }
}

document.addEventListener('DOMContentLoaded', updateDropdownStyle);






//FUNCTION TO ADD THE CLICK EVENT TO THE ACTION
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



///FUNCTION TO REMOVE THE "|" FROM THE EVENT SEDIT SECTION 
jQuery(document).ready(function($) {
    setTimeout(function() {
        $('.row-actions').contents().filter(function() {
            // Target only text nodes containing the vertical bar
            return this.nodeType === 3 && $.trim(this.nodeValue) === '|';
        }).remove();
    }, 1000); // Delay of 1000 milliseconds (1 second)
});


jQuery(document).ready(function($) {
    // Target the specific span element and modify its HTML content
    $('.delete.wp-admin.events-cal').html(function(index, html) {
        // Replace the first occurrence of '|' with an empty string
        return html.replace('|', '');
    });
});


</script>


<script>


//FUNCTION FOR THE ACTION BUTTON DROPDOWN 
function updateDropdownStyle() {
    // Select all dropdowns with the specific class
    var selects = document.querySelectorAll('.event-status-form select[name="event_status"]');
    
    // Loop through each select element
    selects.forEach(function(select) {
        select.className = ''; // Clear previous classes
        if (select.value === 'draft') {
            select.classList.add('status-draft');
        } else if (select.value === 'publish') {
            select.classList.add('status-publish');
        }
    });
}

// Apply the style update on page load
document.addEventListener('DOMContentLoaded', updateDropdownStyle);

// Apply the style update every time a dropdown changes its value
document.querySelectorAll('.event-status-form select[name="event_status"]').forEach(function(select) {
    select.addEventListener('change', updateDropdownStyle);
});


</script>










<script>



// FUNCTION FOR THE SORT BY BUTTON
jQuery(document).ready(function($) {

$('#filter-events').on('change', function() {
    var selectedValue = $(this).val();

    // Function to check if the event date is in the past
    function isPastEvent(eventDateElem) {
        var day = parseInt(eventDateElem.find('.start-date-day .value').text());
        var month = eventDateElem.find('.start-date-month .value').text();
        var year = parseInt(eventDateElem.find('.start-date-year .value').text());

        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var monthNumber = monthNames.indexOf(month) + 1;

        var eventDate = new Date(year, monthNumber - 1, day);
        var today = new Date();
        today.setHours(0,0,0,0);

        return eventDate < today;
    }

    // Function to check if the event date is in the future
    function isUpcomingEvent(eventDateElem) {
        var day = parseInt(eventDateElem.find('.start-date-day .value').text());
        var month = eventDateElem.find('.start-date-month .value').text();
        var year = parseInt(eventDateElem.find('.start-date-year .value').text());

        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var monthNumber = monthNames.indexOf(month) + 1;

        var eventDate = new Date(year, monthNumber - 1, day);
        var today = new Date();
        today.setHours(0,0,0,0);

        return eventDate >= today;
    }

    var rows = $('#tribe-community-events-list tbody tr');
    rows.hide();

    // Apply filter based on selected value
    rows.each(function() {
        var row = $(this);
        var status = row.find('.event-status-form select').val();
        var eventDateElem = row.find('.event-start-date');

        if (selectedValue === 'published' && status === 'publish') {
            row.show();
        } else if (selectedValue === 'draft' && status === 'draft') {
            row.show();
        } else if (selectedValue === 'past' && isPastEvent(eventDateElem)) {
            row.show();
        } else if (selectedValue === 'upcoming' && isUpcomingEvent(eventDateElem)) { // Added condition for upcoming events
            row.show();
        } else if (selectedValue === 'all') {
            row.show();
        }
    });

});
});

</script>


<style>

.table-menu-hidden{
display:none
}
.tribe-button, a.tribe-button, button.tribe-button, input.tribe-button {
    border-radius: 3px;
    line-height: 1;
    margin: 0px;
    padding: 9px 12px;
    font-size: 15px;
}
.main_custom_container_second{
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 30px;  
}
.tribe-community-events-list-title{
    margin-bottom:0!important
}
</style>    

