<?php
/*
Template Name: Organizer Scanner
*/

// Include the custom header
$custom_header_path = get_stylesheet_directory() . '/scanner/header-organizer-scanner.php';
if (file_exists($custom_header_path)) {
    require_once($custom_header_path);
} else {
    // Fallback to the default header if your custom header is not found
    get_header();
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
        <h2 class="tribe-community-events-list-title">Dashboard</h2>
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
// Include the custom footer
$custom_footer_path = get_stylesheet_directory() . '/scanner/footer-organizer-scanner.php';
if (file_exists($custom_footer_path)) {
    require_once($custom_footer_path);
} else {
    // Fallback to the default footer if your custom footer is not found
    get_footer();
}
?>






<style>
    

body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {

    margin-left: inherit;
}
.main-header {
    background-color: #19191b!important;
    border-bottom: 1px solid #444!important;
}
.fake_aviter {
    display: flex;
    align-items: center;
    font-size: 13px;
    background: white;
    border-radius: 100px;
    width: 36px;
    height: 36px;
    justify-content: center;
}

.content-wrapper{
    background: #0d0e0e !important;
}

.fake_aviter span {
    color: black !important;
}
.user-panel .fa-angle-down:before {
    content: "\f107";
    color: white;
    margin-right: 24px;
}

.dark-mode .dropdown-menu {
    background-color: #19191b;
    color: #fff;
    padding: 19px;
    text-decoration: none;
    list-style: none;
    width: fit-content;
}
.admin_dashboard-sidebar-item a {
    color: white;
    padding: 12px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    padding-left: 0 !important;
    white-space: nowrap;
}
.admin_dashboard-sidebar-item i {
    padding-right: 10px;
}

.line_break {
    display: block;
    width: 100%;
    height: 1px;
    background-color: #575757;
    margin: 10px 0;
}


.container-fluid h2 {
    padding-bottom: 11px;
    padding-top: 13px;
    font-weight: 700;
}

.tribe-community-events-list-title {
    font-weight: bold;
    font-size: 35px !important;
}



.container-fluid h2 {
    padding-bottom: 11px;
    padding-top: 13px;
    font-weight: 700;
}






</style>