jQuery(document).ready(function($) {
    $('#category-images-button').click(function(e) {
        e.preventDefault();
        var images = wp.media({
            title: 'Upload Images',
            multiple: true // Enable multiple image selection
        }).open().on('select', function(e) {
            var uploaded_images = images.state().get('selection');
            var image_urls = [];
            uploaded_images.each(function(image) {
                image_urls.push(image.toJSON().url);
            });
            $('#category-images').val(image_urls.join(','));
            $('#category-images-preview').html('');
            for (var i = 0; i < image_urls.length; i++) {
                $('#category-images-preview').append('<img src="' + image_urls[i] + '" style="max-width: 100px; margin-right: 10px;" />');
            }
        });
    });
});


jQuery(document).ready(function($) {
    $('#is_organizer').change(function() {
        if ($(this).is(':checked')) {
            $('#organizer_fields').show(); // Show the organizer specific fields
        } else {
            $('#organizer_fields').hide(); // Hide the organizer specific fields
        }
    });
});








jQuery(document).ready(function($) { 
    console.log( "ready!" );
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
