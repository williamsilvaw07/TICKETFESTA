(function($) {

    $(document).ready(function() {
        $('.add_attendee').on('click', request_add_attendee());
    });

    
    function request_add_attendee(this){
        let eventID = $(this).data('event-id');
        $.ajax({
            type: 'POST',
            data: {
                action: 'add_event_attendee',
                event_id : eventID
            },
            success: function(response) {
                console.log('response ', response)
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

})(jQuery);




