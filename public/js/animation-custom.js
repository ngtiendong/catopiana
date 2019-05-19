	// animation
	tn = new TimelineMax({ repeat: -1, yoyo: true });
	tn.fromTo('.test-now', 4, {skewY:"-1deg", transformOrigin:"50% 50%", x:-20, ease:Power0.easeNone}, {skewY:"1deg", transformOrigin:"50% 50%", x:20, ease:Power0.easeNone}, 0.1)
	wave = new TimelineMax({ repeat: -1, yoyo: false });
	wave.fromTo('.bg', 40, {css:{'background-position':'0'}, ease:Power0.easeNone}, {css:{'background-position':'100%'}, ease:Power0.easeNone}, 0.1)
	girl = new TimelineMax({ repeat: -1, yoyo: true });
	girl.fromTo('.girl', 2, {rotation:-10, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:10, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.1)
	boy = new TimelineMax({ repeat: -1, yoyo: true });
	boy.fromTo('.boy, .boy_result', 1.37, {rotation:-10, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:10, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.33)


	//whale
	whale1 = new TimelineMax({ repeat: -1 });
	whale1.from('.whale1', 40, {css:{'right':'100%', 'bottom':'40%'}}, 0.1)
		.to('.whale1',30, {css:{'right':'-300px', 'bottom':'20%'}}, 0.1)
	whale11 = new TimelineMax({ repeat: -1, yoyo: true });
	whale11.fromTo('.whale1', 1, {transformOrigin:"50% 50%", ease: SlowMo.ease.config(0.7, 0.7, false)}, {transformOrigin:"40% 60%", ease: SlowMo.ease.config(0.7, 0.7, false)}, 0)
	// fish
	f1 = new TimelineMax({ repeat: -1, yoyo: false });
	f1.fromTo('.f1', 100, {css:{'left':'100%'}}, {css:{'left':'-300px'}}, 0)
	f11 = new TimelineMax({ repeat: -1, yoyo: true });
	f11.fromTo('.f1', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f3 = new TimelineMax({ repeat: -1, yoyo: false });
	f3.fromTo('.f3', 80, {css:{'left':'-200px'}}, {css:{'left':'100%'}}, 0)
	f31 = new TimelineMax({ repeat: -1, yoyo: true });
	f31.fromTo('.f3 ', 0.5, {skewY:"-7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f0 = new TimelineMax({ repeat: -1, yoyo: false });
	f0.to('.many-fish1, .many-fish3 ', 40, {css:{'left':'-200px'}}, 0).to('.many-fish2', 35, {css:{'left':'-200px'}}, 0).to('.many-fish4', 37, {css:{'left':'-200px'}}, 0.1)
	f01 = new TimelineMax({ repeat: -1, yoyo: true });
	f01.fromTo('.many-fish1, .many-fish2, .many-fish3, .many-fish4', 1, {skewY:"0deg", transformOrigin:"45% 55%", ease:Power0.easeNone}, {skewY:"-6deg", transformOrigin:"55% 45%", ease:Power0.easeNone}, 0)

	f_1 = new TimelineMax({ repeat: -1, yoyo: false });
	f_1.to('.f1-result2, .f1-result1', 40, {css:{'right':'-100px'}}, 0)
	f_11 = new TimelineMax({ repeat: -1, yoyo: true });
	f_11.fromTo('.f1-result2, .f1-result1', 1, {skewY:"0deg", transformOrigin:"45% 55%", ease:Power0.easeNone}, {skewY:"-6deg", transformOrigin:"55% 45%", ease:Power0.easeNone}, 0)
	
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
	// new bubble
	b5 = new TimelineMax({ repeat: -1 });
	b5.from('.b5', 6, {y:200, x: 10, opacity: 0}, 0.5)
		.to('.b5', 4, {y:-500, opacity: 1}, 0.1)

	b6 = new TimelineMax({ repeat: -1 });
	b6.from('.b6', 6, {y:300, opacity: 0}, .6)
		.to('.b6', 7, {y:-600, opacity: 1}, 0.3)

	b7 = new TimelineMax({ repeat: -1 });
	b7.from('.b7', 6, {y:300, opacity: 0}, 1)
		.to('.b7', 8, {y:-700, opacity: 1}, 0.2)

	b8 = new TimelineMax({ repeat: -1 });
	b8.from('.b8', 6, {y:300, opacity: 0}, 1)
		.to('.b8', 9, {y:-500, opacity: 1}, 0.2)

	b9 = new TimelineMax({ repeat: -1 });
	b9.from('.b9', 6, {y:300, opacity: 0}, 0.9)
		.to('.b9', 6, {y:-500, opacity: 1}, 0.1)

	b10 = new TimelineMax({ repeat: -1 });
	b10.from('.b10', 6, {y:300, opacity: 0}, 0.2)
		.to('.b10', 7, {y:-500, opacity: 1}, 0.2)

	f4 = new TimelineMax({ repeat: -1, yoyo: false });
	f4.fromTo('.new-fish1', 80, {css:{'left':'-200px'}}, {css:{'left':'100%'}}, 0)
	f41 = new TimelineMax({ repeat: -1, yoyo: true });
	f41.fromTo('.new-fish1', 1.5, {skewY:"2deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"-3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	f4 = new TimelineMax({ repeat: -1, yoyo: false });
	f4.fromTo('.new-fish1', 80, {css:{'left':'-200px'}}, {css:{'right':'-200px'}}, 0)
	f41 = new TimelineMax({ repeat: -1, yoyo: true });
	f41.fromTo('.new-fish1', 1.5, {skew:"0", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skew:"-3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

    congratulationgirl = new TimelineMax({ repeat: -1});
    congratulationgirl.fromTo('.congratulation-girl', 15, {x:0, rotationY: -10}, {x:700, rotationY: 10, ease:Power1.easeOut})
    congratulationgirl.fromTo('.congratulation-girl', 0.1, {scaleX:1}, {scaleX:-1} )
    congratulationgirl.fromTo('.congratulation-girl', 15, {x:700, rotationY: -20}, {x:0, rotationY: 10})

    seahorse = new TimelineMax({repeat: -1});
    seahorse.fromTo(".sea-horse1", 1, {rotation: -10, repeat: -1, yoyo: true}, {rotation: 20, ease: Power0.easeNone, repeat:-1, yoyo: true}, 0)
        .to(".sea-horse1", 20, {x: Math.floor(Math.random() * -1000), y: Math.floor(Math.random() * 1000)+100, repeat: -1, yoyo: true},0)
        .to('.sea-horse1', 0.2, {scaleX:-1},20)
        .to(".sea-horse1", 20, {x: Math.floor(Math.random() * 200)+100, y: Math.floor(Math.random() * 100), ease: Power4.easeOut, repeat: -1, yoyo: true},20)
        .to('.sea-horse1', 0.2, {scaleX:1},40)
    var item=$('.bubble-top')
    for (var i=0; i<item.length; i++) {
        bubbles = new TimelineMax({repeat: -1})
        bubbles.fromTo(item[i], Math.floor(Math.random()*15)+10, {y: Math.floor(Math.random() * 200) + 100}, {y: Math.floor(Math.random() * -1500)-1000, opacity: 0.2})
    }

    nf1 = new TimelineMax({ repeat: -1, yoyo: false });
	nf1.fromTo('.f1-2', 60, {css:{'right':'-200px'}}, {css:{'left':'-300px'}}, 0)
	nf11 = new TimelineMax({ repeat: -1, yoyo: true });
	nf11.fromTo('.f1-2', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"6deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	nf2 = new TimelineMax({ repeat: -1, yoyo: false });
	nf2.fromTo('.f1-1', 50, {css:{'right':'-300px'}}, {css:{'left':'-300px'}}, 0)
	nf21 = new TimelineMax({ repeat: -1, yoyo: true });
	nf21.fromTo('.f1-1', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

    nf3 = new TimelineMax({ repeat: -1, yoyo: false });
	nf3.to('.f2-2', 50, {x:3000}, 0);
	nf31 = new TimelineMax({ repeat: -1, yoyo: true });
	nf31.fromTo('.f2-2', 1, {skewY:"-1deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"-3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	nf4 = new TimelineMax({ repeat: -1, yoyo: false });
	nf4.to('.f2-1', 60, {x:3000}, 0);
	nf41 = new TimelineMax({ repeat: -1, yoyo: true });
	nf41.fromTo('.f2-1', 2, {skewY:"-1deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"-3deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)

	jellyfish = new TimelineMax({repeat: -1, yoyo:true});
	jellyfish.fromTo(".con-sua",10, {y: 10, rotation: -10,}, {y:100, rotation: 20, ease: Power0.easeNone}, 0)

	octopus = new TimelineMax({repeat: -1, yoyo:true});
	octopus.to(".bach-tuoc",5, {rotationY:10, y:getRandom(100, 110), ease: Power0.easeNone})

	function getRandom(max, min){
		return Math.floor(Math.random() * (1 + max - min) + min);
	}

	$("#play_btn").click(function(){

		if(threeDTimeline.progress()==1){
			threeDTimeline.restart();
		}else{
			threeDTimeline.play();
		}
	})

    var nemo_ease = Circ.easeOut
	nemo = new TimelineMax({ repeat: -1, yoyo: false });
	nemo.to('.new-fish5-1', 30, {css:{'left':'-200px'}, ease: nemo_ease}, 0);
	nemo.to('.new-fish5-2', 35, {css:{'left':'-200px'}, ease: nemo_ease}, 0);
	nemo.to('.new-fish5-3', 33, {css:{'left':'-200px'}, ease: nemo_ease}, 0);
	nemo1 = new TimelineMax({ repeat: -1, yoyo: true });
	nemo1.fromTo('.new-fish5-1, .new-fish5-2, .new-fish5-3', 1,
        {skewY:"0deg", transformOrigin:"45% 55%", ease:Power0.easeNone},
        {skewY:"-6deg", transformOrigin:"55% 45%", ease:Power0.easeNone}, 0)
