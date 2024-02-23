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

                // Optionally, add visual cues to indicate the field is active
                searchInput.style.boxShadow = '0 0 0 2px #007bff'; // Example: blue glow effect
                searchInput.style.border = '1px solid #007bff'; // Example: blue border
            }
        }, 1000); // Adjust the timeout as needed to ensure the popup is fully visible
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';

        // Reset any visual cues when closing the popup
        if (searchInput) {
            searchInput.style.boxShadow = '';
            searchInput.style.border = '';
        }
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup');
            searchPopup.style.display = 'none';

            // Reset any visual cues when closing the popup
            if (searchInput) {
                searchInput.style.boxShadow = '';
                searchInput.style.border = '';
            }
        }
    });
});
