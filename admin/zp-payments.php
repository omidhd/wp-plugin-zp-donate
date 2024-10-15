<?php
require_once ZP_PATHBASE.'/admin/zp-add-menu-class.php';
require_once ZP_PATHBASE .'/tables/table-class.php';

/*
 * add main page menu in admin panel
 */
$main_page = new Admin_page('zp-donate', 'ZarinPall Donate', 'main_page_callback', 10);
$main_page->add_menu_zp_func();
function main_page_callback()
{
    // get all success payments
    $payments = Zp_tables::select_get_results(
        "*",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1 ORDER BY id DESC");

    // sum of success payments
    $sumPay = Zp_tables::select_get_results(
        "SUM(v_amount) AS TotalPay",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1");
    if($sumPay){
        $totalPay = number_format($sumPay[0]->TotalPay) . ' تومان';
    }

    // the most payment subject
    $mostSubject = Zp_tables::select_get_results(
        "v_subject, COUNT(*) AS mostSub",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1 GROUP BY v_subject ORDER BY mostSub DESC LIMIT 1");

    // the last payment date
    $lastPayDate = Zp_tables::select_get_results(
        "v_date",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1 ORDER BY id DESC LIMIT 1");

    // get all distinct names
    $distictName = Zp_tables::select_get_results(
        "DISTINCT v_name",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1");

    // get all distinct subjects
    $distictSubject = Zp_tables::select_get_results(
        "DISTINCT v_subject",
        PAYMENT_DONATE_TABLE,
        "WHERE status=1");

    // use the function to prosearch part in follow
    function zp_pro_serach($ProSearch)
    {
        if(!empty($ProSearch)){
            foreach($ProSearch as $se){
                $sum[] = $se->v_amount;
            }
            return number_format(array_sum($sum)) . ' تومان';
        }
    }

    //handle search form *****************************************************
    if (isset($_POST['sp_submit'])) {
        // use the function to repeat isset($_POST) method
        function isset_func($value){
            if(isset($_POST[$value])){
                return $_POST[$value];
            }
        }
        $sp_name = isset_func('sp_name');
        $sp_subject = isset_func('sp_subject');
        $sp_status = isset_func('sp_status');
        $sp_stime = isset_func('sp_stime');
        $sp_etime = isset_func('sp_etime');

        /*
         * check the values selected in the search form
         * if the name value and the subject value was on all
         */
        if ($sp_name == 'all' && $sp_subject == 'all') {

            $ProSearch = Zp_tables::select_get_results(
                "*",
                PAYMENT_DONATE_TABLE,
                "WHERE v_date BETWEEN '$sp_stime' AND '$sp_etime' AND status= '$sp_status' ");

            $sumPay = zp_pro_serach($ProSearch);

        // if only the name value was on all
        }elseif($sp_name == 'all'){

            $ProSearch = Zp_tables::select_get_results(
                "*",
                PAYMENT_DONATE_TABLE,
                "WHERE v_date BETWEEN '$sp_stime' AND '$sp_etime' AND v_subject= '$sp_subject' AND status= '$sp_status' ");

            $sumPay = zp_pro_serach($ProSearch);

        // if only the subject value was on all
        }elseif($sp_subject == 'all'){

            $ProSearch = Zp_tables::select_get_results(
                "*",
                PAYMENT_DONATE_TABLE,
                "WHERE v_date BETWEEN '$sp_stime' AND '$sp_etime' AND v_name= '$sp_name' AND status= '$sp_status' ");

            $sumPay = zp_pro_serach($ProSearch);

        //if all of the inputs were set
        }elseif(!empty($sp_name) && !empty($sp_name) && !empty($sp_name) && !empty($sp_name)){

            $ProSearch = Zp_tables::select_get_results(
                "*",
                PAYMENT_DONATE_TABLE,
                "WHERE v_date BETWEEN '$sp_stime' AND '$sp_etime' AND v_name= '$sp_name' AND v_subject= '$sp_subject' AND status= '$sp_status' ");

            $sumPay = zp_pro_serach($ProSearch);

        }else{
            $resultSP = 'اطلاعاتی موجود نمی باشد.';
        }

        //scroll to tableSP id
        ?>
        <script>
            location.replace("#tableSP");
        </script>
        <?php
        // if was an error in getting the data from the database, display it.
        Zp_tables::last_error();
    }

    //Delete payment row ****************************************************
    if(!empty($_GET['dpay'])){
        $dPayID = $_GET['dpay'];
        Zp_tables::delete(PAYMENT_DONATE_TABLE, "WHERE id= '$dPayID' ");

        wp_redirect( admin_url().'/admin.php?page=zp-donate' );
    }

    //Set chart values *********************************************************
    add_action( 'admin_footer', 'chart_payments_js' );
    function chart_payments_js(){
        wp_enqueue_script('CHART_JS', ZP_URLBASE. '/public/js/chart-payments.js');

        $fetch_pay = Zp_tables::select_get_results("*", PAYMENT_DONATE_TABLE, "WHERE status=1");

        if($fetch_pay){
            foreach($fetch_pay as $pays){
                $payAmount[] = $pays->v_amount;
                $payDate[] = $pays->v_date;
                $allSubject[] = $pays->v_subject;
            }

            $subjectCount = array_count_values($allSubject);
            foreach($subjectCount as $key => $value){
                $keySubject[] = $key;
                $valueSubject[] = $value;
            }

            $args = array(
                'payAmount' => $payAmount,
                'payDate' => $payDate,
                'keySubject' => $keySubject,
                'valueSubject' => $valueSubject
            );
        }
        wp_localize_script( 'CHART_JS', 'payObject', $args );

    }

    wp_enqueue_script('TABLE_TO_EXCEL', 'https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js');
    require_once trailingslashit(ZP_PATHBASE). 'views/payments.php';

}