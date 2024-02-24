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
    var searchIcon = document.querySelector('.header_search_icon'); // Assuming this is your trigger element

    if (searchIcon) {
        searchIcon.addEventListener('click', function() {
            // Delay the focus action by 5 seconds
            setTimeout(function() {
                var typeaheadContainer = document.querySelector('.twitter-typeahead');
                var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

                if (typeaheadInput && !typeaheadInput.disabled) {
                    typeaheadInput.focus(); // Focus on the input field to show the caret
                    console.log('Focused on typeahead input, caret should be visible.');
                } else {
                    console.log('Typeahead input is not found or it is disabled.');
                }
            }, 5000); // 5000 milliseconds = 5 seconds
        });
    } else {
        console.log('Search icon not found.');
    }
});
