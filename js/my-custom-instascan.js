function initializeScanner() {
    if (typeof Instascan === 'undefined') {
        // Instascan library is not loaded yet, retry after some time
        console.log('Instascan not loaded yet, trying again...');
        setTimeout(initializeScanner, 500);
        return;
    }
    console.log('Instascan loaded, initializing scanner...');
    let scanner = new Instascan.Scanner({ video: document.getElementById('qr-scanner') });
    scanner.addListener('scan', function(content) {
        alert('QR Code content: ' + content);
        // Here, you can add further handling for the QR code content
    });
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]).catch(function(e) {
                console.error(e);
            });
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
    });
}

document.addEventListener('DOMContentLoaded', initializeScanner);
