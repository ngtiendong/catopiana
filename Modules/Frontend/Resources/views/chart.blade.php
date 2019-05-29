@extends('frontend::layouts.layout')

@section('content')
<section class="section-chart">
    <div class="container d-flex flex-column justify-content-center align-content-center">
        <div class="title text-center">
            <h1>Total Calories</h1>
        </div>
        <div class="chart-wrapper">
            <canvas id="chart"></canvas>
        </div>
        <div class="button-chart-wr text-center">
            <button type="button" class="button-chart gradient-button">Menu for 30 day</button>
        </div>
    </div>
</section>

@endsection
@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/menu.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
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
                position: 'bottom',
                labels: {
                    fontColor: 'white'
                },
                fullWidth: false,
            },
            plugins: {
                datalabels: {
                    color: 'black',
                    font: {
                        size: '30',
                        weight: 'bold'
                    },
                    formatter: (value) => {
                        return value + '%';
                    }
                },
            }
        }
    })
</script>
@endsection
