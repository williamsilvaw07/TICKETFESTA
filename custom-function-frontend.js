document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchInput = document.getElementById('ecsa-search-box'); // Adjust this selector to target your input

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        // Directly show the search popup without waiting
        document.getElementById('searchPopup').style.display = 'block';

        // Focus on the input field
        if (searchInput) {
            console.log('Focusing on search input');
            searchInput.focus(); // Focus on the input
        }
    });

    // If you still want the close button to hide the popup, you can keep this listener
    document.getElementById('closePopup').addEventListener('click', function() {
        console.log('Close button clicked');
        document.getElementById('searchPopup').style.display = 'none';
    });

    // Removed the listener for clicking outside the popup to close it
});
