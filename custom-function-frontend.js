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
    // Find the container where the span will be added
    var navContainer = document.querySelector('.elementor-nav-menu__container');

    if (!navContainer) {
        console.error('Nav menu container not found.');
        return;
    }

    // Create the span element and add the required classes
    var searchIconMobile = document.createElement('span');
    searchIconMobile.classList.add('header_search_icon_mobile', 'jsclass');
    searchIconMobile.textContent = 'Search'; // Add text or you can append an icon/image

    // Append the newly created span to the nav container
    navContainer.appendChild(searchIconMobile);
    console.log('Mobile search icon span added to the nav container.');

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

    // Function to handle click/tap events on the newly added span
    function handleMobileIconTap(event) {
        event.preventDefault(); // Prevent default actions
        console.log('Mobile search icon span tapped.');
        openSearchPopup(); // Call the function to open the search popup
    }

    // Attach event listeners for both click and touch events to the span
    searchIconMobile.addEventListener('click', handleMobileIconTap);
    searchIconMobile.addEventListener('touchend', handleMobileIconTap);

    console.log('Event listeners attached to the mobile search icon span.');
});
