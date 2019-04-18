var tab_number = document.getElementsByClassName("tab");
var total_question = 0
var topic = $('#topic').val().toString()
var type = $('#type').val().toString()

var this_question
var position_this_question
var buttonMemoryChecked = true;

var style = '';
var timeout = 5;
var timerId = null;
$('.badge').text( '0 / '+total_question)

var fakeAnswer = 0;
var minLv = 1;

var timeToChange;
var flagChange = 0;
var current_index_max = 0;
var position_in_local_storage = -1;


//Position
var max_images_in_column = 0

var topic_arr_free = [
	'music',
	'iq',
	'creative',
	'difference',
	'common',
	'memory',
	'language',
	'position'
];

const bar = document.querySelector('.bar');
const progress = document.querySelector('.progress');
bar.style.width = '0%'
$(progress).on('mouseover', () => {
    setTimeout(()=>{
        // const randomTiming = Math.floor((Math.random() * 2)+1.5);
        // console.log(randomTiming);
        bar.style.transitionDuration = `0.5s`;
        bar.style.width = '5%'
    }, 100)

});

function loadAudio(url, vol){
    var audio = new Audio();
    audio.src = url;
    audio.preload = "auto";
    audio.volume = vol;
    $(audio).on("loadeddata", launchApp);  // jQuery checking
    return audio;
}

