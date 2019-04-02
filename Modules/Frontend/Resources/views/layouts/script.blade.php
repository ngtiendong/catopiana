

<!-- JQuery -->
<script src="{{asset('/Catopiana_files/js/jquery.js')}}"></script>
<!-- BOOTSTRAP -->
{{--<script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>--}}
<!-- OTHER -->
<script src="{{asset('/Catopiana_files/js/gsap.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/scrollMagic.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/animation.gsap.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/slick.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/user.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/script.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/calculation.js')}}"></script>
<script>
	$('.d-nav').hc_menu({
			open: '.open-mnav',
	});
</script>
<!-- Some function need to run in document ready function: Select2 ,.... -->
<script src="{{ asset('helperJS/documentReadyFunction.js') }}"></script>
@yield('js')
