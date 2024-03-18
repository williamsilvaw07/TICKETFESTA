document.addEventListener('DOMContentLoaded', function () {
    const html5QrCode = new Html5Qrcode("qr-reader");
    const config = { fps: 10, qrbox: 250 };

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        // Handle the scanned code as required.
    }

    // Start scanning. Provide a camera ID and the scan type.
    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);
});
