document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.querySelector('.tt-hint');

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        setTimeout(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Focusing on the input and simulating keydown event');
                searchInput.focus(); // Focus on the input field

                // Create a new 'keydown' event
                var event = new KeyboardEvent('keydown', {
                    key: 'a', // You can use any character here
                    keyCode: 65, // KeyCode for 'a'
                    code: 'KeyA', // Code for 'a'
                    which: 65,
                    shiftKey: false,
                    ctrlKey: false,
                    metaKey: false
                });

                // Dispatch the event
                searchInput.dispatchEvent(event);
                console.log('Keydown event dispatched');
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
