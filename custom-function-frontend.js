document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

    // Function to handle click event on the search icon
    var searchIcon = document.querySelector('.header_search_icon');
    if (searchIcon) {
        console.log('Search icon found');
    } else {
        console.log('Search icon not found');
    }

    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');

    // Display the search popup when the search icon is clicked
    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        // Trigger click on the input field inside the popup after it becomes visible
        var searchInput = document.getElementById('ecsa-search-box');
        if (searchInput) {
            console.log('Search input found. Triggering click...');
            searchInput.click(); // Trigger click on the input field
            searchInput.focus(); // Optionally, focus on the input field
        } else {
            console.log('Search input not found');
        }
    });

    // Hide the search popup when the close button is clicked
    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';
    });

    // Optional: Close the popup when clicking outside of it
    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup');
            searchPopup.style.display = 'none';
        }
    });
});