
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="author" content="">
    <meta name="description" content="Task">
    <meta name="keywords" content="">
    <link rel="icon" type="image/ico" href="assets/images/favicon.ico">
    <script type="text/javascript" src="{{ asset('ebaohiem/js/preload.min.js') }}"></script>

    <title>Main page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Just+Another+Hand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,300italic,400italic,600italic,700italic,800,800italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('ebaohiem/css/bootstrap-datepicker3.standalone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ebaohiem/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('ebaohiem/css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
<div id="main">
    <div class="layout">
        <div class="layout--header">
            @component('components.header')@endcomponent
        </div>
        <div class="layout--container">
            @yield('content')
        </div>
        <div class=" pop_up_wrap ">
            <div class="pop_up_tabs js-pop_up_tabs">
                <div class="tabs-header">
                    <ul>
                        <li class="active"><a href=".title1">HOUSE INSURANCE</a></li>
                        <li><a href=".title2">CAR INSURANCE</a></li>
                        <li><a href=".title3">TRAVEL INSURANCE</a></li>
                        <li><a href=".title4">LIFE INSURANCE</a></li>
                        <li class="tabs-header-more"><a href="more">MORE +</a>
                            <ul>
                                <li><a href="">INSURANCE 1</a></li>
                                <li><a href="">INSURANCE 2</a></li>
                                <li><a href="">INSURANCE 3</a></li>
                                <li><a href="">INSURANCE 4</a></li>
                                <li><a href="">INSURANCE 5</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="tabs-content">
                    <div class="tabs-item active title1">
                        <div class="tabs-item-img js-bg-img">
                            <img src="assets/images/content/popup/bg1.jpg" alt="">
                        </div>
                        <div class="tabs-item-content">
                            <h2 class="tabs-title">House Insurance <span>Quote</span></h2>
                            <form action="#" class="selector_form">
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">What kind of propriety?</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>
                        </select>
                        </span>
                                </label>
                                <label>
                        <span class="custom-dropdown">
                            <select>
                                <option value="">What type of propriety?</option>
                                <option value="">Variant 1</option>
                                <option value="">Variant 2</option>
                            </select>
                            </span>
                                </label>
                                <label>
                                    <input type="text" placeholder="When the propriety was built?">
                                </label>
                                <label>
                                    <input type="text" placeholder="What is the value of propriety?">
                                </label>
                                <label>
                                    <input type="text" name="fields[name]" placeholder="Your full name" required="required">
                                </label>
                                <label>
                                    <input type="text" placeholder="Phone number" required="required">
                                </label>
                                <label>
                                    <input type="email" name="fields[email]" placeholder="Email" required="required">
                                </label>
                                <label>
                                    <button class="button -green button--mail -medium  ">Request Sent!</button>
                                </label>
                                <input type="hidden" name="fields[code]" value="56345_8safs_">
                            </form>
                            <p class="form-arror">* Sorry, the <i> </i> is not valid.</p>
                            <!-- for ajax contact form -->
                            <div class="ajax-loader"></div>
                            <div class="ajax-result">
                                <div class="success"></div>
                                <div class="error"></div>
                            </div>
                            <!-- end ajax contact form -->
                        </div>
                    </div>
                    <div class="tabs-item title2">
                        <div class="tabs-item-img js-bg-img">
                            <img src="assets/images/content/popup/bg1.jpg" alt="">
                        </div>
                        <div class="tabs-item-content">
                            <h2 class="tabs-title">Car Insurance <span>Quote</span></h2>
                            <form action="#" class="selector_form">
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Car manufacturer?</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>

                        </select>
                        </span>
                                </label>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Your age</option>
                        <option value="">18</option>
                        <option value="">19</option>

                        </select>
                        </span>
                                </label>
                                <label>
                                    <input type="text" placeholder="Car model?">
                                </label>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Car registration year</option>
                        <option value="">18</option>
                        <option value="">19</option>
                        </select>
                        </span>
                                </label>
                                <label>
                                    <input type="text" name="fields[name]" placeholder="Your full name" required="required">
                                </label>
                                <label>
                                    <input type="text" placeholder="Phone number" required="required">
                                </label>
                                <label>
                                    <input type="email" name="fields[email]" placeholder="Email" required="required">
                                </label>
                                <label>
                                    <button class="button -green button--mail -medium  ">Request Sent!</button>
                                </label>
                                <input type="hidden" name="fields[code]" value="56345_8safs_">
                            </form>
                            <p class="form-arror">* Sorry, the <i> </i> is not valid.</p>
                            <!-- for ajax contact form -->
                            <div class="ajax-loader"></div>
                            <div class="ajax-result">
                                <div class="success"></div>
                                <div class="error"></div>
                            </div>
                            <!-- end ajax contact form -->
                        </div>
                    </div>
                    <div class="tabs-item title3">
                        <div class="tabs-item-img js-bg-img">
                            <img src="assets/images/content/popup/bg1.jpg" alt="">
                        </div>
                        <div class="tabs-item-content">
                            <h2 class="tabs-title">Travel Insurance <span>Quote</span></h2>
                            <form action="#" class="selector_form">
                                <div class="label">
                                    <div class="promo_slider_form--label">
                                        <div class="slider-title ">Level of protection
                                            <span class="js-slider-title"></span>
                                        </div>
                                        <div class="js-slider-range"></div>
                                    </div>
                                </div>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">How long?</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>
                         </select>
                        </span>
                                </label>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Destination</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>

                        </select>
                        </span>
                                </label>
                                <label>
                                    <input type="text" id='label19' placeholder="How many people?" required="required">
                                </label>
                                <label>
                                    <input type="text" id='label20' name="fields[name]" placeholder="Your full name" required="required">
                                </label>
                                <label>
                                    <input type="text" id='label21' placeholder="Phone number" required="required">
                                </label>
                                <label>
                                    <input type="email" id='label22' name="fields[email]" placeholder="Email" required="required">
                                </label>
                                <label>
                                    <button class="button -green button--mail -medium  ">Request Sent!</button>
                                </label>
                                <input type="hidden" name="fields[code]" value="56345_8safs_">
                            </form>
                            <p class="form-arror">* Sorry, the <i> </i> is not valid.</p>
                            <!-- for ajax contact form -->
                            <div class="ajax-loader"></div>
                            <div class="ajax-result">
                                <div class="success"></div>
                                <div class="error"></div>
                            </div>
                            <!-- end ajax contact form -->
                        </div>
                    </div>
                    <div class="tabs-item title4">
                        <div class="tabs-item-img js-bg-img">
                            <img src="assets/images/content/popup/bg1.jpg" alt="">
                        </div>
                        <div class="tabs-item-content">
                            <h2 class="tabs-title">Life Insurance <span>Quote</span></h2>
                            <form action="#" class="selector_form">
                                <div class="label text-left">
                                    <div class="promo_slider_form--label">
                                        <div class="slider-title ">Level of protection
                                            <span class="js-slider-title"></span>
                                        </div>
                                        <div class="js-slider-range"></div>
                                    </div>
                                </div>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Your age?</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>

                        </select>
                        </span>
                                </label>
                                <label class="text-left">Do you take any drugs?
                                    <input type="checkbox"><span class="checkbox-decor"></span></label>
                                <label>
                            <span class="custom-dropdown">
                        <select  >
                        <option value="">Type of insurance</option>
                        <option value="">Variant 1</option>
                        <option value="">Variant 2</option>


                        </select>
                        </span>
                                </label>
                                <label>
                                    <input type="text" placeholder="Your full name" name="fields[name]" required="required">
                                </label>
                                <label>
                                    <input type="text" placeholder="Phone number" required="required">
                                </label>
                                <label>
                                    <input type="email" placeholder="Email" name="fields[email]" required="required">
                                </label>
                                <label>
                                    <button class="button -green button--mail -medium  ">Request Sent!</button>
                                </label>
                                <input type="hidden" name="fields[code]" value="56345_8safs_">
                            </form>
                            <p class="form-arror">* Sorry, the <i> </i> is not valid.</p>
                            <!-- for ajax contact form -->
                            <div class="ajax-loader"></div>
                            <div class="ajax-result">
                                <div class="success"></div>
                                <div class="error"></div>
                            </div>
                            <!-- end ajax contact form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout--footer">
            <footer class="footer">
                <div class="footer--bg"></div>
                <div class="footer--inner">
                    <div class="container">
                        <div class="footer_main">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12">
                                    <div class="footer_main--column">
                                        <strong class="footer_main--column_title">About Us</strong>
                                        <div class="footer_about">
                                            <p class="footer_about--text">
                                                From logo design to video animation, web development to website copy; expert designers, developers and digital talent are ready to complete projects.
                                            </p>
                                            <p class="footer_about--text">
                                                Learn creative and technical skills with Envato free tutorials. Try it for free only this weekend.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12">
                                    <div class="footer_main--column">
                                        <strong class="footer_main--column_title">Latest Blog Posts</strong>
                                        <ul class="footer_navigation">
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Start your own agency</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">How to cool down quickly</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Make something awesome</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Plan your summer vacation</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">There is sunlight to enjoy</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix visible-sm-block"></div>
                                <div class="col-lg-3 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12">
                                    <div class="footer_main--column">
                                        <strong class="footer_main--column_title">Our Projects</strong>
                                        <ul class="footer_navigation">
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Go get an ice-cream</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Become the best version</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Eat, sleep and have fun</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Start the journey to the top</a></li>
                                            <li class="footer_navigation--item"><a href="#" class="footer_navigation--link">Can you do this for us?</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12">
                                    <div class="footer_main--column">
                                        <strong class="footer_main--column_title">Contact Info</strong>
                                        <ul class="footer_contact_info">
                                            <li class="footer_contact_info--item"><i class="bi_com-phone"></i><span>Call Us  0 (855) 233-5385</span></li>
                                            <li class="footer_contact_info--item"><i class="bi_com-email"></i><span>info@insuranced.com</span></li>
                                            <li class="footer_contact_info--item"><i class="bi_location-alt-pin"></i><span>425 1st Street, San Francisco, California, USA</span></li>
                                            <li class="footer_contact_info--item"><i class="bi_time-clock-a"></i><span>Monday - Friday, 9am - 6 pm; Sunday closed</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer_copyrights">
                            <div class="footer_copyrights--container">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="footer_copyrights--item">
                                            <div class="footer_copyrights--logo">
                                                <a href="main.html"><img src="./assets/images/design/logo-footer.png" alt="" /></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="footer_copyrights--item">
                                            <p class="footer_copyrights--item_copyrights">Insuranced Theme ©2017. All Rights Reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
</div>
<div id="mobile_sidebar" class="mobile_sidebar">
    <div class="mobile_sidebar--closer -white">
        <button class="c-hamburger c-hamburger--htx is-active"><span>toggle menu</span></button>
    </div>
    <div class="mobile_menu">
        <ul class="menu">
            <li class="menu-item

                current-menu-item

    ">
                <a href="#">Home</a>
                <ul class="sub-menu">
                    <li class="menu-item"><a href="main.html">Home 1</a></li>
                    <li class="menu-item"><a href="main-2.html">Home 2</a></li>
                    <li class="menu-item"><a href="main-3.html">Home 3</a></li>
                </ul>
            </li>
            <li class="menu-item

    ">
                <a href="about_us.html">About</a>
            </li>
            <li class="menu-item  ">
                <a href="#">Services</a>
                <ul class="sub-menu">
                    <li class="menu-item"><a href="services.html">Services</a></li>
                    <li class="menu-item"><a href="service_opened.html">Service opened</a></li>
                    <li class="menu-item"><a href="quote.html">Quote</a></li>
                </ul>
            </li>
            <li class="menu-item

    ">
                <a href="#">Case Study</a>
                <ul class="sub-menu">
                    <li class="menu-item"><a href="#">Page 1</a></li>
                    <li class="menu-item"><a href="#">Page 2</a></li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Page 3</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="#">Page 1</a></li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#">Page 2</a>
                                <ul class="sub-menu">
                                    <li class="menu-item"><a href="#">Page 1</a></li>
                                    <li class="menu-item"><a href="#">Page 2</a></li>
                                    <li class="menu-item"><a href="#">Page 4</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="menu-item

    ">
                <a href="#">News</a>
                <ul class="sub-menu">
                    <li class="menu-item"><a href="blog.html">Blog</a></li>
                    <li class="menu-item"><a href="post.html">Post</a></li>
                </ul>
            </li>
            <li class="menu-item      ">
                <a href="careers.html">Careers    </a>
            </li>
            <li class="menu-item  "><a href="contact_us.html">Contact</a></li>
        </ul>
    </div>
    <!-- select language-->
    <div class="select_language -mobile_sidebar">
        <button type="button" class="select_language--opener"><i class="select_language--opener_icon icons8-globe-earth"></i>Language</button>
        <ul class="select_language--list">
            <li><a href="#">English</a></li>
            <li><a href="#">Espanol</a></li>
        </ul>
    </div>
    <!-- /select language-->
    <!-- topbar_contacts-->
    <ul class="topbar_contacts -mobile_sidebar">
        <li class="topbar_contacts--item"><span class="contact_phone"><i class="icons8-phone"></i>0 (855) 233-5385</span></li>
        <li class="topbar_contacts--item"><span class="contact_email"><i class="icons8-message"></i><a href="#">info@financed.com</a></span></li>
        <li class="topbar_contacts--item"><a href="services.html" class="button -arrowed -waikawa_green  -menu_size"><span class="button--inner">Browse Services</span></a></li>
    </ul>
    <!-- /topbar_contacts-->
    <!-- follow us-->
    <div class="follow_us -mobile_sidebar">
        <strong>Follow us</strong>
        <ul>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
            <li><a href="#"><i class="fa fa-rss"></i></a></li>
        </ul>
    </div>
    <!-- /follow us-->

</div>

<script src="{{ asset('ebaohiem/js/jquery.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/typed.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/headhesive.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/slideout.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('ebaohiem/css/magnific-popup.css') }}">
<script src="{{ asset('ebaohiem/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/jquery.youtubebackground.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/social-buttons.js') }}"></script>
<script src="{{ asset('ebaohiem/js/social-buttons.js') }}"></script>
<link rel="stylesheet" href="{{ asset('ebaohiem/css/social-buttons.css') }}">
<script src="{{ asset('ebaohiem/js/jquery.mixitup.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/isMobile.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/isInViewport.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/progressbar.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/select2.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDer3Uk9C3fR2sQ2xwiTw6wK9VTRDtzYhc" type="text/javascript"></script>
<script src="{{ asset('ebaohiem/js/tabby.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('ebaohiem/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('ebaohiem/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('ebaohiem/js/slick.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/nouislider.min.js') }}"></script>
<script src="{{ asset('ebaohiem/js/nouislider.js') }}"></script>
<script src="{{ asset('ebaohiem/js/bootstrap-datepicker.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('ebaohiem/css/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('ebaohiem/css/slick.css') }}">
<script src="{{ asset('ebaohiem/js/main.js') }}"></script>
@yield('scripts')
</body>

</html>