function onScanSuccess(decodedText, decodedResult) {
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'handle_qr_code_scan',
            decodedText: decodedText
        },
        success: function(response) {
            console.log(response);
            // Handle response
        }
    });
}
