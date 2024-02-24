document.addEventListener('DOMContentLoaded', function() {
    var searchIcon = document.querySelector('.header_search_icon');
    console.log('Search icon element:', searchIcon); // Check if the search icon is correctly identified

    if (!searchIcon) {
        console.error('Search icon not found.');
        return;
    }

    function openSearchPopup() {
        console.log('Attempting to open search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        searchPopup.style.display = 'block';
        console.log('Search popup should now be visible.');
    }

    searchIcon.addEventListener('click', openSearchPopup);
    searchIcon.addEventListener('touchend', function(event) {
        event.preventDefault(); // Prevent the click event from firing after touchend
        openSearchPopup();
    });

    console.log('Event listeners attached.'); // Confirm that event listeners are attached
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
    var searchIconMobile = document.querySelector('.header_search_icon_mobile'); // Target the mobile search icon
    console.log('Mobile search icon element:', searchIconMobile); // Check if the mobile search icon is correctly identified

    if (!searchIconMobile) {
        console.error('Mobile search icon not found.');
        return;
    }

    function openSearchPopup() {
        console.log('Attempting to open mobile search popup...');
        var searchPopup = document.getElementById('searchPopup');

        if (!searchPopup) {
            console.error('Search popup element not found.');
            return;
        }

        searchPopup.style.display = 'block'; // Show the search popup
        console.log('Mobile search popup should now be visible.');
    }

    // Function to handle tap events on the mobile icon
    function handleMobileIconTap(event) {
        event.preventDefault(); // Prevent default actions (like navigating to a link)
        openSearchPopup(); // Call the function to open the search popup
    }

    // Attach event listeners for both touch and click events
    searchIconMobile.addEventListener('click', handleMobileIconTap);
    searchIconMobile.addEventListener('touchend', handleMobileIconTap);

    console.log('Event listeners attached for mobile search icon.'); // Confirm that event listeners are attached
});
