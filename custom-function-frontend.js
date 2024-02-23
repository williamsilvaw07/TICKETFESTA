document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchInput = document.getElementById('ecsa-search-box');

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked, starting to simulate typing every 1 second.');

        // Ensure the popup is displayed
        document.getElementById('searchPopup').style.display = 'block';

        // Function to simulate typing
        function simulateTyping() {
            if (searchInput) {
                console.log('Simulating typing in the input');

                // Define the key(s) you want to simulate, e.g., "t"
                var key = 't'; // You can change this to simulate typing different characters

                // Create and dispatch keydown and keyup events to simulate typing
                ['keydown', 'keyup'].forEach(function(eventType) {
                    var event = new KeyboardEvent(eventType, {
                        key: key,
                        code: 'Key' + key.toUpperCase(),
                        keyCode: key.charCodeAt(0),
                        charCode: key.charCodeAt(0),
                        which: key.charCodeAt(0)
                    });
                    searchInput.dispatchEvent(event);
                });
            }
        }

        // Start an interval to simulate typing every 1 second
        setInterval(simulateTyping, 1000);
    });
});
