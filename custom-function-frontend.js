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
    // Set an interval to check and trigger the event every 1 second
    setInterval(function() {
        var searchInput = document.getElementById('ecsa-search-box');

        // Check if the input exists and is visible to the user
        if (searchInput && searchInput.offsetParent !== null) {
            console.log('Input is visible, triggering keyup event.');

            // Create a keyup event
            var event = new KeyboardEvent('keyup', {
                key: 'a', // Simulating 'a' key, change as needed
                keyCode: 65, // KeyCode for 'a'
                code: 'KeyA', // Code for 'a'
                which: 65,
                shiftKey: false,
                ctrlKey: false,
                altKey: false,
                metaKey: false,
                bubbles: true,
                cancelable: true
            });

            // Dispatch the event to the input element
            searchInput.dispatchEvent(event);
        } else {
            console.log('Input is not visible or does not exist.');
        }
    }, 1000); // 1000 milliseconds = 1 second
});