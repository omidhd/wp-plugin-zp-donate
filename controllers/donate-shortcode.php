<?php ob_start();
add_shortcode('DONATE_PAGE_PAYMENT', 'donate_payment_shortcode');

//Payment part **************************************************************************************************
function donate_payment_shortcode($atts)
{
    wp_enqueue_style('Bootstrap_style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('JQUERY_CDN', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
    wp_enqueue_script('PersianWords', 'https://cdn.jsdelivr.net/gh/mahmoud-eskandari/NumToPersian/dist/num2persian-min.js');
    wp_enqueue_script('persianDatePicker', 'https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js');
    wp_enqueue_script('PersianDate', 'https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js');


    $attributes = shortcode_atts( array(
        'id' => ''
    ), $atts );

    $allSubjects = array(
        '1' => 'درمان و توان بخشی',
        '2' => 'کودکان',
        '3' => 'آسایشگاه و شیرخوارگاه',
        '4' => 'سایر',
    );

    //handle payment form *************************************************************
    global $wpdb;
    $merchant_id = '15866a65-722e-4265-b1b5-36f7eac809ea';
    $description = 'حمایت مالی';
    $callback_url = home_url() . $_SERVER['REQUEST_URI'];

    if(isset($_POST['v-pay'])){

        if(isset($_POST['v-phone'])){
            $phone = validation($_POST['v-phone']);
        }

        if(isset($_POST['v-amount'])){
            $amount = validation($_POST['v-amount']);
        }

        if(isset($_POST['v-name'])){
            $name = validation($_POST['v-name']);
        }

        if($attributes['id'] == ''){
            if(isset($_POST['v-subject'])){
                $subject = validation($_POST['v-subject']);
            }
        }else{
            $subject = $allSubjects[$attributes['id']];
        }

        $date = $_POST['v-date'];
        $time = $_POST['v-time'];

        if( is_user_logged_in() ) {
            $user_current = wp_get_current_user();
            $user_id = $user_current->id;
        }else{
            $user_id = 0;
        }

        $client = new soapClient('https://zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'utf-8']);
        $result = $client->PaymentRequest([
            "MerchantID" => $merchant_id,
            "Amount" => $amount,
            "Description" => $description,
            "Email" => "",
            "Mobile"=> $phone,
            "CallbackURL" => $callback_url
        ]);

        if($result->Status == 100){
            $authority = $result->Authority;
            $status= 0;
            $RefId = 0;
            $wpdb->insert( PAYMENT_DONATE_TABLE, array(
                'user_id' =>        $user_id,
                'v_amount' =>       $amount,
                'v_phone' =>        $phone,
                'v_name' =>         $name,
                'v_subject' =>      $subject,
                'v_authority' =>    $authority,
                'v_refid' =>        $RefId,
                'v_date' =>         $date,
                'v_time' =>         $time,
                'status' =>         $status
            ));
            if($wpdb->last_error){
                wp_die($wpdb->last_error);
            }
            Header('Location:https://zarinpal.com/pg/StartPay/'.$result->Authority);
        }else{
            echo 'Err: ' . $result->Status;
        }

    }

    // update table after payment **********************************************************
    if(isset($_GET['Status'])){
        if($_GET['Status'] == 'OK'){
            global $wpdb;
            $authority = $_GET['Authority'];
            $status= 1;

            //Get amount
            $getAmount = $wpdb->get_results( " SELECT * FROM ".PAYMENT_DONATE_TABLE." WHERE v_authority='$authority' " );

            $client = new SoapClient('https://zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification([
                'MerchantID' => $merchant_id,
                'Authority' => $authority,
                'Amount' => $getAmount[0]->v_amount
            ]);


            if($result->Status == 100){

                $wpdb->query( $wpdb->prepare("UPDATE ".PAYMENT_DONATE_TABLE." SET
                `v_refid` = '$result->RefID',
                `status` = '$status'
                WHERE `v_authority` = '$authority' "
                ));

                session_start();
                $succesPay = 'تراکنش موفقیت آمیز بود. کد پیگیری : ' . $result->RefID;
                $_SESSION['CodePay'] = $succesPay;

                header("refresh: 3; url = ".home_url('/sample/'));
            }else{
                $errorPay = 'تراکنش با خطا مواجه شد. وضعیت :' . $result->Status;
                header("refresh: 3; url = ".home_url('/sample/'));
            }

        }else{
            $ERR = 'عملیات پرداخت توسط کاربر لغو شد.';
            header("refresh: 3; url = ".home_url('/sample/'));
        }

    }

    ob_start();
    require trailingslashit(ZP_PATHBASE). 'views/donate-page-payment.php';
    return ob_get_clean();
}