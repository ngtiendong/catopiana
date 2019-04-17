
/**
 * demo.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2016, Codrops
 * http://www.codrops.com
 */



    // taken from mo.js demos
    function isIOSSafari() {
        var userAgent;
        userAgent = window.navigator.userAgent;
        return userAgent.match(/iPad/i) || userAgent.match(/iPhone/i);
    };

    // taken from mo.js demos
    function isTouch() {
        var isIETouch;
        isIETouch = navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
        return [].indexOf.call(window, 'ontouchstart') >= 0 || isIETouch;
    };

    // taken from mo.js demos
    var isIOS = isIOSSafari(),
        clickHandler = isIOS || isTouch() ? 'touchstart' : 'click';

    function extend( a, b ) {
        for( var key in b ) {
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function Animocon(el, options) {
        this.el = el;
        this.options = extend( {}, this.options );
        extend( this.options, options );

        this.checked = false;

        this.timeline = new mojs.Timeline();

        for(var i = 0, len = this.options.tweens.length; i < len; ++i) {
            this.timeline.add(this.options.tweens[i]);
        }

        var self = this;
        // this.el.addEventListener(clickHandler, function() {
        //     if( self.checked ) {
        //         self.options.onUnCheck();
        //     }
        //     else {
        //         self.options.onCheck();
        //         self.timeline.replay();
        //     }
        //     self.checked = !self.checked;
        // });
    }

    Animocon.prototype.options = {
        tweens : [
            new mojs.Burst({})
        ],
        onCheck : function() { return false; },
        onUnCheck : function() { return false; }
    };


    function anime_init() {
        /* Icon 6 */
        var el6 = document.querySelector('.answer label img')
        new Animocon(el6, {
            tweens : [
                // burst animation
                new mojs.Burst({
                    parent: 			el6,
                    radius: 			{40:110},
                    count: 				20,
                    children: {
                        shape: 			'line',
                        fill : 			'white',
                        radius: 		{ 12: 0 },
                        scale: 			1,
                        stroke: 		'#988ADE',
                        strokeWidth: 2,
                        duration: 	1500,
                        easing: 		mojs.easing.bezier(0.1, 1, 0.3, 1)
                    },
                }),
                // ring animation
                new mojs.Shape({
                    parent: 			el6,
                    radius: 			{10: 60},
                    fill: 				'transparent',
                    stroke: 			'#988ADE',
                    strokeWidth: 	{30:0},
                    duration: 		800,
                    easing: 			mojs.easing.bezier(0.1, 1, 0.3, 1)
                }),

            ],
            onCheck : function() {
                // el6.style.color = '#988ADE';
            },
            onUnCheck : function() {
                // el6.style.color = '#C0C1C3';
            }
        });
        /* Icon 6 */

    }


