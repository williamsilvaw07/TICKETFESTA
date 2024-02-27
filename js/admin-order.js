jQuery(document).ready(function($) {
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-ticket-name').text().trim();
    var ticketPrice = parseFloat(textContent.match(/\d+(\.\d+)?/)[0]);
    
    var textContent = $('.tec-tickets__admin-orders-report-overview-ticket-type-list-item-stat').text().trim();
    var quantity = parseFloat(textContent.match(/\b\d+\b/)[0]);

    console.log('Ticketprice: ', ticketPrice);
    console.log('Quantity: ', quantity);
    var ticketFee = get_tribe_ticket_fee(ticketPrice, quantity = 1);
    let newText = '<strong>Total Site Fees:</strong> ' + ticketFee;
    jQuery('.tribe-event-meta-total-site-fees').text(newText);
});

function get_tribe_ticket_fee(ticketAmount, quantity = 1){
    ticketSiteFee = 0;
    if(ticketAmount < 50 ){
        ticketSiteFee += (ticketAmount * .03 + 0.02) * quantity;
    }
    if(ticketAmount > 50 ){
        ticketSiteFee += (ticketAmount *  .01 + 0.02) * quantity;
    }

    return ticketSiteFee.toFixed(2);
}