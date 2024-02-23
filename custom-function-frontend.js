document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var searchInput = document.getElementById('ecsa-search-box');

    if (!searchIcon || !searchPopup || !searchInput) {
        console.error('Required elements not found.');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        searchPopup.style.display = 'block'; // Ensure the search popup is displayed

        // Function to simulate typing in the input field
        function simulateTyping() {
            console.log('Simulating typing in the input field.');
            searchInput.focus(); // Focus the input field before simulating typing

            // Simulate a keydown event for the character "t"
            var event = new KeyboardEvent('keydown', {
                key: 't',
                code: 'KeyT',
                which: 84,
                keyCode: 84
            });

            searchInput.dispatchEvent(event);
        }

        // Start an interval to simulate typing every 1 second
        setInterval(simulateTyping, 1000);
    });
});
