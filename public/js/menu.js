$(document).on('click', '.list_icon_menu li',function (event) {
    event.preventDefault();
    $(this).siblings('li').removeClass('animated rubberBand')
    $(this).addClass('animated rubberBand');

    $(this).css('opacity', '0.5');
    $(this).find('input').eq(0).prop('checked', true);

    $(this).siblings('li').each(function (index, el) {
        $(el).find('input').eq(0).prop('checked', false);
        $(el).css('opacity', '1');
    });
    play_sound("/sounds/plucky.mp3")
});

$(document).on('click', '.list_icon_food li',function (event) {
    event.preventDefault();
    if($(this).find('input').eq(0).prop('checked') == true) {
        $(this).css('opacity', '1');
        $(this).find('input').eq(0).prop('checked', false);
        $(this).removeClass('animated rubberBand');
        return false;
    } else {
        $(this).siblings('li').removeClass('animated rubberBand')
        $(this).addClass('animated rubberBand');

        $(this).css('opacity', '0.5');
        $(this).find('input').eq(0).prop('checked', true);
    }
    play_sound("/sounds/plucky.mp3")
});