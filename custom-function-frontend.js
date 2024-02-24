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
    var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

    if (typeaheadInput && !typeaheadInput.disabled && typeaheadInput.offsetParent !== null) {
        console.log('Typeahead input is visible and enabled, focusing.');

        typeaheadInput.focus(); // Focus on the input field to show the typing cursor

        // Optional: If you want to simulate the effect of typing, you can append characters
        typeaheadInput.value += "|"; // Adding a character to simulate typing, you can choose any character

        // Trigger the input event to notify any listeners that the value has changed
        var event = new Event('input', { bubbles: true });
        typeaheadInput.dispatchEvent(event);

        console.log('Focused on typeahead input and simulated typing effect.');
    } else {
        console.log('Typeahead input is not visible, disabled, or not found.');
    }
}, 2000); // 2000 milliseconds = 2 seconds
