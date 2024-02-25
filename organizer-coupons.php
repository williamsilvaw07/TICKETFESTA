<?php
/*
Template Name: Organizer Coupons
*/
$events = tribe_get_events([
    'posts_per_page' => -1,
    'post_author' => get_current_user_id(),
    'ends_after' => 'now'
]);

//  foreach ($events as $event) {
// echo "<pre>";
// var_dump($events[0]);
// echo "</pre>";
//  }
// die();

get_header('organizer'); // Include the header


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
                                    <tr>
                                        <td>
                                        </td>
                                        <td>Ticket</td>
                                        <td>Event Name</td>
                                        <td>Start Date</td>
                                        <td>End Date</td>
                                        <td>Value</td>
                                        <td>Type</td>
                                        <td>Action</td>
                                    </tr>
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
                            <label for="coupon_code" name="discount_type">Amount</label>
                            <input type="text" class="form-control" id="coupon_code" placeholder="Enter coupon code">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="coupon_code" name="discount_type">Discount Type</label>
                            <select class="form-control">
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
                                        data-target="#start_date" name="start_date"/>
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
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#end_date" name="end_date"/>
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
                            ?>
                            <option value="<?php echo $event->ID ?>">
                                <?php echo $event->post_title ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="tickets">

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Create</button>
            </div>
        </div>

    </div>

</div>


<?php
get_footer('organizer'); // Include the footer

