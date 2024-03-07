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
<style>
 
.loading_svg_div{
    background-color: rgb(26, 26, 26);
    width: 100vw;
    height: 100vh;
    z-index: 10000000000000;
    position: fixed; /* Use fixed to ensure it covers the whole screen including where it would scroll */
    display: flex;
    align-items: center; /* Fixed typo from align-content to align-items for vertical alignment */
    justify-content: center;

}
.hidden_loading_svg {
display: none !important;
}
.grey {
stroke-dasharray: 788 790;
stroke-dashoffset: 789;
animation: draw_0 2200ms infinite, fade 2200ms infinite;
}

.blue {
stroke-dasharray: 788 790;
stroke-dashoffset: 789;
animation: draw_1 2200ms infinite, fade 2200ms infinite;
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








