document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    var searchPopup = document.getElementById('searchPopup');
    var checkPopupInterval;

    if (!searchIcon || !searchPopup) {
        console.error('Required elements not found.');
        return;
    }

    function openSearchPopup() {
        console.log('Search icon activated.');
        searchPopup.style.display = 'block';

        checkPopupInterval = setInterval(function() {
            if (searchPopup.style.display !== 'none') {
                var typeaheadInput = document.getElementById('ecsa-search-box-active');

                if (typeaheadInput && !typeaheadInput.disabled) {
                    typeaheadInput.focus();
                    console.log('Focused on typeahead input, caret should be visible.');

                    typeaheadInput.addEventListener('input', function() {
                        console.log('User started typing, stopping the interval.');
                        clearInterval(checkPopupInterval);
                    });
                } else {
                    console.log('Typeahead input is not found or it is disabled.');
                }
            } else {
                console.log('Waiting for searchPopup to be displayed...');
            }
        }, 1);
    }

    searchIcon.addEventListener('click', openSearchPopup);
    searchIcon.addEventListener('touchstart', openSearchPopup);
});





document.addEventListener('DOMContentLoaded', function() {
    // Close popup when clicking the close button
    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });

    // Close popup when clicking outside of the popup content area
    document.getElementById('searchOverlay').addEventListener('click', function() {
        document.getElementById('searchPopup').style.display = 'none';
    });
});