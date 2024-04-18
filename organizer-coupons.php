<?php
/*
Template Name: Organizer Coupons
*/
$author_id = get_current_user_id();

$events = tribe_get_events([
    'posts_per_page' => -1,
    'ends_after' => 'now',
    'author' => $author_id,
]);

$eventArray = [];

foreach ($events as $event) {
    $eventArray[$event->ID] = $event->post_title;
}

$author_id = get_current_user_id(); // Replace 112 with the actual author ID

$coupon_posts = get_posts(
    array(
        'post_type' => 'shop_coupon',
        'author' => $author_id,
        'posts_per_page' => -1,
        'post_status' => array('publish', 'future')
    )
);

// Include the header
get_header('organizer');
?>


<style>
    .col-12 {
        margin-bottom: 100px
    }
.event_url_coupon_tooltip{
    margin-bottom:0!important;
    border-bottom-width: 0 !important;
    font-size: 14px;
    color: #aaa !important;
    font-weight: 300;
    line-height: 16px;
    margin-top: 13px;
}
.event_url_coupon{
    margin-bottom:0
}
    .copy_link{
        border-width: 0;
    padding: 6px 5px;
    background: #d5d5d5;
    border-radius: 4px;
    color: black !important;
    font-size: 13px;
    text-align: center;
    cursor: pointer;
    }
    .copy_event_link_btn:hover{
        cursor: pointer; 
    }
    #eventCouponForm .tribe-section {
                margin: 0 !important;
            }


            .coupon_table_tr , .coupon_table_tr_head{
    display: grid;
    grid-template-columns: 30% 15% 15% 8% 8% 8% 8% 4%!important;
    justify-items: stretch;
    justify-content: start;
    align-items: center;
    align-content: center;
    border-bottom: 0px solid #444;
}


            .coupon_code_table{
                display: flex !important;
    flex-direction: column;
    align-items: baseline;
    justify-content: flex-end;
    margin-right: 32px;
    line-height: inherit;
            }
            .coupon_code_table .value{
                word-break: break-all;
    line-height: 18px;
    margin-bottom: 13px;
s

            }
            .tribe-tickets-editor-table tr,
            .tribe-tickets-editor-table .table-header {
                background-color: #212121 !important;
            }
            .tribe-tickets-editor-table tr td , .tribe-tickets-editor-table thead, .tribe-tickets-editor-table .table-header {
    border-bottom: 1px solid #444;
}
            .ticket_duplicate_text {
                display: none;
            }

            #eventCouponForm .tribe-section-content {
                display: flex;
                flex-direction: column;
            }

            #eventCouponForm label:before {
                content: "Select Ticket";
                font-size: 17px;
                font-weight: 600;
                display: block;
                padding-bottom: 10px;
                padding-top: 13px;
            }


    .tribe-community-events-list {
        margin-bottom: 0 !important
    }

    .admin_dashboard_event_list_nav {
        margin-bottom: 20px
    }

    .main_custom_container_second .tribe-button-primary {
        background: #d3fa16 !important;
        color: #000000 !important;
        text-transform: capitalize !important;
        text-decoration: none;
        white-space: nowrap;
        font-size: 12px;
    }

    .content-wrapper {
        height: 100%;
    }

    .tribe-community-events-content .tribe-community-events-list-title,
    .tribe-community-events-content .add-new {
        display: inline-block;
        vertical-align: middle;
        margin-bottom: 0;
    }

    .tribe-community-events-content .add-new {
        margin-left: 20px;
    }

    .tribe-button,
    a.tribe-button,
    button.tribe-button,
    input.tribe-button {
        border-radius: 3px;
        line-height: 1;
        margin: 10px;
        padding: 9px 12px;
    }


    .value {
        font-size: 16px;
        font-weight: 500;
        color: #d3fa16 !important;
    }

    .event-status-form {
        font-size: 13px !important;
        padding: 2px 3px !important;
    }

    .tribe-community-events-list tr th,
    .tribe-community-events-list tr td {
        text-align: left;
        padding-left: 0 !important;
    }

    .dropbtn {
        background-color: transparent;
        color: #d5d5d5 !important;
        font-size: 52px;
        border: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        align-content: center;
        justify-content: center;
        height: 30px;
    }

    .content-wrapper {
        background: #0d0e0e !important;
        color: #fff;
    }

    .content {
        max-width: 1300px;
        margin: 0 auto;
        background: #0d0e0e;
    }


    .dark-mode .modal-content {
        background-color: #19191b !important;
    }

    .dark-mode .custom-control-label::before,
    .dark-mode .custom-file-label,
    .dark-mode .custom-file-label::after,
    .dark-mode .custom-select,
    .dark-mode .form-control:not(.form-control-navbar):not(.form-control-sidebar),
    .dark-mode .input-group-text {
        background-color: #121212;
        color: #fff;
        border: 0px;
        font-size: 13px;
    }

    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 300 !important;
        font-size: 15px;
    }

    .dark-mode .btn-primary {
        color: #000;
        background-color: #d3fa16;
        border: 0px;
        box-shadow: none;
    }

    .datetimepicker-input {
        font-size: 16px !important
    }

    .dark-mode .btn-primary:hover {
        background: black !important;
        color: white !important
    }

    .dark-mode .swal2-popup {
        background-color: #19191b;
        color: #e9ecef;
    }


    @media (max-width: 1400px) {
        .tribe-community-events-list thead {
            display: block;
        }


        .table-responsive {
            overflow-x: auto;
            /* Enables horizontal scrolling */
            position: relative;
            /* For the ::before and ::after to position properly */
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling on iOS devices */
        }

        .table-responsive table {
            min-width: 1400px;
            /* Adjust based on your content */
            border-collapse: collapse;
        }

        .table-responsive th,
        .table-responsive td {
            text-align: left;
            padding: 8px;
        }
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" id="tribe-community-events-shortcode">
                <div class="col-12">
                    <div class="tribe-community-events-content">
                        <div class="admin_dashboard_event_list_nav">
                            <div class="main_custom_container_second">
                                <h2 class="tribe-community-events-list-title">
                                    <?php _e('Promo Codes', 'generatepress-child') ?>
                                </h2>

                                <button type="button" class="tribe-button tribe-button-primary add-new"
                                    data-toggle="modal" data-target="#modal-default">
                                    <?php _e('Create Coupon', 'generatepress-child') ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tribe-responsive-table-container">



                        <div class="table-responsive">
                            <table id="tribe-community-events-list"
                                class="tribe-community-events-list display responsive stripe">
                                <thead>
                                    <tr class="coupon_table_tr_head">
                                        <th class="event-column">
                                      Promo Code
                                        </th>
                                        <th class="tickets-sold-column">
                                            Ticket
                                        </th>
                                        <th class="gross-column">
                                            Event Name
                                        </th>
                                        <th class="status-column">
                                            Start Date
                                        </th>
                                        <th class="status-column">
                                            End Date
                                        </th>
                                        <th class="status-column">
                                            Value
                                        </th>
                                        <th class="status-column">
                                            Type
                                        </th>
                                        <th class="status-column">
                                            Limit
                                        </th>
                                        <th class="status-column action">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($coupon_posts as $coupon): ?>
                                        <?php $wooCoupon = new WC_Coupon($coupon->ID); ?>
                                        <?php
                                            $data = [];
                                            $auto_apply = get_post_meta($coupon->ID, 'auto_apply', 0);
                                            $data['auto_apply'] = is_array($auto_apply) ? (int) $auto_apply[0] : 0;
                                            $data['event_id'] = get_post_meta($coupon->ID, 'event_id', true);
                                            $event = tribe_get_event($data['event_id']);
                                        ?>
                                        <tr class="coupon_table_tr">
                                        <td class="tribe-dependent tribe-list-column tribe-list-column-status tribe-active coupon_code_table">
    <p class="value">
        <?php
        $data['code'] = $wooCoupon->get_code();
        $data['coupon_id'] = $coupon->ID;
        $data['usage_limit'] = $wooCoupon->get_usage_limit();
        $data['usage_limit_per_user'] = $wooCoupon->get_usage_limit_per_user();
        echo $wooCoupon->get_code();
        ?>
    </p>
    <p class="event_url_coupon">
        <?php if ($auto_apply): ?>
            <span class="copy_event_link_btn copy_link" onclick="copyURL('<?php echo esc_url(get_permalink($data['event_id']) . '?coupon=' . $wooCoupon->get_code()); ?>')">
                Share event link
                <i class="fas fa-link"></i>
            </span>
        <?php endif; ?> </p>
        <p class="event_url_coupon_tooltip">Share an event link that auto-applies a code to orders.</p>
   
</td>





                                            <td class="event-status-form">
                                                <?php

                                                $postMeta = get_post_meta($coupon->ID, 'product_ids', true);
                                                $product_ids_array = explode(',', $postMeta);
                                                echo "<ul style='margin: 0;'>";
                                                foreach ($product_ids_array as $key => $product_id) {
                                                    $product = wc_get_product($product_id);
                                                    echo "<li>{$product->get_name()}</li>";
                                                }
                                                echo "</ul>";
                                                $data['product_ids'] = $product_ids_array;
                                                ?>
                                            </td>
                                            <td class="event-status-form">
                                                <?php

                                                if (isset($event->post_title)) {

                                                    $eventTitleShort = mb_substr($event->post_title, 0, 50);

                                                    // Append '...' to the shortened title if it was longer than 50 characters
                                                    if (mb_strlen($eventTitle) > 50) {
                                                        $eventTitleShort .= '...';
                                                    }

                                                    echo $eventTitleShort;
                                                }
                                                ?>
                                            </td>
                                            <td class="event-status-form">
                                                <?php
                                                $start_date = $wooCoupon->get_date_created();
                                                echo $start_date ? date('d-m-Y H:i', strtotime($start_date)) : '';
                                                $data['start_date'] = $start_date ? date('d-m-Y H:i', strtotime($start_date)) : '';
                                                ?>
                                            </td>
                                            <td class="event-status-form">
                                                <?php
                                                $expire_date = $wooCoupon->get_date_expires();
                                                echo $expire_date ? date('d-m-Y H:i', strtotime($expire_date)) : '';
                                                $data['expire_date'] = $expire_date ? date('d-m-Y H:i', strtotime($expire_date)) : '';
                                                ?>
                                            </td>


                                            <td class="event-status-form">
                                                <?php
                                                $data['amount'] = $wooCoupon->get_amount();
                                                echo $wooCoupon->get_amount();
                                                ?>
                                            </td>
                                            <td class="event-status-form">
                                                <?php
                                                $data['discount_type'] = $wooCoupon->get_discount_type();

                                                echo ['fixed_cart' => 'Fixed', 'percent' => 'Percent'][$wooCoupon->get_discount_type()];
                                                ?>
                                            </td>
                                            <td class="event-status-form">
                                                <?php
                                                echo $data['usage_limit']  === 0 ? "&#8734;": $data['usage_limit'];
                                                echo "/";
                                                echo $data['usage_limit_per_user']  === 0 ? "&#8734;": $data['usage_limit_per_user'];

                                                ?>
                                            </td>

                                            <td class="text-end action">
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="dropbtn" data-toggle="dropdown"
                                                        aria-expanded="false">⋮</button>

                                                    <div class="dropdown-menu" role="menu" style="">

                                                        <a class="dropdown-item" href="#"
                                                            data-details='<?php echo json_encode($data) ?>'
                                                            onclick="onClickEditHandeler(this)" data-toggle="modal"
                                                            data-target="#modal-edit">Edit</a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="onClickDeleteHandeler(<?php echo $coupon->ID ?>)">Delete</a>

                                                        <?php if($auto_apply) : ?>
                                                            <span role="buttin" class="dropdown-item"
                                                            onclick='copyURL("<?php echo get_permalink($data['event_id']) . '?coupon=' . $wooCoupon->get_code() ?>")'>Copy URL</span>
                                                        <?php endif ?>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
function copyURL(url) {
    const el = document.createElement('textarea');
    el.value = url;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    // alert('URL copied to clipboard: ' + url);
}


jQuery(document).ready(function($) {
    $('.copy_event_link_btn').click(function() {
        var $this = $(this); // Cache the jQuery object of the span
        var originalText = $this.text().trim(); // Save the original text
        var originalBackgroundColor = $this.css('backgroundColor'); // Save the original background color
        var originalColor = $this.css('color'); // Save the original text color

        // Set new text and styles
        $this.text('Link copied!').css({
            'backgroundColor': '#d3fa16', // Example: a light green background
            'color': 'black' // Black text color
        });

        // Hide the icon temporarily
        $this.find('i').hide();

        // Revert to original text and styles after 3 seconds
        setTimeout(function() {
            $this.text(originalText).css({
                'backgroundColor': originalBackgroundColor, // Revert background color
                'color': originalColor // Revert text color
            });

            // Show the icon again
            $this.find('i').show();
        }, 2000); // 3000 milliseconds = 3 seconds
    });
});
</script>
<div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Coupon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" id="coupon_code" placeholder="Enter coupon code">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="coupon_code" name="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="coupon_code" name="discount_type">Discount Type</label>
                            <select class="form-control" id="discount_type">
                                <option value="fixed_cart">Fixed</option>
                                <option value="percent">Percent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usage_limit">Usage limit per coupon</label>
                            <input type="number" class="form-control" id="usage_limit" placeholder="Unlimited usage" name="usage_limit">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="coupon_code" name="usage_limit_per_user">Usage limit per user</label>
                            <input type="number" class="form-control" id="usage_limit_per_user" placeholder="Unlimited usage" name="usage_limit_per_user">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date & time:</label>
                            <div class="form-group">
                                <div class="input-group date" id="start_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#start_date" name="start_date" id="start_date_time" />
                                    <div class="input-group-append" data-target="#start_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date & time:</label>
                            <div class="form-group">
                                <div class="input-group date" id="end_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#end_date"
                                        name="end_date" id="end_date_time" />
                                    <div class="input-group-append" data-target="#end_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Event</label>
                    <select class="form-control select2" style="width: 100%;" name="event_id" id="event_id" required>
                        <?php
                        foreach ($events as $event) {
                            if ($event->post_author == get_current_user_id()) {
                                ?>
                                <option value="<?php echo $event->ID ?>">
                                    <?php echo $event->post_title ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" id="auto_apply" type="checkbox" name="auto_apply" value="1">
                        <label class="form-check-label" for="auto_apply">Auto apply coupon</label>
                    </div>
                </div>
                <div class="form-group" id="tickets">

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="coupon_form_save">Create</button>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="editForm">
            <input type="hidden" name="coupon_id" id="coupon_id" />
            <div class="modal-header">
                <h4 class="modal-title">Edit Coupon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_coupon_code">Coupon Code</label>
                    <input type="text" name="coupon_code" class="form-control" id="edit_coupon_code"
                        placeholder="Enter coupon code">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_coupon_code">Amount</label>
                            <input type="text" class="form-control" id="edit_amount" placeholder="" name="amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_discount_type">Discount Type</label>
                            <select class="form-control" id="edit_discount_type" name="discount_type">
                                <option value="fixed_cart">Fixed</option>
                                <option value="percent">Percent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_usage_limit">Usage limit per coupon</label>
                            <input type="number" class="form-control" id="edit_usage_limit" placeholder="Unlimited usage" name="usage_limit">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit_limit_per_user">Usage limit per user</label>
                            <input type="number" class="form-control" id="edit_limit_per_user" placeholder="Unlimited usage" name="usage_limit_per_user">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date & time:</label>
                            <div class="form-group">
                                <div class="input-group date" id="edit_start_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#edit_start_date" name="start_date" id="edit_start_date_time"
                                        data-toggle="datetimepicker" />
                                    <div class="input-group-append" data-target="#edit_start_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date & time:</label>
                            <div class="form-group">
                                <div class="input-group date" id="edit_end_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#edit_end_date" name="end_date" id="edit_end_date_time"
                                        data-toggle="datetimepicker" />
                                    <div class="input-group-append" data-target="#edit_end_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Event</label>
                    <select class="form-control select2" style="width: 100%;" name="event_id" id="edit_event_id"
                        required>
                        <?php
                        foreach ($events as $event) {
                            if ($event->post_author == get_current_user_id()) {
                                ?>
                                <option value="<?php echo $event->ID ?>">
                                    <?php echo $event->post_title ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" id="edit_auto_apply" type="checkbox" name="auto_apply"
                            value="1">
                        <label class="form-check-label" for="edit_auto_apply">Auto apply coupon</label>
                    </div>
                </div>
                <div class="form-group" id="edit_tickets">

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_coupon_form_save">Update</button>
            </div>
        </form>

    </div>

</div>

<?php
get_footer('organizer'); // Include the footer

