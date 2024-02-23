document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var searchInput = document.getElementById('ecsa-search-box');
    var clickInterval;

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        // Clear any existing interval to avoid multiple intervals running simultaneously
        if (clickInterval) {
            clearInterval(clickInterval);
        }

        // Start trying to "click" the input every 1 second
        clickInterval = setInterval(function() {
            if (searchInput) {
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

    // Optional: Add a way to stop the interval if needed
    // For example, you can stop it when the close button is clicked
    document.getElementById('closePopup').addEventListener('click', function() {
        clearInterval(clickInterval);
        console.log('Close button clicked. Stopping repeating clicks.');
    });
});
