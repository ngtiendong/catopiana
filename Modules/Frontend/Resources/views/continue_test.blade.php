@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test" id="id2">
    <div class="container">
        <div class="row tn">
            <div class="md-lg-12">
                <div class="bigwhale icon-in-test-page">

                </div>
            </div>
            <div class="col-md-12">
                <div class="testOverlay continue_test" data-topic="{{ $prev_topic }}">
                    <div class="row">
                        <h2 class="text-center title1" style=" font-size: 30px; color: white; margin-bottom: 25px;">You did a great job !</h2>
                        <h2 class="text-center title2" style=" font-size: 30px; color: white; ">Do You want to continue?</h2>
                        <div class="continue"  style=" text-align: center; margin-top: 46px;">
                            <button type="button" class="btn-outline-info btn-info btn-lg button-continue btn-continue">Yes</button>
                            <button type="button"  class="btn-outline-info btn-info btn-lg button-continue btn-back">No</button>
                        </div>
                        <div  class="final" style=" text-align: center; margin-top: 46px; display: none;">
                            <button type="button" class="btn-outline-info btn-info btn-lg button-continue btn-share"><i class="fa fa-facebook"></i> Share on facebook</button>
                            <button type="button"  class="btn-outline-info btn-info btn-lg button-continue">Pay to get Result</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
    </div>
    <div class="container list-test">
        <div class="row">

        </div>
    </div>
    {{-- comment image to test not if lag --}}
    @include('frontend::layouts.background')
</section>
<section class="psy-section" id="id3">
    <div class="container-fluid">
        <div class="row"></div>
    </div>
</section>
@endsection


@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    $(document).ready(function() {
        $('html,body').stop().animate({
            scrollTop: $('.testOverlay').eq(0).offset().top
        }, 500);
        var topic = $('.continue_test').data('topic');
        if(parseInt(topic) < 9){
            var next_quiz = 0;
            var count_free_package = 0;
            for (var i=1; i<9; i++) {
                if (list_test_finished.indexOf(i) < 0) {
                    //Chua thi
                    next_quiz = i
                    break;
                }
                count_free_package++;
            }
            // console.log(list_test_finished);

            // now use variables topic_arr_free[]
            if (count_free_package == 8 && list_test_finished.indexOf(parseInt(topic)) > 0) {
                // share
                $('.final').css('display','inline-block');
                $('.continue;').css('display','none');
                $('.title1').html('Congratulation!');
                $('.title2').html('You have finished all test. Do you want to get the result?');
            }
        } else {
            // topic k phai free
        }
    });
    $('.btn-back').click(function(event) {
        /* Act on the event */
        window.location.href = '/';
    });
    $('.btn-continue').click(function(event) {
        /* Act on the event */
    var topic = $('.continue_test').data('topic');
    if(parseInt(topic) < 9){
        var next_quiz = 0;
        var count_free_package = 0;
        for (var i=1; i<9; i++) {
            if (list_test_finished.indexOf(i) < 0) {
                //Chua thi
                next_quiz = i
                break;
            }
            count_free_package++;
        }
        if (next_quiz > 0) {
            // làm xong bài khác bài free
            var topic_arr_free = [
                'music',
                'iq',
                'creative',
                'difference',
                'common',
                'memory',
                'language',
                'position'
            ];
            var next_topic = topic_arr_free[next_quiz - 1];
            window.location.href = '/'+next_topic;
        }
    } else {
        free_package_arr = [9,10,11,12];
        if(free_package_arr.includes(parseInt(topic)) ) {
            window.location.href = '/free-packages';
        } else {
            window.location.href = '/paid-packages';
        }
    }

    });
    $('.btn-share').click(function(event) {
        /* Act on the event */
         FB.ui({
            method: 'share',
            href: 'https://beta.catopiana.com/',
            layout: 'button_count',
            size: 'large',
        }, function(response){
            if (response && !response.error_code) {
                window.location.href = '/free-test-results'
            } else {
                Swal.fire({
                    title: 'Notice',
                    text: "You haven't shared on Facebook",
                    display: 'flex',
                    backdrop: `rgba(0,0,0,0.1)`,
                })
            }
      });
    });
</script>
@endsection
