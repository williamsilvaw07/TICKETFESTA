
/*

function get_tribe_ticket_fee(ticketAmount, quantity = 1) {
    const flatFee = 0.40; // Flat fee for the whole order
    const percentageFee = 0.042; // Percentage fee for each ticket

    const ticketFee = ticketAmount * percentageFee * quantity;
    const totalFee = ticketFee + flatFee;

    return totalFee.toFixed(2);
}




// single product price
jQuery('.tribe-tickets__tickets-sale-price').each(function() {
    // Append a div element with the text "Site Fees" to each item
    var ticketAmount = jQuery(this).find('.tribe-amount').text().replace(',', ''); 
    ticketAmount = parseFloat(ticketAmount.trim()).toFixed(2);
    var ticketSiteFee =  get_tribe_ticket_fee(ticketAmount);
    console.log('Ticket price: ', ticketAmount); // Log the ticket price
    console.log('Site fee: ', ticketSiteFee); // Log the site fee
    jQuery(this).append('<span class="site-fee-container">+ £<span class="ticket_site_fee">'+ticketSiteFee+'</span> Fee</span>');
});
*/


jQuery(document).ready(function($) {
    console.log("Initializing Select2");
    $('select').select2();
    console.log("Select2 Initialized");
});



document.addEventListener('DOMContentLoaded', function() {









    
    jQuery('.flux-checkout__login-button.login-button').each(function() {
        // Add classes 'xoo-el-action-sc' and 'xoo-el-login-tgr'
        jQuery(this).addClass('xoo-el-action-sc xoo-el-login-tgr');
    });

    jQuery('.xoo-el-action-sc.button.btn.xoo-el-login-tgr').css('visibility', 'hidden');
    setTimeout(function() {
        // Trigger click event and hide the element
        jQuery('.xoo-el-action-sc.button.btn.xoo-el-login-tgr').trigger('click').hide();
    }, 1000); // 2000 milliseconds = 2 seconds
    jQuery('.organizer-title').hide(); 
    jQuery('.organizer-title').prop('required', false); 
    jQuery('.organizer-title_cont').hide();
    jQuery('.create-organizer_cont').on('click', function() {
        if (jQuery('.create-organizer').is(':checked')) { 
            jQuery('.organizer-title').show(); 
            jQuery('.organizer-title').prop('required', true); 
            jQuery('.organizer-title_cont').show();
        } else {
            jQuery('.organizer-title').hide(); 
            jQuery('.organizer-title').prop('required', false); 
            jQuery('.organizer-title_cont').hide();
        }
    });








    var searchIcon = document.querySelector('.header_search_icon');
    //console.log('Search icon element:', searchIcon); // Check if the search icon is correctly identified

    if (!searchIcon) {
       //console.error('Search icon not found.');
        return;
    }

    function openSearchPopup() {
      console.log('Attempting to open search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
           //console.error('Search popup element not found.');
            return;
        }

        searchPopup.style.display = 'block';
        //console.log('Search popup should now be visible.');
    }

    searchIcon.addEventListener('click', openSearchPopup);
    searchIcon.addEventListener('touchend', function(event) {
        event.preventDefault(); // Prevent the click event from firing after touchend
        openSearchPopup();
    });

    //console.log('Event listeners attached.'); // Confirm that event listeners are attached
});






document.addEventListener('DOMContentLoaded', function() {
    // Close popup when clicking the close button
    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });

    // Close popup when clicking outside of the popup content area
    document.getElementById('searchOverlay').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });
});







document.addEventListener('DOMContentLoaded', function() {
    // Find the .dynamic_div container where the span will be added
    var dynamicDiv = document.querySelector('.dynamic_div');

    if (!dynamicDiv) {
        //console.error('Dynamic div container not found.');
        return;
    }

    // Create the span element and add the required classes
    var searchIconMobile = document.createElement('span');
    searchIconMobile.classList.add('header_search_icon_mobile', 'jsclass');
   

    // Append the newly created span to the dynamic div
    dynamicDiv.appendChild(searchIconMobile);
    //console.log('Mobile search icon span added to the dynamic div.');

    function openSearchPopup() {
        //console.log('Attempting to open mobile search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
           // console.error('Search popup element not found.');
            return;
        }

        // Toggle the display of the search popup
        searchPopup.style.display = (searchPopup.style.display === 'block') ? 'none' : 'block';
        //console.log('Mobile search popup toggled.');
    }

    // Function to handle click/tap events on the newly added span
    function handleMobileIconTap(event) {
        event.preventDefault(); // Prevent default actions
       // console.log('Mobile search icon span tapped.');
        openSearchPopup(); // Call the function to open the search popup
    }

    // Attach event listeners for both click and touch events to the span
    searchIconMobile.addEventListener('click', handleMobileIconTap);
    searchIconMobile.addEventListener('touchend', handleMobileIconTap);

    //console.log('Event listeners attached to the mobile search icon span.');
});






jQuery(document).ready(function($) {
    // jQuery code to be executed when the DOM is ready
    
    function deleteVanue(vanueID) {
        console.log('Delete vanue called with ID:', vanueID);

        if (!confirm('Are you sure you want to delete this vanue?')) {
            return;
        }

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType : 'json',
            data: {
                'action': 'delete_vanue',
                'vanue_id': vanueID
            },
            success: function(response) {
                alert(response.data.message);
                jQuery('#organizer-row-' + vanueID).remove(); // Remove the row from the table
            },
            fail: function(response){
                //console.log('AJAX error:', response);
                alert('Failed to delete: ' );
            }
        });
    }





    jQuery(document).ready(function($) {

        // Function to recalculate the total and update the footer
        function recalculateTotal() {
            var total = 0;
    
            $('.tribe-tickets__tickets-item').each(function() {
                var ticketAmount = parseFloat($(this).find('.tribe-amount').text().replace('£', '').trim());
                var quantity = parseInt($(this).find('.tribe-tickets__tickets-item-quantity-number-input').val());
              
    
                if (!isNaN(ticketAmount) && !isNaN(quantity) && !isNaN(siteFee)) {
                    total += (ticketAmount * quantity);
                }
            });
    
            // Update the total fee displayed in the footer
            $('.tribe-tickets__tickets-footer-total .tribe-amount').text(total.toFixed(2));
        }
    
        // Attach event listeners to the add and remove buttons
        $('body').on('click', '.tribe-tickets__tickets-item-quantity-add, .tribe-tickets__tickets-item-quantity-remove', function() {
            // Slight delay to wait for the input value to update
            setTimeout(function() {
                recalculateTotal();
            }, 100);
        });
    
        // Additional listener for any change in ticket quantity input fields
        $('body').on('change', '.tribe-tickets__tickets-item-quantity-number-input', function() {
            recalculateTotal();
        });
    });
    

    
    






//old one working 
/*
    jQuery(document).ready(function($) {


        
        // Function to recalculate the total and update the footer
        function recalculateTotal() {
            var total = 0;
    
            $('.tribe-tickets__tickets-item').each(function() {
                var ticketAmount = parseFloat($(this).find('.tribe-amount').text().replace('£', '').trim());
                var quantity = parseInt($(this).find('.tribe-tickets__tickets-item-quantity-number-input').val());
                var siteFee = parseFloat($(this).find('.site-fee-container .ticket_site_fee').text().trim());
    
                if (!isNaN(ticketAmount) && !isNaN(quantity) && !isNaN(siteFee)) {
                    total += (ticketAmount * quantity) + (siteFee * quantity);
                }
            });
    
            // Update the total fee displayed in the footer
            $('.tribe-tickets__tickets-footer-total .tribe-amount').text(total.toFixed(2));
        }
    
        // Attach event listeners to the add and remove buttons
        $('body').on('click', '.tribe-tickets__tickets-item-quantity-add, .tribe-tickets__tickets-item-quantity-remove', function() {
            // Slight delay to wait for the input value to update
            setTimeout(function() {
                recalculateTotal();
            }, 100);
        });
    
        // Additional listener for any change in ticket quantity input fields
        $('body').on('change', '.tribe-tickets__tickets-item-quantity-number-input', function() {
            recalculateTotal();
        });
    });
    */

    
    $('.tribe-tickets__tickets-item').each(function() {
        var titleElement = $(this).find('.tribe-tickets__tickets-item-content-title');
        var ticket_id = $(this).data('ticket-id');
		if($(this).hasClass("future_tickets_item")){
				 ticket_id = $(this).data('tmp-ticket-id');
			}
        var start_date = jQuery('.pick_start_date').text().trim();
        var end_date = jQuery('.pick_end_date').text().trim();
        var start_date_passed = '';
        var end_date_passed = '';
        $('.ticket-date-container').each(function() {
            var ticketId = $(this).data('ticket-id');
			
            if(ticket_id == ticketId){
                start_date        = $(this).find('.pick_start_date').text().trim();
                start_date_passed = $(this).find('.pick_start_date').data('passed');
                end_date          = $(this).find('.pick_end_date').text().trim()
                end_date_passed   = $(this).find('.pick_end_date').data('passed');
            }
        });
    
        let dateHtml = '<div class="ticket-sales-dates">'; // Start of combined div
    
        if(start_date_passed != '1'){
            dateHtml += '<div class="startdate">Sales start on ' + start_date + '</div>';
        }
    
        // Always add end date
        dateHtml += '<div class="enddate">Sales end on ' + end_date + '</div>';
    
        dateHtml += '</div>'; // End of combined div
    
        // Create a new div element with combined start and end dates
        var $newDatesElement = $(dateHtml); 
        
        $newDatesElement.insertAfter(titleElement);
    });

    

    jQuery(document).on('change', '#saved_tribe_venue', function() {
        // When the select field changes, log its value to the console
        var selectedValue = jQuery(this).val();
        if(selectedValue != '-1'){
            jQuery('#event_tribe_venue').removeClass('required');
        }else{
            jQuery('#event_tribe_venue').addClass('required');
        }
    });

    jQuery(document).on('change', 'input[name="venue[Address][]"]', function() {
        var vanueAddress = jQuery('input[name="venue[Address][]"]').val();
        if(vanueAddress != ''){
            jQuery('#event_tribe_venue').removeClass('required');
        }else{
            jQuery('#event_tribe_venue').addClass('required');
        }
    
    });


    jQuery(document).on('change', '#saved_tribe_organizer', function() {
        // When the select field changes, log its value to the console
        var selectedValue = jQuery(this).val();
        if(selectedValue != '-1'){
            jQuery('#event_tribe_organizer').removeClass('required');
        }else{
            jQuery('#event_tribe_organizer').addClass('required');
        }
    });

    var selectedValue = jQuery('#event_image').val();
    var preview_image  = jQuery('.tribe-community-events-preview-image').val()

    if(selectedValue == '' && preview_image != ''){
        jQuery('#trive-select-event-images').addClass('required');
    }

    jQuery(document).on('change', '#event_image', function() {
        // When the select field changes, log its value to the console
        var selectedValue = jQuery(this).val();
        if(selectedValue != ''){
            console.log('value: ', selectedValue, 'remove class required');
            jQuery('#trive-select-event-images').removeClass('required');
        }else{
            console.log('value: ', selectedValue,'add class required');
            jQuery('#trive-select-event-images').addClass('required');
        }
    });
    
    if(!jQuery('.tribe-tickets-editor-table-tickets-body').length){
        jQuery('#ticket_form_toggle').addClass('required');
    }
    jQuery('.section-toggle').click(function(event){
        if(jQuery('.tribe-tickets-editor-table-tickets-body').length){
            jQuery('#ticket_form_toggle').removeClass('required');
        }else{
            jQuery('#ticket_form_toggle').addClass('required');
        }
    });
    jQuery('#tribetickets').click(function(event){
        setTimeout(function() {
            if(jQuery('.tribe-tickets-editor-table-tickets-body').length){
                jQuery('#ticket_form_toggle').removeClass('required');
            }else{
                jQuery('#ticket_form_toggle').addClass('required');
            }
        }, 2000); 

    });
    
    jQuery('.events-community-submit').click(function(event) {
        if (jQuery('#event_tribe_organizer').hasClass('required')) {
            setTimeout(function() {
                // Append error message to .tribe-community-notice-error
                jQuery('.tribe-community-notice-error').append('<p>Organizer is required</p>');
            }, 500); 
        }

        if (jQuery('#trive-select-event-images').hasClass('required')) { 
            setTimeout(function() {
                jQuery('.tribe-community-notice-error').append('<p>Image is required</p>');
            }, 500); 
        }

        if (jQuery('#event_tribe_venue').hasClass('required')) { 
            setTimeout(function() {
                jQuery('.tribe-community-notice-error').append('<p>Vanue is required</p>');
            }, 500); 
        }


        if (jQuery('#ticket_form_toggle').hasClass('required')) { 
            setTimeout(function() {
                jQuery('.tribe-community-notice-error').append('<p>Please add a ticket.</p>');
            }, 500); 
        }
    });

    autoSelectCountry();

    // change vanue edit link 
    jQuery('.vanue-container').on('click', function() {
        var vanueId  = jQuery('#saved_tribe_venue').val()

        // Get the href value from the clicked element's child
        var newHref = 'https://ticketfesta.co.uk/edit-vanues/?id=' + vanueId; // Replace 'new_href_value' with the desired new href value

        // Update the href attribute of the child element
        jQuery(this).find('.edit-linked-post-link > a').attr('href', newHref);
    });

});











// auto select country for edit vanue
function autoSelectCountry(){
    var selectElement = document.getElementById("venue_country");

    // Get the data-country value
    var countryValue = selectElement.getAttribute("data-country");

    // Loop through options and select the one that matches the data-country value
    for (var i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === countryValue) {
            selectElement.selectedIndex = i;
            break;
        }
    }
}
















