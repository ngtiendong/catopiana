<!DOCTYPE html>
<!-- saved from url=(0021)http://catopiana.com/ -->
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


		<div id="lbdictex_find_popup" class="lbexpopup hidden" style="position: absolute; top: 0px; left: 0px;">
			<div class="lbexpopup_top">
				<h2 class="fl popup_title">&nbsp;</h2>
				<ul>
					<li><a class="close_main popup_close" href="#">&nbsp;</a></li>
				</ul>
				<div class="clr"></div>
			</div>
			<div class="popup_details"></div>
			<div class="popup_powered">abc</div>
		</div>
		<div id="lbdictex_ask_mark" class="hidden" style="position: absolute; top: 0px; left: 0px;">
			<a class="lbdictex_ask_select" href="#">&nbsp;</a>
		</div>
	</body>
</html>