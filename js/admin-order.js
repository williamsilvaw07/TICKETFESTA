jQuery(document).ready(function($) {
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-ticket-name').text().trim();
    var Ticketprice = parseFloat(textContent.match(/\d+(\.\d+)?/)[0]);
    
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-stat').text().trim();
    var quantity = parseFloat(textContent.match(/\b\d+\b/)[0]);

    console.log('Ticketprice: ', Ticketprice);
    console.log('Quantity: ', quantity);
});