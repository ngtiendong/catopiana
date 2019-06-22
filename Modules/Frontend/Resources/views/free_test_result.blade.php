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
                    <button data-route='{{ route('home') }}' class="btn-save button-recevie-package">Receive Package</button>
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
    jQuery(document).ready(function($) {
        let gen_html = '';
        let style = '';
        for (var i=1; i<9; i++) {
            this_question = testing_data.question[i -1];
            if (this_question.status == 1) {
                if(parseInt(this_question.type) == 2) {
                    total_question = countTotalPosition(this_question)
                    correct = filterCorrectPosition(this_question);
                } else {
                    total_question = parseInt(this_question.question_data.length);
                    correct = filterCorrectNormal(this_question);
                }
               result = correct+'/'+total_question ;
               topic = parseInt(this_question.topic);
            }
            gen_html += '<div class="col-md-3 below-list-test-f">' + array_svg[topic-1] +'<p class="result_test" ><b>'+result+'</b></p></div>'
        }
        $('.free_test_result .list_icon').append(gen_html)
    });

    $(document).on('click', '.button-recevie-package', function(event) {
            // add status đã nhận package to localstorage
            // if(received_free_package_status == 2) {
            //     testing_data.received_free_package_status = 1;
            //     localStorage.setItem('testing', JSON.stringify(testing_data));
            //     url = $(this).data('route');
            //     window.location.href = url
            // } else 
            if (received_free_package_status == 1) {
                url = $(this).data('route');
                window.location.href = url
            } else {
                window.location.href = url
            }
    });
    function filterCorrectPosition(this_question) {
        result = 0
        this_question.answers.forEach(function(answer, i){
            result_element = this_question.result[i];
            for (var k=0; k<answer.length; k++) {
                ans = answer[k].filter(function(value, index, array){ return index < 2});
                if (result_element.containsArray(ans)) {
                    result += 1;
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
    Array.prototype.containsArray = function(val) {
        var hash = {};
        for(var i=0; i<this.length; i++) {
            hash[this[i]] = i;
        }
        return hash.hasOwnProperty(val);
    }

    function filterCorrectNormal(this_question) {
        if(this_question.type === "5" && this_question.topic === "3"){
            return this_question.answers.length;
        } else {
            result = 0
            result_element = this_question.result;
            answer_element = this_question.answers;
            for (var k=0; k<answer_element.length; k++) {
                if (result_element[k] == answer_element[k]) {
                    result += 1;
                }
            }
            return result;
        }
    }

$(document).on('click', '.free_test_result .test-item', function(event) {
    event.preventDefault();
    let topic = $(this).data('topic');
    Swal.fire({
        title: 'Receive report for this test',
        backdrop: `rgba(255, 255, 255, 0.61)`,
        animation: false,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        customClass: {
            popup: 'swal-pop-custom-report animated zoomIn',
            title:'swal-title-custom-report',
            content: 'swal-content-custom-report',
            confirmButton:'swal-button-confirm-report',
            cancelButton: 'swal-button-cancel-report'
        }
    }).then((result) => {
        if (result.value) {
            window.location.href = '/report/'+topic
        }
     });
});
    


</script>
@endsection
