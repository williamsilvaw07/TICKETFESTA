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

  
              <!--  <p class="scanner_vrsion">Version 1.0</p> -->
      <div class="scanner_login_divs"> 


        <h2 class="tribe-community-events-list-title">Ticket Scanner</h2>
        <button class="change_event_btn" style="display:none"><i class="fas fa-sign-in-alt"></i> Change Event</button>
        </div>
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
.scanner_login_divs{
    display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
    gap: 40px;
    margin-bottom:40px
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
    margin: 0 auto;

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
    max-width: 280px;
    border-radius: 4px;
    margin-right: 11px;
}

.event_data{
    border-radius: 2px;
    margin-bottom: 21px;
    background: #121212 !important;
    padding: 7px;
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
    color: #d3fa16 !important;
    font-weight: 300;
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
    .tab-content.active .event-container {
        width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
    }



    .change_event_btn {
        background-color: #E72929;
    color: white;
    font-size: 11px;
    padding: 2px 9px;
    border: none;
    border-radius: 5px;
    cursor: pointer!important;
    height: 32px;
}

button i {
    margin-right: 5px; /* Space between the icon and the text */
}

#event_not_found{
        color: red !important;

}

.tabs-container .active{

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
    stroke-width: 7;
}

.progress-ring__circle {
    fill: transparent;
    stroke: #4CAF50; 
    stroke-width: 4; 
    stroke-dasharray: 365; 
    stroke-dashoffset: 365;
    transition: stroke-dashoffset 0.35s;
}

.progress-percentage {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 14px;
    color: aliceblue;
    font-weight: bolder;
}
.ticket-progress-container_main{
    display: flex;
    gap: 10px;
}

.ticket-info {
    text-align: left;
    color: white;
}
.info_div h6{
    margin:0;
    font-size: 14px;
    font-weight: 300;
    color: #aaa !important;
}
.info_div p{
    font-weight: 700;
    font-size: 16px;
    margin:0;
}
.ticket-progress-container_svg{
    width: fit-content;
    position: relative;
}

.progress-percentage_individual {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}


.ticket-info_hidden_all{
    display: none;
    flex-direction: column;
    gap: 22px;
}

.container-fluid , .content-wrapper>.content{
    padding:0!important
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
    border-bottom: 0px solid #ddd;
    justify-content: center;
    position: fixed;
    bottom: 0;
    background: #121212 !important;
    width: 100%;
    z-index: 999;
}.tabs-container {

    padding: 0px;
 
}
    }

    /* Media query for desktop (optional, for more control) */
    @media (min-width: 768px) {
        .tabs-container {
            flex-direction: row;  /* Tabs side-by-side on desktop */
        }
    }






    
</style>