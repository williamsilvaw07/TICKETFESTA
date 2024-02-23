document.addEventListener('DOMContentLoaded', function() {
    // Select the search icon, search popup, close button, and search input
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.getElementById('ecsa-search-box'); // Assuming this is the ID of your search input

    // Display the search popup and focus on the input field when the search icon is clicked
    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked'); // Debugging log
        searchPopup.style.display = 'block';

        // Check if the search input exists and is visible
        if (searchInput && searchPopup.style.display === 'block') {
            console.log('Focusing on search input'); // Debugging log
            searchInput.focus(); // Focus on the input to bring up the keyboard on mobile devices
            searchInput.click(); // Trigger a click event on the input
        }
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
