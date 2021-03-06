@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section test section-test" id="id2">
    <div class="container">
        <div class="row tn">
            <div class="col-lg-12">
                <div class="bigwhale icon-in-test-page">
                    
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3 fadeOut">
                <h3>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iste sunt explicabo? Doloremque, odio. </h3>
            </div>
            <div class="col-md-12 testOver">
                <div class="newTestOverlay">
                    <input id="type" value="{{$type_and_topic['type']}}" hidden>
                    <input id="topic" value="{{$type_and_topic['topic']}}" hidden>
                    <div class="progress">
                        <div class="bar shadow bars"></div>
                    </div>
                    <form id="testForm" data-login="{{ auth()->guard('customers')->check() ? true : false }}" >
                            <button class="test-button button-gradient" type="button" id="prevBtn"  onclick="prev()">Previous</button>
                            <button class="test-button button-gradient" type="button" id="nextBtn" onclick="next()">Next</button>
                            <button class="test-button button-gradient" type="submit" id="submitBtn" style="display: none">Submit</button>
                    </form>
                </div>
                <div class="dot">
                    <span class="badge badge-pill badge-primary"></span>
                </div>
            </div>
            <div class="below-test">
                <div class="button-below-test col-md-12">
                    <button class="button-below previous" data-url="{{ route('home') }}">previous</button>                    
                    <button class="button-below next">next</button>              
                </div>
                <div class="list-below-test col-md-12">
                    <div class="row row-list-below-test">
  
                    </div>           
                </div>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="layout-test" src="{{asset('./Catopiana_files/images/test.png')}}" alt="">
    </div>

    {{-- comment image to test not lag --}}
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
<script src="{{asset('/js/variables.js?v=1.2')}}"></script>
<script src="{{asset('/js/handle_client_ver_1.js?v=1.2')}}"></script>
<script src="{{asset('/js/svg_variables.js?v=1.2')}}"></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
@endsection
