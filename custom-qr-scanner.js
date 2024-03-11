jQuery(document).ready(function($) {
    function onScanSuccess(decodedText, decodedResult) {
        // Send the decoded text to the server
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'handle_qr_code_scan',
                decodedText: decodedText
            },
            success: function(response) {
                alert(response.data.message); // Show success message
            },
            error: function() {
                alert("There was an error processing the QR code.");
            }
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
});
