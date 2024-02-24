document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon'); // Selector for the search icon
    var searchPopup = document.getElementById('searchPopup'); // The search popup element

    if (!searchIcon || !searchPopup) {
        console.error('Search icon or popup not found.'); // Log error if elements are not found
        return;
    }

    // Function to open the search popup
    function openSearchPopup() {
        console.log('Opening search popup...'); // Log opening action
        searchPopup.style.display = 'block'; // Change the display style to block to show the popup
        console.log('Search popup is now visible.'); // Log visibility change
    }

    // Event listeners for opening the popup on click or touch
    searchIcon.addEventListener('click', openSearchPopup);
    searchIcon.addEventListener('touchstart', openSearchPopup);
});




document.addEventListener('DOMContentLoaded', function() {
    // Close popup when clicking the close button
    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });

    // Close popup when clicking outside of the popup content area
    document.getElementById('searchOverlay').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });
});