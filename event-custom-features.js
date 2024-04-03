

/*

(function($) {

    $(document).ready(function() {
        $('.tickets_checkin').on('click', request_add_attendee());
            
    function request_add_attendee(){
        console.log("Function called after 3 seconds!");
        let eventID = $('.add_attendee').data('event-id');
        $.ajax({
            url: window.tribe_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_add_event_attendee',
                event_id : eventID
            },
            success: function(response) {
                // console.log('response ', response)
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    });



})(jQuery);




*/