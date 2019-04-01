<header class="">
	<nav class="d-nav">
		<ul class="psy-pane">
			<li class="home"><img src="{{asset('./Catopiana_files/images/home.png')}}" alt=""><a class="smooth active" href="{{route('home')}}">home</a></li>
			<li class="contact"><img src="{{asset('./Catopiana_files/images/contact.png')}}" alt=""><a class="smooth" href="#id2">contact</a></li>
			<li class="about"><img src="{{asset('./Catopiana_files/images/about.png')}}" alt=""><a class="smooth" href="#for-parent">about us</a></li>
		</ul>
		<ul class="top-right-menu">
			@if(!auth()->check())
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
				<a class="smooth" href="#signin">sign in</a>
			</li>
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt=""><a class="smooth" href="#signup">sign up</a></li>
			@else
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt=""><a class="smooth" href="#signup">{{auth()->user()->username}}</a></li>
			<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt=""><a class="smooth" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
			</li>
			@endif
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
				@if(!auth()->check())
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt="">
					<a class="smooth" href="#signin">sign in</a>
				</li>
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt=""><a class="smooth" href="#signup">sign up</a></li>
				@else
				<li class="sign"><img src="{{asset('./Catopiana_files/images/sign.png')}}" alt=""><a class="smooth" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">sign out</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</header>

@include('frontend::layouts.header_button')
