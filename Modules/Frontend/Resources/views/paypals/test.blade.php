@extends('frontend::layouts.layout')

@section('content')
    <section class="psy-section section-test" id="id2">
        <div class="container">
            <div class="row tn justify-content-center">
                <div class="col-md-12 justify-content-center" style="position: relative;width: 1000px;height: 800px; left: 50px; top: 110px;">
                        
                <form id="form-payment" method="POST" action="{{route('create-payment')}}">
                    @csrf
                </form>
                <div class="row">
                    <h3 class="text-center">Buy Package</h3>
                </div>
                <div class="row pricing">
                    <!-- Free Tier -->
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Free</h5>
                                <h6 class="card-price text-center">$0<span class="period"></span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 1</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 2</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 3</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 4</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Free Unlimited Private Curriculum</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Monthly Unlimited Private Curriculum</li>
                                </ul>
                                <a href="#" class="btn-checkout btn-block btn-warning text-uppercase">Let's Do it</a>
                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Package++</h5>
                                <h6 class="card-price text-center">$11.99<span class="period">/package</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 1</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 2</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 3</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 4</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Free Unlimited Private Curriculum</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Monthly Unlimited Private Curriculum</li>
                                </ul>
                                <a href="#" class="btn-checkout btn-block btn-primary text-uppercase checkout">CheckOut</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pro Tier -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Package Pro</h5>
                                <h6 class="card-price text-center">$21.99<span class="period">/package</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 1</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 2</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 3</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Topic 4</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Unlimited Private Curriculum</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Free Unlimited Private Curriculum</li>
                                    <li><span class="fa-li"><i class="fa fa-times"></i></span>Monthly Unlimited Private Curriculum</li>
                                </ul>
                                <a href="#" class="btn-checkout btn-block btn-primary text-uppercase checkout">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>  
            </div>
            <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
            <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
        </div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
    <script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
    <script>
        @if (session()->has('buy_package_light'))
            Swal.fire({
                type: 'info',
                title: '{{session('buy_package_light')}}',
                showConfirmButton: false,
              timer: 3000
            })
        @elseif (session()->has('buy_package_error'))
            Swal.fire({
                type: 'error',
                title: '{{session('buy_package_error')}}',
                showConfirmButton: false,
              timer: 3000
            })
        @endif
        $(document).on('click', '.checkout', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '<h2><strong>Checkout<u></u></strong></h2>',
                type: 'info',
                html:
                    'You Will buy <b>this package:</b>'
                    + ' <ul><li><p>Curriculum creative level 4</p></li>'
                    +'<li><p>Curriculum iq level 4</p></li></ul>'

                    ,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-shopping-cart "></i> Buy!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                '<i class="fa fa-ban"></i>',
                cancelButtonAriaLabel: 'Cancel',
            }).then((result) => {
                if(result.value) {
                    $('#form-payment').submit();
                }
            })        
        });

    </script>
@endsection