document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.querySelector('.tt-hint'); // Adjust this selector to target your specific input
    var typingInterval;

    function simulateTyping() {
        if (searchInput && searchPopup.style.display === 'block') {
            console.log('Simulating typing "t"');

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
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked. Starting to simulate typing every 1 second.');
        searchPopup.style.display = 'block';

        // Start the interval to simulate typing every 1 second
        typingInterval = setInterval(simulateTyping, 1000);
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked. Stopping the typing simulation.');
        searchPopup.style.display = 'none';
        clearInterval(typingInterval); // Stop the typing simulation when the popup is closed
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup. Stopping the typing simulation.');
            searchPopup.style.display = 'none';
            clearInterval(typingInterval); // Stop the typing simulation when clicking outside the popup
        }
    });
});
