document.addEventListener('DOMContentLoaded', function() {
    // Selectors for the search icon and search popup
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');

    // Check if the required elements are present
    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return;
    }

    // Event listener for the search icon click
    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        // Display the search popup when the icon is clicked
        searchPopup.style.display = 'block';

        // Set an interval to repeatedly check if the popup is visible
        var checkPopupInterval = setInterval(function() {
            // Check if the popup is currently visible
            if (searchPopup.style.display !== 'none') {
                // Selector for the typeahead input within the twitter-typeahead container
                var typeaheadContainer = document.querySelector('.twitter-typeahead');
                var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

                // Check if the typeahead input exists and is not disabled
                if (typeaheadInput && !typeaheadInput.disabled) {
                    // Focus on the typeahead input to show the caret
                    typeaheadInput.focus();
                    console.log('Focused on typeahead input, caret should be visible.');

                    // Optionally, clear the interval if you only want to focus once after the popup is visible
                    // clearInterval(checkPopupInterval);
                } else {
                    console.log('Typeahead input is not found or it is disabled.');
                }
            } else {
                console.log('Waiting for searchPopup to be displayed...');
            }
        }, 1); // Check every 1 millisecond
    });
});
