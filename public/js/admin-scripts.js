//The vows payment table
$(document).ready(function() {
    $('#payTable').DataTable({
        "language": {
            "lengthMenu": "نمایش _MENU_ رکورد هر صفحه",
            "zeroRecords": "موردی یافت نشد",
            "info": "صفحه _PAGE_ از _PAGES_",
            "infoEmpty": "موردی یافت نشد",
            "infoFiltered": "(فیلتر _MAX_ رکورد)",
            "search": "جستجو",
            "loadingRecords": "درحال بارگذاری",
            "processing": "در حال پردازش",
            "paginate": {
                "first": "ابتدا",
                "last": "انتها",
                "next": " بعدی ",
                "previous": " قبلی "
            },
            "aria": {
                "sortAscending": ": حالت صعودی فعال",
                "sortDescending": ": حالت نزولی فعال"
            }
        },
        order: [[7, 'desc']],
        "pageLength": 10
    });
});

//Report in range **********************************************************************
$(document).ready(function() {
    $("#sp_stime").on('focus', function() {
        $(this).persianDatepicker({
            format: 'YYYY-MM-DD',
            calendar:{
                persian: {
                    locale: 'en'
                }
            }
        });
    });

    $("#sp_etime").on('focus', function() {
        $(this).persianDatepicker({
            format: 'YYYY-MM-DD',
            calendar:{
                persian: {
                    locale: 'en'
                }
            }
        });
    });
});
//End