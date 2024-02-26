// custom-ajax.js
// O

function parseQueryString(queryString) {
  var params = {};

  queryString.split("&").forEach(function (param) {
    var keyValue = param.split("=");
    var key = decodeURIComponent(keyValue[0]);
    var value = keyValue.length > 1 ? decodeURIComponent(keyValue[1]) : null;
    params[key] = value;
  });

  return params;
}

function updateTicket() {
  console.log('updateTicket');

  var eventId = jQuery("#event_id").val();
  //var responseData = xhr.responseText;
  if (!eventId) return;


  var htmlOutputStart = `<label>Tickets</label>`;


  jQuery.ajax({
    url: iam00_ajax_object.ajax_url, // AJAX URL set by WordPress
    type: "post",
    data: {
      action: "get_event_ticket_action", // Custom AJAX action
      nonce: iam00_ajax_object.nonce,
      event_id: eventId,
    },
    success: function (response) {
      // Handle the response from the server
      if (response.success) {
        Object.entries(response.data).forEach(([key, value]) => {
          htmlOutputStart +=
            `<div class="form-check">
                <input class="form-check-input" id="product_ids_`+ key + `" type="checkbox" name="product_ids[]" value="`+ key + `">
                <label class="form-check-label" for="product_ids_`+ key + `">`+ value + `</label>
            </div>`;
        });

        jQuery("#tickets").html(htmlOutputStart);
      }
    },
  });
}

function addCreateEventForm() {
  var eventId = jQuery("#post_ID").val();
  //var responseData = xhr.responseText;
  if (!eventId) return;

  var htmlOutputStart = `
  
    <div class="tribe-section tribe-section-terms">
        <div class="tribe-section-header">
          <h3>Coupon</h3>
          <div id="couponList"></div>
        </div>
        <div class="tribe-section-content">
          <span class="coupon_title_section">Code</span>
          <input type="text" class="event-terms-description" id="coupon_code" name="coupon_code"/>
          <br>
          <span class="coupon_title_section">Amount</span>
          <input type="text" class="event-terms-description" id="amount" name="amount"/>
          <br>
          <span class="coupon_title_section">Discount Type</span> 
          <select name="discount_type" id="discount_type">
          <option value="percent">Percent</option>
          <option value="fixed">Fixed</option>
          </select>
          <br/>
          <span class="coupon_title_section">usage limit</span> 
          <input type="text" class="event-terms-description" id="usage_limit" name="usage_limit"/>
          <br>
          <span class="coupon_title_section tribe-datepicke">start date</span> 
          <input type="text" class="hasDatepicker" id="start_date" name="start_date"/>
          <br>
          <span class="coupon_title_section">start time</span>
          <input type="text" class="event-terms-description tribe-datepicker tribe-field-start_date ticket_field hasDatepicker" id="start_time" name="start_time"/>
          <br>
          <span class="coupon_title_section">expire date</span> 
          <input type="text" class="event-terms-description" id="expire_date" name="expire_date"/>
          <br>
          <span class="coupon_title_section">expire time</span> 
          <input type="text" class="event-terms-description" id="expire_time" name="expire_time"/>
          <br>`;

  var htmlOutputEnd = `<br/>
          <input type="button" id="coupon_form_save" class="button-primary tribe-dependent tribe-validation-submit tribe-active" name="ticket_form_save" value="Save ticket">
        </div>
    </div>
  `;

  jQuery.ajax({
    url: iam00_ajax_object.ajax_url, // AJAX URL set by WordPress
    type: "post",
    data: {
      action: "get_event_ticket_action", // Custom AJAX action
      nonce: iam00_ajax_object.nonce,
      event_id: eventId,
    },
    success: function (response) {
      // Handle the response from the server
      var options = "";

      if (response.success) {
        Object.entries(response.data).forEach(([key, value]) => {
          options +=
            `<label class="coupon_ticket_list" for="option` +
            key +
            `">
            <input type="checkbox" name="product_ids[]" id="option` +
            key +
            `" value="` +
            key +
            `"> ` +
            value +
            `
        </label><br/>`;
        });

        jQuery("#eventCouponForm").html(htmlOutputStart + options + htmlOutputEnd);
        // jQuery("#eventCouponForm").find("#start_date").datepicker();
      }
    },
  });
}


jQuery(document).ready(function (jQuery) {
  // Select the parent element with class .tribe-community-notice.tribe-community-notice-update
  // Find all elements with the class .tribe-community-notice.tribe-community-notice-update
  const parentElements = document.querySelectorAll('.tribe-community-notice.tribe-community-notice-update');

  // Loop through each parent element
  parentElements.forEach(parentElement => {
    // Find the .edit-event element within the parent element
    const editEventElement = parentElement.querySelector('.edit-event');

    // If the .edit-event element is found
    if (editEventElement) {
      // Get the current href attribute value
      let currentHref = editEventElement.getAttribute('href');

      // Replace the part of the href attribute value
      currentHref = currentHref.replace('/events/organizer/edit/', '/organizer-edit-event/?event_id=');

      // Update the href attribute with the new value
      editEventElement.setAttribute('href', currentHref);
    }
  });


  // Function to parse the query string into a JavaScript object
  // AJAX request when the button is clicked
  jQuery(document).on("click", "#coupon_form_save", function () {
    $(this).attr('disabled');

    var eventId = jQuery("#event_id").val();

    var checkboxes = document.querySelectorAll(
      'input[name="product_ids[]"]:checked'
    );

    var coupon_code = document.getElementById("coupon_code");
    var discount_type = document.getElementById("discount_type");
    var amount = document.getElementById("amount");
    // var usage_limit = document.getElementById("usage_limit");
    var start_date_time = document.getElementById("start_date_time");
    var end_date_time = document.getElementById("end_date_time");

    var selectedValues = [];
    checkboxes.forEach(function (checkbox) {
      selectedValues.push(parseInt(checkbox.value));
    });

    jQuery.ajax({
      url: iam00_ajax_object.ajax_url, // AJAX URL set by WordPress
      type: "post",
      data: {
        action: "add_coupon_action", // Custom AJAX action
        nonce: iam00_ajax_object.nonce,
        event_id: eventId,
        product_ids: selectedValues,
        coupon_code: coupon_code.value,
        discount_type: discount_type.value,
        amount: amount.value,
        // usage_limit: usage_limit.value,
        end_date_time: end_date_time.value,
        start_date_time: start_date_time.value,
      },
      success: function (response) {
        // Handle the response from the server
        let html = `
        
              <tr>
                <td class="code">`+ response.data.code + `</td>
                <td class="amount">`+ response.data.amount + `</td>
                <td class="discount_type">`+ response.data.discount_type + `</td>
                <td class="start_date">`+ response.data.start_date + `</td>
                <td class="expire_date">`+ response.data.expire_date + `</td>
                <td class="usage_limit">`+ response.data.usage_limit + `</td>
              </tr>
        `;

        jQuery(document).find("#couponListBody").append(html);
        location.reload(true);
        coupon_code.value = '';
        discount_type.value = '';
        amount.value = '';
        start_date_time.value = '';
        end_date_time.value = '';
      },
    });
  });

  addCreateEventForm();


  updateTicket();

  jQuery(document).ajaxSuccess(function (event, xhr, settings) {
    var paramsObject = parseQueryString(settings.data);
    if (paramsObject.action !== "tribe-ticket-add") {
      return;
    }

    updateTicket();
  });


  function getCoupons() {

    var eventId = jQuery("#post_ID").val();
    jQuery.ajax({
      url: iam00_ajax_object.ajax_url, // AJAX URL set by WordPress
      type: "post",
      data: {
        action: "get_event_ticket_coupon_action", // Custom AJAX action
        nonce: iam00_ajax_object.nonce,
        event_id: eventId,
      },
      success: function (response) {
        // Handle the response from the server
        var options = "";

        if (response.success) {
          //

          let html = `
        <table>
            <thead>
              <tr class="table-header">
                <th class="code">Code</th>
                <th class="amount">Amount</th>
                <th class="discount_type">Discount Type</th>
                <th class="start_date">Start Date</th>
                <th class="expire_date">End Date</th>
                <th class="usage_limit">Usage Limit</th>
              </tr>
            </thead>
            <tbody id="couponListBody">`;

          let body = '';

          jQuery.each(response.data, function (index, data) {
            body += `<tr>
              <td class="code">`+ data.code + `</td>
              <td class="amount">`+ data.amount + `</td>
              <td class="discount_type">`+ data.discount_type + `</td>
              <td class="start_date">`+ data.start_date + `</td>
              <td class="expire_date">`+ data.expire_date + `</td>
              <td class="usage_limit">`+ data.usage_limit + `</td>
            </tr>`;
          });

          let htmlEnd = `
            </tbody>
          </table>
        `;
          jQuery(document).find("#couponList").append(html + body + htmlEnd);
          // console.log(html + body + htmlEnd);
        }
      },
    });
  }

  getCoupons();

});







// Check if the URL contains 'category_id'
jQuery(document).ready(function () {

  $("#event_id").on('change', updateTicket);

  $('#start_date').datetimepicker({
    format: 'YYYY-MM-DD H:mm'
  });

  $('#end_date').datetimepicker({
    format: 'YYYY-MM-DD H:mm'
  });

  console.log("Document ready.");

  // Check if the URL contains 'category_id'
  if (window.location.href.indexOf('category_id') !== -1) {
    console.log("URL contains 'category_id'.");

    // Check how many elements are selected before applying the style change
    var elements = jQuery('.elementor .hide_back_btn_gallery');
    console.log(elements.length + " elements found with the class 'hide_back_btn_gallery'.");

    // Override the CSS for '.elementor .hide_back_btn_gallery'
    elements.css('display', 'block');

    // Confirm the style change was attempted
    console.log("Attempted to change display to 'block'.");
  } else {
    console.log("URL does not contain 'category_id'.");
  }
});

