jQuery(document).ready(function($) { 
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scanned text: ${decodedText}`, decodedResult);

        // Sending scanned code to the server via AJAX
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'handle_qr_code_scan', // The AJAX handler action name
                decodedText: decodedText // The scanned QR code text
            },
            success: function(response) {
                if(response.success) {
                    // Handle a successful check-in
                    alert(`Success: ${response.data.message}`);
                } else {
                    // Handle different error cases based on the message or error codes from the server
                    alert(`Error: ${response.data.message}`);
                }
            },
            error: function() {
                alert('There was a problem with the request. Please try again.');
            }
        });
    }

    // Initialize the QR code scanner
    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 }, false);
    html5QrcodeScanner.render(onScanSuccess);
});
