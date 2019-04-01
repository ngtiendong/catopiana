@extends('frontend::layouts.layout')

@section('content')
		<section class="psy-section section-test" id="id2">
		    <div class="container">
        <div class="row tn">
            <div class="col-md-6 col-md-offset-3 fadeOut">
            </div>
            <div class="col-md-4 col-md-offset-4">	
                <h3>Register</h3>
			    <form method="POST" action="{{route('register')}}">
			        @csrf
			        <div class="form-group">
			            <label for="name">Username:</label>	
			            <input type="text" class="form-control" value="{{old('username')}}"  name="username">
			            @if ($errors->has('username'))
						    <small class="text-danger">{{ $errors->first('username') }}</small>
						@endif
			        </div>
			 
			        <div class="form-group">
			            <label for="email">Email:</label>
			            <input type="email" class="form-control" value="{{old('email')}}"   name="email">
			            @if ($errors->has('username'))
						    <small class="text-danger">{{ $errors->first('email') }}</small>
						@endif
			        </div>
			 
			        <div class="form-group">
			            <label for="password">Password:</label>
			            <input type="password" class="form-control"name="password">
			            @if ($errors->has('username'))
						    <small class="text-danger">{{ $errors->first('password') }}</small>
						@endif
			        </div>

			        <div class="form-group">
			            <label for="fullname">Full name:</label>
			            <input type="text" class="form-control"  value="{{old('fullname')}}"  name="fullname">
			            @if ($errors->has('username'))
						    <small class="text-danger">{{ $errors->first('fullname') }}</small>
						@endif
			        </div>
			 
			        <div class="form-group">
			        	<button type="submit" style="cursor:pointer;" class="btn-outline-dark btn-success" >sign up</button>
			        </div>
			    </form>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
    </div>
		</section>
@endsection