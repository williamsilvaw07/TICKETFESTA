document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');

    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return; // Exit if elements are not found
    }

    // Function to handle opening the search popup
    function openSearchPopup() {
        console.log('Search icon activated.');
        searchPopup.style.display = 'block'; // Display the search popup
    }

    // Add event listeners for both click and touchstart events
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