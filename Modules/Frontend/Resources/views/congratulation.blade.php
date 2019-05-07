@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test" id="id2">
{{-- <section class="continue_section"> --}}
    <div class="container continue_container">
        <div class="row tn">
            <div class="col-md-12">
                <div class="continue_test"">
                    <div class="row">
                        <h2 class="text-center title1" style=" font-size: 35px; color: white; margin-bottom: 25px;">Congratulation!</h2>
                        <h2 class="text-center title2" style=" font-size: 25px; color: white; ">Get your result and receive free test here</h2>
                        <div  class="final">
                            <button type="button" class="btn-info btn-lg button-congratulation btn-share"><i class="fa fa-facebook"></i> Share on facebook</button>
                            <button type="button"  class=" btn-info btn-lg button-congratulation btn-paid">or 1.99$</button>
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
            scrollTop: $('.continue_test').eq(0).offset().top
        }, 500);
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
                shared_or_paid()
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
    shared_or_paid = () => {
        if(received_free_package_status == 0) {
            testing_data.received_free_package_status = 2;
            localStorage.setItem('testing', JSON.stringify(testing_data));
        } 
        window.location.href = '/free-test-results'
    }
</script>
@endsection
