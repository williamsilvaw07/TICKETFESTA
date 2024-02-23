document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    var searchInput = document.getElementById('ecsa-search-box');

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        setTimeout(function() {
            if (searchInput) {
                console.log('Focusing on search input');
                searchInput.focus(); // Focus on the input
            }
        }, 1000); // Delay to ensure the popup is fully visible
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup');
            searchPopup.style.display = 'none';
        }
    });
});
