@extends('frontend::layouts.layout')

@section('content')
	<section class="psy-section section-test" id="id2">
	    <div class="container">
            {{-- <div class="col-md-6 col-md-offset-3 fadeOut">
            </div> --}}
            {{-- <div class="col-md-4 col-md-offset-4">	 --}}
            <div class="row tn justify-content-center">
                <h3 class="text-center">Buy Package</h3>
                <div class="col-md-12 justify-content-center" style="position: relative;
                                                                    width: 1000px;
                                                                    height: 800px;
                                                                    left: 50px;
                                                                    top: 110px;">
                        
        			    <form id="form-payment" method="POST" action="{{route('create-payment')}}">
        			        @csrf
        			    </form>
                        <div class="row">
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            <div class=" package-paid card col-md-3 text-white bg-light border-danger">
                                <img class="card-img-top" src="{{asset('Catopiana_files/images/no-picture.svg')}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Package ABC</h5>
                                    <p class="card-text">This package with more curriculum for your choice</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Curriculum creative level 4</li>
                                    <li class="list-group-item">Curriculum iq level 4</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-primary checkout"  style="position: relative;">Checkout</button>   
                                </div>
                            </div>
                            
                        </div>
                </div>  
            </div>

            {{-- </div> --}}
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
    </div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
    <script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
    <script>
        @if (session()->has('buy_package_light border-danger'))
            Swal.fire({
                type: 'light border-danger',
                title: '{{session('buy_package_light border-danger')}}',
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
                title: '<strong>Checkout<u></u></strong>',
                type: 'light',
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