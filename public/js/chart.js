let ctx = document.getElementById('chart').getContext('2d');
let labels = ['Protein', 'Fat', 'Cacbonhydrate'];
let color = ['rgba(255, 99, 132)', 'rgba(255, 206, 86)', 'rgba(75, 192, 192)'];
let chart = new Chart(ctx, {
    type: 'pie',
    data: {
        datasets: [{
            data: [20, 20, 60],
            backgroundColor: color,
            borderWidth: 0,
        }],
        labels: labels
    },
    options: {
        reponsive: true,
        legend: {
            display: false
        },
        plugins: {
            datalabels: {
                color: 'black',
                font: {
                    // size: '30',
                    weight: 'bold'
                },
                formatter: (value) => {
                    return value + '%';
                }
            },
        }
    }
});
var myLegendContainer = document.getElementById("legend");
myLegendContainer.innerHTML = chart.generateLegend();
