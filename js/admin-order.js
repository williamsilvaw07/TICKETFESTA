jQuery(document).ready(function($) {
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-ticket-name').text().trim();
    var ticketPrice = parseFloat(textContent.match(/\d+(\.\d+)?/)[0]);
    
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-stat').text().trim();
    var quantity = parseFloat(textContent.match(/\b\d+\b/)[0]);

    console.log('Ticketprice: ', ticketPrice);
    console.log('Quantity: ', quantity);
    let newText = '<strong>Total Site Fees:</strong> £' + window.order_data.site_fees;
    jQuery('.tribe-event-meta-total-site-fees').html(newText);
});