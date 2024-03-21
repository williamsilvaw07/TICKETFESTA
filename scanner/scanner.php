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

        <div class="scanner_login_divs"> 

</div>
            <p class="scanner_vrsion">Version 1.0</p>

        <h2 class="tribe-community-events-list-title">Ticket Scanner</h2>
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



.scanner_login_div h3 {
    margin-bottom: 10px;
    font-size: 21px;
    font-weight: 700;
}
.scanner_login_div{
    background-color: #19191b;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 17px;
    border-radius: 10px;
    width: fit-content;
    margin: 0 auto;
    margin-top: 100px !important;

}
.scanner_login_div p{
    font-weight: 300;
    color: #aaa !important;
    font-size: 15px;
    max-width: 400px;
}


#check-passcode{
    background: white;
    color: black;
    font-size: 14px;
    padding: 10px 20px;
    border: 0px;
    border-radius: 4px;
    position: relative;
    top: -2px;
}
input#event-pass {
    border: 0px;
    margin-bottom: 30px;
    width: 100%;
    max-width: 308px;
    border-radius: 4px;
    margin-right: 11px;
}





#video-container {
        width: 100%;
        text-align: center;
    }

    #video {
        width: 100%;
        max-width: 600px;
    }
    /* span#html5-qrcode-anchor-scan-type-change {
        display: none !important;
    } */


    #result {
        margin-top: 20px;
        font-weight: bold;
    }

    div#video-container {
    display: flex;
    flex-direction: column;
    padding: 30px;
    /* justify-content: center; */
        align-items: center;
    }
    input#event-pass {
        margin-bottom: 30px;
    }
    input#event-pass.error {
        border: 2px solid #ea4335 !important;
    }

        /* Style the tabs container */
    .tabs-container {
        display: flex;
        flex-direction: column !important;
        margin: 0 auto;
        background-color: #19191b;
    position: relative;
    padding: 17px;
    border-radius: 10px;
    width: 100%;
    }

    /* Style the tabs navigation list */
    .tabs-nav {
        display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    border-bottom: 0px solid #ddd;
    }

    /* Style the individual tabs */
    .tabs-nav li.tab {
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Style the active tab */
    .tabs-nav li.tab.active {
        background-color: #eee;
    }

    /* Style the tabs navigation links */
    .tabs-nav li.tab a {
        text-decoration: none;
        color: #333;
    }

    /* Style the tab content container */
    .tab-content-container {
        flex: 1; /* Allow content to fill remaining space */
    }

    /* Style the individual tab content sections */
    .tab-content {
        padding: 20px;
        display: none; /* Hide all content initially */
    }

    /* Style the active tab content */
    .tab-content.active {
        display: block;
    }
    li.tab.active a {
        color: #000 !important;
    }
    .tab-content.active .event-container {
        width: 100%;
        display: inline-flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    /* Media query for responsive behavior (tablet and mobile) */
    @media (max-width: 768px) {
        .tabs-container {
            flex-direction: column; /* Stack tabs vertically on mobile */
        }
    }

    /* Media query for desktop (optional, for more control) */
    @media (min-width: 768px) {
        .tabs-container {
            flex-direction: row;  /* Tabs side-by-side on desktop */
        }
    }






    
</style>