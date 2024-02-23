document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchInput = document.getElementById('ecsa-search-box');

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');

        // Wait a bit to ensure any initialization or display changes have been completed
        setTimeout(function() {
            if (searchInput) {
                console.log('Focusing on search input');
                searchInput.focus(); // Focus on the input field

                // Simulate a keydown event to mimic typing
                var event = new KeyboardEvent('keydown', {
                    key: ' ', // Using space to minimally interact with the input
                    keyCode: 32, // Keycode for spacebar
                    code: 'Space', // Code for spacebar
                    which: 32,
                    shiftKey: false,
                    ctrlKey: false,
                    metaKey: false
                });

                // Dispatch the keydown event
                searchInput.dispatchEvent(event);
                console.log('Keydown event dispatched on search input');
            }
        }, 1000); // Adjust this delay as needed
    });
});
