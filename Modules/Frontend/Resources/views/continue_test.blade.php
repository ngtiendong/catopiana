@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test" id="id2">
{{-- <section class="continue_section"> --}}
    <div class="container continue_container">
        <div class="row tn">
            <div class="col-md-12">
                <div class="continue_test" data-topic="{{ $prev_topic }}">
                    <div class="row">
                        <h2 class="text-center title1" style=" font-size: 30px; color: white; margin-bottom: 25px;">You did a great job !</h2>
                        <h2 class="text-center title2" style=" font-size: 30px; color: white; ">Do You want to continue?</h2>
                        <div class="continue">
                            <button type="button" class="btn-outline-info btn-info btn-lg button-continue btn-continue">Yes</button>
                            <button type="button"  class="btn-outline-info btn-info btn-lg button-continue btn-back">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        {{-- <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt=""> --}}
    </div>
    <div class="container list-test">
        <div class="row">
            <div class="col-md-12 list-test-unfinished" id="list-test-unfinished">
                <h3></h3>
            </div>
        </div>
    </div>
    {{-- comment image to test not if lag --}}
    @include('frontend::layouts.background')
</section>
{{-- <section class="psy-section" id="id3">
    <div class="container-fluid">
        <div class="row"></div>
    </div>
</section> --}}
@endsection


@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    $(document).ready(function() {
        $('html,body').stop().animate({
            scrollTop: $('.continue_container .continue_test').eq(0).offset().top
        }, 500);
    });
    $('.btn-back').click(function(event) {
        /* Act on the event */
        window.location.href = '/';
    });
    $('.btn-continue').click(function(event) {
        /* Act on the event */
    var topic = $('.continue_test').data('topic');
    displayTestUnFinishedAfterSubmit(parseInt(topic))
    // if(parseInt(topic) < 9){
    //     var next_quiz = 0;
    //     var count_free_package = 0;
    //     for (var i=1; i<9; i++) {
    //         if (list_test_finished.indexOf(i) < 0) {
    //             //Chua thi
    //             next_quiz = i
    //             break;
    //         }
    //         count_free_package++;
    //     }
    //     if (next_quiz > 0) {
    //         // làm xong bài khác bài free
    //         var topic_arr_free = [
    //             'music',
    //             'iq',
    //             'creative',
    //             'difference',
    //             'common',
    //             'memory',
    //             'language',
    //             'position'
    //         ];
    //         var next_topic = topic_arr_free[next_quiz - 1];
    //         window.location.href = '/'+next_topic;
    //     }
    // } else {
    //     free_package_arr = [9,10,11,12];
    //     if(free_package_arr.includes(parseInt(topic)) ) {
    //         window.location.href = '/free-packages';
    //     } else {
    //         window.location.href = '/paid-packages';
    //     }
    // }

    });

    function displayTestUnFinishedAfterSubmit(topic) {
        console.log(list_test_finished);
        let gen_html = '<div style="margin-top:25px; padding-right: 40px">'
        if(topic < 9){
            for (var i=1; i<9; i++) {
                if (list_test_finished.indexOf(i) < 0) {
                    //Chua thi
                    gen_html += array_svg[i-1]
                }
            }
        } else {
            free_package_arr = [9,10,11,12];
            if(free_package_arr.includes(topic) ) {
                window.location.href = '/free-packages';
            } else {
                window.location.href = '/paid-packages';
            }
        }
        gen_html += '</div>'
        $('div.list-test-unfinished > h3').text("Next test: ")
        $('div.list-test-unfinished').hide()
        $('div.list-test-unfinished').empty()
        $('div.list-test-unfinished').append(gen_html)

        $('.fadeOut').hide()
        $('div.list-test-unfinished').fadeIn(1000)

        $('html,body').animate({
            scrollTop: $('#list-test-unfinished').offset().top
        }, 700);
    }
</script>
@endsection
