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
            $(document).on('click', '.change_event_btn', function() {
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

            $('#event_not_found').css("display", "block"); 
            $('event-pass').addClass('error');
            $('#event_not_found').show();

            $('.scanner_login_div').show(); 
            $('.change_event_btn').css("display", "none"); 
            
            
            $('.tabs-container').hide();
            $('.tab-content-container').hide();
        }





        function calculatePercentage(issued, total) {
            if (total === 0) {
                console.error("Total tickets cannot be 0.");
                return 0;
            }
            return (issued / total) * 100;
        }
        
        function updateProgressCircle(issuedTickets, totalTickets) {
            var percentage = calculatePercentage(issuedTickets, totalTickets);
            if (isNaN(percentage)) {
                console.error("Percentage calculation error.");
                return;
            }
        
            var precisePercentage = percentage.toFixed(1); // To display one decimal place
            var radius = 31; // Set the radius of your SVG circle
            var circumference = 2 * Math.PI * radius;
        
            $('.progress-ring__circle').css({
                'stroke-dasharray': circumference,
                'stroke-dashoffset': circumference - (percentage / 100) * circumference,
                'stroke': '#d3fa16' // Color of progress
            });
        
            // Update the percentage text in the center of the progress circle
            $('.progress-percentage').text(precisePercentage + '%');
        
            // Update the ticket count text
            $('.ticket-count').text(issuedTickets + ' / ' + totalTickets);
        }
        
        function updateIndividualProgressCircle(container, issuedTickets, totalTickets) {
            var percentage = calculatePercentage(issuedTickets, totalTickets);
            if (isNaN(percentage)) {
                console.error("Percentage calculation error.");
                return;
            }
        
            var precisePercentage = percentage.toFixed(1); // To display one decimal place
            var radius = 31; // Set the radius of your SVG circle
            var circumference = 2 * Math.PI * radius;
        
            // Calculate stroke-dasharray and stroke-dashoffset
            var dashArray = circumference;
            var dashOffset = circumference - (percentage / 100) * circumference;
        
            container.find('.progress-ring__circle-individual').css({
                'stroke-dasharray': dashArray,
                'stroke-dashoffset': dashOffset,
                'stroke': '#d3fa16' // Color of progress
            });
        
            // Update the percentage text
            container.find('span.progress-percentage_individual').text(precisePercentage + '%');
        }
        
        function passcodeMatch(response) {
            if (!response || !response.event_data) {
                console.error("Invalid response data.");
                return;
            }
        
            $('.tabs-container').show();
            $('.tab-content-container').show();
            $('.event-container .event-image').attr('src', response.event_data.thumbnail_url);
            $('.event-container .name span').text(response.event_data.name);
            $('.event-container .date span').text(response.event_data.start_date);
        
            // Extract the ticket information
            var issuedTickets = parseInt(response.event_data.issued_tickets, 10);
            var totalTickets = parseInt(response.event_data.total_tickets_available, 10);
        
            // Check for NaN values after parsing
            if (isNaN(issuedTickets) || isNaN(totalTickets)) {
                console.error("Error parsing ticket information.");
                return;
            }
        
            // Update the progress circle with the new data
            updateProgressCircle(issuedTickets, totalTickets);
        
            // Display ticket information with percentages
            var ticketList = response.event_data.ticket_list;
            var ticketInfoHtml = '';
            ticketList.forEach(function(ticket) {
                var issued = parseInt(ticket.issued_tickets, 10);
                var capacity = parseInt(ticket.capacity, 10);
                var percentage = calculatePercentage(issued, capacity).toFixed(1); // Calculate percentage for each ticket type
        
                // HTML for individual progress components with the same class names as before
                var individualProgressHtml = `
                    <div class="ticket-progress-container">
                        <svg class="progress-ring" width="72" height="72">
                            <circle class="progress-ring__circle-bg" cx="36" cy="36" r="31" stroke-width="6"></circle>
                            <circle class="progress-ring__circle progress-ring__circle-individual" cx="36" cy="36" r="31" stroke-width="6"></circle>
                            <span class="progress-percentage_individual" ${percentage}%</span>
                        </svg>
                        <div class="ticket-details">
                            <div class="ticket-name">${ticket.name}</div>
                            <div class="ticket-count">${issued} issued out of ${capacity} available</div>
                        </div>
                    </div>
                `;
        
                ticketInfoHtml += `<li>${ticket.name}: ${issued} issued out of ${capacity} available (${percentage}%)</li>`;
                $('.ticket-info_hidden_all ul').html(ticketInfoHtml);
        
                // Append individual progress component to container
                $('.ticket-info_hidden_all').append(individualProgressHtml);
        
                // Update individual progress circle with the same class names as before
                updateIndividualProgressCircle($('.ticket-info_hidden_all .ticket-progress-container').last(), issued, capacity);
            });
        
            // Proceed with other functions like startScanQR...
            startScanQR(response.event_id);
        }


    });
})(jQuery);













