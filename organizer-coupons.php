<?php
/*
Template Name: Organizer Coupons
*/
$author_id = get_current_user_id();

$events = tribe_get_events([
    'posts_per_page' => -1,
    'ends_after' => 'now'
]);

$author_id = get_current_user_id(); // Replace 112 with the actual author ID

$coupon_posts = get_posts(
    array(
        'post_type' => 'shop_coupon',
        'author' => $author_id,
        'posts_per_page' => -1,
    )
);




// //  foreach ($events as $event) {
// echo "<pre>";
// var_dump($events);
// echo "</pre>";
// //  }



// foreach ($coupon_posts as $coupon) {
//     $wooCoupon = new WC_Coupon($coupon->ID);
//     $postMeta = get_post_meta($coupon->ID, 'product_ids', true);
//     $product_ids_array = explode(',', $postMeta);
//     echo "<pre>";
//     $products = get_posts(array(
//         'post_type'      => 'product',
//         'post__in'       => $product_ids,
//         'posts_per_page' => -1,
//     ));
//     var_dump($products);
//     echo "</pre><br/><br/>";
// }

// die();
// Include the header
get_header('organizer');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <?php _e('Coupons', 'generatepress-child') ?>
                            </h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-block btn-warning btn-sm" data-toggle="modal"
                                    data-target="#modal-default">
                                    <?php _e('Create Coupon', 'generatepress-child') ?>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table class="table table-bordered table-hover dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>Coupon Code</th>
                                        <th>Ticket</th>
                                        <th>Event Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Value</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($coupon_posts as $coupon): ?>
                                        <?php $wooCoupon = new WC_Coupon($coupon->ID); ?>
                                        <tr>
                                            <td>
                                                <?php echo $wooCoupon->get_code() ?>
                                            </td>
                                            <td>
                                                <?php
                                                $postMeta = get_post_meta($coupon->ID, 'product_ids', true);
                                                $product_ids_array = explode(',', $postMeta);
                                                echo "<ul>";
                                                foreach ($product_ids_array as $key => $product_id) {
                                                    $product = wc_get_product($product_id);
                                                    echo "<li>{$product->get_name()}</li>";
                                                }
                                                echo "</ul>";
                                                ?>
                                            </td>
                                            <td>Event Name</td>
                                            <td>
                                                <?php
                                                $start_date = $wooCoupon->get_date_created();
                                                echo $start_date ? date('Y-m-d H:i', strtotime($start_date)) : '';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $expire_date = $wooCoupon->get_date_expires();
                                                echo $expire_date ? date('Y-m-d H:i', strtotime($expire_date)) : '';
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $wooCoupon->get_amount(); ?>
                                            </td>
                                            <td>
                                                <?php echo $wooCoupon->get_discount_type(); ?>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info" data-toggle="dropdown"
                                                        aria-expanded="false">Action</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu" style="">
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="onClickDeleteHandeler(<?php echo $coupon->ID ?>)">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ./card-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
                                <option value="fixed">Fixed</option>
                                <option value="percent">Percent</option>
                            </select>
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


<?php
get_footer('organizer'); // Include the footer

