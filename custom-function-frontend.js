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
    // Find the input element
    var searchInput = document.getElementById('ecsa-search-box');

    if (searchInput) {
        // Create a keyup event
        var event = new KeyboardEvent('keyup', {
            key: 'a', // You can choose any key to simulate, here we use 'a'
            keyCode: 65, // 'a' key's keyCode
            code: 'KeyA', // Code for 'a' key
            which: 65,
            shiftKey: false,
            ctrlKey: false,
            altKey: false,
            metaKey: false,
            bubbles: true, // Make sure the event bubbles up through the DOM
            cancelable: true // Make it cancelable
        });

        // Dispatch the event to the input element
        searchInput.dispatchEvent(event);
        console.log('Keyup event dispatched to #ecsa-search-box');
    } else {
        console.error('Input element #ecsa-search-box not found.');
    }
});