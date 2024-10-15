//chart payment
$(document).ready (function () {  
    
    new Chart("myChart", {
    type: "line",
    data: {
        labels: payObject['payDate'],
        datasets: [{
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.1)",
        data: payObject['payAmount']
        }]
    },
    options: {
        legend: {display: false},
        scales: {
        yAxes: [{ticks: {min: 0, max:1000000}}],
        }
    }
    });

});


$(document).ready (function () {  

    const xValues = payObject['keySubject'];
    const yValues = payObject['valueSubject'];
    const barColors = [
    "#F26784",
    "#FCCB57",
    "#36A2EB",
    "#e8c3b9",
    "#1e7145"
    ];

    new Chart("myChart2", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
        backgroundColor: barColors,
        data: yValues
        }]
    },
    options: {
        title: {
        display: true,
        text: "نمودار بیشترین موضوع پرداخت"
        }
    }
    });

});
