<?php
//define plugin url
define('ZP_URLBASE', dirname(plugin_dir_url(__FILE__)));
//define plugin path
define('ZP_PATHBASE', dirname(plugin_dir_path(__FILE__)));

// add style in wordpress *************************************************************
add_action('init', 'zp_add_styles');
function zp_add_styles()
{
    wp_enqueue_style( 'CUSTOMCSS', ZP_URLBASE. '/public/css/style.css' );
    wp_enqueue_style( 'DATEPICKERCSS','https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css' );
    wp_enqueue_style( 'PAGINATION_CSS',"https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.css" );
}

//add js scripts on front ************************************************************************
add_action('wp_footer','zp_enqueue_scripts');
function zp_enqueue_scripts()
{
    wp_enqueue_script('CUSTOMJS', ZP_URLBASE. '/public/js/script.js');
}

//add js scripts on Admin space ****************************************************************************
add_action('admin_enqueue_scripts','zp_admin_enqueue_scripts');
function zp_admin_enqueue_scripts(){
    //Jquery
    if (isset($_GET['page'])){
        if ($_GET['page'] == 'zp-donate' ){
            wp_enqueue_script('JQUERYCDN', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
        }
    }
    wp_enqueue_script('ADMINCUSTOMJS', ZP_URLBASE. '/public/js/admin-scripts.js');
    wp_enqueue_script('Chart_JS', ZP_URLBASE. '/public/js/chart-payments.js');
    wp_enqueue_script('JQUERY_LIBTABLE', ZP_URLBASE. '/public/js/jquery.dataTables.min.js');
    wp_enqueue_script('persianDatePicker', 'https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js');
    wp_enqueue_script('PersianDate', 'https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js');
    wp_enqueue_script('CHARTJS', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js');
}

//vaidation form function *********************************************************
function validation($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}