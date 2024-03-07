<?php
/*
Template Name: Organizer Template
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

<script>
jQuery(document).ready(function($) {
    // Wait for 1 second after the document is ready
    setTimeout(function() {
        // Select the SVG div and add the 'hidden' class
        $('.loading_svg_div').addClass('hidden_loading_svg');
        console.log('SVG should now be hidden');

        // After hiding the SVG, wait another 1 second to perform further actions
        setTimeout(function() {
            console.log('Performing another action 1 second after hiding the SVG');
            // Any subsequent actions can be placed here
        }, 1000);
    }, 1500);
});
</script>



<style>
    .loading_svg_div{
        background-color: rgb(26, 26, 26);
    width: 100%;
    z-index: 10000000000000;
    position: absolute;

    }
    .hidden_loading_svg {
    display: none !important;
}
.grey {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_0 3200ms infinite, fade 3200ms infinite;
}

.blue {
  stroke-dasharray: 788 790;
  stroke-dashoffset: 789;
  animation: draw_1 3200ms infinite, fade 3200ms infinite;
}

@keyframes fade {
  0% {
    stroke-opacity: 1;
  }
  80% {
    stroke-opacity: 1;
  }
  100% {
    stroke-opacity: 0;
  }
}

@keyframes draw_0 {
  9.375% {
    stroke-dashoffset: 789
  }
  39.375% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes draw_1 {
  35.625% {
    stroke-dashoffset: 789
  }
  65.625% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

</style>
<?php
get_footer('organizer'); // Include the footer








