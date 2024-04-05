<?php
/*
Template Name: Organizer Scanner
*/

// Check if the current user has the required role to access this page
if ( ! current_user_can( 'organiser' ) && ! current_user_can( 'administrator' ) && ! current_user_can( 'verifier' ) ) {
    // Redirect users without the required role to the login page
    wp_redirect( wp_login_url() );
    exit;
}

// Include the custom header
$custom_header_path = get_stylesheet_directory() . '/scanner/header-organizer-scanner.php';
if ( file_exists( $custom_header_path ) ) {
    require_once( $custom_header_path );
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
            <!-- Your content goes here -->
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>

            <!-- Frontend Login Form -->
            <div class="frontend-login-form">
                <?php wp_login_form(); ?>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include the custom footer
$custom_footer_path = get_stylesheet_directory() . '/scanner/footer-organizer-scanner.php';
if ( file_exists( $custom_footer_path ) ) {
    require_once( $custom_footer_path );
} else {
    // Fallback to the default footer if your custom footer is not found
    get_footer();
}
?>








<style>
.main-header .d-block{
    display:none!important
}
footer{
    display:none!important
}
.main-header{
    padding-left: 0;
    padding-right: 0;
}
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
.scanner_login_divs{
    display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
    gap: 40px;
   padding-bottom:20px
}
.line_break {
    display: block;
    width: 100%;
    height: 1px;
    background-color: #575757;
    margin: 10px 0;
}



.tribe-community-events-list-title {
    font-weight: bold;
    font-size: 35px !important;
}



.container-fluid h2 {
    padding-bottom: 0;
    font-weight: 700;
    margin-bottom:0!important
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
    margin: 0 4%;

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
    width: 100%;
    max-width: 180px;
    border-radius: 4px;
    margin-right: 11px;
}

.event_data{
    border-radius: 10px;
    background-color: #19191b;
    padding: 7px;
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}
.event_data .name span{
    color: #d3fa16 !important;
    font-size: 20px;
    font-weight: 500;
    text-align: center;
    text-transform: capitalize;
}
.event-container {
    text-align: center;  
}
.event_data .date span{
    text-align: center;
    font-size: 14px;
    color:#ffffff !important;
    font-weight: 400;
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
#qr_error{
    font-weight: 700;
    font-size: 21px;
}
.checkin-details{
    background-color: red;
    text-align: center;
    border-radius: 10px;
    max-width: 350px;
    margin: 0 auto;
    padding: 5px;
    font-size: 14px;
}

    div#video-container {
    display: flex;
    flex-direction: column;
    padding: 30px;
        align-items: center;
        padding-top: 5px;
        margin-bottom: 100px;
    }
    input#event-pass {
        margin-bottom: 30px;
    }
    input#event-pass.error {
        border: 2px solid #ea4335 !important;
    }
.main_div_event_data{
    padding:0 10px
}
        /* Style the tabs container */
    .tabs-container {
        display: flex;
    flex-direction: column !important;
    margin: 0 auto;

    position: relative;
    border-radius: 10px;
    width: 100%;
    max-width: 900px;
    }

    /* Style the tabs navigation list */
    .tabs-nav {
        display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    border-bottom: 0px solid #ddd;
    justify-content: center;
    }

    /* Style the individual tabs */
    .tabs-nav li.tab {
        padding: 10px 20px;
        cursor: pointer;
        font-size:14px
    }

    /* Style the active tab */
    .tabs-nav li.tab.active {
        background-color: #fff;
    border-radius: 4px;
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
   



    .change_event_btn {
        background-color: #19191b;
    color: white;
    font-size: 13px;
    padding: 2px 9px;
    border: none;
    border-radius: 5px;
    cursor: pointer !important;
    height: 32px;
    margin-top: 15px;
    margin-left: 13px;
}
.change_event_btn  .fa-sign-in-alt:before {
    color: #ff3b3b;
}

button i {
    margin-right: 5px; /* Space between the icon and the text */
}

#event_not_found{
        color: red !important;

}
.main_stats i{
    opacity: 0.06;
    transform: rotate(302deg) !important;
    font-size: 46px;
    position: absolute;
    top: 20%;
    right: 0;
}

.main_stats_block{
    background-color: #19191b;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 9px;
    border-radius: 10px;
    width: 100%;
    max-width: fit-content;
    flex-direction: row-reverse!important;
    display: flex!important;
    gap: 10px;
    padding-top: 17px;
    padding-bottom: 17px;
}



.tab-content{
    max-width: 500px;
    margin: 0 auto;
    padding: 0;
    margin-top: 10px;
}
.event-container img{
    display:none!important
}
.event-container-details{
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.tickets_total_sections {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    gap: 49px;
}

.ticket-info-container_main{
    display: flex;
    gap: 15px;
    flex-direction: row;
}

.ticket-progress-container {
    position: relative;
    display: flex;
    gap: 14px;
}

.progress-ring {
    transform: rotate(-90deg);
}

.progress-ring__circle-bg {
    fill: transparent;
    stroke: #3a3a3a;
    stroke-width: 4;
}

.progress-ring__circle {
    fill: transparent;
    stroke: #4CAF50; 
    stroke-width: 4; 
    stroke-dasharray: 365; 
    stroke-dashoffset: 365;
    transition: stroke-dashoffset 0.35s;
}
.progress-percentage_individual{
    font-size: 12px;
}
.progress-percentage {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    color: white;
    font-weight: bolder;
    font-weight: 500 !important;
}
.ticket-progress-container_main{
    display: flex;
    gap: 6px;
    height: fit-content;
    align-items: center;

}
.ticket_checkedin_main_stats i {
    opacity: 0.1;
    transform: rotate(0deg) !important;
    font-size: 46px;
    position: absolute;
    top: 20%;
    right: 0;
}
.ticket-info {
    text-align: left;
    color: white;
}
.ticket_checkedin_main_stats {
    margin-top:0!important
}
.info_div h6{
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.main_stats{
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
}
.stats_count_main{
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}.stats_count_main span{
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}

.ticket-progress-container_svg{
    width: fit-content;
    position: relative;
    height: fit-content;
}

.progress-percentage_individual {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}


.ticket-info_hidden_all{
    display: flex;
    flex-direction: column;
    gap: 23px;
    text-align: left!important;

}

.container-fluid , .content-wrapper>.content{
    padding:0!important
}


li.tab a{
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
}
.ticket_dropdown{
    display: flex;
    justify-content: space-between;
    width: 100%;
    cursor: pointer;
}
.ticket_dropdown h6{
    margin-bottom:0;
    font-weight: 600;
}
.single_ticket_section_inner{
    width: 100%;
    display:none
}

.display-block{
    display:block
}
.single_ticket_section {
    background: #19191b;
    position: relative;
    padding: 20px 17px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    display: flex;
    gap: 35px;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    margin: 0 auto 100px;
    margin-top: 11px;
}
.ticket-count{
    margin-bottom:0;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 0px;
    color: #d3fa16 !important;
    white-space: nowrap;
}





    /* Media query for responsive behavior (tablet and mobile) */
    @media (max-width: 768px) {
        .tabs-container {
            flex-direction: column; /* Stack tabs vertically on mobile */
        }
        .tribe-community-events-list-title {
    font-weight: bold;
    font-size: 25px !important;
}.scanner_login_divs {

    align-content: center;
    justify-content: flex-start;
 
}

.tabs-nav {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 25px;
    border-bottom: 0px solid #ddd;
    justify-content: center;
    position: fixed;
    bottom: 0;
    background: #121212 !important;
    width: 100%;
    z-index: 999;
    padding-top: 14px;
    padding-bottom: 15px;

}
.tabs-container {

    padding: 0px;
 
}
.tabs-nav li.tab {
    padding: 6px 9px;
    cursor: pointer;
    font-size: 14px;
}
.brand-link .brand-image {
  
    width: 100px;
}
.user-panel .info{
    font-size: 14px;
}.fake_aviter {
    font-size: 12px;
    width: 30px;
    height: 30px;

}
    }

    /* Media query for desktop (optional, for more control) */
    @media (min-width: 768px) {
        .tabs-container {
            flex-direction: row;  /* Tabs side-by-side on desktop */
        }
    }






    
</style>