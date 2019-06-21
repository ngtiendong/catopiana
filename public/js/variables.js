var tab_number = document.getElementsByClassName("tab");
var total_question = 0
var topic = $('#topic').val().toString()
var type = $('#type').val().toString()
var check_mobile = function() {
	if ($(window).width() < 700) {
		return true
	} else{
		return false
	}
}
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
var disabled_label_click = false;
var doubleFalse = false;

var player
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


//Variables of Position
var line_array = []
var all_line_array = []
var mix_line_array = []


const bar = document.querySelector('.bar');
const progress = document.querySelector('.progress');
bar.style.width = '0%'
// $(progress).on('mouseover', () => {
//     setTimeout(()=>{
//         // const randomTiming = Math.floor((Math.random() * 2)+1.5);
//         // console.log(randomTiming);
//         bar.style.transitionDuration = `0.5s`;
//         bar.style.width = '5%'
//     }, 100)
//
// });

function loadAudio(url, vol){
    var audio = new Audio();
    audio.src = url;
    audio.preload = "auto";
    audio.volume = vol;
    $(audio).on("loadeddata", launchApp);  // jQuery checking
    return audio;
}

