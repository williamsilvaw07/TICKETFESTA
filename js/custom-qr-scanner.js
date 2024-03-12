jQuery(document).ready(function($) {
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Decoded text: ${decodedText}`, decodedResult);
        // Send the decoded text to the server for validation
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'handle_qr_code_scan',
                decodedText: decodedText
            },
            success: function(response) {
                if (response.success) {
                    alert(response.data.message);
                } else {
                    alert(response.data.message);
                }
            }
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 }, false);
    html5QrcodeScanner.render(onScanSuccess);
});
