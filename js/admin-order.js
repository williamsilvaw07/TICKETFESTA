jQuery(document).ready(function($) {
    let newText = '<strong>Total Site Fees:</strong> £' + window.order_data.site_fees;
    jQuery('.tribe-event-meta-total-site-fees').html(newText);
});