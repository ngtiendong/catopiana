@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test" id="id2">
    <div class="container">
        <div class="row tn">
            <div class="md-lg-12">
                <div class="bigwhale icon-in-test-page">

                </div>
            </div>
            <div class="col-md-6 col-md-offset-3 fadeOut">
                <h3>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iste sunt explicabo? Doloremque, odio. </h3>
            </div>
            <div class="col-md-12 list-after-finished" id="list-after-finished">
                <h3></h3>
            </div>
            <div class="col-md-12">
                <div class="testOverlay free_test_result">
                    <div class="row">
                        <h2 class="text-center" style=" font-size: 30px; margin-bottom: 25px;">Your free test results</h2>
                        <div class="top text-center" style="margin-bottom: 15px"> 
                        </div>
                        <div class="bot text-center" style="margin-bottom: 15px">
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
        console.log()
        for (var i = 0; i < testing_data.question.length; i++) {
            this_question = testing_data.question[i];
            // console.log('current', current_data)

            if (this_question.status == 1) {
               total_question = parseInt(this_question.question_data.length);
               correct = this_question.answers.filter(answer => answer == 0).length;
               result = correct+'/'+total_question;
               topic = parseInt(this_question.topic)
               if(i < 4) {
                    $('.free_test_result .top').append('<div>'+array_svg[topic-1]+'<p><b>'+result+'</b></p></div>')
                } else if ( i < 8) {
                    $('.free_test_result .bot').append('<div>'+array_svg[topic-1]+'<p><b>'+result+'</b></p></div>')
                }
            }
        }
    });
</script>
@endsection
