document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon'); // Selector for the search icon
    var searchPopup = document.getElementById('searchPopup'); // The popup element's ID

    if (!searchIcon || !searchPopup) {
        console.error('Search icon or popup element not found.');
        return;
    }

    // Event listener for the search icon click
    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        searchPopup.style.display = 'block'; // Make the popup visible

        // Find the .tt-menu element within the popup and add the tt-open class
        var ttMenu = searchPopup.querySelector('.tt-menu');
        if (ttMenu) {
            ttMenu.classList.add('tt-open');
            console.log('.tt-menu class tt-open added');
        } else {
            console.error('.tt-menu element not found within the popup.');
        }
    });
});
