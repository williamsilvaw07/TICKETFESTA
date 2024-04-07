(function($) {
    

// Add a click event listener to the .ticket_dropdown element
$('.single_ticket_section').on('click', function() {
    // Log a message indicating that the click event is triggered
    console.log("Ticket dropdown clicked");

    // Get the .single_ticket_section_inner and <i class="fas fa-angle-down"></i> elements
    var innerElement = $('.single_ticket_section_inner');
    var iconElement = $('.ticket_dropdown i.fas');

    // Check if the inner element has the 'display-block' class
    if (innerElement.hasClass('display-block')) {
        // If it does, remove the 'display-block' class
        innerElement.removeClass('display-block');
        // Log a message indicating that the 'display-block' class is removed
        console.log("Removed 'display-block' class from inner element");

        // and change the icon's class to fa-angle-up
        iconElement.removeClass('fa-angle-down').addClass('fa-angle-up');
        // Log a message indicating that the icon's class is changed
        console.log("Changed icon's class to fa-angle-up");
    } else {
        // If the inner element doesn't have the 'display-block' class, add the 'display-block' class
        innerElement.addClass('display-block');
        // Log a message indicating that the 'display-block' class is added
        console.log("Added 'display-block' class to inner element");

        // and change the icon's class to fa-angle-down
        iconElement.removeClass('fa-angle-up').addClass('fa-angle-down');
        // Log a message indicating that the icon's class is changed
        console.log("Changed icon's class to fa-angle-down");
    }
});


    document.addEventListener("DOMContentLoaded", function(event) {
        var event_id_global = '';
        var changing_event = false;
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
                $('#qr_error').html('Ticket is not valid for this event');
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
               // console.log(`Code scanned = ${decodedText}`, decodedResult);
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
                  // console.log('ajax response', response);
                    if(response.match){
                        event_id_global = response.event_id;
                        // startScanQR(response.event_id);
                        if (!response || !response.event_data) {
                          //  console.error("Invalid response data.");
                            return;
                        } else{
                            $('.tabs-container').show();
                            $('.tab-content-container').show();
                            changing_event =  false;
                            passcodeMatch(response,0);
                        }
                        
                    }else{
                        noEventFound();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                   // console.error(xhr.responseText);
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
                            //$('.checkin-details .checkin-time').text('Checked-in at ' + response.checkin_time);
                            //$('.checkin-details .scaned_by span').text(response.scaned_by);
                           // $('.checkin-details').show();
                        }
                    }else{
                        $('.checkin-details').css("background-color", "#c30101");
                        $('#qr_error').text(response.message);
                        $('#qr_error').show();
                        if(response.fullname){
                            $('.checkin-details .name').text(response.fullname);
                            $('.checkin-details .email').text(response.email);
                            $('.checkin-details .checkin-time').text('Checked-in at ' + response.checkin_time);
                            $('.checkin-details .scaned_by span').text(response.scaned_by);
                            $('.checkin-details').show();
                        }
                    }
                    // Handle the response from the server
                },
                error: function(xhr, status, error) {
                    // Handle errors
                  //  console.error(xhr.responseText);
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



    // Function to calculate percentage
function calculatePercentage(issued, total) {
    if (total === 0) {
       // console.error("Total tickets cannot be 0.");
        return 0;
    }
    return (issued / total) * 100;
}

// Function to update the progress circle
function updateProgressCircle(issuedTickets, totalTickets) {
    var percentage = calculatePercentage(issuedTickets, totalTickets);
    if (isNaN(percentage)) {
        //console.error("Percentage calculation error.");
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

// Function to update individual progress circles
function updateIndividualProgressCircle(container, issuedTickets, totalTickets) {
    var percentage = calculatePercentage(issuedTickets, totalTickets);
    if (isNaN(percentage)) {
      //  console.error("Percentage calculation error.");
        return;
    }

    var precisePercentage = percentage.toFixed(1); // To display one decimal place
    var radius = 31; // Set the radius of your SVG circle
    var circumference = 2 * Math.PI * radius;

    // Calculate stroke-dasharray and stroke-dashoffset
    var dashArray = circumference;
    var dashOffset = circumference - (percentage / 100) * circumference;

    container.find('.progress-ring__circle-individual').css({
        'stroke-dasharray': circumference,
        'stroke-dashoffset': dashOffset,
        'stroke': '#d3fa16' // Color of progress
    });

    // Update the percentage text inside SVG for individual tickets
    container.find('span.progress-percentage_individual').text(precisePercentage + '%');
}

// Function to create the checked-in progress component dynamically
function createCheckedInProgressCircle(checkedIn, issuedTickets) {
    var checkedInPercentage = checkedIn === 0 ? 0 : Math.ceil((checkedIn / issuedTickets) * 100); // Calculate the checked-in percentage
    var checkedInText = checkedInPercentage === 0 ? '0%' : checkedInPercentage.toFixed(1) + '%';

    // Calculate stroke-dasharray and stroke-dashoffset for the first half
    var circumference = 2 * Math.PI * 31; // 31 is the radius of the circle
    var dashArray1 = checkedInPercentage <= 50 ? (checkedInPercentage / 100) * circumference : circumference / 2;
    var dashOffset1 = 0;

    // Calculate stroke-dasharray and stroke-dashoffset for the second half
    var dashArray2 = checkedInPercentage > 50 ? ((checkedInPercentage - 50) / 100) * circumference : 0;
    var dashOffset2 = checkedInPercentage > 50 ? dashArray1 : 0;

    // Dynamic creation of progress circle for checked-in percentage
    var checkedInProgressHtml = `
        <div class="ticket-progress-container checkedin-progress">
            <div class="ticket-progress-container_svg">
            <svg class="progress-ring" width="58" height="58">
            <circle class="progress-ring__circle-bg" cx="29" cy="29" r="24" stroke-width="6"></circle>
            <circle class="progress-ring__circle progress-ring__circle-first-half" cx="29" cy="29" r="24" stroke-width="6" style="stroke-dasharray: ${circumference}px; stroke-dashoffset: ${circumference - (checkedInPercentage / 100) * circumference}px; stroke: #d3fa16;"></circle>
        </svg>
                <span class="progress-percentage">${checkedInText}</span>
            </div>
        </div>
    `;


  
    return checkedInProgressHtml;
}



// Function to update the checked-in progress component specifically for .ticket_checkedin_main_stats
function updateCheckedInProgress(response) {
    if (!response || !response.event_data) {
      //  console.error("Invalid response data.");
        return;
    }

    // Extract the checked-in information
    var checkedIn = parseInt(response.event_data.checked_in.split(' / ')[0], 10);
    var issuedTickets = parseInt(response.event_data.issued_tickets, 10);

    // Check for NaN values after parsing
    if (isNaN(checkedIn) || isNaN(issuedTickets)) {
     //   console.error("Error parsing checked-in information.");
        return;
    }

    // Create the checked-in progress component HTML
    var checkedInProgressHtml = createCheckedInProgressCircle(checkedIn, issuedTickets);

    // Update the checked-in progress component in the DOM
    $('.ticket_checkedin_main_stats .checkedin-progress-ring-container').html(checkedInProgressHtml);
}




        // Function to handle passcode match response
        function passcodeMatch(response,isajax = 1) {
            if (!response || !response.event_data) {
                //console.error("Invalid response data.");
                return;
            }

            // $('.tabs-container').show();
            $('.event-container .event-image').attr('src', response.event_data.thumbnail_url);
            $('.event-container .name span').text(response.event_data.name);
            $('.event-container .date span').text(response.event_data.start_date);
            $('.checkedin_ticket-count span').text(response.event_data.checked_in);
            $('.ticket-info_hidden_all ').text();




            // Extract the ticket information
            var issuedTickets = parseInt(response.event_data.issued_tickets, 10);
            var totalTickets = parseInt(response.event_data.total_tickets_available, 10);

            // Check for NaN values after parsing
            if (isNaN(issuedTickets) || isNaN(totalTickets)) {
                //console.error("Error parsing ticket information.");
                return;
            }

            // Calculate the checked-in percentage
            var checkedIn = parseInt(response.event_data.checked_in.split(' / ')[0], 10);
            var checkedInPercentage = checkedIn === 0 ? 0 : Math.ceil((checkedIn / issuedTickets) * 100); // Round up the percentage
            var checkedInText = checkedInPercentage === 0 ? '0%' : checkedInPercentage.toFixed(0) + '%';
            

            // Update the progress circle with the new data
            updateProgressCircle(issuedTickets, totalTickets);

            // Update the checked-in progress component
            updateCheckedInProgress(response);

            // Clear existing ticket information
            $('.ticket-info_hidden_all').empty();

            // Display ticket information with percentages
            var ticketList = response.event_data.ticket_list;
            ticketList.forEach(function(ticket) {
                var issued = parseInt(ticket.issued_tickets, 10);
                var capacity = parseInt(ticket.capacity, 10);
                var percentage = calculatePercentage(issued, capacity).toFixed(1); // Calculate percentage for each ticket type

                // HTML for individual progress components
                var individualProgressHtml = `
                    <div class="ticket-progress-container">
                        <div class="ticket-progress-container_svg">
                        <svg class="progress-ring" width="58" height="58">
                        <circle class="progress-ring__circle-bg" cx="29" cy="29" r="24" stroke-width="6"></circle>
                        <circle class="progress-ring__circle progress-ring__circle-individual" cx="29" cy="29" r="24" stroke-width="6"></circle>
                    </svg>
                            <span class="progress-percentage_individual">${percentage}%</span>
                        </div>
                        <div class="ticket-details info_div">
                            <h6>Total Ticket Sold</h6>
                            <div class="ticket-name">${ticket.name}</div>
                            <p class="ticket-count">${issued} / ${capacity}</p>
                        </div>
                    </div>
                `;

                // Append individual progress components to container
                $('.ticket-info_hidden_all').append(individualProgressHtml);


    


                // Update individual progress circles with the correct percentage
                updateIndividualProgressCircle($('.ticket-info_hidden_all .ticket-progress-container').last(), issued, capacity);
            });

            // Proceed with other functions like startScanQR...
           if(!isajax){
            startScanQR(response.event_id);
        }
        }





        function CheckProgressData() {
            if(event_id_global && ! changing_event ){
                //console.log('ajax called');
                 $.ajax({
                 url: window.tribe_ajax.ajax_url,
                 type: 'post',
                 data: {
                     action: 'check_progress_data',
                     event_id: event_id_global
                 },
                 success: function(response) {
                   // console.log(response); 
                    $('.tabs-container').show();
                    passcodeMatch(response);

                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                   //  console.error("AJAX Error:", textStatus, errorThrown);
                 }
                 });
             }
        }
       


        
        var intervalId = setInterval(function() {
            // Your function to be called every 3 seconds
            CheckProgressData();
        }, 3000);




/*
var intervalId = null;

function checkAndRun() {
    if ($('#tab1').hasClass('active')) {
        if (intervalId === null) {
            console.log('Starting interval because #tab1 is active.');
            intervalId = setInterval(function() {
                console.log('Calling CheckProgressData function.');
                CheckProgressData();
            }, 3000);
        }
    } else {
        if (intervalId !== null) {
            console.log('Clearing interval because #tab1 is no longer active.');
            clearInterval(intervalId);
            intervalId = null;
        }
    }
}

checkAndRun(); // Perform the initial check

var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === "class") {
            console.log('#tab1 class attribute changed.');
            checkAndRun();
        }
    });
});

observer.observe(document.getElementById('tab1'), {
    attributes: true,
    attributeFilter: ['class']
});
*/











        $(document).on('click', '.change_event_btn', function() {
           // console.log("Button clicked");
            changing_event = true;
          //  $('.tabs-container').hide();
           // $('.scanner_login_div').show(); 
          //  $('.change_event_btn').css("display", "none");
             
          
          // Refresh the page immediately
    location.reload();
            
        });
    });
         // (Optional) Clear the interval when the user leaves the page
        //  $(window).unload(function() {
        //      clearInterval(intervalId);
        //  });







})(jQuery);
















// When the document is fully loaded and ready
$(document).ready(function() {
         
     // Set an interval to call the function every 30 seconds

    // Initially load passcodes from Local Storage and populate the datalist
    loadPasscodes();
   
    document.addEventListener("click", function(e){
  const target = e.target.closest("#html5-qrcode-button-camera-start"); // Or any other selector.
     //  console.log(target)
       
  if(target){
    // Do something with `target`.
     $(".checkin-details").hide();
  }
});
    // Event handler for clicking the login button
    $('#check-passcode').click(function() {
        // Retrieve the current value entered in the passcode input field
        var passcodeInput = $('#event-pass').val();
        // Get the existing passcodes from Local Storage or initialize an empty array if none exist
        var passcodes = JSON.parse(localStorage.getItem('passcodes')) || [];
        
        // Check if the current input passcode is not already saved in Local Storage
        if ($.inArray(passcodeInput, passcodes) === -1) {
            // Add the new passcode to the array of saved passcodes
            passcodes.push(passcodeInput);
            // Update Local Storage with the new set of passcodes
            localStorage.setItem('passcodes', JSON.stringify(passcodes));

            // Refresh the datalist with the new entry to include the newly saved passcode
            loadPasscodes();
        }

    });
});

// Function to load passcodes from Local Storage and populate the datalist
function loadPasscodes() {
    // Retrieve passcodes from Local Storage or initialize an empty array if none exist
    var passcodes = JSON.parse(localStorage.getItem('passcodes')) || [];
    // Clear any existing options from the datalist to prepare for repopulation
    $('#passcodes').empty();
    // Iterate through each saved passcode and append it as an option to the datalist
    $.each(passcodes, function(index, passcode) {
        $('#passcodes').append($('<option></option>').attr('value', passcode));
    });
}



