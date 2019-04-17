@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test" id="id2">
    <div class="container">
        <div class="row tn">
            <div class="col-md-12">
                <div class="bigwhale icon-in-test-page">

                </div>
            </div>
            <div class="col-md-6 col-md-offset-3 ">
                <h3>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iste sunt explicabo? Doloremque, odio.</h3>
            </div>

            <div class="col-md-12">
                <div class="testOverlay">
                    <a class="startBtn">Click To Start!</a>
                    <input id="type" value="{{$type_and_topic['type']}}" hidden>
                    <input id="topic" value="{{$type_and_topic['topic']}}" hidden>

                    <form id="testForm" data-login="{{ auth()->guard('customers')->check() ? true : false }}">
                            <button class="test-button" type="button" id="prevBtn" onclick="prev()">Previous</button>
                            <button class="test-button" type="button" id="nextBtn" onclick="next()">Next</button>
                            <button class="test-button" type="submit" id="submitBtn" style="display: none">Submit</button>

                        <div class="dot">
                            <span class="badge badge-pill badge-primary"></span>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-12 list-after-finished" id="list-after-finished">
                <h3></h3>
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
@include('frontend::layouts.modal_in_testing')
@endsection


@section('js')
    <script type="text/javascript" src="{{asset('/js/local-storage.js')}}"></script>
    <script src="{{asset('/js/music.js?v=1.2')}}"></script>
    <script src="{{asset('/js/variables.js')}}"></script>
    <script src="{{asset('/js/handle_client_ver_1.js')}}"></script>
    <script src="{{asset('/js/svg_variables.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
@endsection
