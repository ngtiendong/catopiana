
/**
 * Handle here
 */

$(window).on('load', function(){
    /**
     * Load mp3 here
     */
    function preloadAudio(url) {
        var audio = new Audio();
        // once this file loads, it will call loadedAudio()
        // the file will be kept by the browser as cache
        audio.src = url;
    }

    preloadAudio("sounds/demand.mp3")
    preloadAudio("sounds/oh-really.mp3")
    preloadAudio("sounds/plucky.mp3")
    preloadAudio("sounds/win.mp3")
    preloadAudio("sounds/applause3.mp3")
})
/**
 * 1. Submit Event
 * 2. Click Image in topic Position
 */
$(function () {
    //Auto scroll when into test page
    $('html,body').stop().animate({
        scrollTop: $('#id2 div.newTestOverlay').eq(0).offset().top
    }, 700);

    $('#testForm').on('submit', function (event) {
        //update local storage
        event.preventDefault()
        if (type == '2') {
            // POSITION
            return submitPosition()
        }
        let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')
        if (typeof $(just_answer).val() === 'undefined') {
            //Chua tra loi
            errorAnswer()
        } else {
            // play_sound("sounds/win.mp3")
            just_answer = just_answer.data('position')
            if (this_question.answers.length > this_question.current_index) {
                this_question.answers.pop()
            }
            this_question.answers.push(just_answer)
            this_question.status = 1
            //Save into local storage
            localStorage.setItem('testing', JSON.stringify(testing_data));

            // let candidate_answers = this_question.answers;
            // console.log('answer', candidate_answers, this_question, just_answer)

            // let correct = candidate_answers.filter(answer => answer == 0).length
            // let login = false;
            var login = $(this).data('login');
            updateDataTesting(login);

            // return false;
            if(!list_test_finished.includes(parseInt(topic))){
                list_test_finished.push(parseInt(topic))
            }
            redirectAfterSubmit(parseInt(topic))
            // showDialogScore(correct, total_question, login)
            //Display test not finished
            // displayTestUnFinishedAfterSubmit()
        }
    })

    $(document).ready(function() {
        //Check local storage
        if (typeof(test_level) === 'undefined') {
            inputOptions = {'4': '4', '5': '5', '6': '6', '7': '7', '8': '8', '9': '9', '10': '10'}
            swal.fire({
                title: 'Choose your age',
                width: 'auto',
                input: 'radio',
                inputOptions: inputOptions,
                inputValidator: (value) => {
                    if (!value) {
                      return 'You need to choose your age!';
                    }
                },
                confirmButtonText: 'Look up',
                // backdrop: `rgba(255, 255, 255, 0.61)`,
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    test_level = value
                    play_sound("sounds/demand.mp3")
                    return getNewQuestionData(position_in_local_storage)
                },
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-pop-chosse-level',
                    header:'swal-header-chosse-level',
                    title:'swal-title-chosse-level',
                    content: 'swal-content-chosse-level',
                    confirmButton:'swal-button-chosse-level'
                }
            })
        }
        else {
            //Check history
            let flag = 1;
            // login = $('#testForm').data('login');
            // testStatus = $('#testForm').data('testStatus');
            for (var i = 0; i < testing_data.question.length; i++) {
                this_question = testing_data.question[i];
                if (this_question.topic == topic) {
                        position_this_question = i
                        console.log('current', this_question)
                        // this_question = current_data
                        total_question = parseInt(this_question.question_data.length)
                        generateUnfinishedTest(this_question)
                    // }
                        flag = -1;
                        break;
                }
            }
            if (flag !== -1) {
                //Da ton tai nhung da hoan thanh bai test HOAC chua ton tai trong local storage
                getNewQuestionData(position_in_local_storage)
            }
        }
        displayTestUnFinishedInit();
    });

})



function generateUnfinishedTest(current_data) {
    // Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
    var html = ''
    var length_answered = current_data.answers.length;
    console.log('length answer', length_answered, $('.tab').length)
    // gen lai html,
    if(current_data.html_arr.length == 0){
        current_data.type = current_data.type.toString()
        console.log(current_data.type, topic, test_level)
        if (current_data.type === '1'){
            current_data.question_data.forEach( function(question_data_element, index) {
                current_data.html_arr.push(renderAudio(question_data_element.question, question_data_element.answers,
                    question_data_element.question_image, question_data_element.answer_image))
            });
        } else if (current_data.type === '2'){
            max_images_in_column = current_data.question_data[0].length
            current_data.question_data.forEach( function(question_data_element, index) {
                current_data.html_arr.push(renderPosition(question_data_element[0],question_data_element[1], "unlock-selection", "none"))
            });
        } else if(current_data.type === '4') {
            current_data.question_data.forEach( function(question_data_element, index) {
                current_data.html_arr.push(renderIQ(question_data_element.question, question_data_element.answers))
            });
        } else if(current_data.type === '5') {
            current_data.question_data.forEach( function(question_data_element, index) {
                current_data.html_arr.push(renderNoQuestion(question_data_element.answers))
            });
        }else {
            current_data.question_data.forEach( function(question_data_element, index) {
                current_data.html_arr.push(render(question_data_element.question, question_data_element.answers))
            });

        }
    }
        /**
     * Gen html : Chỗ này code thừa cực nhiều, cần sửa
     */
    if (type == '1'){
        //Audio
        for (var i = 0; i<length_answered; i++) {
            html += '<div class="tab" style="display: none;"><img class="question audio-image" src="'+current_data.question_data[i].question_image+'" alt="">'+
                '<audio src="'+ current_data.question_data[i].question +'" class="audio"></audio>' + '<div class="answer">'
            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {
                // console.log('i,j', j, i, current_data.answer[i])
                if (j == current_data.answers[i]) {
                    answer += '<label class="col-md-4 col-xs-4 col-lg-4" style="opacity: 1">' +
                        '<input type="radio" style="z-index: -1;" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img class="audio-image" src="' + current_data.question_data[i].answer_image + '" alt="">' +
                        '<audio src="'+ current_data.question_data[i].answers[j] +'" class="audio"></label>'
                } else {
                    answer += '<label class="col-md-4 col-xs-4 col-lg-4" style="opacity: 0.3"> ' +
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

    else if(type == '2') {
        max_images_in_column = this_question.question_data[0][0].length
        all_line_array = current_data.answers.slice();
        // console.log('all line array init', all_line_array)

        for (var i = 0; i<length_answered; i++) {
            var question_left = current_data.question_data[i][0]
            var question_right = current_data.question_data[i][1]

            html += renderPosition(question_left, question_right, "clicked-img", "none")

            // this_question.current_index++
        }
        // if (length_answered < total_question) {
        //     html += renderPosition(current_data.question_data[length_answered][0], current_data.question_data[length_answered][1], "unlock-selection", "block")
        // }
    }

    else if(type == '4') {
        for (var i = 0; i<length_answered; i++) {
            html += '<div class="tab" style="display: none;"><img class="question iq-question" src="'+current_data.question_data[i].question+'" alt="">'
                + "<div class='answer'>" ;

            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {
                let layout = 'col-md-4';
                if(current_data.question_data[i].answers.length == 8){
                   layout = 'col-md-3';
                }
                if (j == current_data.answers[i]) {
                    answer += '<label class="iq-answer '+ layout +'" style="opacity: 1">' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                } else {
                    answer += '<label class="iq-answer '+ layout +'" style="opacity: 0.3"> ' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                }
            }

            html += answer
            html += '</div></div>'
            // currentTab++
        }
        // console.log(current_data.question_data[length_answered])
    }
    else if(type == '5') {
        for (var i = 0; i<length_answered; i++) {
            html += '<div class="tab" style="display: none;">'
                + "<div class='answer'>" ;

            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {
                if (j == current_data.answers[i]) {
                    answer += '<label class="no-question-answer col-md-6" style="opacity: 1">' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                } else {
                    answer += '<label class="no-question-answer col-md-6" style="opacity: 0.3"> ' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                }
            }

            html += answer
            html += '</div></div>'
            // currentTab++
        }
        // console.log(current_data.question_data[length_answered])
    } else {
        for (var i = 0; i<length_answered; i++) {
            var style = '';
            var classMemory = '';
            if (topic == '6') {
                style = 'style ="display: none;"';
                classMemory = 'memoryImage';
            }
            html += '<div class="tab" style="display: none;"><img class="question ' + classMemory + '" '+style+' src="'+current_data.question_data[i].question+'" alt="">'
                + '<button class="start_memory" style ="display: none;">Start</button>' +
                "<div class='answer'>" ;

            var answer = ""
            for (var j = 0; j < current_data.question_data[i].answers.length; j++) {
                // console.log('i,j', j, i, current_data.answer[i])
                if (j == current_data.answers[i]) {
                    answer += '<label class="col-md-4" style="opacity: 1">' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" checked data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
                        '</label>'
                } else {
                    answer += '<label class="col-md-4" style="opacity: 0.3"> ' +
                        '<input type="radio" value="' + current_data.question_data[i].answers[j] + '" data-position="'+j+'" hidden>' +
                        '<img src="' + current_data.question_data[i].answers[j] + '" alt="">' +
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
    // console.log(current_data.html_arr, 'tuss');
    /**
     * Show line of last Tab Position
     */
    if (type == '2' && length_answered == total_question) {
        setTimeout(function () {
            line_array.length = 0
            var old_line_array = current_data.answers[length_answered-1]
            gen_line_from_localstorage(old_line_array, length_answered-1)
        }, 1000)

    }

    // if(current_data.level_temp > minLv){
    //     setTimeToChange(current_data.level_temp - 1 , current_data.current_index + 1 );
    // }
}

function getNewQuestionData(position) {
    $.ajax({
        method: "POST",
        url: "/get-list-question",
        data: {
            'type' : type,
            'topic': topic,
            'level': test_level
        },
        success: function (response) {
            if (response.status === 1) {
                if (typeof testing_data == 'undefined') {
                    login = $('#testForm').data('login');
                    guest_id = '0';
                    if (login) {
                        guest_id = '-1';
                    }
                    testing_data = {
                        level: test_level,
                        question: [],
                        received_free_package_status: 0,
                        guest_id: guest_id
                    };
                }
                // save html -> localstorage
                html_arr = [];
                response.type = response.type.toString()
                console.log(response.type, topic, test_level)
                if (response.type === '1'){
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(renderAudio(question_data_element.question, question_data_element.answers,
                            question_data_element.question_image, question_data_element.answer_image))
                    });
                } else if (response.type === '2'){
                    max_images_in_column = response.question_data[0].length
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(renderPosition(question_data_element[0],question_data_element[1], "unlock-selection", "none"))
                    });
                } else if(response.type === '4') {
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(renderIQ(question_data_element.question, question_data_element.answers))
                    });
                } else if(response.type === '5') {
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(renderNoQuestion(question_data_element.answers))
                    });
                }else {
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(render(question_data_element.question, question_data_element.answers))
                    });

                }
                var curriculum_ids = [];
                curriculum_ids.push(response.curriculum_id)
                // console.log('tudm')
                console.log(response.result)
                // console.log('tudmend')
                this_question = {
                    type: response.type,
                    topic: topic,
                    question_data: response.question_data,
                    status: 0,
                    answers: [],
                    current_index: 0,
                    level_temp: 1,
                    html_arr : html_arr,
                    curriculum_ids : curriculum_ids,
                    customer_testing_id : '',
                    result: response.result,
                    count_correct_answer: 0
                };
                if (typeof testing_data !== 'undefined') {
                    if (position == -1 ) {
                        position_this_question = testing_data.question.length
                        testing_data.question.push(this_question);
                    } else {
                        testing_data.question[position] = this_question
                    }
                } else {

                }


                total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));


                //Display html all
                var html_gen_all = ''+renderIntroduction()
                html_arr.forEach( function(html_arr_element, index) {
                    html_gen_all += html_arr_element;
                });
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("prevBtn").style.display = "none";
                $('#prevBtn').before(html_gen_all)

                displayTest()
                player = new Plyr('#player');

                current_index_max = this_question.current_index;
                // showTab(this_question.current_index)
                // if(this_question.level_temp > minLv){
                //     setTimeToChange(this_question.level_temp - 1 , this_question.current_index + 1 );
                // }

            } else {
                console.log("error", response)
            }

        }

    })
}

function displayTest() {
    $('.startBtn').css('opacity', '0').css('z-index', '-1');
    waiting_element_load()
}

$(document).on('click', '#introduction_button', function(event){
    event.preventDefault()
    play_sound("/sounds/oh-really.mp3")
    player.stop()
    $('.video_introduction').css('display', 'none')
    showTab(this_question.current_index)
    return false
})

function showTab(current_index) {
    //Badge
    // console.log("currentTab", currentTab)
    $('.badge').text((current_index+1)+' / '+total_question)
    //Button
    for (let i = 0; i < tab_number.length; i++) {
        tab_number[i].style.display = "none";
    }
    if (topic == '8') {
        tab_number[current_index].style.display = "block";
        $(tab_number[current_index]).addClass('animated rubberBand')
    } else {
        tab_number[current_index].style.display = "flex";
        $(tab_number[current_index]).addClass('animated fadeInDown faster')

    }

    // console.log(n, currentTab, total_question)

    if (current_index === 0) {
        // if(current_index_max > current_index ) {
        //     document.getElementById("nextBtn").style.display = "inline";
        // } else {
        //     document.getElementById("nextBtn").style.display = "none";
        // }
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "none";

    }else if (current_index === total_question - 1) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("submitBtn").style.display = "inline";

    }
    else {
        document.getElementById("submitBtn").style.display = "none";
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("nextBtn").style.display = "inline";
        // if(current_index_max > current_index ) {
        //     document.getElementById("nextBtn").style.display = "inline";
        // } else {
        //     document.getElementById("nextBtn").style.display = "none";
        // }
    }

}

// đặt time check trả lời sau 20s
setTimeToChange = (test_level, indexIncorrect) => {
    timeToChange = setTimeout(() => {
        changeDynamicQuestionTimeOut(test_level, indexIncorrect)
    }, 20000)
}
// dừng check trả lời 20s
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
            'type' : type,
            'topic': topic,
            'level': test_level,
            'index' : indexIncorrect
        },
        success: function (response) {
            if (response.status === 1) {
                // ghep cau hoi vao this_question
                if(response.question_data.length != 0){
                    // add curriculum_ids
                    if(!this_question.curriculum_ids.includes(response.curriculum_id)) {
                        this_question.curriculum_ids.push(response.curriculum_id)
                    }
                    // gen lai html
                    //
                    html_arr_gen_again = [];
                    if (type === '1'){
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderAudio(question_data_element.question, question_data_element.answers,
                                question_data_element.question_image, question_data_element.answer_image))
                        });
                    } else if (type === '2'){
                        max_images_in_column = response.question_data[0].length
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderPosition(question_data_element[0],question_data_element[1], "unlock-selection", "none"))
                        });
                    } else if (type === '4') {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderIQ(question_data_element.question, question_data_element.answers))
                        });
                    } else if (type === '5') {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderNoQuestion(question_data_element.answers))
                        });
                    } else {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(render(question_data_element.question, question_data_element.answers))
                        });

                    }

                    Array.prototype.splice.apply(this_question.html_arr, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(html_arr_gen_again));
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    Array.prototype.splice.apply(this_question.result, [indexIncorrect, this_question.result.length - indexIncorrect ].concat(response.result));
                    var tab_ = $('.tab');
                    var html_gen_again = '';
                    console.log(tab_, indexIncorrect)

                    for(var i = indexIncorrect; i < this_question.question_data.length; i++ ){
                        tab_.eq(i).remove();
                    }
                    html_arr_gen_again.forEach( function(gen_again_element, index) {
                        html_gen_again += gen_again_element;
                    });

                    $('#prevBtn').before(html_gen_again)
                    waiting_element_load()
                }
                // trừ lv khi sai
                this_question.level_temp = test_level
                this_question.count_correct_answer = 0

                localStorage.setItem('testing', JSON.stringify(testing_data));
                console.log('current: ', indexIncorrect, 'data', this_question)
                showTab(indexIncorrect)

                flagChange = 0;
                // if(this_question.level_temp > minLv){
                //     // console.log('vào đây dynamyc')
                //     setTimeToChange(this_question.level_temp - 1 , indexIncorrect + 1 );
                // }
            } else {
                console.log("error", response)
            }

        }

    })
}

let changeDynamicQuestionTimeOut = (test_level, indexIncorrect) => {
    $.ajax({
        method: "POST",
        url: "/get-list-less-level-question",
        data: {
            'type' : type,
            'topic': topic,
            'level': test_level,
            'index' : indexIncorrect
        },
        success: function (response) {
            if (response.status === 1) {
                if(response.question_data.length != 0){
                    // add curriculum_ids
                    if(!this_question.curriculum_ids.includes(response.curriculum_id)){
                        this_question.curriculum_ids.push(response.curriculum_id)
                    }
                    // gen lai html

                    html_arr_gen_again = [];
                    if (type === '1'){
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderAudio(question_data_element.question, question_data_element.answers,
                                question_data_element.question_image, question_data_element.answer_image))
                        });
                    } else if (type === '2'){
                        max_images_in_column = response.question_data[0].length
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderPosition(question_data_element[0],question_data_element[1], "unlock-selection", "none"))
                        });
                    } else if (type === '4') {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderIQ(question_data_element.question, question_data_element.answers))
                        });
                    } else if (type === '5') {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(renderNoQuestion(question_data_element.answers))
                        });
                    }
                    else {
                        response.question_data.forEach( function(question_data_element, index) {
                            html_arr_gen_again.push(render(question_data_element.question, question_data_element.answers))
                        });
                    }
                    console.log('html_arr_gen_again ', html_arr_gen_again)
                    // console.log('indexIncorrect ', indexIncorrect)
                    // console.log('current_index ', this_question.current_index)
                    // console.log('this_questionlength ', this_question.question_data.length)

                    Array.prototype.splice.apply(this_question.html_arr, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(html_arr_gen_again));
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    Array.prototype.splice.apply(this_question.result, [indexIncorrect, this_question.result.length - indexIncorrect ].concat(response.result));
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
    play_sound("/sounds/oh-really.mp3")
    // if(type == "3" && buttonMemoryChecked == false){
    //     // MEMORY
    //     return false;
    // }
    if(type == '2') {
        // POSITION
        nextButtonPosition()
    } else {
        // AUDIO AND NORMAL
        nextButton()
    }
    // for auto next
    $('#nextBtn').prop('disabled', false);
    disabled_label_click = false;
}

function prev() {
    play_sound("/sounds/oh-really.mp3")

    // if(type == '3' && buttonMemoryChecked == false)
    // {
    //     // MEMORY
    //     return false;
    // }
    var x = document.getElementsByClassName("tab");

    if (type == '2') {
        // POSITION
        if (line_array) {
            for (var i=0; i < line_array.length; i++) {
                line_array[i][2].hide()
            }
        }

        x[this_question.current_index].style.display = "none";

        var old_line_array = this_question.answers.pop()

        console.log('Old line array : ' ,old_line_array);
        console.log('line array', line_array)
        console.log('current tag ', this_question.current_index)
        let temp_arr = [...line_array]

        if (all_line_array.length > this_question.current_index) {
            all_line_array[this_question.current_index] = temp_arr
        } else {
            all_line_array.push(temp_arr)
        }

        this_question.current_index += -1;
        while(this_question.answers.length > this_question.current_index){
            this_question.answers.pop()
        }
        //Save into local storage
        localStorage.setItem('testing', JSON.stringify(testing_data))
        showTab(this_question.current_index);

        //Show line already in prev
        var currentTab = this_question.current_index
        gen_line_from_localstorage(old_line_array, currentTab)

    } else {
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



}

function render(question, answers) {
    let answerHTML = "";
    answers.forEach(function (el, index) {
        answerHTML += "<label class='col-md-4 col-xs-4 col-lg-4'>" +
            "<input type='radio' value='"+el+index+"' data-position='"+index+"' hidden>" +
            "<img src='" + el + "' alt=''>" +
            "</label>"

    });
    normal = 'style="display : none;"';
    classMemory = ''
    if(topic === "6" ){
        style = 'style="display : none;"';
        normal = 'style="display : inline-block;"'
        classMemory = 'memoryImage'
    }

    let content = "<div class='tab' style='display: none;'>" +
        "<img class='question "+ classMemory +"' src='" + question + "' alt=''>" +
        '<button class="start_memory"'+normal+' >Start</button>'+
        "<div class='answer'"+ style +">" +
        answerHTML +
        "</div>" +
        "</div>";
    return content
}
function renderIQ(question, answers) {
    let layout = 'col-md-4 ';
    if(answers.length == 8) {
        layout = 'col-md-3';
    }
    let answerHTML = "";
    answers.forEach(function (el, index) {
        answerHTML += "<label class='iq-answer "+ layout +"'>" +
            "<input type='radio' value='"+el+index+"' data-position='"+index+"' hidden>" +
            "<img src='" + el + "' alt=''>" +
            "</label>"

    });
    let content = "<div class='tab' style='display: none;'>" +
        "<img class='question iq-question' src='" + question + "' alt=''>" +
        "<div class='answer'>" +
        answerHTML +
        "</div>" +
        "</div>";
    return content
}

function renderNoQuestion(answers) {
    let layout = 'col-md-6';
    // if(answers.length == 8) {
    //     layout = 'col-md-3';
    // }
    let answerHTML = "";
    answers.forEach(function (el, index) {
        answerHTML += "<label class='no-question-answer "+ layout +"'>" +
            "<input type='radio' value='"+el+index+"' data-position='"+index+"' hidden>" +
            "<img src='" + el + "' alt=''>" +
            "</label>"

    });
    let content = "<div class='tab' style='display: none;'>" +
        // "<img class='question iq-question' src='" + question + "' alt=''>" +
        "<div class='answer'>" +
        answerHTML +
        "</div>" +
        "</div>";
    return content
}

function renderIntroduction() {
    var html = "<div class='video_introduction' style='display: flex; flex-direction: column' >"+
        "<div class='plyr__video-embed video-player' id='player' data-plyr-provider='youtube' data-plyr-embed-id='ddaEtFOsFeM' >" +
        "    <iframe width='560' height='315' src='https://www.youtube.com/embed/ddaEtFOsFeM' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"+
        "</div><button class='introduction-button linear-button' id='introduction_button'>Done</button></div>"
    return html
}

function renderAudio(question, answers, question_image, answer_image){
    var answerHTML = "";
    answers.forEach(function(el, index) {
        answerHTML += "<label class='col-md-4 col-xs-4 col-lg-4'>" +
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

$(document).on('click', '.start_memory', function(event) {
    event.preventDefault();
    current_index = this_question.current_index;
    var x = document.getElementsByClassName("tab");
    $(x[current_index]).children('.answer').css('display' ,'block');
    $(x[current_index]).children('img').css('display' ,'none');
    $(x[current_index]).children('.start_memory').css('display' ,'none');
    play_sound("sounds/plucky.mp3")
});

function hideQuestion(current_index){
    var x = document.getElementsByClassName("tab");
    $(x[current_index]).children('answer').css('visibility' ,'hidden');

    timerId = setInterval(function() {
        if (timeout == 0) {
            $(x[current_index]).children('img').css('visibility' ,'hidden')
            $(x[current_index]).children('.answer').css('visibility' ,'visible')
            $(x[current_index]).children('.countDownTimer').html( 'Time out!')
            buttonMemoryChecked = true;
            clearTimeout(timerId);
            timeout = 5;
            $('button').removeClass('countdown-disabled')

        } else {
             $(x[current_index]).children('.countDownTimer').html( timeout + ' seconds');
            timeout--;
            $('button').addClass('countdown-disabled')
        }
    }, 1000);
}

function displayTestUnFinishedInit() {

    let gen_html = '';
    let style = '';
    for (var i=1; i<9; i++) {
        if (list_test_finished.indexOf(i) > -1) {
            gen_html += '<div class="col-md-3 col-xs-3 col-lg-3 below-list-test-f" style="opacity:0.4;">' + array_svg[i-1] + '</div>'
        } else {
            gen_html += '<div class="col-md-3 col-xs-3 col-lg-3 below-list-test-f">' + array_svg[i-1] + '</div>'
        }

    }
    $('.below-test .row-list-below-test').append(gen_html)
}

function nextButton() {
    // let just_answer = tab_number[currentTab].querySelector('input:checked')
    let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')

    if (typeof $(just_answer).val() === 'undefined'){
        // Chua tra loi hide
        // console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
        errorAnswer();
    } else {
        tab_number[this_question.current_index].style.display = "none";
        this_question.current_index += 1
        // console.log ("number tab", tab_number.length-1, "tab current", this_question.current_index)

        //Lock and save answered
        just_answer = just_answer.data('position')

        // checkAnswer

        this_question.answers.push(just_answer)
        console.log("push here", this_question.answers)
        if (current_index_max >= this_question.current_index){
            showTab(this_question.current_index);
        } else {
            if(parseInt(topic) != 3) {
                countCorrectAnswer(just_answer);
            }
            current_index_max += 1;
            // dừng việc check20s tránh đuplicate lặp timeout
            // stopTimeToChange()
            // compare answer
            if(type != '4' && this_question.count_correct_answer == 5 && this_question.level_temp == 1){
                // dung 5 cau trong 1 level 1
                changeDynamicQuestion(this_question.level_temp + 1 , this_question.current_index)
            } else if(type != '4' && this_question.count_correct_answer == 3 && this_question.level_temp == 2){
                // dung 3 cau level 2
                changeDynamicQuestion(this_question.level_temp + 1 , this_question.current_index)
            } else if(type != '4' && doubleFalse && this_question.level_temp != 1 ){
                // sai 2 cau lien tiep khac level 1
                changeDynamicQuestion(this_question.level_temp -1 , this_question.current_index)
            } else {
                //Save into local storage
                localStorage.setItem('testing', JSON.stringify(testing_data))

                showTab(this_question.current_index)
                flagChange = 0
                // sau khi render 20s k next thì sẽ => câu hỏi thấp
                // if(this_question.level_temp > minLv){
                //     // lv hết => câu đang làm chậm => curren_index này chậm => truyền vào câu thứ i sai : chính là currne_index + 1;
                //     setTimeToChange(this_question.level_temp - 1 , this_question.current_index + 1 );
                // }
            }
        }
    }
}

function updateDataTesting(login)
{
    guest_id = testing_data.guest_id;
    if(login || guest_id != '0') {
        if(typeof type != 'undefined' &&  type === '2' ){
           convertAnswersPosition()
        }
        // get local storate
        let data = {
            'local_storage_this_question' : this_question,
            'level' : test_level,
            'guest_id' : guest_id,
            'received_free_package_status' : testing_data.received_free_package_status,
        };
        if (login) {
            url = '/updateDataTesting'
        } else {
            url = '/updateGuestDataTesting'
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: data,
        })
        .done(function(response) {
            // update testing_id đã có trên db,
            if(response.customer_testing_id == ''){
                // somethings wrongs
            }else {
                console.log(response);
                this_question.customer_testing_id  = response.customer_testing_id;
                localStorage.setItem('testing', JSON.stringify(testing_data));
            }
        })
        .fail(function(response) {
            console.log(response);
        })
    }
}

function continueTest()
{

    if(!list_test_finished.includes(parseInt(topic))){
        list_test_finished.push(parseInt(topic))
    }
    // check 8 bài free
    if(parseInt(topic) < 9){
        var next_quiz = 0;
        var count_free_package = 0;
        for (var i=1; i<9; i++) {
            if (list_test_finished.indexOf(i) < 0) {
                //Chua thi
                next_quiz = i
                break;
            }
            count_free_package++;
        }
        // console.log(list_test_finished);

        // now use variables topic_arr_free[]
        if (count_free_package == 8 && list_test_finished.indexOf(parseInt(topic)) > 0) {
            // share
            Swal.fire({
                title: '<strong>Share to receive your result. Share on <u> Facebook</u></strong>',
                type: 'success',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-facebook"></i> Share on Facebook',
                cancelButtonText:'Cancel',
                // backdrop: `rgba(255, 255, 255, 0.61)`,
                backdrop: `rgba(0,0,0,0.1)`,
            }).then((result) => {
                if(result.value) {
                    FB.ui({
                        method: 'share',
                        href: 'https://beta.catopiana.com/',
                        layout: 'button_count',
                        size: 'large',
                    }, function(response){
                        if (response && !response.error_code) {
                            window.location.href = '/free-test-results'
                        } else {
                            Swal.fire({
                                title: 'Notice',
                                text: "You haven't share on Facebook",
                                display: 'flex',
                                // backdrop: `rgba(255, 255, 255, 0.61)`,
                                backdrop: `rgba(0,0,0,0.1)`,
                            })
                        }
                  });
                }
            });
        }
        if (next_quiz > 0) {
            // làm xong bài khác bài free
            var next_topic = topic_arr_free[next_quiz - 1];
            window.location.href = '/'+next_topic;
        }
    } else {
        free_package_arr = [9,10,11,12];
        if(free_package_arr.includes(parseInt(topic)) ) {
            window.location.href = '/free-packages';
        } else {
            window.location.href = '/paid-packages';
        }
    }
}

resetData = () => {
    if(received_free_package_status == 1) {
        // clear data except với 4 curri tặng, chưa rõ cách giải quyết, cần dữ liệu chuẩn để thêm vào localstorage -> xác định được các test thuộc loại nào
        testing_data.question.splice(8, 4);
        localStorage.setItem('testing', JSON.stringify(testing_data));
    } else {
        localStorage.removeItem('testing');
    }
}

redirectAfterSubmit = (topic) => {
    if(topic < 9) {
        flag = 0;
        var count_free_package = 0;
        for (var i=1; i<9; i++) {
            if (list_test_finished.indexOf(i) < 0) {
                // có bài Chưa thi
                flag = 1
                break;
            }
            count_free_package++;
        }
        if (flag == 1) {
            window.location.href = '/continue-test/'+topic
        }
        // now use variables topic_arr_free[]
        if (count_free_package == 8) {
            //save database guest and redirect
            if(testing_data.guest_id == '0' ) {
                saveGuestTesting();
            } else {
                window.location.href = '/congratulation'
            }
        }
    } else {
        // free_package_arr = [9,10,11,12];
        // if(free_package_arr.includes(topic) ) {
        //     window.location.href = '/free-packages';
        // } else {
        //     window.location.href = '/paid-packages';
        // }
        window.location.href = '/continue-test/'+topic
    }
}

errorAnswer = () => {
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'Please answer the question!',
        backdrop: `rgba(255, 255, 255, 0.61)`,
        animation: false,
        customClass: {
            popup: 'swal-pop-custom-error animated tada',
            title:'swal-title-custom-error',
            content: 'swal-content-custom-error',
            confirmButton:'swal-button-custom-error'
        }
    });
}

$(document).on('click', '.button-below.next', function(event) {
    event.preventDefault();
        $('html,body').animate({
            scrollTop: $('.row-list-below-test').offset().top - $('.row-list-below-test').height()/2
        }, 200);
});

$(document).on('click', '.button-below.previous', function(event) {
    event.preventDefault();
    window.location.href = $(this).data('url');
});

countCorrectAnswer = (just_answer) => {
    position_current_answer = this_question.answers.length -1 ;
    if(checkAnswer(just_answer, this_question, position_current_answer)) {
        this_question.count_correct_answer += 1;
        doubleFalse = false;
    } else {
        if(position_current_answer > 0 && !checkAnswer(this_question.answers[position_current_answer -1], this_question, position_current_answer - 1) ) {
            doubleFalse = true;
        }
    }
    console.log('anss:', this_question.count_correct_answer )
    console.log('doubleFalse:', doubleFalse )
}

checkAnswer = (just_answer, this_question, position_current_answer) => {
    if(just_answer == this_question.result[position_current_answer]) {
        return true;
    }

    return false;
}

saveGuestTesting = () => {
    console.log('create new guest')
    if(typeof type != 'undefined' &&  type === '2' ){
       convertAnswersPosition()
    }

    testing_data.question.forEach((question) => {
        question.html_arr.length = 0;
    })

    let data = {
        'local_storage' : testing_data
    };
    $.ajax({
        url: '/save-guest-testing',
        type: 'POST',
        dataType: 'json',
        data: data,
    })
    .done(function(response) {
        localStorage.removeItem('testing');
        if(response.local_storage === undefined || response.local_storage.length == 0){
            alert('somethings wrongs');
        }else {
            changeLocalStorage(response.local_storage, response.guest_id);
            window.location.href = '/congratulation';
        }
    })
    .fail(function(response) {
        console.log(response);
        alert('somethings wrongs');
    });
}
