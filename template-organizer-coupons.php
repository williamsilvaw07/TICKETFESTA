<?php
/*
Template Name: Organizer Coupons
*/

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
                                <button type="button" class="btn btn-block btn-warning btn-sm">
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
                                    <?php
                                       $events = tribe_events()
                                       ->where('post_author', get_current_user_id())
                                       ->all();
                                       $eventIds=[];
                                       foreach ($events as $event) {
                                            $eventIds[] = $event->ID;
                                       }


                                    ?>

                                    <td>
                                        
                                    <?php var_dump($eventIds) ?>
                                    </td>
                                    <td>Ticket</td>
                                    <td>Event Name</td>
                                    <td>Start Date</td>
                                    <td>End Date</td>
                                    <td>Value</td>
                                    <td>Type</td>
                                    <td>Action</td>

                                    ?>
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

<?php
get_footer('organizer'); // Include the footer

