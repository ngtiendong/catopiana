@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test continue_section" id="id2">
{{-- <section class="continue_section"> --}}
    <div class="container continue_container">
        <div class="continue_row tn">
            <div class="col-md-12">
                <div class="report_container">
                    <div class="button-report-container">
                        <form target="_blank" action="{{ route('read-report') }}" method="POST">
                            @csrf
                            @method('post')
                            <input class="result_report" type="text" hidden name="result">
                            <input class="total_question" type="text" hidden name="total_question">
                            <input id="topic-report" type="text" hidden value="{{ $topic }}" name="topic">
                            <button type="submit" class="btn-lg button-report btn-see-report"> Click for Report</button>
                        </form>
                        <form action="{{ route('download-report') }}" method="POST">
                            @csrf
                            @method('post')
                            <input class="result_report" type="text" hidden name="result">
                            <input class="total_question" type="text" hidden name="total_question">
                            <input type="text" hidden value="{{ $topic }}" name="topic">
                            <button type="submit" class=" btn-lg button-report btn-download-report"><i class="fa fa-download"></i> Download report</button>      
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <img class="girl congratulation-girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="f7 fish" src="{{asset('./Catopiana_files/images/f7.svg')}}" alt="">
        <img class="f1-1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f1-2 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f2-1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="f2-2 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
        <img class="sea-horse1" src="{{asset('./Catopiana_files/images/sea-horse1.png')}}" alt="">
    </div>
    <div class="container list-test">
        <div class="row">

        </div>
    </div>
    {{-- comment image to test not if lag --}}
    @include('frontend::layouts.background')
    <img class="boy" src="{{asset('./Catopiana_files/images/boy-blue.png')}}" alt="">
    <img id="island" src="{{asset('./Catopiana_files/images/island1.png')}}" alt="">
</section>
@endsection

@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    $(document).ready(function() {
        var topic = $('#topic-report').val();
        for (var i=1; i<9; i++) {
            if(typeof testing_data.question[i -1] === 'undefined') {
                continue;
            }
            this_question = testing_data.question[i -1];
            if (this_question.status == 1 && parseInt(this_question.topic) == parseInt(topic)) {
                if(parseInt(this_question.type) == 2) {
                    total_question = countTotalPosition(this_question)
                    correct = filterCorrectPosition(this_question);
                } else {
                    total_question = parseInt(this_question.question_data.length);
                    correct = filterCorrectNormal(this_question);
                }
                break;
            }
        }
        $('.result_report').val(correct);
        $('.total_question').val(total_question);
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
</script>
@endsection
