@extends('frontend::layouts.layout')
@section('content')
<section class="psy-section" id="id1">
    <div class="container">
        <div class="board">
            <img id="bb" src="{{asset('./Catopiana_files/images/bh.png')}}" alt="">
            <div class="row">
                <div class="col-lg-5 item">
                    <h1>CAT</h1>
                </div>
                <div class="col-lg-7 item">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. In aliquam dolore pariatur odit repellendus perspiciatis corrupti dolorem, porro est voluptatibus quo, eum unde rerum enim et animi nisi temporibus necessitatibus debitis! Quis molestias sint quaerat.</p>
                </div>
            </div>
            <img id="sub1" src="{{asset('./Catopiana_files/images/sub1.png')}}" alt="">
            <img id="sub2" src="{{asset('./Catopiana_files/images/sub2.png')}}" alt="">
            <img id="sub3" src="{{asset('./Catopiana_files/images/sub3.png')}}" alt="">
        </div>
        <div class="cta">
            <div class="item-cta">
                <a class="psy-btn" href="#id3">Parents</a>
            </div>
            <div class="item-cta">
                <a class="psy-btn" href="#id2">Children</a>
            </div>
        </div>
    </div>
    <img class="f1 fish" src="{{asset('./Catopiana_files/images/f1.svg')}}" alt="">
    <img class="f3 fish" src="{{asset('./Catopiana_files/images/f3.svg')}}" alt="">
    <img class="f4 fish" src="{{asset('./Catopiana_files/images/f3.svg')}}" alt="">
    <img class="f5 fish" src="{{asset('./Catopiana_files/images/f5.svg')}}" alt="">
    <img class="b1 bubble" src="{{asset('./Catopiana_files/images/b1.svg')}}" alt="">
    <img class="b2 bubble" src="{{asset('./Catopiana_files/images/b1.svg')}}" alt="">
    <img class="b3 bubble" src="{{asset('./Catopiana_files/images/b1.svg')}}" alt="">
    <img class="b4 bubble" src="{{asset('./Catopiana_files/images/b1.svg')}}" alt="">
</section>
<section class="psy-section" id="id2">
    <div class="container">
        <div class="row tn">
            <div class="col-md-6 col-md-offset-3">
                <h3>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iste sunt explicabo? Doloremque, odio. Quos totam corrupti dignissimos? Consequuntur impedit quaerat non dolorum autem tenetur! Impedit deserunt dignissimos facilis odio.</h3>
            </div>
            <div class="col-md-12">
                <div class="bigwhale">
                    <a class="test-now" href="#list-test">
                    <img src="{{asset('./Catopiana_files/images/whale.png')}}">
                    </a>
                    <div class="bg" id="list-test"></div>
                </div>
            </div>
        </div>
        <img class="girl" src="{{asset('./Catopiana_files/images/girl.png')}}" alt="">
        <img class="boy" src="{{asset('./Catopiana_files/images/boy.png')}}" alt="">
        <img class="whale" src="{{asset('./Catopiana_files/images/wavebg.png')}}" alt="">
    </div>
    <div ></div>
    @if (!auth()->guard('customers')->user() || auth()->guard('customers')->user()->test_status == 0)
    <div class="container list-test free_topic"><!-- free_topic_here -->
        <div class="row">
            <div class="top"> 
            </div>
            <div class="bot">
            </div>
        </div>
        <img class="f6" src="{{asset('./Catopiana_files/images/f6.svg')}}" alt="">
        <img class="f7" src="{{asset('./Catopiana_files/images/f7.svg')}}" alt="">
    </div>
    @else
    <div class="container list-test package-give-free" style="z-index: 9; font-size: 40px; text-align: center;">
        <div class="row">
            @if($freePackage != null)
                <h2 class="text-center" style=" font-size: 30px; margin-bottom: 25px;">Your free curriculum:</h2>
            @endif
            <div class="top text-center">
                @if($freePackage != null)
                @foreach($freePackage as $key => $curriculum)
                <a class="test-item brain" href="/{{$curriculum->topic->name}}" data-topic="{{$curriculum->topic_id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 119.93 116.7"><defs><style>.ea7927c4-26e5-4a51-8871-91fb1090623f{fill:#ae87be;}.\\35 2ea4671-10bf-4979-884b-08f6ad13f2db{fill:#f05c42;}.fc5a0db9-2687-41c3-a28e-80996c513432{fill:#102f41;}.\\34 28ee4a8-30b0-414c-bb65-d1f885636717{fill:#ffaf42;}.\\34 1de24ea-9b3c-40a9-97ae-73f0ac741c62{fill:#f1e4c4;}.calbtn{fill:#faaf3d;}.\\34 b7c23d9-1cf6-4e21-9d40-c4c726c687ba{fill:#ed6245;}</style></defs><title>iq</title><g id="d2005e62-e63c-4ca3-a37f-4bba6d4ce9c6" data-name="Layer 2"><g id="3770d6ff-e05d-4b80-8ebd-a41431f8007a" data-name="Layer 1"><g id="113a161e-8ddf-4d88-a1eb-b79910d75aae" data-name="iq"><ellipse class="ea7927c4-26e5-4a51-8871-91fb1090623f" cx="59.97" cy="58.35" rx="59.97" ry="58.35"></ellipse><g id="c64a0ee1-1f41-494a-8a73-396fafa50d27" data-name="atom"><path class="52ea4671-10bf-4979-884b-08f6ad13f2db" d="M46.13,49.56a5.12,5.12,0,1,0,1.57-7.08A5.12,5.12,0,0,0,46.13,49.56Z"></path><path id="c4" data-name="c4" class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M22.35,63.83c-5-7.76,3.2-21.5,18.56-31.29S72.16,21.17,77.1,28.93s-3.21,21.5-18.56,31.28S27.29,71.58,22.35,63.83Zm3.13-2C28.77,67,42,66.33,56.55,57.08S77.27,36.09,74,30.92,57.41,26.43,42.9,35.67,22.18,56.66,25.48,61.83Z"></path><path id="c3" data-name="c3" class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M35.89,55.19C26.11,39.84,24.52,24,32.28,19s21.49,3.21,31.28,18.56,11.37,31.25,3.61,36.19S45.68,70.55,35.89,55.19Zm3.13-2c9.25,14.5,21,20.72,26.16,17.43s4.49-16.57-4.75-31.08-21-20.72-26.16-17.42S29.78,38.7,39,53.2Z"></path><path id="c2" data-name="c2" class="428ee4a8-30b0-414c-bb65-d1f885636717" d="M46.38,61.49C29.11,57.66,17.06,48,18.93,39.56a9.74,9.74,0,0,1,4.64-6c6.31-4,17.62-4.89,29.5-2.25C70.34,35.09,82.39,44.72,80.52,53.2a9.7,9.7,0,0,1-4.64,6C69.57,63.26,58.26,64.12,46.38,61.49ZM20.74,40c-.75,3.42,1.45,7.35,6.2,11,4.94,3.85,12,6.93,19.84,8.67,11.25,2.49,22.28,1.7,28.1-2a8,8,0,0,0,3.83-4.87c.75-3.43-1.45-7.36-6.2-11-4.94-3.86-12-6.93-19.84-8.67-11.25-2.49-22.28-1.7-28.1,2A8,8,0,0,0,20.74,40Z"></path><path id="c1" data-name="c1" class="428ee4a8-30b0-414c-bb65-d1f885636717" d="M42.91,77.17C34.43,75.29,30.79,60.3,34.61,43c2.64-11.88,8.19-21.77,14.51-25.79a9.69,9.69,0,0,1,7.42-1.65c8.48,1.87,12.12,16.87,8.3,34.13-2.64,11.89-8.19,21.77-14.51,25.8A9.69,9.69,0,0,1,42.91,77.17ZM36.42,43.43C34.69,51.28,34.5,59,35.9,65.08c1.35,5.87,4,9.52,7.41,10.28a8,8,0,0,0,6-1.41C55.16,70.24,60.53,60.57,63,49.32c1.73-7.85,1.92-15.53.52-21.64-1.35-5.87-4-9.52-7.41-10.28a7.92,7.92,0,0,0-6,1.4C44.29,22.52,38.92,32.18,36.42,43.43Z"></path></g><g id="cal" data-name="cal"><path class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M71.68,63.18H94.45A2.83,2.83,0,0,1,97.27,66V94.65a2.82,2.82,0,0,1-2.82,2.82H71.68a2.83,2.83,0,0,1-2.83-2.83V66A2.82,2.82,0,0,1,71.68,63.18Z"></path><path class="41de24ea-9b3c-40a9-97ae-73f0ac741c62" d="M72.76,67.39h20.6a1.18,1.18,0,0,1,1.18,1.18v4.5a1.17,1.17,0,0,1-1.17,1.17H72.76a1.17,1.17,0,0,1-1.17-1.17V68.57A1.17,1.17,0,0,1,72.76,67.39Z"></path><path class="calbtn" d="M73,77.56h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H73a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,73,77.56Z"></path><path class="calbtn" d="M78.74,77.56h2.88a.78.78,0,0,1,.78.78v2.89a.79.79,0,0,1-.79.79H78.74a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,78.74,77.56Z"></path><path class="calbtn" d="M84.51,77.56h2.88a.79.79,0,0,1,.79.79v2.88a.79.79,0,0,1-.79.79H84.51a.79.79,0,0,1-.79-.79V78.34A.78.78,0,0,1,84.51,77.56Z"></path><path class="calbtn" d="M90.28,77.56h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H90.28a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,90.28,77.56Z"></path><path class="calbtn" d="M73,83h2.88a.78.78,0,0,1,.78.78v2.89a.78.78,0,0,1-.78.78H73a.78.78,0,0,1-.78-.78V83.76A.79.79,0,0,1,73,83Z"></path><path class="calbtn" d="M78.74,83h2.88a.78.78,0,0,1,.78.78v2.89a.78.78,0,0,1-.78.78H78.74a.78.78,0,0,1-.78-.78V83.76A.79.79,0,0,1,78.74,83Z"></path><path class="calbtn" d="M84.51,83h2.88a.79.79,0,0,1,.79.79v2.88a.78.78,0,0,1-.78.78H84.51a.79.79,0,0,1-.79-.79V83.76A.79.79,0,0,1,84.51,83Z"></path><path class="calbtn" d="M73,88.39h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H73a.78.78,0,0,1-.78-.78V89.17A.78.78,0,0,1,73,88.39Z"></path><path class="calbtn" d="M78.74,88.39h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H78.74a.78.78,0,0,1-.78-.78V89.17A.78.78,0,0,1,78.74,88.39Z"></path><path class="calbtn" d="M84.51,88.39h2.88a.79.79,0,0,1,.79.79v2.88a.79.79,0,0,1-.79.79H84.51a.79.79,0,0,1-.79-.79V89.17A.78.78,0,0,1,84.51,88.39Z"></path><path class="4b7c23d9-1cf6-4e21-9d40-c4c726c687ba" d="M90.28,83.09h2.88a.78.78,0,0,1,.78.78v8.18a.78.78,0,0,1-.78.78H90.28a.79.79,0,0,1-.79-.79V83.88A.78.78,0,0,1,90.28,83.09Z"></path></g></g></g></g>
                    </svg>
                </a>
                @endforeach
                @endif
            </div>
            @if($paidPackage != null)
                <h2 class="text-center" style=" font-size: 30px; margin-bottom: 25px;">Your paid curriculum:</h2>
            @endif
            <div class="bot text-center">
                @if($paidPackage != null)
                @foreach($paidPackage as $key => $curriculum)
                <a class="test-item brain" href="/{{$curriculum->topic->name}}" data-topic="{{$curriculum->topic_id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 119.93 116.7"><defs><style>.ea7927c4-26e5-4a51-8871-91fb1090623f{fill:#ae87be;}.\\35 2ea4671-10bf-4979-884b-08f6ad13f2db{fill:#f05c42;}.fc5a0db9-2687-41c3-a28e-80996c513432{fill:#102f41;}.\\34 28ee4a8-30b0-414c-bb65-d1f885636717{fill:#ffaf42;}.\\34 1de24ea-9b3c-40a9-97ae-73f0ac741c62{fill:#f1e4c4;}.calbtn{fill:#faaf3d;}.\\34 b7c23d9-1cf6-4e21-9d40-c4c726c687ba{fill:#ed6245;}</style></defs><title>iq</title><g id="d2005e62-e63c-4ca3-a37f-4bba6d4ce9c6" data-name="Layer 2"><g id="3770d6ff-e05d-4b80-8ebd-a41431f8007a" data-name="Layer 1"><g id="113a161e-8ddf-4d88-a1eb-b79910d75aae" data-name="iq"><ellipse class="ea7927c4-26e5-4a51-8871-91fb1090623f" cx="59.97" cy="58.35" rx="59.97" ry="58.35"></ellipse><g id="c64a0ee1-1f41-494a-8a73-396fafa50d27" data-name="atom"><path class="52ea4671-10bf-4979-884b-08f6ad13f2db" d="M46.13,49.56a5.12,5.12,0,1,0,1.57-7.08A5.12,5.12,0,0,0,46.13,49.56Z"></path><path id="c4" data-name="c4" class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M22.35,63.83c-5-7.76,3.2-21.5,18.56-31.29S72.16,21.17,77.1,28.93s-3.21,21.5-18.56,31.28S27.29,71.58,22.35,63.83Zm3.13-2C28.77,67,42,66.33,56.55,57.08S77.27,36.09,74,30.92,57.41,26.43,42.9,35.67,22.18,56.66,25.48,61.83Z"></path><path id="c3" data-name="c3" class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M35.89,55.19C26.11,39.84,24.52,24,32.28,19s21.49,3.21,31.28,18.56,11.37,31.25,3.61,36.19S45.68,70.55,35.89,55.19Zm3.13-2c9.25,14.5,21,20.72,26.16,17.43s4.49-16.57-4.75-31.08-21-20.72-26.16-17.42S29.78,38.7,39,53.2Z"></path><path id="c2" data-name="c2" class="428ee4a8-30b0-414c-bb65-d1f885636717" d="M46.38,61.49C29.11,57.66,17.06,48,18.93,39.56a9.74,9.74,0,0,1,4.64-6c6.31-4,17.62-4.89,29.5-2.25C70.34,35.09,82.39,44.72,80.52,53.2a9.7,9.7,0,0,1-4.64,6C69.57,63.26,58.26,64.12,46.38,61.49ZM20.74,40c-.75,3.42,1.45,7.35,6.2,11,4.94,3.85,12,6.93,19.84,8.67,11.25,2.49,22.28,1.7,28.1-2a8,8,0,0,0,3.83-4.87c.75-3.43-1.45-7.36-6.2-11-4.94-3.86-12-6.93-19.84-8.67-11.25-2.49-22.28-1.7-28.1,2A8,8,0,0,0,20.74,40Z"></path><path id="c1" data-name="c1" class="428ee4a8-30b0-414c-bb65-d1f885636717" d="M42.91,77.17C34.43,75.29,30.79,60.3,34.61,43c2.64-11.88,8.19-21.77,14.51-25.79a9.69,9.69,0,0,1,7.42-1.65c8.48,1.87,12.12,16.87,8.3,34.13-2.64,11.89-8.19,21.77-14.51,25.8A9.69,9.69,0,0,1,42.91,77.17ZM36.42,43.43C34.69,51.28,34.5,59,35.9,65.08c1.35,5.87,4,9.52,7.41,10.28a8,8,0,0,0,6-1.41C55.16,70.24,60.53,60.57,63,49.32c1.73-7.85,1.92-15.53.52-21.64-1.35-5.87-4-9.52-7.41-10.28a7.92,7.92,0,0,0-6,1.4C44.29,22.52,38.92,32.18,36.42,43.43Z"></path></g><g id="cal" data-name="cal"><path class="fc5a0db9-2687-41c3-a28e-80996c513432" d="M71.68,63.18H94.45A2.83,2.83,0,0,1,97.27,66V94.65a2.82,2.82,0,0,1-2.82,2.82H71.68a2.83,2.83,0,0,1-2.83-2.83V66A2.82,2.82,0,0,1,71.68,63.18Z"></path><path class="41de24ea-9b3c-40a9-97ae-73f0ac741c62" d="M72.76,67.39h20.6a1.18,1.18,0,0,1,1.18,1.18v4.5a1.17,1.17,0,0,1-1.17,1.17H72.76a1.17,1.17,0,0,1-1.17-1.17V68.57A1.17,1.17,0,0,1,72.76,67.39Z"></path><path class="calbtn" d="M73,77.56h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H73a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,73,77.56Z"></path><path class="calbtn" d="M78.74,77.56h2.88a.78.78,0,0,1,.78.78v2.89a.79.79,0,0,1-.79.79H78.74a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,78.74,77.56Z"></path><path class="calbtn" d="M84.51,77.56h2.88a.79.79,0,0,1,.79.79v2.88a.79.79,0,0,1-.79.79H84.51a.79.79,0,0,1-.79-.79V78.34A.78.78,0,0,1,84.51,77.56Z"></path><path class="calbtn" d="M90.28,77.56h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H90.28a.78.78,0,0,1-.78-.78V78.34A.78.78,0,0,1,90.28,77.56Z"></path><path class="calbtn" d="M73,83h2.88a.78.78,0,0,1,.78.78v2.89a.78.78,0,0,1-.78.78H73a.78.78,0,0,1-.78-.78V83.76A.79.79,0,0,1,73,83Z"></path><path class="calbtn" d="M78.74,83h2.88a.78.78,0,0,1,.78.78v2.89a.78.78,0,0,1-.78.78H78.74a.78.78,0,0,1-.78-.78V83.76A.79.79,0,0,1,78.74,83Z"></path><path class="calbtn" d="M84.51,83h2.88a.79.79,0,0,1,.79.79v2.88a.78.78,0,0,1-.78.78H84.51a.79.79,0,0,1-.79-.79V83.76A.79.79,0,0,1,84.51,83Z"></path><path class="calbtn" d="M73,88.39h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H73a.78.78,0,0,1-.78-.78V89.17A.78.78,0,0,1,73,88.39Z"></path><path class="calbtn" d="M78.74,88.39h2.88a.78.78,0,0,1,.78.78v2.88a.79.79,0,0,1-.79.79H78.74a.78.78,0,0,1-.78-.78V89.17A.78.78,0,0,1,78.74,88.39Z"></path><path class="calbtn" d="M84.51,88.39h2.88a.79.79,0,0,1,.79.79v2.88a.79.79,0,0,1-.79.79H84.51a.79.79,0,0,1-.79-.79V89.17A.78.78,0,0,1,84.51,88.39Z"></path><path class="4b7c23d9-1cf6-4e21-9d40-c4c726c687ba" d="M90.28,83.09h2.88a.78.78,0,0,1,.78.78v8.18a.78.78,0,0,1-.78.78H90.28a.79.79,0,0,1-.79-.79V83.88A.78.78,0,0,1,90.28,83.09Z"></path></g></g></g></g>
                    </svg>
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
    <img id="island" src="{{asset('./Catopiana_files/images/island.png')}}" alt="">
</section>
<section class="psy-section" id="id3">
    <div class="container-fluid">
        <div class="row"></div>
    </div>
</section>
<section id="for-parent">
    <div class="container">
        <div class="for-parent-title">
            {{--            <img src="{{asset('./Catopiana_files/images/for-parent.png')}}" alt="">--}}
        </div>
        <div class="for-parent-content">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error
                veniam consequatur provident laudantium voluptates ad blanditiis
                illo doloremque optio, consectetur veritatis officiis deleniti.
                Magni impedit, totam odio non exercitationem ut!
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed,
                vero aut amet quae inventore fugiat in praesentium natus cumque
                quidem.
            </p>
        </div>
        <!-- utilities -->
        <div class="testnow-tailieu-wr">
            <button class="testnow">Test now</button>
            <button class="tailieu">Tai Lieu</button>
        </div>
        <div class="above-trynow">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ex in
                itaque qui tempore minus ducimus magni, quam et consequatur cum
                sed exercitationem fugit iusto a quasi culpa, enim necessitatibus.
                Molestiae fuga, placeat quasi eum. Corporis, adipisci facilis in
                quod.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Reiciendis, soluta.
            </p>
        </div>
        <div class="trynow-btn-wr">
            <button>Try now</button>
        </div>
        <div class="article-slide-wr">
            <div class="article-slide">
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt="">
                        </a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt=""></a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt=""></a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt=""></a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt=""></a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
                <div class="one-article">
                    <div class="img-slide-wr">
                        <a href="#" onclick="return false;" tabindex="-1"><img id="" src="{{asset('./Catopiana_files/images/Random-Pictures-of-Conceptual-and-Creative-Ideas-02.jpg')}}" alt=""></a>
                    </div>
                    <a href="#" onclick="return false;" tabindex="-1">
                        <p class="slide-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ratione porro quia facere commodi laboriosam eius est
                            obcaecati, incidunt nemo, atque aliquid fugiat delectus,
                            accusantium quas.
                        </p>
                    </a>
                </div>
            </div>
        </div>
        <!-- utilities -->
        <div class="ultilities-wr">
            <div class="ult-slide">
                <div class="one-ult">
                    <div class="img-ult-wr">
                        <img src="{{asset('./Catopiana_files/images/icon3.png')}}" alt="">
                    </div>
                    <div class="ult-content">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="one-ult">
                    <div class="img-ult-wr">
                        <img src="{{asset('./Catopiana_files/images/icon2.png')}}" alt="">
                    </div>
                    <div class="ult-content">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="one-ult">
                    <div class="img-ult-wr">
                        <img src="{{asset('./Catopiana_files/images/icon1.png')}}" alt="">
                    </div>
                    <div class="ult-content">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="one-ult">
                    <div class="img-ult-wr">
                        <img src="{{asset('./Catopiana_files/images/icon2.png')}}" alt="">
                    </div>
                    <div class="ult-content">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="one-ult">
                    <div class="img-ult-wr">
                        <img src="{{asset('./Catopiana_files/images/icon1.png')}}" alt="">
                    </div>
                    <div class="ult-content">
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{asset('/js/svg_variables.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/local-storage.js')}}" ></script>
<script type="text/javascript" src="{{asset('/js/signup.js')}}"></script>
<script>
    // in home side to check free Package
    $(document).ready(function() {
        @if (isset($freePackage) && auth()->guard('customers')->user() !== null && auth()->guard('customers')->user()->test_status == 1 )
            // test_status = 1 la lam xong =2 la lam xong va da nhan thong bao, =0 la chua xong
            Swal.fire({
                title: 'Congratulations!',
                text: "You have received a few free tests!",
                type: 'info',
                confirmButtonText: 'Go!'
            }).then(() => {
                $.ajax({
                    url: '{{ route('update-test-status') }}',
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(response) {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
            });
        @endif
    });
</script>
@endsection