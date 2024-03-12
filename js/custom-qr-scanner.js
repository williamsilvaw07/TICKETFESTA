jQuery(document).ready(function($) {
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'handle_qr_code_scan',
                decodedText: decodedText
            },
            success: function(response) {
                alert(response.data.message);
            },
            error: function() {
                alert("There was a problem with the request. Please try again.");
            }
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
});
