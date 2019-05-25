

<!-- JQuery -->
<script src="{{asset('/Catopiana_files/js/jquery.js')}}"></script>
<!-- BOOTSTRAP -->
<script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- OTHER -->
<script src="{{asset('/Catopiana_files/js/gsap.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/scrollMagic.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/animation.gsap.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/slick.min.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/user.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/script.js?v=1.2')}}"></script>
<script src="{{asset('/Catopiana_files/js/calculation.js')}}"></script>
<script src="{{asset('/Catopiana_files/js/sweetalert2.min.js')}}"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<!-- or -->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mo-js@latest/build/mo.min.js"></script>
<script src="{{asset('/Catopiana_files/js/howler.min.js')}}"></script>
<script src="{{asset('/js/effect.js?v=1.2')}}"></script>
<script src="{{asset('/js/waitForImages.js')}}"></script>
{{--<script src="{{asset('/js/animation-custom.js')}}"></script>--}}
<script src="{{asset('/js/mobile.js')}}"></script>

<script>
	$('.d-nav').hc_menu({
			open: '.open-mnav',
	});
</script>
<!-- Some function need to run in document ready function: Select2 ,.... -->
<script src="{{ asset('helperJS/documentReadyFunction.js') }}"></script>

<script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
    }
</script>


@yield('js')
