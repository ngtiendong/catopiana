var sound = null;
var music_image = '<svg id="play"  viewBox="0 0 163 163" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"="0px">'+
    '    '+
    '    <g fill="none">'+
    '        <g  transform="translate(2.000000, 2.000000)" stroke-width="4">'+
    '            <path d="M10,80 C10,118.107648 40.8923523,149 79,149 L79,149 C117.107648,149 148,118.107648 148,80 C148,41.8923523 117.107648,11 79,11" id="lineOne" stroke="#A5CB43"></path>'+
    '            <path d="M105.9,74.4158594 L67.2,44.2158594 C63.5,41.3158594 58,43.9158594 58,48.7158594 L58,109.015859 C58,113.715859 63.4,116.415859 67.2,113.515859 L105.9,83.3158594 C108.8,81.1158594 108.8,76.6158594 105.9,74.4158594 L105.9,74.4158594 Z" id="triangle" stroke="#A3CD3A"></path>'+
    '            <path d="M159,79.5 C159,35.5933624 123.406638,0 79.5,0 C35.5933624,0 0,35.5933624 0,79.5 C0,123.406638 35.5933624,159 79.5,159 L79.5,159" id="lineTwo" stroke="#A5CB43"></path>'+
    '        </g>'+
    '    </g>'+
    '</svg>';

$(document).on('mouseenter', '.audio-image', function(event) {
    event.preventDefault();
    let music = $(this).siblings('.audio').attr('src');
    if (sound != null) {
        sound.stop();
        // sound.unload();
        sound = null;
    }
    sound = new Howl({
        src: [music],
        format: 'mp3'
    });
    sound.play();
});

$(document).on('mouseleave', '.tab[style="display: flex;"] .audio-image', function(event) {
    event.preventDefault();
    sound.stop();
    sound.unload();
    sound = null;
});



function audioReady2(){
    return $.when.apply($, $('audio').map(function(){
        var ready = new $.Deferred();
        $(this).one('canplay', ready.resolve);
        return ready.promise();
    }));
}

function audioReady() {
    return $.when($('audio').each(function(index){
        document.getElementsByTagName('audio')[index].addEventListener('canplaythrough', ()=>{
            setTimeout(()=>{
                w = (bar.style.width).replace("%", "");
                w2 = Math.round(parseInt(w) + bias);
                console.log(w, w2, bar.style.width, bias, $('audio').length)
                bar.style.transitionDuration = `0.5s`;
                bar.style.width = w2 + '%'
            }, 1)
        })
    })).then(function(){
        setTimeout(()=>{
            $('.progress').css('display', 'none')
            $('#testForm').css('display', 'block').css('opacity', '1')

            //Reset loading progress bar
            bar.style.width='0%'
        }, 10)
    })
}
