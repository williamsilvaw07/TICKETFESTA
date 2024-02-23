
document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var closePopup = document.getElementById('closePopup');

    searchIcon.addEventListener('click', function() {
        searchPopup.style.display = 'block';
    });

    closePopup.addEventListener('click', function() {
        searchPopup.style.display = 'none';
    });

    // Optional: Close the popup when clicking outside of it
    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('searchOverlay')) {
            searchPopup.style.display = 'none';
        }
    });
});

