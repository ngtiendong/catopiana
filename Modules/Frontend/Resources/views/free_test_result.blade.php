@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section test result_test section-test" id="id2">
    <div class="col-md-12">
        <div class="bigwhale icon-in-test-page">
            <img class="girl congratulation-girl" src="{{asset('./Catopiana_files/images/girl.png')}}">
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="thanksforsubmit">
                        <h2 class="text-center">Thank you for submitting !</h2>
                        <div class="text-center">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                                Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="free_test_result">
                <div class="list_icon">
                </div>
                <div class="button_save">
                    <button class="btn-save button-recevie-package">Receive Package</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form_signup">
                <form action="">
                    <div class="form-group input-signup-result">
                        <label for="" class="col-md-2" style="text-align: right;">
                            NAME:
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group input-signup-result">
                        <label for="" class="col-md-2" style="text-align: right;">
                            EMAIL:
                        </label>
                        <div class="col-md-8">
                            <input type="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="button_create" style="text-align: center;">
                            <button type="button" class="btn_create">Sign up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <img class="boy_result" src="{{asset('./Catopiana_files/images/boy-blue.png')}}" alt="">
    </div>
    {{-- comment image to test not if lag --}}
    @include('frontend::layouts.background')
    <img id="island_result" src="{{asset('./Catopiana_files/images/island.png')}}" alt="">
    <img class="f1-result2 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
    <img class="f1-result1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
</section>
@endsection


@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    // $(document).ready(function() {
            // var count_free_package = 0;
            // for (var i=1; i<9; i++) {
                // if (list_test_finished.indexOf(i) < 0) {
                //     // có bài Chưa thi
                //     break;
                // }
                // count_free_package++;
            // }
            // if (count_free_package == 8) {
                // for (var i = 0; i < testing_data.question.length; i++) {
                //     this_question = testing_data.question[i];
                    // console.log('current', current_data)

                    // if (this_question.status == 1) {
                        // if(parseInt(this_question.type) == 2) {
                        //     max_images_in_column = this_question.question_data[0].length
                        //     total_question = parseInt(this_question.question_data.length) * max_images_in_column;
                        //     correct = filterCorrectPosition(this_question, max_images_in_column);
                        // } else {
                        //     total_question = parseInt(this_question.question_data.length);
                        //     correct = this_question.answers.filter(answer => answer == 0).length;
                        // }


                       // result = 1;
                       // topic = parseInt(this_question.topic)
                       // if(i < 5) {
                            // $('.free_test_result .top').append('<div>'+array_svg[i-1]+'<p><b>'+result+'</b></p></div>')
                        // } else if ( i < 9) {
                            // $('.free_test_result .bot').append('<div>'+array_svg[i-1]+'<p><b>'+result+'</b></p></div>')
                        // }
                        // $('.button-recevie-package').removeClass('hidden')
                    // }
                // }
            // } 
    // });
jQuery(document).ready(function($) {
    let gen_html = '';
    let style = '';
    for (var i=1; i<9; i++) {
        this_question = testing_data.question[i];
        if (this_question.status == 1) {
            if(parseInt(this_question.type) == 2) {
                total_question = countTotalPosition(this_question)
                correct = filterCorrectPosition(this_question);
            } else {
                total_question = parseInt(this_question.question_data.length);
                correct = this_question.answers.filter(answer => answer == 0).length;
            }
           result = correct+'/'+total_question ;
        }
        gen_html += '<div class="col-md-3 below-list-test-f">' + array_svg[i-1] +'<p><b>'+result+'</b></p></div>'
    }
    $('.free_test_result .list_icon').append(gen_html)
});

$(document).on('click', '.button-recevie-package', function(event) {
        // add status đã nhận package to localstorage
        if(received_free_package_status == 2) {
            testing_data.received_free_package_status = 1;
            localStorage.setItem('testing', JSON.stringify(testing_data));
            url = $(this).data('route');
            window.location.href = url
        } else if(received_free_package_status == 1) {
            url = $(this).data('route');
            window.location.href = url
        } else {
            return false;
        }
});
    function filterCorrectPosition(this_question) {
        let result = 0
        this_question.answers.forEach(function(value, index){
            for (var k=0; k<value.length; k++) {
                if (value[k][0] == value[k][1] ) {
                    result += 1
                }
            }
        })
        return result;
    }
    function countTotalPosition(this_question) {
        let total = 0;
        this_question.answers.forEach(function(value, index){
            total += value.length
        })
        return total;
    }
</script>
@endsection
