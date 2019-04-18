$('.modal').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomIn faster animated');
})
$('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomOut faster animated');
})


$(document).on('click', 'label',function (event) {
    event.preventDefault();
    $('.answer label').removeClass('animated rubberBand')
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
});

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
    $('.progress').trigger('mouseover')
}

function allImagesLoaded() {
    $('.progress').css('display','none')
}

function waiting_element_load() {
    $('#testForm').css('display', 'none')
    wait_load()
    $('#testForm img').imagesLoaded()
        .always(function( instance ) {
            // setTimeout(function () {
            //     $('.progress').css('display','none')
            // }, 3000)

            $('.progress').css('display','none')
            $('#testForm').css('display', 'block').css('opacity', '1')
        })
        .progress(function() {
            var w,w2, bias
            bias = Math.ceil(95/$('#testForm img').length)
            setTimeout(()=>{
                w = (bar.style.width).replace("%","");
                w2= Math.round(parseInt(w)+ bias);
                // console.log(image, w, w2, bar.style.width, bias, $('#testForm img').length)
                bar.style.transitionDuration = `0.5s`;
                bar.style.width = w2+'%'

            }, 100)

        })
}
