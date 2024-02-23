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

        // Additional styles for #ecsa-search .tt-menu can be applied here if needed
        var ttMenu = searchPopup.querySelector('#ecsa-search .tt-menu');
        if (ttMenu) {
            ttMenu.style.width = '100%';
            ttMenu.style.display = 'inline-block';
            ttMenu.style.maxHeight = '300px';
            ttMenu.style.overflowX = 'hidden';
            ttMenu.style.overflowY = 'auto';
            ttMenu.style.marginTop = '5px';
            ttMenu.style.padding = '0';
            ttMenu.style.backgroundColor = '#fff';
            ttMenu.style.border = '1px solid rgba(0,0,0,.2)';
            ttMenu.style.borderRadius = '2px';
            ttMenu.style.boxShadow = '0 2px 5px rgba(0,0,0,.15)';
            ttMenu.style.position = 'relative';
            ttMenu.style.top = '0';
        }
    });
});
