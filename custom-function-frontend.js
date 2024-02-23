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
    // Function to check if an element is visible in the viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to dispatch keyup event
    function dispatchKeyupEvent() {
        var searchInput = document.getElementById('ecsa-search-box');

        if (searchInput) {
            if (isInViewport(searchInput)) {
                console.log('#ecsa-search-box is visible.');

                // Create and dispatch a keyup event
                var event = new KeyboardEvent('keyup', {
                    key: 'a',
                    keyCode: 65,
                    code: 'KeyA',
                    which: 65,
                    shiftKey: false,
                    ctrlKey: false,
                    altKey: false,
                    metaKey: false,
                    bubbles: true,
                    cancelable: true
                });

                searchInput.dispatchEvent(event);
                console.log('Keyup event dispatched to #ecsa-search-box.');
            } else {
                console.log('#ecsa-search-box is not visible yet.');
            }
        } else {
            console.error('Input element #ecsa-search-box not found.');
        }
    }

    // Option to repeatedly check visibility and dispatch event when visible
    var checkVisibilityInterval = setInterval(function() {
        var searchInput = document.getElementById('ecsa-search-box');
        if (searchInput && isInViewport(searchInput)) {
            dispatchKeyupEvent();
            clearInterval(checkVisibilityInterval); // Stop checking once the event is dispatched
        }
    }, 1000); // Check every second
});
