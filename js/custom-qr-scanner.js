jQuery(document).ready(function($) { 
    function onScanSuccess(decodedText, decodedResult) {
        // Here you can handle the decoded text, e.g., display it or send it to the server
        console.log(decodedText, decodedResult);

        // Sending scanned code to the server via AJAX
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'handle_qr_code_scan', // The AJAX handler action name
                decodedText: decodedText // The scanned QR code text
            },
            success: function(response) {
                alert(response.data.message); // Success response from server
            }
        });
    }

    // Initialize the QR code scanner
    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 }, false);
    html5QrcodeScanner.render(onScanSuccess);
});
