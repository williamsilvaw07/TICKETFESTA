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
                $('.entry-content').css("background-color", "#000");
                $('.checkin-details').hide();
                // test data YaCS1r2t
                // test data2 c7KOLbP0
                console.log('Event Pass:' , eventPass)
                checkForEventPass(eventPass);               
            }
        });
        function processQRCode(eventID, code){
            const params = new URLSearchParams(code);
            // Retrieve all variables
            // example: https://ticketfesta.co.uk/?event_qr_code=1&ticket_id=3811&event_id=3789&security_code=bb2b8ecf41&path=wp-json%2Ftribe%2Ftickets%2Fv1%2Fqr
            const event_qr_code = params.get('event_qr_code');
            const ticket_id = params.get('ticket_id');
            const qr_event_id = params.get('event_id');
            const security_code = params.get('security_code');
            const path = params.get('path');

            if(eventID == qr_event_id){
                checkinTicket(ticket_id);
            }else{
                $('#event_not_found').html('QR Code did not Match with Event Pass.');
                $('#event-pass').addClass('error');
                $('#event_not_found').show();
            }
        
        }
        // function startScanQR(eventID){
        //     const canvas = document.createElement('canvas');
        //     const context = canvas.getContext('2d');
        //     $('#event-pass').removeClass('error');
        //     $('#event_not_found').hide();
        //     canvas.width = video.videoWidth;
        //     canvas.height = video.videoHeight;
        //     const scanInterval = setInterval(function() {
        //         context.drawImage(video, 0, 0, canvas.width, canvas.height);
        //         const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        //         const code = jsQR(imageData.data, imageData.width, imageData.height);
        //         if (code) {
        //             processQRCode(eventID, code.data);
        //             // resultContainer.textContent = 'QR Code detected: ' + code.data;
        //             clearInterval(scanInterval);
        //         }else{
        //             console.log('QR Code not found :', code)
        //         }
        //     }, 200);
        // }

        function startScanQR(eventID) {
            // Remove error classes and hide not found message
            $('#event-pass').removeClass('error');
            $('#event_not_found').hide();
          
            const html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 12 });
            console.log('html5QrcodeScanner: ', Html5QrcodeScanner);

            // Success callback - called when a QR code is scanned
            const onScanSuccess = (qrCodeText) => {
                console.log('success: ', qrCodeText);
              processQRCode(eventID, qrCodeText);
              html5QrcodeScanner.stop(); // Stop scanner after successful scan
            };
          
            // Render the scanner UI and start scanning
            html5QrcodeScanner.render(onScanSuccess, (err) => {
              console.error("Error:", err);
            });
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
                    $('#scan-button').hide();

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

        function checkinTicket(ticketId){
            // 4450
            $.ajax({
                url: window.tribe_ajax.ajax_url, // This is set by WordPress and points to admin-ajax.php
                type: 'POST',
                data: {
                    action: 'custom_check_in_ticket',
                    ticket_id : ticketId
                },
                success: function(response) {
                    if(response.success){
                        $('.entry-content').css("background-color", "green");
                        if(response.fullname){
                            $('.checkin-details .name').text(response.fullname);
                            $('.checkin-details .email').text(response.email);
                            $('.checkin-details .checkin-time').text(response.checkin_time);
                            $('.checkin-details').show();
                        }
                    }else{
                        $('.entry-content').css("background-color", "red");
                        $('#event_not_found').text(response.message);
                        $('#event_not_found').show();
                        if(response.fullname){
                            $('.checkin-details .name').text(response.fullname);
                            $('.checkin-details .email').text(response.email);
                            $('.checkin-details .checkin-time').text(response.checkin_time);
                            $('.checkin-details').show();
                        }
                    }
                    // Handle the response from the server
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