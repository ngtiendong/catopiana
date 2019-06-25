$('.modal').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomIn faster animated');
})
$('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomOut faster animated');
})


$(document).on('click', '.answer label',function (event) {
    event.preventDefault();
    // $('.answer label').removeClass('animated rubberBand')
    $('label').removeClass('animated rubberBand')
    $(this).addClass('animated rubberBand');

    $(this).css('opacity', '1');
    $(this).find('input').eq(0).prop('checked', true);
    // console.log("checked here", $(this))

    $(this).siblings('label').each(function (index, el) {
        $(el).find('input').eq(0).prop('checked', false);
        $(el).css('opacity', '0.3');
    });

    if ($(this).find('img.audio-image').length == 0) {
        play_sound("/sounds/plucky.mp3")

    }
    // Disable button
    $('.test-button');
    // auto next when click button
    if ($(window).width() > 1366 || this_question.type !== '1')  {
        autonext()
    }

});

$(document).on('click', '.swal2-radio label',function (event) {
    event.stopPropagation();
    $('.swal2-radio label').removeClass('animated rubberBand')
    $(this).addClass('animated rubberBand');
    $(this).css('opacity', '1');
    $(this).siblings(' .swal2-radio  label').each(function (index, el) {
        $(el).css('opacity', '0.3');
    });

    if ($(this).find('img.audio-image').length == 0) {
        play_sound("/sounds/plucky.mp3")

    }
});

function autonext()
{
    if( this_question.current_index < this_question.question_data.length - 1 && current_index_max == this_question.current_index && !disabled_label_click ) {
        $('#nextBtn').prop('disabled', true);
        disabled_label_click = true;
        setTimeout(()=>{
                next()
        },500)

    }
}

function play_sound(src) {
    var sound = null
    let music = src;
    if (sound != null) {
        sound.stop();
        sound.unload();
        sound = null;
    }
    sound = new Howl({
        src: [music],
        format: 'mp3'
    });
    sound.play();
}

function wait_load() {
    $('.progress').css('display','block')
    // $('.progress').trigger('mouseover')
    setTimeout(()=>{
//         // const randomTiming = Math.floor((Math.random() * 2)+1.5);
//         // console.log(randomTiming);
        bar.style.transitionDuration = `0.5s`;
        bar.style.width = '5%'
    }, 1)
}

function allImagesLoaded() {
    $('.progress').css('display','none')
}

function waiting_element_load() {
    $('#testForm').css('display', 'none')

    if ($('audio').length > 0) {
        if ($(window).width() > 1366) {
            $('.progress').css('display','block')
            let audio_not_load =  $('audio')
            let bias = round(100/$('audio').length, 0.2), w,w2, count=0, total=0
            // console.log( $('audio').length, document.querySelectorAll('audio:not([readyState="4"])').length)
            $('audio[readyState!="4"]').each(function(index){
                if ($(this).prop('readyState') != 4) {
                    total += 1
                    document.querySelectorAll('audio')[index].addEventListener('canplaythrough', ()=>{
                        setTimeout(()=>{
                            w = (bar.style.width).replace("%", "");
                            w2 = parseFloat(w) + bias;
                            // console.log(w, w2, bar.style.width, bias, $('audio').length)
                            bar.style.transitionDuration = `0.5s`;
                            bar.style.width = w2 + '%'
                        }, 1)
                        count += 1

                    })
                }

            })

            let loop = setInterval(function(){
                console.log(count, total)
                if (count === total) {
                    $('.progress').css('display', 'none')
                    $('#testForm').css('display', 'block').css('opacity', '1')
                    //Reset loading progress bar
                    bar.style.width = '0%'
                    clearInterval(loop)
                }}, 100);
        } else {
            setTimeout(()=>{
                // console.log(w, w2, bar.style.width, bias, $('audio').length)
                bar.style.transitionDuration = `0.5s`;
                bar.style.width = '20%'
            }, 200)
            $('.progress').css('display', 'none')
            $('#testForm').css('display', 'block').css('opacity', '1')
        }


    } else {
        wait_load()
        // Not music test
        $('#testForm img').imagesLoaded()
            .always(function (instance) {
                setTimeout(function () {
                    $('.progress').css('display', 'none')
                    $('#testForm').css('display', 'block').css('opacity', '1')

                    //Reset loading progress bar
                    bar.style.width='0%'
                }, 300)


            })
            .progress(function () {
                var w, w2, bias
                bias = round(95 / $('#testForm img').length, 0.05)
                if (bias == 0) {bias = 0.1}
                // console.log("bias", bias, round(95 / $('#testForm img').length, 0.2), 95 / $('#testForm img').length)
                setTimeout(() => {
                    w = (bar.style.width).replace("%", "");
                    // console.log("result", parseFloat(w) + bias)
                    w2 = parseFloat(w) + bias;
                    // console.log(image, w, w2, bar.style.width, bias, $('#testForm img').length)
                    bar.style.transitionDuration = `0.5s`;
                    bar.style.width = w2 + '%'

                }, 1)

            })
    }
}

function round(value, step) {
    step || (step = 1.0);
    var inv = 1.0 / step;
    return Math.round(value * inv) / inv;
}
// Dog
// d1 = new TimelineMax({ repeat: -1, yoyo: true });
// d1.fromTo('.iconwin1', 10, {css:{'left':'70%'}}, {css:{'left':'68%'}}, 0)
d11 = new TimelineMax({ repeat: -1, yoyo: true });
d11.fromTo('.iconwin1', 1, {rotation:-10, transformOrigin:"50% 50%", ease:Power0.easeNone}, {rotation:10, transformOrigin:"50% 50%", ease:Power0.easeNone}, 0.05)

d2 = new TimelineMax({ repeat: -1, yoyo: false });
d2.fromTo('.iconwin2', 10, {css:{'left':'20%'}}, {css:{'left':'23%'}}, 0)
// d21 = new TimelineMax({ repeat: -1, yoyo: true });
// d21.fromTo('.iconwin2', 1, {skewY:"0deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, {skewY:"7deg", transformOrigin:"50% 50%", ease:Power0.easeNone}, 0)


// burst animation
var el6 = document.querySelector('div.continue_test')
const fw1 = new mojs.Burst({
    parent: el6,
    top: '10%',
    left: '-10%',
    radius: {40: 150},
    count: 50,
    duration: 1500,
    children: {
        shape: 'line',
        fill: 'white',
        radius: {20: 0},
        scale: 1,
        stroke: '#ff0e00',
        strokeWidth: 1,
        duration: 1500,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
    },
    onComplete () {
        this.generate().replay();
    }
});

const fw20 = new mojs.Burst({
    parent: 	el6,
    top: '-20%',
    left: '15%',
    count: 		15,
    radius: 	{20:80},
    angle: 		{ 0: 140, easing: mojs.easing.bezier(0.1, 1, 0.3, 1) },
    children: {
        fill: 			'#988ADE',
        radius: 		20,
        opacity: 		0.6,
        duration: 	1500,
        easing: 		mojs.easing.bezier(0.1, 1, 0.3, 1)
    },
    onComplete () {
        this.generate().replay();
    }
})

const fw21 = new mojs.Burst({
    parent: el6,
    top: '10%',
    left: '-10%',
    radius: {40: 150},
    count: 20,
    angle: 	{ 0:360, easing: mojs.easing.bezier(0.1, 1, 0.3, 1) },
    yoyo: true,
    children: {
        shape: 'polygon',
        radius: {15: 5},
        scale: 1,
        stroke: '#f70e00',
        strokeWidth: 0.5,
        duration: 1500,
        easing: mojs.easing.bezier(0.1, 1.5, 0.3, 1),
        // repeat: 9999,
    },
    onComplete () {
        this.generate().replay();
    }
});
// ring animation
const fws1 = new mojs.Shape({
    top: '10%',
    left: '-10%',
    parent: el6,
    radius: {10: 100},
    fill: 'transparent',
    stroke: '#fff34b',
    strokeWidth: {30: 0},
    duration: 800,
    easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
    repeat: 9999,
    // children: {
    //     repeat: 9999,
    // }

});

const fw2 = new mojs.Burst({
    top: '80%',
    left: '15%',
    parent: el6,
    count: 28,
    radius: {50: 110},
    repeat: 9999,
    children: {
        fill: '#ff00f5',
        opacity: 0.6,
        radius: {'rand(5,20)': 0},
        scale: 1,
        swirlSize: 15,
        duration: 1600,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
        isSwirl: true,
        repeat: 9999,
    }
});
// burst animation
const fw3 = new mojs.Burst({
    parent: el6,
    top: '40%',
    left: '60%',
    count: 18,
    angle: {0: 10},
    radius: {140: 200},
    repeat: 9999,
    children: {
        fill: '#ff00f5',
        shape: 'line',
        opacity: 0.6,
        radius: {'rand(5,20)': 0},
        scale: 1,
        stroke: '#988ADE',
        strokeWidth: 2,
        duration: 1800,
        delay: 300,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
        repeat: 9999,
    }
});
// burst animation
const fw4 = new mojs.Burst({
    parent: el6,
    radius: {40: 80},
    count: 18,
    repeat: 9999,
    top: '35%',
    left: '95%',
    children: {
        fill: '#988ADE',
        opacity: 0.6,
        radius: {'rand(5,20)': 0},
        scale: 1,
        swirlSize: 15,
        duration: 2000,
        delay: 500,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
        isSwirl: true,
        repeat: 9999,
    }
});
// burst animation
const fw5 = new mojs.Burst({
    parent: el6,
    count: 20,
    top: '45%',
    left: '80%',
    angle: {0: -10},
    radius: {90: 130},
    children: {
        fill: '#988ADE',
        opacity: 0.6,
        radius: {'rand(10,20)': 0},
        scale: 1,
        duration: 3000,
        delay: 750,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1)
    }
});

const burstPolygon = new mojs.Burst({
    parent: el6,
    radius: { 0 : 150 },
    top: '60%',
    left: '-10%',
    count: 30,
    children: {
        shape: 'polygon',
        radius: { 20 : 5 },
        duration: 1500,
        repeat: 9999,
    },
});
const burstCross = new mojs.Burst({
    parent: el6,
    radius: { 0 : 135 },
    top: '90%',
    left: '80%',
    count: 15,
    children: {
        shape: 'cross',
        stroke: 'orange',
        strokeWidth: { 9 : 3 },
        radius: { 20 : 5 },
        angle: { 360 : 0 },
        duration: 1500,
        repeat: 9999,
    },
});
const swirls = {
    parent: el6,
    radius: 5,
    direction: -1,
    swirlSize: 85,
    swirlFrequency: 10,
    repeat: 999
};
const swirl = new mojs.ShapeSwirl({
    parent: el6,
    radius: 5,
    direction: -1,
    swirlSize: 85,
    swirlFrequency: 10,
    repeat: 999,
    fill: 'papayawhip',
    top: '10%',
    y: { 0: -150 },
    duration: 3000,
});
const swirl2 = new mojs.ShapeSwirl({
    parent: el6,
    radius: 5,
    direction: -1,
    swirlSize: 85,
    swirlFrequency: 10,
    repeat: 999,
    fill: 'mediumvioletred',
    top: '90%',
    left: '80%',
    y: { 0: 50 },
    duration: 3000,
});
const swirl3 = new mojs.ShapeSwirl({
    parent: el6,
    radius: 5,
    direction: -1,
    swirlSize: 85,
    swirlFrequency: 10,
    repeat: 999,
    fill: 'yellow',
    top: '80%',
    left: '20%',
    y: { 0: -100 },
    duration: 3000,
});
const circs = {
    parent: el6,
    fill: 'none',
    opacity: { 1 : 0 },
    duration: 1800,
    repeat: 999
};
const circ = new mojs.Shape({
    parent: el6,
    fill: 'none',
    opacity: { 1 : 0 },
    duration: 1800,
    repeat: 999,
    radius: { 0 : 100 },
    top: '90%',
    left: '80%',
    stroke: 'peachpuff',
});
const circ2 = new mojs.Shape({
    parent: el6,
    fill: 'none',
    opacity: { 1 : 0 },
    duration: 1800,
    repeat: 999,
    radius: { 0 : 150 },
    top: '-10%',
    left: '20%',
    zIndex: '-1',
    stroke: 'magenta'
});
