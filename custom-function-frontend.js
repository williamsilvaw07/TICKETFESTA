document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.querySelector('.tt-hint'); // Ensure this selector targets the correct input

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        setTimeout(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Focusing on the input and simulating keydown event for "t"');
                searchInput.focus(); // Focus on the input field

                // Create a new 'keydown' event for the "t" key
                var event = new KeyboardEvent('keydown', {
                    key: 't', // Simulate "t" key
                    keyCode: 84, // KeyCode for "t"
                    code: 'KeyT', // Code for "t"
                    which: 84,
                    shiftKey: false,
                    ctrlKey: false,
                    metaKey: false
                });

                // Dispatch the event
                searchInput.dispatchEvent(event);
                console.log('Keydown event for "t" dispatched');
            }
        }, 2000); // Delay of 2 seconds
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup, closing it');
            searchPopup.style.display = 'none';
        }
    });
});
