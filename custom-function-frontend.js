document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.querySelector('.tt-hint'); // Ensure this targets your input
    var typingInterval;

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        // Start trying to simulate typing "t" every 1 second
        typingInterval = setInterval(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Attempting to simulate typing "t"');
                searchInput.focus();

                var event = new KeyboardEvent('keydown', {
                    key: 't', // Simulate "t" key
                    keyCode: 84, // KeyCode for "t"
                    code: 'KeyT', // Code for "t"
                    which: 84,
                    shiftKey: false,
                    ctrlKey: false,
                    metaKey: false
                });

                searchInput.dispatchEvent(event);
            }
        }, 1000); // Every 1 second
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';
        clearInterval(typingInterval); // Stop trying to simulate typing when the popup is closed
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup, closing it');
            searchPopup.style.display = 'none';
            clearInterval(typingInterval); // Stop trying to simulate typing when the popup is closed
        }
    });
});
