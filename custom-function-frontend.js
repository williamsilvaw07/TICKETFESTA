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
    // Attach the event listener to a parent container that exists at page load
    var navContainer = document.querySelector('.elementor-nav-menu__container');

    if (!navContainer) {
        console.error('Nav menu container not found.');
        return;
    }

    function openSearchPopup() {
        console.log('Attempting to open mobile search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        // Toggle the display of the search popup
        searchPopup.style.display = (searchPopup.style.display === 'block') ? 'none' : 'block';
        console.log('Mobile search popup toggled.');
    }

    // Function to handle tap events, checking if they originated from a .header_search_icon_mobile element
    function handleNavTap(event) {
        var target = event.target;
        var searchIconMobile = target.closest('.header_search_icon_mobile');

        if (searchIconMobile) {
            event.preventDefault(); // Prevent default actions
            console.log('Mobile search icon tapped.');
            openSearchPopup(); // Call the function to open the search popup
        }
    }

    // Attach event listeners for both touch and click events using event delegation
    navContainer.addEventListener('click', handleNavTap);
    navContainer.addEventListener('touchend', handleNavTap);

    console.log('Event delegation set up for mobile search icon.');
});
