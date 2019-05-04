<header class="">
	<nav class="d-nav">
		<ul class="psy-pane">
			<li class="home"><img src="{{asset('./Catopiana_files/images/home.png')}}" alt=""><a class="smooth active" href="{{route('home')}}">home</a></li>
			<li class="contact"><img src="{{asset('./Catopiana_files/images/contact.png')}}" alt=""><a class="smooth" href="#id2">contact</a></li>
			<li class="about"><img src="{{asset('./Catopiana_files/images/about.png')}}" alt=""><a class="smooth" href="#for-parent">about us</a></li>
		</ul>
		<ul class="top-right-menu">
			@guest('customers')
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
				{{--<a class="smooth" href="#signin">sign in</a>--}}
                <a type="button" class="smooth btn" data-toggle="modal" data-target="#modal-sign-in">sign in</a>
			</li>
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
                <a type="button" class="smooth btn" data-toggle="modal" data-target="#modal-sign-up">sign up</a>
            </li>
			@else
			@if(auth()->guard('customers')->user()->test_status == 1) 
			{{-- da lam xong bai free --}}
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
	                 <a class="smooth" href="{{ route('packages') }}">Packages</a>
	            </li>
            @endif
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
                <a class="smooth" href="#">{{auth()->guard('customers')->user()->username}}</a>
            </li>
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
                <a class="smooth" style="cursor: pointer;" id="logoutBtn" data-route="{{ route('logout') }}"">log out</a>
			</li>
			@endguest
		</ul>
	</nav>
	<button class="open-mnav"><span></span><span></span><span></span></button>

	<div class="m-nav">
		<button class="m-nav-close">×</button>
		<div class="nav-ct">
			<ul class="psy-pane">
				<li class="home"><img src="{{asset('./Catopiana_files/images/home.png')}}" alt=""><a class="smooth active" href="">home</a></li>
				<li class="contact"><img src="{{asset('./Catopiana_files/images/contact.png')}}" alt=""><a class="smooth" href="#id2">contact</a></li>
				<li class="about"><img src="{{asset('./Catopiana_files/images/about.png')}}" alt=""><a class="smooth" href="#for-parent">about us</a></li>
			</ul>
			<ul class="top-right-menu">
				@guest('customers')
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
					{{-- <a class="smooth" href="#signin">sign in</a> --}}
                    <a type="button" class="smooth btn" data-toggle="modal" data-target="#modal-sign-in">sign in</a>
				</li>
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
					<a type="button" class="smooth btn" data-toggle="modal" data-target="#modal-sign-up">sign up</a>
				</li>
				@else
				@if(auth()->guard('customers')->user()->test_status == 1) 
				{{-- da lam xong bai free --}}
					<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
		                 <a class="smooth" href="{{ route('packages') }}">Packages</a>
		            </li>
	            @endif
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
                	<a class="smooth" style="cursor: pointer;" id="logoutBtn" data-route="{{ route('logout') }}"">log out</a>
				</li>
				@endguest
			</ul>
		</div>
	</div>
</header>

@include('frontend::layouts.header_button')
