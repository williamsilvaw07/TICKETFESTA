jQuery(document).ready(function($) {
    function onScanSuccess(decodedText, decodedResult) {
        // Sending scanned code to the server via AJAX
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'handle_qr_code_scan',
                decodedText: decodedText,
                api_key: ajax_object.api_key
            },
            success: function(response) {
                alert(response.data.message);
            }
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 }, false);
    html5QrcodeScanner.render(onScanSuccess);
});
