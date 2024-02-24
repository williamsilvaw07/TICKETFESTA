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
            console.log('Typeahead input is visible and enabled, simulating typing.');

            // Simulate typing by appending 'a' to the input's value, adjust as needed
            typeaheadInput.value += "a";

            // Create a new 'input' event since setting value programmatically doesn't trigger it
            var event = new Event('input', { bubbles: true });
            typeaheadInput.dispatchEvent(event);

            console.log('Simulated typing into typeahead input.');
        } else {
            console.log('Typeahead input is not visible.');
        }
    } else if (typeaheadInput && typeaheadInput.disabled) {
        console.log('Typeahead input is disabled.');
    } else {
        console.log('Typeahead input not found.');
    }
}, 2000); // 2000 milliseconds = 2 seconds
