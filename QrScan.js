(function($) {
    
    document.addEventListener("DOMContentLoaded", function(event) {
        const video = document.getElementById('video');
        const resultContainer = document.getElementById('result');

        // Check if getUserMedia is supported
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function(error) {
                console.error('Error accessing the camera:', error);
            });
        }

        jQuery("#scan-button").on('click', function(){
            if($('#event-pass').val()){
                var eventPass = $('#event-pass').val();
                // test data YaCS1r2t
                // test data2 c7KOLbP0
                console.log('Event Pass:' , eventPass)
                checkForEventPass(eventPass);               
            }
        });
        function processQRCode(eventID, code){
            const params = new URLSearchParams(code);
            // Retrieve all variables
            const event_qr_code = params.get('event_qr_code');
            const ticket_id = params.get('ticket_id');
            const qr_event_id = params.get('event_id');
            const security_code = params.get('security_code');
            const path = params.get('path');

            if(eventID == event_qr_code){
            
            }else{
                $('#event_not_found').html('QR Code did not Match with Event Pass.');
                $('#event-pass').addClass('error');
                $('#event_not_found').show();
            }
        
        }
        function startScanQR(eventID){
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            $('#event-pass').removeClass('error');
            $('#event_not_found').hide();
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const scanInterval = setInterval(function() {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                if (code) {
                    processQRCode();
                    resultContainer.textContent = 'QR Code detected: ' + code.data;
                    clearInterval(scanInterval);
                }else{
                    console.log('QR Code not found :', code)
                }
            }, 200);
        }
        function checkForEventPass(eventPass){
            $.ajax({
                url: window.tribe_ajax.ajax_url, // This is set by WordPress and points to admin-ajax.php
                type: 'POST',
                data: {
                    action: 'validate_event_pass',
                    event_pass : eventPass
                },
                success: function(response) {
                    // Handle the response from the server
                    console.log('ajax response', response);
                    if(response.match){
                        startScanQR(response.event_id);
                    }else{
                        noEventFound();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }

        function noEventFound(){
            $('#event-pass').addClass('error');
            $('#event_not_found').show();
        }
    });
})(jQuery);