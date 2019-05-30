@extends('frontend::layouts.layout')

@section('content')
<section class="menu">
    <div class="container">
        <form action="" class="form-menu">
            <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
            <div class="age">
                <div class="title">1.Age: </div>
                <ol class="list_icon_menu">
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <input type="radio" value="3" name="age" hidden>3</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="3" name="age" hidden>4</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="3" name="age" hidden>5</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="3" name="age" hidden>6</li>
                </ol>
            </div>
            <div class="weight">
                <div class="title">2.Weight</div>
                <ol class="list_icon_menu">
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="10-12" name="weight" hidden>10-12</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="12-14" name="weight" hidden>12-14</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="14-16" name="weight" hidden>14-16</li>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3"><input type="radio" value="16-18" name="weight" hidden>16-18</li>
                </ol>
            </div>
            <div class="slide">
                <div class="title">3. Select food your children can not eat or does not like to eat:</div>
                    <div class="menu-slide-wr">
                        <div class="menu-slide">
                            <div class="one-article">
                                <div class="text-center">
                                    <h3 class="menu-food-catetory">Fruits</h3>
                                </div>
                                <div class="food">
                                    <ol class="list_icon_food">
                                        @foreach($fruits as $name => $url)
                                        <li class="col-xs-4 col-sm-4">
                                            <div class="img-food">
                                                <img src="{{ $url }}" alt="">
                                            </div>
                                            <div class="food-name">
                                                <p>{{ $name }}</p>
                                            </div>
                                            <input type="checkbox" name="fruits[]" value="{{ $name }}" hidden>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="one-article">
                                <div class="text-center">
                                    <h3 class="menu-food-catetory">Vegetables</h3>
                                </div>
                                <div class="food">
                                    <ol class="list_icon_food">
                                        @foreach($vegetables as $name => $url)
                                        <li class="col-xs-4 col-sm-4">
                                            <div class="img-food">
                                                <img src="{{ $url }}" alt="">
                                            </div>
                                            <div class="food-name">
                                                <p>{{ $name }}</p>
                                            </div>
                                            <input type="checkbox" name="vegetables[]" value="{{ $name }}" hidden>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="one-article">
                                <div class="text-center">
                                    <h3 class="menu-food-catetory">Grains</h3>
                                </div>
                                <div class="food">
                                    <ol class="list_icon_food">
                                        @foreach($grains as $name => $url)
                                        <li class="col-xs-4 col-sm-4">
                                            <div class="img-food">
                                                <img src="{{ $url }}" alt="">
                                            </div>
                                            <div class="food-name">
                                                <p>{{ $name }}</p>
                                            </div>
                                            <input type="checkbox" name="grains[]" value="{{ $name }}" hidden>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="one-article">
                                <div class="text-center">
                                    <h3 class="menu-food-catetory">Dairy Food</h3>
                                </div>
                                <div class="food">
                                    <ol class="list_icon_food">
                                        @foreach($dairyfood as $name => $url)
                                        <li class="col-xs-4 col-sm-4">
                                            <div class="img-food">
                                                <img src="{{ $url }}" alt="">
                                            </div>
                                            <div class="food-name">
                                                <p>{{ $name }}</p>
                                            </div>
                                            <input type="checkbox" name="dairyfood[]" value="{{ $name }}" hidden>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="one-article">
                                <div class="text-center">
                                    <h3 class="menu-food-catetory">Protein Food</h3>
                                </div>
                                <div class="food">
                                    <ol class="list_icon_food">
                                        @foreach($proteinfood as $name => $url)
                                        <li class="col-xs-3 col-sm-3">
                                            <div class="img-food">
                                                <img src="{{ $url }}" alt="">
                                            </div>
                                            <div class="food-name">
                                                <p>{{ $name }}</p>
                                            </div>
                                            <input type="checkbox" name="proteinfood[]" value="{{ $name }}" hidden>
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="button-menu-wr text-center">
                <button type="button" onclick="window.location.href='/chart'" class="button-menu gradient-button">OK</button>
            </div>
        </form>
    </div>
</section>

@endsection
@section('js')

<script type="text/javascript" src="{{asset('/js/local-storage.js?v=1.2')}}" ></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/menu.js')}}"></script>
@endsection
