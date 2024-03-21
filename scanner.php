<?php
/*
Template Name: Organizer Scanner
*/

get_header('organizer'); // Include the header
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                      the_content();
                endwhile;
            endif;
            ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
get_footer('organizer'); // Include the footer








