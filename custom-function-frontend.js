document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');

    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return;
    }

    searchIcon.addEventListener('click', function() {
        console.log('Search icon clicked.');
        searchPopup.style.display = 'block'; // Display the search popup

        var checkPopupInterval = setInterval(function() {
            if (searchPopup.style.display !== 'none') {
                var typeaheadContainer = document.querySelector('.twitter-typeahead');
                var typeaheadInput = typeaheadContainer ? typeaheadContainer.querySelector('.typeahead.tt-input') : null;

                if (typeaheadInput && !typeaheadInput.disabled) {
                    typeaheadInput.focus(); // Focus on the input to show the caret
                    console.log('Focused on typeahead input, caret should be visible.');

                    // Modify the DOM structure for .ecsa-search-sugestions elements
                    document.querySelectorAll('.ecsa-search-sugestions').forEach(function(suggestion) {
                        var anchor = suggestion.querySelector('a');
                        var href = anchor.href; // Get the URL from the anchor

                        // Create new anchors for .ecsa-img and .ecsa-info
                        ['ecsa-img', 'ecsa-info'].forEach(function(className) {
                            var element = suggestion.querySelector('.' + className);
                            if (element) {
                                var newAnchor = document.createElement('a');
                                newAnchor.href = href; // Set the URL to the new anchor
                                newAnchor.appendChild(element.cloneNode(true)); // Clone and append the element to the new anchor
                                element.parentNode.replaceChild(newAnchor, element); // Replace the old element with the new anchor
                            }
                        });

                        // Remove the original anchor element
                        anchor.remove();
                    });

                    clearInterval(checkPopupInterval); // Optional: Clear the interval
                } else {
                    console.log('Typeahead input is not found or it is disabled.');
                }
            } else {
                console.log('Waiting for searchPopup to be displayed...');
            }
        }, 1); // Check every 1 millisecond
    });
});
