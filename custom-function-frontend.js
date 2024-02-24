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





setInterval(function() {
    // Find the container with the 'twitter-typeahead' class
    var typeaheadContainer = document.querySelector('.twitter-typeahead');

    // Find the input with the 'typeahead' class within the container
    var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead') : null;

    // Check if the input exists and is not disabled
    if (typeaheadInput && !typeaheadInput.disabled) {
        // Check if the input is visible
        if (typeaheadInput.offsetParent !== null) {
            console.log('Typeahead input is visible and enabled, simulating mouse click.');

            // Create a mouse click event
            var clickEvent = new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true,
                clientX: typeaheadInput.getBoundingClientRect().left,
                clientY: typeaheadInput.getBoundingClientRect().top
            });

            // Dispatch the event to the input element
            typeaheadInput.dispatchEvent(clickEvent);

            console.log('Simulated mouse click on typeahead input.');
        } else {
            console.log('Typeahead input is not visible.');
        }
    } else if (typeaheadInput && typeaheadInput.disabled) {
        console.log('Typeahead input is disabled.');
    } else {
        console.log('Typeahead input not found.');
    }
}, 2000); // 2000 milliseconds = 2 seconds
