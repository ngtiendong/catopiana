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
