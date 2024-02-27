jQuery(document).ready(function($) {
    console.log('hello from order js');
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-ticket-name').text().trim();

    // Extract the numeric value using regular expression
    var Ticketprice = parseFloat(textContent.match(/\d+(\.\d+)?/)[0]);

    // Output the parsed float value
    console.log('Ticketprice: ', Ticketprice);
});