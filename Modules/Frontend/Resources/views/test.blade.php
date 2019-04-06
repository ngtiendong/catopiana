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
                <div class="testOverlay">
                    <input id="type" value="{{$type_and_topic['type']}}" hidden>
                    <input id="topic" value="{{$type_and_topic['topic']}}" hidden>

                    <a class="startBtn">Click To Start!</a>
                    <form id="testForm">

                            <button class="test-button" type="button" id="prevBtn"  onclick="prev()">Previous</button>
                            <button class="test-button" type="button" id="nextBtn" onclick="next()">Next</button>
                            <button class="test-button" type="submit" id="submitBtn" style="display: none">Submit</button>
                        <div class="dot">
                            <span class="badge badge-pill badge-primary"></span>


                            {{--<span class="step active" onclick="currentQ(0)"></span>--}}
                            {{--<span class="step" onclick="currentQ(1)"></span>--}}
                            {{--<span class="step" onclick="currentQ(2)"></span>--}}
                        </div>
                    </form>
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
<script src="{{asset('/js/variables.js')}}"></script>
<script src="{{asset('/js/handle_client_ver_1.js')}}"></script>
<script src="{{asset('/js/svg_variables.js')}}"></script>

@endsection
