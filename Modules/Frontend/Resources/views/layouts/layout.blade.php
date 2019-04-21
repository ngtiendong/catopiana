<!DOCTYPE html>
<html lang="en-US">
	@include('frontend::layouts.head')
	<body class="home blog">
		<div class="wrap">
			<img src="{{asset('./Catopiana_files/images/bg-02.png')}}" alt="">
			@include('frontend::layouts.header')
			
			@yield('content')
			
			@include('frontend::layouts.footer')
		</div>
		@include('frontend::layouts.script')
	</body>
</html>

