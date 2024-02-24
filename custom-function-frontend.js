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
    var typeaheadContainer = document.querySelector('.twitter-typeahead');
    var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead') : null;

    if (typeaheadInput && !typeaheadInput.disabled && typeaheadInput.offsetParent !== null) {
        console.log('Typeahead input is visible and enabled, simulating keyup event.');

        // Simulate a keyup event for the 'a' key
        var keyupEvent = new KeyboardEvent('keyup', {
            key: 'a', // Simulate 'a' key
            code: 'KeyA', // Code for 'a' key
            keyCode: 65, // KeyCode for 'a'
            charCode: 0, // Character code 'a', for compatibility
            bubbles: true, // Ensure the event bubbles up through the DOM
            cancelable: true // Ensure the event is cancelable
        });

        // Dispatch the keyup event to the input element
        typeaheadInput.dispatchEvent(keyupEvent);

        console.log('Simulated keyup event on typeahead input.');
    } else {
        if (!typeaheadInput) {
            console.log('Typeahead input not found.');
        } else if (typeaheadInput.disabled) {
            console.log('Typeahead input is disabled.');
        } else {
            console.log('Typeahead input is not visible.');
        }
    }
}, 2000); // Repeat every 2000 milliseconds (2 seconds)
