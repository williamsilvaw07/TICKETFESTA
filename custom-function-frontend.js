document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon'); // Ensure this selector targets your search icon correctly
    var searchPopup = document.getElementById('searchPopup'); // This should match the ID of your popup container

    if (!searchIcon || !searchPopup) {
        console.error('Search icon or popup element not found');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block'; // This should show the popup

        // Optional: Focus on the search input after a slight delay to ensure it's ready
        setTimeout(function() {
            var searchInput = document.getElementById('ecsa-search-box');
            if (searchInput) {
                console.log('Focusing on search input');
                searchInput.focus();
            } else {
                console.log('Search input not found');
            }
        }, 500); // Adjust this delay as needed
    });
});
