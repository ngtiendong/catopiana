@extends('frontend::layouts.layout')

@section('content')
<section class="section-chart">
    <div class="container d-flex flex-column justify-content-center align-content-center">
        <div class="title text-center">
            <h1>Total Calories</h1>
        </div>
        <div class="chart-wrapper">
            <canvas id="chart"></canvas>
            <div id="legend"></div>
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
<script type="text/javascript" src="{{asset('/js/chart.js')}}"></script>

@endsection
