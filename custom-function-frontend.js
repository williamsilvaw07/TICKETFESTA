document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');

    if (!searchIcon) {
        console.error('Search icon not found.');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');

        // Find the .tt-menu element within #ecsa-search
        var ttMenu = document.querySelector('#ecsa-search .tt-menu');

        if (ttMenu) {
            // Apply the CSS styles to the .tt-menu element
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
            ttMenu.style.position = 'relative!important';
            ttMenu.style.top = '0!important';
        } else {
            console.error('.tt-menu element not found within #ecsa-search.');
        }
    });
});
