@extends('frontend::layouts.layout')

@section('content')

<section class="psy-section section-test continue_section" id="id2">
{{-- <section class="continue_section"> --}}
    <div class="container continue_container">
        <div class="continue_row tn">
            <div class="col-md-12">
                <div class="continue_test"">
                    <div class="row">
                        <h1 class="text-center title1">Congratulation!</h1>
                        <h2 class="text-center title2">Get your result and receive free test here</h2>
                        <div  class="final">
                            <button type="button" class="btn-lg button-congratulation btn-share"><i class="fa fa-facebook"></i> Share on facebook</button>
                            <button type="button" onclick="location.href='{{route('payForResult')}}'"  class=" btn-lg button-congratulation btn-paid">or 1.99$</button>
                        </div>
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
        {{-- <img class="new-fish1" src="{{asset('./Catopiana_files/images/new-fish1.png')}}" alt=""> --}}
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
                    animation: false,
                    customClass: {
                        popup: 'swal-pop-facebook animated bounce',
                        title:'swal-title-facebook',
                        content: 'swal-content-facebook',
                        confirmButton:'swal-button-facebook'
                    }
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
