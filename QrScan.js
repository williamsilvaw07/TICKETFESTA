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
                console.log('Event Pass:' , eventPass)
                checkForEventPass(eventPass);
                // startScanQR();
               
            }
        });

        function startScanQR(){
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            $('#event_not_found').hide();
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const scanInterval = setInterval(function() {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                if (code) {
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
                        startScanQR();
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
            $('#event_not_found').show();
        }
    });
})(jQuery);