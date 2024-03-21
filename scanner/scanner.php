<?php
/*
Template Name: Organizer Scanner
*/

get_header('scanner/header-organizer-scanner.php'); // Include the header
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
get_footer('/scanner/footer-organizer-scanner.php'); // Include the footer








