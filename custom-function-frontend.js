document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');
    // Selecting the input using its class 'tt-hint'
    var searchInput = document.querySelector('.tt-hint'); 

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked');
        searchPopup.style.display = 'block';

        // Wait for the popup to fully open and content to be ready
        setTimeout(function() {
            if (searchInput && searchPopup.style.display === 'block') {
                console.log('Attempting to click on the input');
                // Programmatically triggering a 'click' event on the input field
                searchInput.click(); 
                console.log('Clicked on the input after 2 seconds');
            }
        }, 2000); // 2000 milliseconds = 2 seconds delay
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');
        searchPopup.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            console.log('Clicked outside the popup, closing it');
            searchPopup.style.display = 'none';
        }
    });
});
