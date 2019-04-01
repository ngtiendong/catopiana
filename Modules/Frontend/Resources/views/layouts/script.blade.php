

<!-- JQuery -->
<script src="{{asset('/Catopiana_files/js/jquery.js')}}"></script>
<!-- BOOTSTRAP -->

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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@stack('js')
