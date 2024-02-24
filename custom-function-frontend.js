document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var checkPopupInterval; // Declare the interval variable outside so it's accessible later

    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        searchPopup.style.display = 'block'; // Display the search popup

        checkPopupInterval = setInterval(function() {
            if (searchPopup.style.display !== 'none') {
                var typeaheadContainer = document.querySelector('.twitter-typeahead');
                var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

                if (typeaheadInput && !typeaheadInput.disabled) {
                    typeaheadInput.focus(); // Focus on the input
                    console.log('Focused on typeahead input, caret should be visible.');

                    // Event listener to stop the interval when the user starts typing
                    typeaheadInput.addEventListener('input', function() {
                        console.log('User started typing, stopping the interval.');
                        clearInterval(checkPopupInterval);
                    });

                } else {
                    console.log('Typeahead input is not found or it is disabled.');
                }
            } else {
                console.log('Waiting for searchPopup to be displayed...');
            }
        }, 1); // Check every 1 millisecond
    });
});




document.addEventListener('DOMContentLoaded', function() {
    // Close popup when clicking the close button
    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });

    // Close popup when clicking outside of the popup content area
    document.getElementById('searchOverlay').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });
});