//show Amount Vows
function showAmount(){
    var x = document.getElementById("v-amount").value;
    document.getElementById("v-sum").textContent = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' تومان';
    // convert num to word
    document.getElementById("persianWords").innerHTML = Num2persian(x) + ' تومان';
}

//datepicker *********************************************************************************
$(document).ready(function() {
    $("#show-date").on('focus', function() {
        $(this).persianDatepicker({
            format: 'YYYY/MM/DD'
        });
    });

    $("#show-date-brith").on('focus', function() {
        $(this).persianDatepicker({
            format: 'YYYY/MM/DD'
        });
    });-

    $("#paymentDate").persianDatepicker({
        calendar:{
            persian: {
                locale: 'en'
            }
        },
        format: 'YYYY-MM-DD',
        minDate: new persianDate().unix()
    });

    $("#paymentTime").persianDatepicker({
        calendar:{
            persian: {
                locale: 'en'
            }
        },
        format: 'H:M:s',
        minDate: new persianDate().unix()
    });
});
//END