@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test continue_section" id="id2">
    <div class="container continue_container">
        <div class="continue_row tn">
            <div class="col-md-12">
                <div class="continue_test" data-topic="{{ $prev_topic }}">
                    <div class="row">
                        <h1 class="text-center title1" >You did a great job !</h1>
                        <h2 class="text-center title2" >Do You want to continue?</h2>
                        <div class="continue">
                            <button type="button" class=" btn-lg button-continue btn-continue button">Yes</button>
                            <button type="button"  class=" btn-lg button-continue btn-back button">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="girl congratulation-girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        {{-- <img class="f7 fish" src="{{asset('./Catopiana_files/images/f7.svg')}}" alt=""> --}}
        <img class="f1-1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f1-2 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f2-1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f2-2 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="sea-horse1" src="{{asset('./Catopiana_files/images/sea-horse1.png')}}" alt="">
        {{-- <img class="new-fish1" src="{{asset('./Catopiana_files/images/new-fish1.png')}}" alt=""> --}}
    </div>
    {{-- <div class="list-test continue-list-test"> --}}
        <div class="col-md-12 list-test-unfinished" id="list-test-unfinished">
            <h3></h3>
        </div>
    {{-- </div> --}}
    {{-- comment image to test not if lag --}}
    @include('frontend::layouts.background')
    <img id="island" src="{{asset('./Catopiana_files/images/island1.png')}}" alt="">
    <img class="boy" src="{{asset('./Catopiana_files/images/boy-blue.png')}}" alt="">

</section>
@endsection


@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    $(window).on('load', function(){
        /**
         * Load mp3 here
         */
        function preloadAudio(url) {
            var audio = new Audio();
            // once this file loads, it will call loadedAudio()
            // the file will be kept by the browser as cache
            audio.src = url;
        }
        preloadAudio("/sounds/win.mp3")
        preloadAudio("/sounds/applause3.mp3")
    })
    $(document).ready(function() {
        $('html,body').stop().animate({
            scrollTop: $('.continue_container').eq(0).offset().top
        }, 500);
        play_sound("/sounds/win.mp3")
        play_sound("/sounds/applause3.mp3")
        const tl1 = new mojs.Timeline({
            repeat: 999
        }).add(fw1, fws1, fw21, fw20, fw2, fw3, fw4, fw5, burstPolygon, burstCross, swirl, swirl2, swirl3, circ, circ2).play();

    });
    $('.btn-back').click(function(event) {
        /* Act on the event */
        window.location.href = '/';
    });
    $('.btn-continue').click(function(event) {
            /* Act on the event */
        $('div.list-test-unfinished').css('display', 'flex');
        var topic = $('.continue_test').data('topic');
        displayTestUnFinishedAfterSubmit(parseInt(topic))
    });

    function displayTestUnFinishedAfterSubmit(topic) {
        console.log(list_test_finished);
        let gen_html = '<div>'
        if(topic < 9){
            for (var i=1; i<9; i++) {
                if (list_test_finished.indexOf(i) < 0) {
                    //Chua thi
                    gen_html += array_svg[i-1]
                }
            }
        } else {
            // free_package_arr = [9,10,11,12];
            // if(free_package_arr.includes(topic) ) {
            //     window.location.href = '/free-packages';
            // } else {
            //     window.location.href = '/paid-packages';
            // }
            window.location.href = '/'
        }
        gen_html += '</div>'
        $('div.list-test-unfinished > h3').text("Next test: ")
        $('div.list-test-unfinished').hide()
        $('div.list-test-unfinished').empty()
        $('div.list-test-unfinished').append(gen_html)

        $('.fadeOut').hide()
        $('div.list-test-unfinished').fadeIn(1000)

        $('html,body').animate({
            scrollTop: $('#list-test-unfinished').offset().top - $('#list-test-unfinished').height()
        }, 700);
    }
</script>
@endsection
