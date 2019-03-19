(function() {
	var $;
	$ = this.jQuery || window.jQuery;
	win = $(window), body = $('body'), doc = $(document);

	$.fn.hc_menu = function(options) {
		var settings = $.extend({
	        open: '.open-mnav',
	    }, options ), this_ = $(this);
	    var m_nav = $('<div class="m-nav"><button class="m-nav-close">&times;</button><div class="nav-ct"></div></div>');
	    body.append(m_nav);

		m_nav.find('.m-nav-close').click(function(e) {
			e.preventDefault();
			mnav_close();
		});

		m_nav.find('.nav-ct').append(this_.children().clone());

		var mnav_open = function(){
			m_nav.addClass('active');
			body.append('<div class="m-nav-over"></div>').css('overflow', 'hidden');
		}
		var mnav_close = function(){
			m_nav.removeClass('active');
			body.children('.m-nav-over').remove();
			body.css('overflow', '');
		}

		doc.on('click', settings.open, function(e) {
	    	e.preventDefault();
	    	if(win.width() <=991) mnav_open();
	    }).on('click', '.m-nav-over', function(e) {
			e.preventDefault();
			mnav_close();
		});
	}
}).call(this);


jQuery(function($) {
	var win = $(window), body = $('body'), doc = $(document);

	var UI = {
		header: function(){
			var elm = $('header'), h = elm.innerHeight(), offset = 100, mOffset = 0;
			var fixed = function(){
				elm.addClass('fixed');
			}
			var unfixed = function(){
				elm.removeClass('fixed');
			}
			var Mfixed = function(){
				elm.addClass('m-fixed');
			}
			var unMfixed = function(){
				elm.removeClass('m-fixed');
			}
			if(win.width()>991){
				win.scrollTop()> offset ? fixed() : unfixed();
			}
			else{
				win.scrollTop()> mOffset ? Mfixed() : unMfixed();
			}
			win.scroll(function(e) {
				if(win.width()>991){
					win.scrollTop()> offset ? fixed() : unfixed();
				}
				else{
					win.scrollTop()> mOffset ? Mfixed() : unMfixed();
				}
			});
		},
		slider: function(){
			$('.ult-slide').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				dots: true,
			});
			$('.article-slide').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				dots: true,
			});
		},
		psy: function(){
			var btn = '.psy-btn', sec = $('.psy-section'), pane = '.psy-pane';
			doc.on('click', btn, function(e) {
				e.preventDefault();
				$(this).closest(pane).find(btn).removeClass('active');
				$(this).addClass('active');
				$("html, body").animate({ scrollTop: $($(this).attr('href')).offset().top - 40 }, 600 );
			});

			var section_act = function(){
				sec.each(function(index, el) {
	                if(win.scrollTop() + (win.height()/2) >= $(el).offset().top){
	                    var id = $(el).attr('id');
	                    $(pane).find(btn).removeClass('active');
	                    $(pane).find(btn+'[href="#'+id+'"]').addClass('active');
	                }
	            });
	        }
	        section_act();
	        win.scroll(function(){
	            section_act();
	        });
		},

		init: function(){
			UI.header();
			UI.slider();
			UI.psy();
		},
	}

	UI.init();

	// animation 
	tn = new TimelineMax({ repeat: -1, yoyo: true });
	tn.fromTo('.test-now', 4, {skewY:"-1deg", transformOrigin:"50% 50%", x:-20, ease:Power0.easeNone}, {skewY:"1deg", transformOrigin:"50% 50%", x:20, ease:Power0.easeNone}, 0.1)
	wave = new TimelineMax({ repeat: -1, yoyo: false });
	wave.fromTo('.bg', 40, {css:{'background-position':'0'}, ease:Power0.easeNone}, {css:{'background-position':'100%'}, ease:Power0.easeNone}, 0.1)
	girl = new TimelineMax({ repeat: -1, yoyo: true });
	girl.fromTo('.girl', 2, {rotation:-10, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:10, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.1)
	boy = new TimelineMax({ repeat: -1, yoyo: true });
	boy.fromTo('.boy', 1.37, {rotation:-10, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:10, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.33)

	// fish
	f1 = new TimelineMax({ repeat: -1, yoyo: false });
	f1.fromTo('.f1', 100, {css:{'left':'100%'}}, {css:{'left':'-300px'}}, 0)
	f11 = new TimelineMax({ repeat: -1, yoyo: true });
	f11.fromTo('.f1', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f3 = new TimelineMax({ repeat: -1, yoyo: false });
	f3.fromTo('.f3', 80, {css:{'left':'-200px'}}, {css:{'left':'100%'}}, 0)
	f31 = new TimelineMax({ repeat: -1, yoyo: true });
	f31.fromTo('.f3', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f4 = new TimelineMax({ repeat: -1, yoyo: false });
	f4.fromTo('.f4', 50, {css:{'left':'-200px'}}, {css:{'left':'100%'}}, 0)
	f41 = new TimelineMax({ repeat: -1, yoyo: true });
	f41.fromTo('.f4', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f5 = new TimelineMax({ repeat: -1, yoyo: false });
	f5.fromTo('.f5', 40, {css:{'left':'100%'}}, {css:{'left':'-200px'}}, 0)
	f51 = new TimelineMax({ repeat: -1, yoyo: true });
	f51.fromTo('.f5', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f6 = new TimelineMax({ repeat: -1, yoyo: false });
	f6.fromTo('.f6', 40, {css:{'left':'100%'}}, {css:{'left':'-200px'}}, 0)
	f61 = new TimelineMax({ repeat: -1, yoyo: true });
	f61.fromTo('.f6' , 1, {skewY:"-3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f7 = new TimelineMax({ repeat: -1, yoyo: false });
	f7.fromTo('.f7', 80, {css:{'left':'-200px'}}, {css:{'left':'100%'}}, 0)
	f71 = new TimelineMax({ repeat: -1, yoyo: true });
	f71.fromTo('.f7', 1, {skewY:"-12deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"-15deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	// submarine
	s1 = new TimelineMax({ repeat: -1, yoyo: true });
	s1.fromTo('#sub1', 3, {rotation:-5, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:5, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.1)

	s2 = new TimelineMax({ repeat: -1, yoyo: false });
	s2.fromTo('#sub2', 50, {css:{'left':'200%'}}, {css:{'left':'-200%'}}, 0)
	s21 = new TimelineMax({ repeat: -1, yoyo: true });
	s21.fromTo('#sub2', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	s3 = new TimelineMax({ repeat: -1, yoyo: false });
	s3.fromTo('#sub3', 60, {css:{'left':'200%'}}, {css:{'left':'-200%'}}, 2)
	s31 = new TimelineMax({ repeat: -1, yoyo: true });
	s31.fromTo('#sub3', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	// island
	island = new TimelineMax({ repeat: -1, yoyo: true });
	island.fromTo('#island', 2, {y:-15, ease:Power0.easeNone}, {y:15, ease:Power0.easeNone}, 0.1)

	// bubble
	b1 = new TimelineMax({ repeat: -1 });
	b1.from('.b1', 0.5, {y:150, opacity: 0}, 0.1)
		.to('.b1', 4, {y:0, opacity: 1}, 0.1)
	b2 = new TimelineMax({ repeat: -1 });
	b2.from('.b2', 0.5, {y:150, opacity: 0}, 0.1)
		.to('.b2', 2.5, {y:0, opacity: 1}, 0.1)
	b3 = new TimelineMax({ repeat: -1 });
	b3.from('.b3', 0.5, {y:150, opacity: 0}, 0.3)
		.to('.b3', 3, {y:0, opacity: 1}, 0.3)
	b4 = new TimelineMax({ repeat: -1 });
	b4.from('.b4', 0.5, {y:150, opacity: 0}, 1)
		.to('.b4', 5, {y:-50, opacity: 1}, 1)
		

	var tl, tl2;
	// $('.test-now').hover(function() {
	// 	tl = new TimelineMax({ repeat: -1, yoyo: true });
	// 	tl.staggerTo('.test-item', 0.3, {scale: 1.3}, 0.1);
	// }, function() {
	// 	tl.restart();
	// 	tl.pause();
	// });
	//
	// tl2 = new TimelineMax({ repeat: -1, yoyo: true });
	// 	tl2.to('#c1', 2, {rotation: 360, transformOrigin:"50% 50%"}, 0.1);
	// $('.science').hover(function() {
	// 	tl2.play();
	// }, function() {
	// 	tl2.restart();
	// 	tl2.pause();
	// });

	$($('.test-item')).hover(function() {
		tlgt = new TimelineMax();
		tlgt.to($(this), 0.05, {scale: 1.3}, 0.1);
		tlgt1 = new TimelineMax({ repeat: -1, yoyo: true });
		tlgt1.fromTo($(this), 0.05, {rotation:-10, transformOrigin:"50% 50%"}, {rotation:10, transformOrigin:"50% 50%"}, 0.1);
	}, function() {
		tlgt.restart();
		tlgt.pause();
		tlgt1.restart();
		tlgt1.pause();
	});

	// end animation

	
	var ii = 0;
	$('.test-now').click(function() {
		ii++;
		// if(ii % 2 != 0) {
		// 	TweenMax.to('.list-test .top', 0.3, {css: {'opacity':'1', 'z-index':'1'}}, 0.1);
		// 	TweenMax.to('.list-test .bot', 0.3, {css: {'opacity':'1', 'z-index':'1'}}, 0.1);
		// } else {
		// 	TweenMax.to('.list-test', 0.3, {css: {'opacity':'0', 'z-index':'0'}}, 0.1);
		// }
	});
	if(!localStorage.getItem('IQ')) {
		console.log('not login yet');
	} else {
		console.log('logged in')
	}

	$('.startBtn').click(function(){
		$(this).css('opacity','0').css('z-index','-1');
		setTimeout(function(){
			$('#testForm').css('display','block').css('opacity','1')
		}, 700)
	});

	// $(document).on('click', '.submitName', function(){
	// 	var uname = "",
	// 		upass = "";

	// 	var possibleName = "0123456789";
	// 	var possiblePass = "AaBbCcDdEeFfJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789"
		
	// 	for (var i = 0; i < 5; i++) {
	// 		uname += possibleName.charAt(Math.floor(Math.random() * possibleName.length));
	// 		upass += possiblePass.charAt(Math.floor(Math.random() * possiblePass.length));
	// 	}
	// 	uname = $('.regName').val().toLowerCase() + uname;
	// 	console.log(uname);
	// 	$(".testOverlay").append(
	// 						'<div class="popupResult">'
	// 						+    '<p>Howdie ' + $('.regName').val() + '!</p>'
	// 						+    '<p>Your score: ' + checkNumTrue(ca_arr, ra) + '/'+ x.length +'</p>'
	// 						+    '<p class="small">Please write down your account below:</p>'
	// 						+	 '<p class="small">Username: '+ uname + '</p>'
	// 						+	 '<p class="small">Password: '+ upass + '</p>'
	// 						+ '</div>'
	// 					);
	// 	localStorage.setItem('username',uname);
	// });

	$('.sign').click(function(){
		$('body').toggleClass('overlay');
		$($(this).children('a').attr('href')).toggleClass('active');
	});
	$('.signWindow a').click(function() {
		$(".signWindow").removeClass('active');
		$('body').removeClass('overlay');
	});

// 	$(document).on('click', '#submitReg', function() {
// 		localStorage.setItem('username', $('.uname').val());
// 		var data = {
// 			"title": $('.uname').val(),
// 			"uname": $('.uactualname').val(),
// 			"username": $('.uname').val(),
// 			"userpass": $('.upass').val(),
// 			"email": $('.uemail').val()
// 		};
// // 		var url = "http://localhost/cat/create-user.php";
// 		var url = "http://catopiana.com/create-user.php";
	
// 		$.post(url, data, function (json) {});
// 	});
})
