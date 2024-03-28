(function($) {

    $(document).ready(function() {
        console.log('add_attendee 99');
        $('.add_attendee').on('click', request_add_attendee());
    });

    
    function request_add_attendee(){
        let eventID = $(this).data('event-id');
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

})(jQuery);




