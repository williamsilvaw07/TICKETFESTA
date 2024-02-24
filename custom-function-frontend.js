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
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon'); // Selector for the search icon

    if (searchIcon) {
        searchIcon.addEventListener('click', function() {
            // Set an interval to check if the popup is visible
            var checkPopupInterval = setInterval(function() {
                var searchPopup = document.getElementById('searchPopup');

                // Check if the popup is visible
                if (searchPopup && searchPopup.style.display !== 'none') {
                    var typeaheadContainer = document.querySelector('.twitter-typeahead');
                    var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

                    if (typeaheadInput && !typeaheadInput.disabled) {
                        setTimeout(function() { // Add a slight delay before focusing
                            typeaheadInput.focus(); // Focus on the input field to show the caret
                            console.log('Focused on typeahead input, caret should be visible.');
                        }, 1000); // 1000 milliseconds = 1 second
                        
                        clearInterval(checkPopupInterval); // Clear the interval to stop checking
                    } else {
                        console.log('Typeahead input is not found or it is disabled.');
                    }
                } else {
                    console.log('Waiting for searchPopup to be displayed...');
                }
            }, 500); // Check every 500 milliseconds
        });
    } else {
        console.log('Search icon not found.');
    }
});
