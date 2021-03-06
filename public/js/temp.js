// let currentTab = 0;
let tab_number = document.getElementsByClassName("tab");
let total_question = 0
var type = $('#type').val()

var this_question
var position_this_question
var buttonMemoryChecked = true;

var style = '';
var timeout = 5;
var timerId = null;
$('.badge').text( '0 / '+total_question)

let fakeAnswer = 0;
let minLv = 1;

let timeToChange;
let flagChange = 0;
let current_index_max = 0;

$(document).on('click', 'label',function (event) {
    event.preventDefault();
    $(this).css('opacity', '1');
    $(this).find('input').eq(0).prop('checked', true);
    console.log("checked here", $(this))

    $(this).siblings('label').each(function (index, el) {
        $(el).find('input').eq(0).prop('checked', false);
        $(el).css('opacity', '0.3');
    });
});


$(function(){
    $('#testForm').on('submit', function(event){
        //update local storage
        event.preventDefault()
        let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')
        if (typeof $(just_answer).val() === 'undefined'){
            //Chua tra loi
            alert("Please answer the question")
        } else {
            just_answer = just_answer.data('position')
            if (this_question.answers.length > this_question.current_index) {
                this_question.answers.pop()
            }
            this_question.answers.push(just_answer)
            this_question.status = 1
            //Save into local storage
            localStorage.setItem('testing', JSON.stringify(testing_data));

            let candidate_answers = this_question.answers;
            console.log('answer', candidate_answers, this_question, just_answer)

            let correct = candidate_answers.filter(answer => answer == 0).length
            Swal.fire({
                title: ` \n Your score: `+ correct +' / '+total_question,
                text: 'You have completed this test!',
                background: 'orange',
                display: 'flex',
            }).then(() => {
                $('#modal-after-answertoppic').modal();
            });
            //Display test not finished
            displayTestUnFinishedAfterSubmit()
        }
    })
})

$('.startBtn').click(async function () {
    //Check local storage
    if (typeof(test_level) === 'undefined') {
        await swal.fire({
            title: 'Please add level',
            input: 'text',
            inputPlaceholder: 'Enter your level',
            confirmButtonText: 'Look up',
            showLoaderOnConfirm: true,
            preConfirm: (level) => {
                return $.ajax({
                    method: "POST",
                    url: "/get-list-question",
                    data: {
                        'type': type,
                        'level': level
                    },
                    cache: false,

                }).then(function (response) {
                    console.log(type, response)
                    if (response.status === 1) {
                        //Save local storage
                        testing_data = {
                            level: level,
                            question: []
                        };

                        position_this_question = 0
                        // add
                        // data to html
                        html_arr = [];
                        if (type === '1'){
                            response.question_data.forEach( function(question_data_element, index) {
                                html_arr.push(renderAudio(question_data_element.question, question_data_element.answers,
                                question_data_element.question_image, question_data_element.answer_image))
                            });
                        }
                        else {
                            response.question_data.forEach( function(question_data_element, index) {
                                html_arr.push(render(question_data_element.question, question_data_element.answers))
                            });

                        }
                        //
                        this_question = {
                            type: type, //topic
                            question_data: response.question_data,
                            current_index: 0,
                            answers: [],
                            status: 0,
                            level_temp : level,
                            html_arr: html_arr,
                        };

                        testing_data.question.push(this_question);
                        localStorage.setItem('testing', JSON.stringify(testing_data));
                        total_question = parseInt(this_question.question_data.length)
                        //Display
                        displayTest()
                        var html_gen_all = ''
                        html_arr.forEach( function(html_arr_element, index) {
                            html_gen_all += html_arr_element;
                        });
                         $('#prevBtn').before(html_gen_all)
                        current_index_max = this_question.current_index
                        showTab(this_question.current_index)

                        if(type == '6'){
                            //Memory
                            if(timerId != null){
                                clearTimeout(timerId);
                                timeout = 5;
                            }
                            buttonMemoryChecked = false;
                            hideQuestion(this_question.current_index);
                        }

                        // check khi start lan dau qua 20s chuyen cau hoi lv thap
                        if(level > minLv){
                            setTimeToChange(level - 1 , this_question.current_index + 1)
                        }
                    }

                }).catch(function (response) {
                    console.log("error", response)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    }

    else {
        //Check history
        let flag = 1;
        let position = -1;
        for (var i = 0; i < testing_data.question.length; i++) {
            var current_data = testing_data.question[i];
            // console.log('current', current_data)

            if (current_data.type == type ) {
                // Da ton tai bai test type nay trong lich su
                position_this_question = i
                if (current_data.status === 0) {
                    // Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
                    console.log('current', current_data)
                    this_question = current_data
                    total_question = parseInt(this_question.question_data.length)
                    generateUnfinishedTest(current_data)
                    flag = -1;
                } else {
                    // Da ton tai nhung da hoan thanh bai test => luu lai position
                    flag = 0;
                    position = i;
                }

                break
            }
        }


        if (flag !== -1) {
            //Da ton tai nhung da hoan thanh bai test HOAC chua ton tai trong local storage
            getNewQuestionData(position)
        }



    }

});

function generateUnfinishedTest(current_data) {
    // Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
    var html = ''
    var length_answered = current_data.answers.length;
    var length_
    console.log('length answer', length_answered)

    if (type == '1'){
        //Audio
        for (var i = 0; i<length_answered; i++) {
            html += '<div class="tab" style="display: none;"><img class="question audio-image" src="'+current_data.question_data[i].question_image+'" alt="">'+
                '<audio src="'+ current_data.question_data[i].question +'" class="audio"></audio>' + '<div class="answer">'

            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {

                // console.log('i,j', j, i, current_data.answer[i])
                if (j == current_data.answers[i]) {
                    answer += '<label class="col-md-4" style="opacity: 1">' +
                        '<input type="radio" style="z-index: -1;" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img class="audio-image" src="' + current_data.question_data[i].answer_image + '" alt="">' +
                        '<audio src="'+ current_data.question_data[i].answers[j] +'" class="audio"></label>'
                } else {
                    answer += '<label class="col-md-4" style="opacity: 0.3"> ' +
                        '<input type="radio" style="z-index: -1;" value="' + current_data.question_data[i].answers[j] + '" data-position="'+j+'" hidden>' +
                        '<img class="audio-image" src="' + current_data.question_data[i].answer_image + '" alt="">' +
                        '<audio src="'+ current_data.question_data[i].answers[j] +'" class="audio"></label>'
                }



            }

            html += answer
            html += '</div></div>'
            // currentTab++
        }
    }
    else {
        for (var i = 0; i<length_answered; i++) {
            var visibility = '';
            if (type=='6') {
                visibility = 'visibility: hidden;'
            }
            html += '<div class="tab" style="display: none;"><img class="question" style="'+visibility+'" src="/test/images/'+current_data.question_data[i].question+'" alt="">'
            + '<p class="countDownTimer"></p>' +
            "<div class='answer'>" ;

            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {
                // console.log('i,j', j, i, current_data.answer[i])
                if (j == current_data.answers[i]) {
                    answer += '<label class="col-md-6" style="opacity: 1">' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img src="/test/images/' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                } else {
                    answer += '<label class="col-md-6" style="opacity: 0.3"> ' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" data-position="'+j+'" hidden>' +
                        '<img src="/test/images/' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                }



            }

            html += answer
            html += '</div></div>'
            // currentTab++
        }
        // console.log(current_data.question_data[length_answered])
    }
    if (length_answered < total_question){
        for(var not_answered = length_answered ; not_answered < total_question ; not_answered++ ){
            html += current_data.html_arr[not_answered];
        }
    }

    $('.tab').remove()
    $('#prevBtn').before(html)
    displayTest()
    current_index_max = current_data.current_index;
    showTab(current_data.current_index)
    if(current_data.level_temp > minLv){
        setTimeToChange(current_data.level_temp - 1 , current_data.current_index + 1 );
    }
    if(type === '6'){
        //Memory
        if(timerId != null){
            clearTimeout(timerId);
            timeout = 5;
        }
        buttonMemoryChecked = false;
        hideQuestion(current_data.current_index);
    }
}

function getNewQuestionData(position) {
    $.ajax({
        method: "POST",
        url: "/get-list-question",
        data: {
            'type': type,
            'level': test_level
        },
        success: function (response) {
            if (response.status === 1) {
                // save html -> localstorage
                html_arr = [];
                if (type === '1'){
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(renderAudio(question_data_element.question, question_data_element.answers,
                        question_data_element.question_image, question_data_element.answer_image))
                    });
                }
                else {
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(render(question_data_element.question, question_data_element.answers))
                    });

                }
                this_question = {
                    type: type,
                    question_data: response.question_data,
                    status: 0,
                    answers: [],
                    current_index: 0,
                    level_temp: test_level,
                    html_arr : html_arr
                };
                if (position == -1) {
                    position_this_question = testing_data.question.length
                    testing_data.question.push(this_question);
                } else {
                    testing_data.question[position] = this_question
                }

                total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));


                displayTest()
                //Display html all
                var html_gen_all = ''
                html_arr.forEach( function(html_arr_element, index) {
                    html_gen_all += html_arr_element;
                });
                $('#prevBtn').before(html_gen_all)

                current_index_max = this_question.current_index;
                showTab(this_question.current_index)
                if(this_question.level_temp > minLv){
                    setTimeToChange(this_question.level_temp - 1 , this_question.current_index + 1 );
                }
                if(type === '6'){
                    //Memory
                    if(timerId != null){
                        clearTimeout(timerId);
                        timeout = 5;
                    }
                    buttonMemoryChecked = false;
                    hideQuestion(this_question.current_index);
                }


            } else {
                console.log("error", response)
            }

        }

    })
}

function displayTest() {
    $('.startBtn').css('opacity', '0').css('z-index', '-1');
    setTimeout(function () {
        $('#testForm').css('display', 'block').css('opacity', '1')
    }, 100)
}

function showTab(current_index) {
    //Badge
    // console.log("currentTab", currentTab)
    $('.badge').text((current_index+1)+' / '+total_question)
    //Button
    for (let i = 0; i < tab_number.length; i++) {
        tab_number[i].style.display = "none";
    }
    tab_number[current_index].style.display = "flex";
    // console.log(n, currentTab, total_question)
    if (current_index === 0) {
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "none";

    }else if (current_index === total_question - 1) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline";

    }
    else {
        document.getElementById("submitBtn").style.display = "none";
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("nextBtn").style.display = "inline";
    }

}


setTimeToChange = (test_level, indexIncorrect) => {
    timeToChange = setTimeout(() => {
    changeDynamicQuestionTimeOut(test_level, indexIncorrect)
}, 20000)
}

stopTimeToChange = () => {
    for (var i = timeToChange; i > 0; i--)
    clearTimeout(timeToChange)
}



let changeDynamicQuestion = (test_level, indexIncorrect) => {
    console.log(type, test_level, indexIncorrect)
    $.ajax({
        method: "POST",
        url: "/get-list-less-level-question",
        data: {
            'type': type,
            'level': test_level,
            'index' : indexIncorrect
        },
        success: function (response) {

            if (response.status === 1) {
                // console.log(response.question_data)
                // ghep cau hoi vao this_question
                // html_arr_gen_again = [];
                if(response.question_data.length != 0){
                    // gen laij html
                    //
                    html_arr_gen_again = [];
                    if (type === '1'){
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderAudio(question_data_element.question, question_data_element.answers,
                            question_data_element.question_image, question_data_element.answer_image))
                        });
                    }
                    else {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(render(question_data_element.question, question_data_element.answers))
                        });

                    }
                    console.log('html_arr_gen_again ', html_arr_gen_again)
                    console.log('indexIncorrect ', indexIncorrect)
                    console.log('current_index ', this_question.current_index)
                    console.log('this_questionlength ', this_question.question_data.length)

                    Array.prototype.splice.apply(this_question.html_arr, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(html_arr_gen_again));
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    var tab_ = $('.tab');
                    var html_gen_again = '';
                    for(var i = indexIncorrect; i < this_question.question_data.length; i++ ){
                            tab_[i].remove();
                    }
                    html_arr_gen_again.forEach( function(gen_again_element, index) {
                        html_gen_again += gen_again_element;
                    });

                    $('#prevBtn').before(html_gen_again)
                }
                // trừ lv khi sai
                this_question.level_temp = test_level

                localStorage.setItem('testing', JSON.stringify(testing_data));
                console.log('current: ', indexIncorrect, 'data', this_question)
                showTab(indexIncorrect)
                if(type === '6'){
                    //Memory
                    if(timerId != null){
                        clearTimeout(timerId);
                        timeout = 5;
                    }
                    buttonMemoryChecked = false;
                    hideQuestion(indexIncorrect);
                }

                flagChange = 0;
                if(this_question.level_temp > minLv){
                    // console.log('vào đây dynamyc')
                    setTimeToChange(this_question.level_temp - 1 , indexIncorrect + 1 );
                }
            } else {
                console.log("error", response)
            }

        }

    })
}

let changeDynamicQuestionTimeOut = (test_level, indexIncorrect) => {
    console.log(type, test_level, indexIncorrect)
    $.ajax({
        method: "POST",
        url: "/get-list-less-level-question",
        data: {
            'type': type,
            'level': test_level,
            'index' : indexIncorrect
        },
        success: function (response) {

            if (response.status === 1) {
                if(response.question_data.length != 0){
                    // gen laij html
                    //
                    html_arr_gen_again = [];
                    if (type === '1'){
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderAudio(question_data_element.question, question_data_element.answers,
                            question_data_element.question_image, question_data_element.answer_image))
                        });
                    }
                    else {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(render(question_data_element.question, question_data_element.answers))
                        });

                    }
                    // console.log('html_arr_gen_again ', html_arr_gen_again)
                    // console.log('indexIncorrect ', indexIncorrect)
                    // console.log('current_index ', this_question.current_index)
                    // console.log('this_questionlength ', this_question.question_data.length)

                    Array.prototype.splice.apply(this_question.html_arr, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(html_arr_gen_again));
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    var tab_ = $('.tab');
                    var html_gen_again = '';
                    for(var i = indexIncorrect; i < this_question.question_data.length; i++ ){
                            tab_[i].remove();
                    }
                    html_arr_gen_again.forEach( function(gen_again_element, index) {
                        html_gen_again += gen_again_element;
                    });

                    $('#prevBtn').before(html_gen_again)
                }
                // xuwr lyys
                 // trừ lv khi timeout
                    this_question.level_temp = test_level
                // console.log(response.question_data)

                // total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));
                // neu da thay doi cau hoi r thi doi flagchange khong bat doi cau khi tra loi sai nua
                flagChange = 1;
            } else {
                console.log("error", response)
            }
        }

    })
}

function next() {
    if(type == "6" && buttonMemoryChecked == false){
        return false;
    }
    // let just_answer = tab_number[currentTab].querySelector('input:checked')
    let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')
    if (typeof $(just_answer).val() === 'undefined'){
        //Chua tra loihide
        // console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
        alert("Please answer the question")
    } else {
        tab_number[this_question.current_index].style.display = "none";
        this_question.current_index += 1
        console.log ("number tab", tab_number.length-1, "tab current", this_question.current_index)

        //Lock and save answered
        just_answer = just_answer.data('position')
        this_question.answers.push(just_answer)
        console.log("push here", this_question.answers)
        if (current_index_max >= this_question.current_index){
                showTab(this_question.current_index);
        } else {
            current_index_max += 1;
        // dừng việc check20s tránh đuplicate lặp timeout
            stopTimeToChange()
            // compare answer
            if(just_answer != fakeAnswer && this_question.level_temp > minLv && flagChange == 0 ){
                console.log('w answer');
                // truyền vào câu số i sai => truyền current index đã dc cộng + 1
                changeDynamicQuestion(this_question.level_temp -1 , this_question.current_index)
            } else {
                //Save into local storage
                // console.log (testing_data, 'test')
                localStorage.setItem('testing', JSON.stringify(testing_data))
                if(type === '6'){
                        //Memory
                        if(timerId != null){
                            clearTimeout(timerId);
                            timeout = 5;
                        }
                        buttonMemoryChecked = false;
                        hideQuestion(this_question.current_index);
                    }
                showTab(this_question.current_index)
                flagChange = 0
                // sau khi render 20s k next thì sẽ => câu hỏi thấp
                if(this_question.level_temp > minLv){
                    // lv hết => câu đang làm chậm => curren_index này chậm => truyền vào câu thứ i sai : chính là currne_index + 1;
                    setTimeToChange(this_question.level_temp - 1 , this_question.current_index + 1 );
                }
            }
        }
    }

}

function prev() {

    if(type == "6" && buttonMemoryChecked == false)
    {
        return false;
    }
    var x = document.getElementsByClassName("tab");

    x[this_question.current_index].style.display = "none";

    this_question.current_index += -1
    while(this_question.answers.length > this_question.current_index){
        this_question.answers.pop()
    }
    console.log("pop here", this_question.answers)

    //Save into local storage
    localStorage.setItem('testing', JSON.stringify(testing_data))

    showTab(this_question.current_index);

}

function render(question, answers) {
    let answerHTML = "";
    answers.forEach(function (el, index) {
        answerHTML += "<label class='col-md-6'>" +
            "<input type='radio' value='"+el+index+"' data-position='"+index+"' hidden>" +
            "<img src='/test/images/" + el + "' alt=''>" +
            "</label>"

    });

    if(type === "6" ){
        style = 'style="visibility : hidden;"';
    }

    let content = "<div class='tab' style='display: none;'>" +
        "<img class='question' src='/test/images/" + question + "' alt=''>" +
        '<p class="countDownTimer"></p>' +
        "<div class='answer'"+ style +">" +
        answerHTML +
        "</div>" +
        "</div>";

    // $('.button-np').before(content);
    // console.log("conent", content)
    // $('#prevBtn').before(content)
    return content
}

function renderAudio(question, answers, question_image, answer_image){
    var answerHTML = "";
    answers.forEach(function(el, index) {
        answerHTML += "<label class='col-md-4'>" +
            "<input type='radio' style='z-index: -1;' value='"+el+"' data-position='"+index+"' hidden>" +
            "<img class='audio-image' src='" + answer_image +"' alt=''>" +
            "<audio src='"+ el+"' class='audio'></audio>" +
            "</label>"

    });
    var content = "<div class='tab' style='display: none;'>" +
        "<img class='question audio-image' src='"+ question_image +"' alt=''>" +
        "<audio src='"+ question +"' class='audio'></audio>" +
        "<div class='answer'>" +
        answerHTML +
        "</div>" +
        "</div>" ;
    // $('#prevBtn').before(content);
    return content
}

function hideQuestion(currne_index){
    var x = document.getElementsByClassName("tab");
    $(x[currne_index]).children('answer').css('visibility' ,'hidden');

    timerId = setInterval(function() {
        if (timeout == 0) {
            $(x[currne_index]).children('img').css('visibility' ,'hidden')
            $(x[currne_index]).children('.answer').css('visibility' ,'visible')
            $('.countDownTimer').html( 'Time out!')
            buttonMemoryChecked = true;
            clearTimeout(timerId);
            timeout = 5;
            $('button').removeClass('countdown-disabled')

        } else {
            $('.countDownTimer').html( timeout + ' seconds');
            timeout--;
            $('button').addClass('countdown-disabled')
        }
    }, 1000);
}

function displayTestUnFinishedAfterSubmit() {
    list_test_finished.push(parseInt(type))

    let gen_html = '<div style="margin-top:25px; padding-right: 40px">'

    for (var i=1; i<9; i++) {
        if (list_test_finished.indexOf(i) < 0) {
            //Chua thi
            gen_html += array_svg[i-1]
        }
    }

    gen_html += '</div>'
    $('div.list-after-finished > h3').text("Next test: ")
    $('div.list-after-finished').hide()
    $('div.list-after-finished').empty()
    $('div.list-after-finished').append(gen_html)

    $('.fadeOut').hide()
    $('div.list-after-finished').fadeIn(1000)


}
