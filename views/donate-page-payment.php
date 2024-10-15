<?php
    if(isset($_GET['Status'])){
        session_start();
            if(isset($_SESSION['CodePay'])){
                echo '<div class="successPay"> <span id="time"> 00:03 </span> '.$_SESSION['CodePay'].'</div>';
            }?>
            <?php if(isset($errorPay)) echo '<div class="errorPay"> <span id="time"> 00:03 </span> '.$errorPay.'</div>'; ?>
            <?php if(isset($ERR)) echo '<div class="errorPay"> <span id="time"> 00:03 </span> '.$ERR.'</div>'; ?>
        <?php session_destroy();
    }
?>

<div id="paymentParent" class="vows-payment" style="margin-top:40px; font-family: estedad">
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
        <h3 class="mb-4 fw-bold">حمایت مالی <small>(درگاه زرین پال)</small></h3>

        <div class="">

            <div class="mt-3">
                <label class="mb-2" for="">شماره تلفن پرداخت کننده</label>
                <input type="number" name="v-phone" id="v-phone" required>
            </div>

            <div class="mt-3">
                <label class="mb-2" >مبلغ (تومان)</label>
                <input id="v-amount" type="number" name="v-amount" onkeyup="showAmount()" required>
                <span class="small text-primary" id="persianWords">صفر تومان</span>
            </div>

            <div class="mt-3">
                <label class="mb-2">نام پرداخت کننده</label>
                <input type="text" name="v-name" required>
            </div>
        </div>

        <?php if($attributes['id'] == ''): ?>
            <div class="vows-child mt-4">
                <div id="subPay" class"checkbox-group hideInput">
                    <p style="margin-bottom: 5px;color: #000;font-weight:300">موضوع پرداخت</p>

                    <label class="DctBTN ActBTN" for="v1">درمان و توان بخشی</label>
                    <input class="ms-3" id="v1" type="radio" name="v-subject" value="درمان و توان بخشی" required>

                    <label class="DctBTN" for="v2">کودکان</label>
                    <input class="ms-3" id="v2" type="radio" name="v-subject" value="کودکان" required>

                    <label class="DctBTN" for="v3">آسایشگاه و شیرخوارگاه</label>
                    <input class="ms-3" id="v3" type="radio" name="v-subject" value="آسایشگاه و شیرخوارگاه" required>

                    <label class="DctBTN" for="v4">سایر</label>
                    <input class="ms-3" id="v4" type="radio" name="v-subject" value="سایر" required>
                </div>
            </div>
        <?php endif; ?>

        <div class="vows-child">
            <input id="paymentDate" type="hidden" name="v-date">
            <input id="paymentTime" type="hidden" name="v-time">
        </div>

        <?php if($attributes['id'] == ''): ?>
            <div class="mt-3">
                <label for="">مجموع : <Span id="v-sum"></Span></label>
            </div>
        <?php endif; ?>

        <div class="vows-child v-center mt-4">
            <button class="v-pay" type="submit" name="v-pay">پرداخت</button>
        </div>
    </form>
</div>