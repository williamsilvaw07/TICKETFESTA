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
    var searchInput = document.getElementById('ecsa-search-box');

    // Check if the input exists
    if (searchInput) {
        // Check if the input is visible and not disabled
        if (searchInput.offsetParent !== null && searchInput.disabled) {
            console.log('Input is visible but disabled, enabling it now.');
            searchInput.disabled = false; // Enable the input
        }

        // Check again if the input is visible and now enabled
        if (searchInput.offsetParent !== null && !searchInput.disabled) {
            console.log('Input is visible and enabled, simulating typing.');

            // Simulate typing by setting the input's value
            var simulatedText = "Hello"; // Change this to whatever you want to simulate typing
            searchInput.value = simulatedText;

            // Create a new 'input' event since setting value programmatically doesn't trigger it
            var event = new Event('input', { bubbles: true });
            searchInput.dispatchEvent(event);

            console.log('Simulated typing "' + simulatedText + '" into input.');
        } else {
            console.log('Input is not visible or still disabled.');
        }
    } else {
        console.log('Input element #ecsa-search-box not found.');
    }
}, 2000); // 2000 milliseconds = 2 seconds
