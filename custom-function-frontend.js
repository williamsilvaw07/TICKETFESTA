document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');

    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        searchPopup.style.display = 'block'; // Ensure the search popup is displayed

        // Select all .tt-dataset elements within the searchPopup and set them to display: block
        var datasets = searchPopup.querySelectorAll('.tt-dataset');
        datasets.forEach(function(dataset) {
            dataset.style.display = 'block';
        });
    });
});
