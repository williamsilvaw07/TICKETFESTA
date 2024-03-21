(function($) {
    
    document.addEventListener("DOMContentLoaded", function(event) {
        // const video = document.getElementById('video');

        // Check if getUserMedia is supported
        // if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        //     navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        //     .then(function(stream) {
        //         video.srcObject = stream;
        //         video.play();
        //     })
        //     .catch(function(error) {
        //         console.error('Error accessing the camera:', error);
        //     });
        // }
        $('.tabs-nav li.tab a').click(function(e) {
            e.preventDefault(); // Prevent default link behavior
    
            var target = $(this).attr('href');
    
            // Remove active class from all tabs and content
            $('.tabs-nav li.tab').removeClass('active');
            $('.tab-content').removeClass('active');
            // Add active class to clicked tab and its corresponding content
            $(this).parent().addClass('active');
            $(target).addClass('active');

            if($(this).parent().hasClass('tab2')){
                // $('#html5-qrcode-button-camera-start').trigger('click');
            }else{
                // $('#html5-qrcode-button-camera-stop').trigger('click');
            }
        });



        // jQuery("#scan-button").on('click', function(){
        //     if($('#event-pass').val()){
        //         var eventPass = $('#event-pass').val();
        //         $('.entry-content').css("background-color", "#000");
        //         $('.checkin-details').hide();
        //         // test data YaCS1r2t
        //         // test data2 c7KOLbP0
        //         console.log('Event Pass:' , eventPass)
        //         checkForEventPass(eventPass);               
        //     }
        // });

        jQuery("#check-passcode").on('click', function(){
            var eventPass = $('#event-pass').val();
            checkForEventPass(eventPass);
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
                $('#qr_error').html('QR Code did not Match with Event Pass.');
                $('#event-pass').addClass('error');
                $('#qr_error').show();
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


        ///function to change event passcode
   
            // Delegating click event for dynamically added content
            $(document).on('click', '.change_event_btne', function() {
                console.log("Button clicked");
                $('.tabs-container').hide();
                $('.scanner_login_div').show(); 
                $('.change_event_btn').css("display", "none");
            });
    





        function startScanQR(eventID){
            $('#event-pass').removeClass('error');
            $('#event_not_found').hide();
            let html5QrcodeScanner = new Html5QrcodeScanner(
                'qr-reader', {
                    fps: 10,
                    qrbox: 250, // Set qrbox size to keep the scanning area square
                    rememberLastUsedCamera: true,
                    aspectRatio: 1,
                    disableFlip: true // Disable the option to flip camera
                }, false);
            function onScanSuccess(decodedText, decodedResult) {
                // Handle the scanned code as needed
                $('#html5-qrcode-button-camera-stop').trigger('click');
                $('#html5-qrcode-button-camera-start').text('Scan Another Ticket');
                console.log(`Code scanned = ${decodedText}`, decodedResult);
                processQRCode(eventID, decodedText);
            }
    
            function hideCameraSelectionText() {
                // Hide the text indicating which camera is selected
                $('.camera-selection-text').hide();
            }
            
            html5QrcodeScanner.render(onScanSuccess);
            // Call the function to hide the camera selection text after the camera has been selected
            html5QrcodeScanner.html5Qrcode._internalApi.onCameraSelected = hideCameraSelectionText;
                
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
                    $('.scanner_login_div').hide(); 
                    $('.change_event_btn').css("display", "block");  
                    // Handle the response from the server
                    console.log('ajax response', response);
                    if(response.match){
                        // startScanQR(response.event_id);
                        passcodeMatch(response);
                        
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
                        $('#qr_error').hide();
                        $('.checkin-details').css("background-color", "green");
                        if(response.fullname){
                            $('.checkin-details .name').text(response.fullname);
                            $('.checkin-details .email').text(response.email);
                            $('.checkin-details .checkin-time').text(response.checkin_time);
                            $('.checkin-details .scaned_by span').text(response.scaned_by);
                            $('.checkin-details').show();
                        }
                    }else{
                        $('.checkin-details').css("background-color", "red");
                        $('#qr_error').text(response.message);
                        $('#qr_error').show();
                        if(response.fullname){
                            $('.checkin-details .name').text(response.fullname);
                            $('.checkin-details .email').text(response.email);
                            $('.checkin-details .checkin-time').text(response.checkin_time);
                            $('.checkin-details .scaned_by span').text(response.scaned_by);
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
           
            $('event-pass').addClass('error');
            $('#event_not_found').show();

            $('.tabs-container').hide();
            $('.tab-content-container').hide();
        }

        function passcodeMatch(response){
            $('.tabs-container').show();
            $('.tab-content-container').show();
            $('.event-container .event-image').attr('src', response.event_data.thumbnail_url);
            $('.event-container .name span').text(response.event_data.name);
            $('.event-container .date span').text(response.event_data.start_date);
            $('.event-container .tickets span').text(response.event_data.issued_ticked);
            startScanQR(response.event_id);
         
             
        }

    });
})(jQuery);




