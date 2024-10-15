<div class="wrap">
    <h3 class="branch-title">صفحه پرداخت ها</h3>

    <div id="payInfo">
        <div class="payInfoRow">

            <div class="payInfoCol">
                <div class="payInfoBox" style="background-color: #ffbe46;">
                    <h3 class="branch-title">مجموع پرداخت ها</h3>
                    <p><?php if(isset($totalPay)) echo $totalPay; ?></p>
                </div>
            </div>

            <div class="payInfoCol">
                <div class="payInfoBox" style="background-color: #a9c8ff;">
                    <h3 class="branch-title">تعداد پرداخت ها</h3>
                    <span class="countPay"><?php if(isset($payments)) echo count($payments); ?></span>
                </div>
            </div>

            <div class="payInfoCol">
                <div class="payInfoBox" style="background-color: #fbb0b0;">
                    <h3 class="branch-title"> بیشترین موضوع پرداخت</h3>
                    <p>
                        <?php if($mostSubject && isset($mostSubject)) echo $mostSubject[0]->v_subject; ?>
                        <span class="countPay"><?php if($mostSubject && isset($mostSubject)) echo $mostSubject[0]->mostSub; ?></span>
                    </p>
                </div>
            </div>

            <div class="payInfoCol">
                <div class="payInfoBox" style="background-color: #00ffb8;">
                    <h3 class="branch-title">تاریخ آخرین پرداخت</h3>
                    <p><?php if($lastPayDate && isset($lastPayDate)) echo $lastPayDate[0]->v_date; ?></p>
                </div>
            </div>


        </div>
    </div>

    <div class="paginationPay">
        <table id="payTable" class="table-branch">

            <thead>
            <tr>
                <td>شناسه</td>
                <td>نام</td>
                <td>مبلغ</td>
                <td>شماره تماس</td>
                <td>موضوع پرداخت</td>
                <td>تاریخ</td>
                <td>کد پیگیری</td>
                <td>اقدام</td>
            </tr>
            </thead>

            <tbody>

            <?php foreach($payments as $pay): ?>
                <tr id="payTD">
                    <td><?php echo $pay->id; ?></td>
                    <td><?php echo $pay->v_name; ?></td>
                    <td id='amount'><?php echo $pay->v_amount; ?></td>
                    <td><?php echo $pay->v_phone; ?></td>
                    <td><?php echo $pay->v_subject; ?></td>
                    <td><?php echo $pay->v_date; ?></td>
                    <td><?php echo $pay->v_refid; ?></td>
                    <td>
                        <a href="?page=zp-donate&dpay=<?php echo $pay->id; ?>"
                           onclick="return confirm('<?php echo 'آیا از این اقدام اطمینان دارید؟'; ?>');">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
    </div>

    <div id="chartPay">
        <canvas id="myChart" class="canvasPay"></canvas>
        <canvas id="myChart2" style="width:100%;max-width:580px"></canvas>
    </div>

    <div id="SearchProParent">
        <h3 class="branch-title">گزارش گیری</h3>
        <div id="searchPro">
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
                <div class="searchRow">

                    <div class="searchCol">
                        <span>نام </span>
                        <select name="sp_name">

                            <?php if(isset($_POST['sp_name'])){
                                echo '<option>'.$sp_name.'</option>';
                            }?>

                            <option value="all">همه</option>

                            <?php foreach($distictName as $pay): ?>
                                <option value="<?php echo $pay->v_name; ?>"><?php echo $pay->v_name; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="searchCol">
                        <span>موضوع </span>
                        <select name="sp_subject">

                            <?php if(isset($_POST['sp_subject'])){
                                echo '<option>'.$sp_subject.'</option>';
                            }?>

                            <option value="all">همه</option>

                            <?php foreach($distictSubject as $pay): ?>
                                <option value="<?php echo $pay->v_subject; ?>"><?php echo $pay->v_subject; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="searchCol">
                        <span>وضعیت پرداخت</span>
                        <select name="sp_status">

                            <?php if(isset($_POST['sp_status'])){
                                echo '<option>'.$sp_status.'</option>';
                            }?>

                            <option value="1">موفق</option>
                            <option value="0">ناموفق</option>
                        </select>
                    </div>

                    <div class="searchCol">
                        <span>از تاریخ : </span>
                        <input id="sp_stime" type="text" name="sp_stime" value="<?php if(isset($_POST['sp_stime'])) echo $sp_stime; ?>">
                    </div>


                    <div class="searchCol">
                        <span>تا تاریخ : </span>
                        <input id="sp_etime" type="text" name="sp_etime" value="<?php if(isset($_POST['sp_etime'])) echo $sp_etime; ?>">
                    </div>


                    <div class="searchCol sp-btn">
                        <button type="submit" name="sp_submit" class="button-primary">جستجو</button>
                    </div>
                </div>
            </form>

        </div>

        <div id="tableSP">
            <table class="table-branch">
                <thead>
                <tr>
                    <td>نام</td>
                    <td>مبلغ</td>
                    <td>شماره تماس</td>
                    <td>موضوع پرداخت</td>
                    <td>تاریخ</td>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($ProSearch)): ?>
                    <?php foreach($ProSearch as $pay): ?>
                        <tr id="payTD">
                            <td><?php echo $pay->v_name; ?></td>
                            <td id='amount'><?php echo $pay->v_amount; ?></td>
                            <td><?php echo $pay->v_phone; ?></td>
                            <td><?php echo $pay->v_subject; ?></td>
                            <td><?php echo $pay->v_date; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if(!empty($ProSearch)): ?>
                <p> مجموع پرداخت :
                    <?php if(isset($sp_name) && isset($sumPay)){ echo $sumPay; }?>
                </p>
                <button id="payExport">خروجی اکسل</button>
            <?php endif; ?>

            <p><?php if(!empty($resultSP)) echo $resultSP; ?></p>
        </div>

    </div>

</div>

<style>.notice{display:none;}
    #payExport{float: left;background-color: #008b74;border: unset;padding: 10px 20px;color: #fff;border-radius: 4px;cursor:pointer;}
</style>