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
    console.log("checked here", $(this))

    $(this).siblings('label').each(function (index, el) {
        $(el).find('input').eq(0).prop('checked', false);
        $(el).css('opacity', '0.3');
    });

    if ($(this).find('img.audio-image').length == 0) {
        play_sound("/sounds/plucky.mp3")

    }
    // auto next when click button
    autonext()

});

$(document).on('click', '.swal2-radio label',function (event) {
    event.preventDefault();
    $('.swal2-radio label').removeClass('animated rubberBand')
    $(this).addClass('animated rubberBand');

    $(this).css('opacity', '1');
    $(this).find('input').eq(0).prop('checked', true);
    $(this).siblings(' .swal2-radio  label').each(function (index, el) {
        $(el).find('input').eq(0).prop('checked', false);
        $(el).css('opacity', '0.3');
    });

    if ($(this).find('img.audio-image').length == 0) {
        play_sound("/sounds/plucky.mp3")

    }
});

function autonext()
{
    if( this_question.current_index < this_question.question_data.length - 1 && current_index_max == this_question.current_index ) {
        $('#nextBtn').prop('disabled', true);
        setTimeout(()=>{
                next()
        },1000)
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
        $('.progress').css('display','block')
        let audio_not_load =  $('audio')
        let bias = Math.ceil(100 /$('audio').length), w,w2, count=0, total=0
        // console.log( $('audio').length, document.querySelectorAll('audio:not([readyState="4"])').length)
        $('audio[readyState!="4"]').each(function(index){
            if ($(this).prop('readyState') != 4) {
                total += 1
                document.querySelectorAll('audio')[index].addEventListener('canplaythrough', ()=>{
                    setTimeout(()=>{
                        w = (bar.style.width).replace("%", "");
                        w2 = Math.round(parseInt(w) + bias);
                        console.log(w, w2, bar.style.width, bias, $('audio').length)
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
                bias = Math.ceil(95 / $('#testForm img').length)
                setTimeout(() => {
                    w = (bar.style.width).replace("%", "");
                    w2 = Math.round(parseInt(w) + bias);
                    // console.log(image, w, w2, bar.style.width, bias, $('#testForm img').length)
                    bar.style.transitionDuration = `1s`;
                    bar.style.width = w2 + '%'

                }, 1)

            })
    }
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
    left: '10%',
    radius: {40: 110},
    count: 20,
    repeat: 9999,
    children: {
        shape: 'line',
        fill: 'white',
        radius: {12: 0},
        scale: 1,
        stroke: '#ff0e00',
        strokeWidth: 2,
        duration: 1500,
        easing: mojs.easing.bezier(0.1, 1, 0.3, 1),
        repeat: 9999,
    },
});
// ring animation
const fws1 = new mojs.Shape({
    top: '10%',
    left: '10%',
    parent: el6,
    radius: {10: 60},
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
    radius: { 0 : 180 },
    top: '60%',
    left: '20%',
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
    ...swirls,
    parent: el6,
    fill: 'papayawhip',
    top: '10%',
    y: { 0: -150 },
    duration: 3000,
});
const swirl2 = new mojs.ShapeSwirl({
    ...swirls,
    parent: el6,
    fill: 'mediumvioletred',
    top: '90%',
    left: '80%',
    y: { 0: 50 },
    duration: 3000,
});
const swirl3 = new mojs.ShapeSwirl({
    ...swirls,
    parent: el6,
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
    ...circs,
    parent: el6,
    radius: { 0 : 100 },
    top: '90%',
    left: '80%',
    stroke: 'peachpuff',
});
const circ2 = new mojs.Shape({
    ...circs,
    parent: el6,
    radius: { 0 : 250 },
    top: '30%',
    left: '20%',
    stroke: 'magenta'
});
