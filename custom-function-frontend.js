
function get_tribe_ticket_fee(ticketAmount, quantity = 1){
    ticketSiteFee = 0;
    if(ticketAmount < 50 ){
        ticketSiteFee += (ticketAmount * .03 + 0.02) * quantity;
    }
    if(ticketAmount > 50 ){
        ticketSiteFee += (ticketAmount *  .01 + 0.02) * quantity;
    }

    return ticketSiteFee.toFixed(2);
}
document.addEventListener('DOMContentLoaded', function() {

    // single product price
    jQuery('.tribe-tickets__tickets-sale-price').each(function() {
        // Append a div element with the text "Sites Fees" to each item
        
        var ticketAmount = parseFloat(jQuery('.tribe-amount').text().trim()).toFixed(2);
        var ticketSiteFee =  get_tribe_ticket_fee(ticketAmount);
        jQuery(this).append('<span class="site-fee-container">+ £<span class="ticket_site_fee">'+ticketSiteFee+'</span> Fee</span>');
    }); 

    // jQuery('.tribe-tickets__tickets-footer-total').each(function() {
    //     // Append a div element with the text "Sites Fees" to each item
        
    //     var ticketAmount = parseFloat(jQuery('.tribe-amount').text().trim()).toFixed(2);
    //     var ticketSiteFee =  get_tribe_ticket_fee(ticketAmount);
    //     $(this).append('<span class="site-fee-container">+£ <span class="ticket_site_fee tribe_total_fee">'+ticketSiteFee+'</span> fee</span>');
    // }); 


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
        console.error('Search icon not found.');
        return;
    }

    function openSearchPopup() {
        //console.log('Attempting to open search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
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
        console.error('Dynamic div container not found.');
        return;
    }

    // Create the span element and add the required classes
    var searchIconMobile = document.createElement('span');
    searchIconMobile.classList.add('header_search_icon_mobile', 'jsclass');
   

    // Append the newly created span to the dynamic div
    dynamicDiv.appendChild(searchIconMobile);
    console.log('Mobile search icon span added to the dynamic div.');

    function openSearchPopup() {
        console.log('Attempting to open mobile search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        // Toggle the display of the search popup
        searchPopup.style.display = (searchPopup.style.display === 'block') ? 'none' : 'block';
        console.log('Mobile search popup toggled.');
    }

    // Function to handle click/tap events on the newly added span
    function handleMobileIconTap(event) {
        event.preventDefault(); // Prevent default actions
        console.log('Mobile search icon span tapped.');
        openSearchPopup(); // Call the function to open the search popup
    }

    // Attach event listeners for both click and touch events to the span
    searchIconMobile.addEventListener('click', handleMobileIconTap);
    searchIconMobile.addEventListener('touchend', handleMobileIconTap);

    console.log('Event listeners attached to the mobile search icon span.');
});






jQuery(document).ready(function($) {
    // jQuery code to be executed when the DOM is ready
       
    function update_site_fees(){
    
        var ticketAmount = parseFloat(jQuery('.tribe-amount').text().trim()).toFixed(2);
        var quantity = parseInt(jQuery('.tribe-tickets__tickets-footer-quantity-number').text().trim());
        var ticketSiteFee = get_tribe_ticket_fee(ticketAmount, quantity );
        var total_fee =  parseFloat(ticketAmount) * parseFloat(quantity) + parseFloat(ticketSiteFee);
        jQuery('.tribe-tickets__tickets-footer-total .tribe-amount').text(total_fee.toFixed(2)); 
    }
    jQuery('.tribe-tickets__tickets-item').on('click',function(){
        update_site_fees();
    });

    $('.tribe-tickets__tickets-item').each(function() {
        var titleElement = $(this).find('.tribe-tickets__tickets-item-content-title');
        var ticket_id = $(this).data('ticket-id');
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
        let dateHtml = '';

        if(start_date_passed != '1'){
            dateHtml += '<div class="startdate">Sales start on ' + start_date + '</div>';
        }
        dateHtml += '<div class="enddate">Sales end on ' + end_date + '</div>';
        // Create a new title element
        var $newTitleElement = $(dateHtml); 
        
        $newTitleElement.insertAfter(titleElement);
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
    jQuery('.tribe-section-tickets').click(function(event){
        setTimeout(function() {
            if(jQuery('.tribe-tickets-editor-table-tickets-body').length){
                jQuery('#ticket_form_toggle').addClass('required');
            }else{
                jQuery('#ticket_form_toggle').removeClass('required');
            }
        }, 500); 
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

});


