document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    //console.log('Search icon element:', searchIcon); // Check if the search icon is correctly identified

    if (!searchIcon) {
        console.error('Search icon not found.');
        return;
    }

    function openSearchPopup() {
        //console.log('Attempting to open search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        searchPopup.style.display = 'block';
        //console.log('Search popup should now be visible.');
    }

    searchIcon.addEventListener('click', openSearchPopup);
    searchIcon.addEventListener('touchend', function(event) {
        event.preventDefault(); // Prevent the click event from firing after touchend
        openSearchPopup();
    });

    //console.log('Event listeners attached.'); // Confirm that event listeners are attached
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










document.addEventListener('DOMContentLoaded', function() {
    var searchIconMobile = document.querySelector('.header_search_icon_mobile');

    if (!searchIconMobile) {
        console.error('Mobile search icon not found.');
    } else {
        console.log('Mobile search icon element found:', searchIconMobile);
    }

    function openSearchPopup() {
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        searchPopup.style.display = (searchPopup.style.display === 'block') ? 'none' : 'block';
        console.log('Mobile search popup toggled.');
    }

    function handleMobileIconTap(event) {
        event.preventDefault();
        event.stopPropagation();
        console.log('Mobile icon tapped.');
        openSearchPopup();
    }

    searchIconMobile.addEventListener('click', handleMobileIconTap);
    searchIconMobile.addEventListener('touchstart', handleMobileIconTap, { passive: false });

    console.log('Event listeners attached for mobile search icon.');
});
