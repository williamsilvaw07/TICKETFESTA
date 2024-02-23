document.addEventListener('DOMContentLoaded', function() {
    // Select the search icon, search popup, close button, and search input
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.getElementById('ecsa-search-box'); // Assuming this is the ID of your search input

    // Display the search popup when the search icon is clicked
    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked'); // Debugging log
        searchPopup.style.display = 'block';

        // Wait 2 seconds before focusing and clicking on the input field
        setTimeout(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Focusing and clicking on search input after 2 seconds'); // Debugging log
                searchInput.focus(); // Focus on the input

                // Create and dispatch a new 'click' event to simulate a user click
                var clickEvent = new MouseEvent('click', {
                    'view': window,
                    'bubbles': true,
                    'cancelable': false
                });
                searchInput.dispatchEvent(clickEvent);
            }
        }, 2000); // 2000 milliseconds = 2 seconds
    });

    // Hide the search popup when the close button is clicked
    closePopup.addEventListener('click', function() {
        console.log('Close button clicked'); // Debugging log
        searchPopup.style.display = 'none';
    });

    // Optional: Close the popup when clicking outside of it
    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup'); // Debugging log
            searchPopup.style.display = 'none';
        }
    });
});