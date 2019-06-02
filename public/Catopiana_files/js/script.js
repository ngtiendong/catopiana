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

			window_width = $(window).width()
			if (window_width < 641){
				$('.article-slide').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false,
				});
				$('.list-test-slide').slick({
					slidesToShow: 4,
					slidesToScroll: 4,
					dots: true,
				});
				$('.ult-slide').slick({
					slidesToShow: 2,
					slidesToScroll: 1,
					dots: true,
				});
				$('.menu-slide').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
				});
			} else{
				$('.article-slide').slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					dots: true,
				});
				$('.ult-slide').slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					dots: true,
				});
				$('.menu-slide').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
				});
			}


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

	


	var tl, tl2;
	$('.test-now').hover(function() {
		tl = new TimelineMax({ repeat: -1, yoyo: true });
		tl.staggerTo('.test-item', 0.3, {scale: 1.3}, 0.1);
	}, function() {
		tl.restart();
		tl.pause();
	});

	tl2 = new TimelineMax({ repeat: -1, yoyo: true });
		tl2.to('#c1', 2, {rotation: 360, transformOrigin:"50% 50%"}, 0.);
	$('.science').hover(function() {
		tl2.play();
	}, function() {
		tl2.restart();
		tl2.pause();
	});

	if (window.width() > 1024) {
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
	}


	// end animation


	// var ii = 0;
	// $('.test-now').click(function() {
		// ii++;
		// if(ii % 2 != 0) {
		// 	TweenMax.to('.list-test .top', 0.3, {css: {'opacity':'1', 'z-index':'1'}}, 0.1);
		// 	TweenMax.to('.list-test .bot', 0.3, {css: {'opacity':'1', 'z-index':'1'}}, 0.1);
		// } else {
		// 	TweenMax.to('.list-test', 0.3, {css: {'opacity':'0', 'z-index':'0'}}, 0.1);
		// }
	// });
});


