document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var searchInput = document.getElementById('ecsa-search-box');
    var clickInterval;

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        // Start trying to "click" the input every 1 second
        clickInterval = setInterval(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Attempting to click on the input');

                // Focus before click might help some UI components recognize the interaction
                searchInput.focus();

                // Create and dispatch a mouse click event
                var clickEvent = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true
                });
                searchInput.dispatchEvent(clickEvent);
            }
        }, 1000); // Repeat every 1 second
    });

    // Consider stopping the interval when the popup is closed or when the user starts interacting with the input
    searchPopup.addEventListener('click', function(event) {
        if (event.target === searchInput || event.target.id === 'closePopup') {
            clearInterval(clickInterval);
            console.log('Stopped repeating clicks');
        }
    });
});
