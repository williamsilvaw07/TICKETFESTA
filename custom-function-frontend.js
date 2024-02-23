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

        // Find the .tt-menu element within the popup, add the tt-open class, and set aria-expanded to true
        var ttMenu = searchPopup.querySelector('.tt-menu');
        if (ttMenu) {
            ttMenu.classList.add('tt-open');
            ttMenu.setAttribute('aria-expanded', 'true'); // Set aria-expanded to true
            console.log('.tt-menu class tt-open added and aria-expanded set to true');
        } else {
            console.error('.tt-menu element not found within the popup.');
        }
    });
});
