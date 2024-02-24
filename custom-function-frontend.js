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
    var typingInterval = setInterval(function() {
        var searchInput = document.getElementById('ecsa-search-box');

        // Check if the input exists and is visible to the user
        if (searchInput && searchInput.offsetParent !== null) {
            console.log('Input is visible.');

            // Simulate typing by setting the input's value
            var existingValue = searchInput.value;
            searchInput.value = existingValue + 'a'; // Append 'a' to the current value to simulate typing

            // Create a new 'input' event since setting value doesn't trigger it
            var event = new Event('input', { bubbles: true });
            searchInput.dispatchEvent(event);

            console.log('Simulated typing into input.');

            // Optional: Clear the interval if you only want to simulate typing once
            // clearInterval(typingInterval);
        } else {
            console.log('Input is not visible or does not exist.');
        }
    }, 1000); // 2000 milliseconds = 2 seconds
});