document.addEventListener('DOMContentLoaded', function() {
    // Function to handle click event on the search icon
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');

    // Display the search popup when the search icon is clicked
    searchIcon.addEventListener('click', function() {
        searchPopup.style.display = 'block';
    });

    // Function to handle click event on the close button of the popup
    // Hide the search popup when the close button is clicked
    closePopup.addEventListener('click', function() {
        searchPopup.style.display = 'none';
    });

    // Function to handle click events outside the popup to close it
    // Optional: Close the popup when clicking outside of it
    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            searchPopup.style.display = 'none';
        }
    });
});