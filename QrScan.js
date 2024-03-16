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
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
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
        });
    });
})(jQuery);