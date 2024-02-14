<?php
// Assuming this code is inside a loop or a function where $event is defined
$event_id = $event->ID;
$tickets = Tribe__Tickets__Tickets::get_all_event_tickets($event_id);
$gross_income = 0; // Initialize gross income

$post_status = $event->post_status;
$status_label = get_post_status_object($post_status);
$nonce = wp_create_nonce('delete_event_' . $event_id);
?>
<div class="admin_view_more_setting">
    <!-- Dropdown Button -->
    <div class="dropdown">
        <button onclick="toggleDropdown('dropdown-<?php echo $event_id; ?>')" class="dropbtn">&#8942;</button> <!-- Three vertical dots -->
        <!-- Dropdown Content -->
        <div id="dropdown-<?php echo $event_id; ?>" class="dropdown-content">
            <a href="<?php echo esc_url(home_url('/event/' . $event->post_name)); ?>" target="_blank">View</a>
            <a href="<?php echo esc_url(home_url('/organizer-edit-event/?event_id=' . $event_id)); ?>">Edit Event</a>
            <a onclick="deleteEvent(event)" data-nonce="<?php echo $nonce; ?>" data-event_id="<?php echo $event_id; ?>" href="<?php echo esc_url(home_url('/events/organizer/delete/' . $event_id . '/?_wpnonce=' . $nonce)); ?>">Delete</a>
            <a href="<?php echo esc_url(home_url('/organizer-sales-report/?event_id=' . $event_id)); ?>">Sales</a>
            <a href="<?php echo esc_url(home_url('/organizer-attendees-report/?event_id=' . $event_id)); ?>">Attendees</a>

           
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	function deleteEvent(e) {
			e.preventDefault();
			if ( ! $( e.target ).data( 'event_id' ) ) {
				return false;
			}

			if ( ! confirm( "Are you sure you want to delete this event? This cannot be undone!" ) ) {
				return false;
			}

			var target = e.target;
			// do the ajax thing
			var event_id = target.dataset.event_id;
			var nonce = target.dataset.nonce;
			var $parent_row = $( target.closest( 'tr' ) );
			var recurring = target.dataset.recurring;

			$.ajax({
				url: TEC.ajaxurl,
				method: 'GET',
				data: {
					action: 'tribe_events_community_delete_post',
					nonce: nonce,
					id: event_id
				},
				success: function( response ) {
					if ( true === response.success ) {
						$parent_row.fadeOut( function(){
							$parent_row.remove();
						});
					}
				},
				complete: function( response ){
					var response_data = $.parseJSON( response.responseText );
					alert( response_data.data );

					if( recurring === '1' ){
						location.reload();
						return;
					}

				}
			});

			// don't follow link!
			return false;
		} 
$(document).ready(function() {
	
    // Function to toggle the dropdown
    window.toggleDropdown = function(dropdownId) {
        console.log('toggleDropdown called with ID:', dropdownId); // Debugging log

        // Using jQuery to select the dropdown content
        var $dropdownContent = $('#' + dropdownId);
        console.log('Element with ID:', dropdownId, 'is:', $dropdownContent); // Debugging log

        // Check if the element exists
        if ($dropdownContent.length === 0) {
            console.error('Dropdown with ID ' + dropdownId + ' not found.');
            return;
        }

        // Toggle the visibility of the current dropdown and close others
        $('.dropdown-content').not($dropdownContent).hide(); // Hide all other dropdowns
        $dropdownContent.toggle(); // Toggle the current dropdown
    };

    // Optional: Add a listener to close dropdowns when clicking elsewhere on the page
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.dropdown').length) {
            $('.dropdown-content').hide();
        }
    });
});
</script>







<style>
/* Dropdown Button */
.admin_view_more_setting .dropbtn {
    background-color: transparent;
    color: #d5d5d5!important;
    font-size: 52px;
    border: none;
    cursor: pointer;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    align-content: center;
    justify-content: center;
}

/* Dropdown button on hover & focus */
.admin_view_more_setting .dropbtn:hover, .admin_view_more_setting .dropbtn:focus {
    background-color: transparent;
}

/* Dropdown Content (Hidden by Default) */
.admin_view_more_setting .dropdown-content {
    display: none;
    position: absolute;
    background-color: #fffafa!important;
    min-width: 100px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0;
}

/* Links inside the dropdown */
.admin_view_more_setting .dropdown-content a {
    color: black;
    padding: 5px 11px!important;
    text-decoration: none;
    display: block;
    font-size: 13px;
    font-weight: 300;
}

/* Change color of dropdown links on hover */
.admin_view_more_setting .dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu */
.admin_view_more_setting .show {display: block;}
.admin_view_more_setting .dropdown-content a{
    color: black!important;
}  


</style>




