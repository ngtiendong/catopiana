@extends('frontend::layouts.layout')

@section('content')
		<section class="psy-section section-test" id="id2">
		    <div class="container">
        <div class="row tn">
            <div class="col-md-6 col-md-offset-3 fadeOut">
            </div>
            <div class="col-md-4 col-md-offset-4">	
                <h3>Payment</h3>
			    <form method="POST" action="{{route('create-payment')}}">
			        @csrf
			        <div class="form-group justify-content-center">
			        	<button class="btn btn-primary" style="position: relative; top: 20px">Checkout</button>
			        </div>
			    </form>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
    </div>
		</section>
@endsection
