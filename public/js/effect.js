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
    const randomTiming = Math.floor((Math.random() * 2) + 0.5);
    bar.style.width = 100+'%';
    // bar.style.transitionDuration = `${randomTiming}s`;

}

function allImagesLoaded() {
    $('.progress').css('display','none')
}