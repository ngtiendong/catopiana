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

// // Fn to allow an event to fire after all images are loaded
// $.fn.imagesLoaded = function () {
//
//     // get all the images (excluding those with no src attribute)
//     var $imgs = this.find('img[src!=""]');
//     // if there's no images, just return an already resolved promise
//     if (!$imgs.length) {return $.Deferred().resolve().promise();}
//
//     // for each image, add a deferred object to the array which resolves when the image is loaded (or if loading fails)
//     var dfds = [];
//     $imgs.each(function(){
//
//         var dfd = $.Deferred();
//         dfds.push(dfd);
//         var img = new Image();
//         img.onload = function(){dfd.resolve();}
//         img.onerror = function(){dfd.resolve();}
//         img.src = this.src;
//
//     });
//
//     // return a master promise object which will resolve when all the deferred objects have resolved
//     // IE - when all the images are loaded
//     return $.when.apply($,dfds);
//
// }
