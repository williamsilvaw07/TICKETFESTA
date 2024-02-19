jQuery(document).ready(function($) {
// Check if the element with the specified class exists
var termsWrapper = document.querySelector('.woocommerce-terms-and-conditions-wrapper');

if (termsWrapper) {
    // Create a checkbox input field
    var checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = 'subscribed_organiser';
    checkbox.id = 'subscribed_organiser';
    checkbox.value = 'checked'; 

    checkbox.checked = true;
    var label = document.createElement('label');
    label.htmlFor = 'subscribed_organiser';
    label.appendChild(document.createTextNode('Subscribe to event organizer.'));

    // Append the checkbox and label to the terms wrapper
    termsWrapper.appendChild(checkbox);
    termsWrapper.appendChild(label);
}

});