
/**
 * Handle here
 */
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

/**
 * 1. Submit Event
 * 2. Click Image in topic Position
 */
$(function(){
    $('#testForm').on('submit', function(event){
        //update local storage
        event.preventDefault()
        if (type == '2') {
            // POSITION
            return submitPosition()
        }
        let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')
        if (typeof $(just_answer).val() === 'undefined'){
            //Chua tra loi
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Please answer the question!',
            })
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
            // let login = false;
            var login = $(this).data('login');
            showDialogScore(correct, total_question, login )
            //Display test not finished
            displayTestUnFinishedAfterSubmit()
        }
    })
})

/**
 * Click start button to load data from server
 */
$('.startBtn').click(async function () {
    //Check local storage
    const level_obj = {'4': 'level 4','5': 'level 5','6': 'level 6' }
    if (typeof(test_level) === 'undefined') {
        await swal.fire({
            title: 'Please add level',
            input: 'radio',
            inputPlaceholder: 'Chose your level',
            confirmButtonText: 'Look up',
            input: 'radio',
            inputOptions: level_obj,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to choose your level!'
                }
            },
            showLoaderOnConfirm: true,
            preConfirm: (level) => {
                test_level = level
                return getNewQuestionData(position_in_local_storage)
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    }

    else {
        //Check history
        let flag = 1; 
        for (var i = 0; i < testing_data.question.length; i++) {
            this_question = testing_data.question[i];
            // console.log('current', current_data)

            if (this_question.topic == topic) {
                // Da ton tai bai test type nay trong lich su
                position_this_question = i
                console.log('current', this_question)
                // this_question = current_data
                total_question = parseInt(this_question.question_data.length)
                generateUnfinishedTest(this_question)
                flag = -1;
                break

            }
        }
        if (flag !== -1) {
            //Da ton tai nhung da hoan thanh bai test HOAC chua ton tai trong local storage
            getNewQuestionData(position_in_local_storage)
        }
    }

});

function generateUnfinishedTest(current_data) {
    // Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
    var html = ''
    var length_answered = current_data.answers.length;
    console.log('length answer', length_answered)
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
        }
        else {
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
        if (length_answered < total_question) {
            html += renderPosition(current_data.question_data[length_answered][0], current_data.question_data[length_answered][1], "unlock-selection", "block")
        }
    }

    else {
        for (var i = 0; i<length_answered; i++) {
            var visibility = '';
            if (topic == '6') {
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

    if(topic === '6'){
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
            'topic': topic,
            'level': test_level
        },
        success: function (response) {
            if (response.status === 1) {
                if (typeof testing_data == 'undefined') {
                    testing_data = {
                        level: test_level,
                        question: []
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
                }
                else {
                    response.question_data.forEach( function(question_data_element, index) {
                        html_arr.push(render(question_data_element.question, question_data_element.answers))
                    });

                }
                var curriculum_ids = [];
                curriculum_ids.push(response.curriculum_id)

                this_question = {
                    type: response.type,
                    topic: topic,
                    question_data: response.question_data,
                    status: 0,
                    answers: [],
                    current_index: 0,
                    level_temp: test_level,
                    html_arr : html_arr,
                    curriculum_ids : curriculum_ids,
                    customer_testing_id : ''
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
                if(topic === '6'){
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
    if (topic == '8') {
        tab_number[current_index].style.display = "block";
    } else {
        tab_number[current_index].style.display = "flex";
    }

    // console.log(n, currentTab, total_question)

    if (current_index === 0) {
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
            'topic': topic,
            'level': test_level,
            'index' : indexIncorrect
        },
        success: function (response) {
            if (response.status === 1) {
                // console.log(response.question_data)
                // ghep cau hoi vao this_question
                // html_arr_gen_again = [];
                if(response.question_data.length != 0){
                    // add curriculum_ids
                    if(!this_question.curriculum_ids.includes(response.curriculum_id)){
                        this_question.curriculum_ids.push(response.curriculum_id)
                    }
                    // gen laij html
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
                    console.log(tab_, indexIncorrect)

                    for(var i = indexIncorrect; i < this_question.question_data.length; i++ ){
                        tab_.eq(i).remove();
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
                if(topic === '6'){
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
    $.ajax({
        method: "POST",
        url: "/get-list-less-level-question",
        data: {
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
    if(type == "3" && buttonMemoryChecked == false){
        // MEMORY
        return false;
    }
    if(type == '2') {
        // POSITION
        nextButtonPosition()
    } else {
        // AUDIO AND NORMAL
        nextButton()
    }

}

function prev() {
    if(type == '3' && buttonMemoryChecked == false)
    {
        // MEMORY
        return false;
    }
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

        //Save into local storage
        localStorage.setItem('testing', JSON.stringify(testing_data))

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

        showTab(this_question.current_index);

        //Show line already in prev
        line_array.length = 0
        var currentTab = this_question.current_index

        for (var j = 0; j < 3; j++) {
            if (jQuery.isEmptyObject(old_line_array[j][2])) {
                //Create line
                var left = old_line_array[j][0]
                var right = old_line_array[j][1]
                var left_element = document.getElementsByClassName('tab')[currentTab]
                    .getElementsByClassName('column-left')[0].getElementsByClassName('clicked-img')[left]
                var right_element = document.getElementsByClassName('tab')[currentTab]
                    .getElementsByClassName('column-right')[0].getElementsByClassName('clicked-img')[right]

                //Push to line array
                line_array.push([$(left_element).data('index'), $(right_element).data('index'), createLine(left_element, right_element)])

            } else {
                line_array = [...old_line_array]
                old_line_array[j][2].show()
            }
        }

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
        answerHTML += "<label class='col-md-6'>" +
            "<input type='radio' value='"+el+index+"' data-position='"+index+"' hidden>" +
            "<img src='/test/images/" + el + "' alt=''>" +
            "</label>"

    });

    if(topic === "6" ){
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

function displayTestUnFinishedAfterSubmit() {
    if(!list_test_finished.includes(parseInt(topic))){
        list_test_finished.push(parseInt(topic))
    }
    console.log(list_test_finished);
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

function nextButton() {
    // let just_answer = tab_number[currentTab].querySelector('input:checked')
    let just_answer = $('.tab').eq(this_question.current_index).find('input:checked')

    if (typeof $(just_answer).val() === 'undefined'){
        // Chua tra loi hide
        // console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Please answer the question!',
        })    
    } else {
        tab_number[this_question.current_index].style.display = "none";
        this_question.current_index += 1
        // console.log ("number tab", tab_number.length-1, "tab current", this_question.current_index)

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
                if(topic === '6'){
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

function showDialogScore(correct, total, login = false) {
    Swal.fire({
        title: ` \n Your score: `+ correct +' / '+total,
        text: 'You have completed this test!',
        background: 'orange',
        display: 'flex',
    }).then(() => {
        // console.log(login, !login)
        if(!login){
            $('#modal-after-answertoppic').modal();
        } else {
            // Login roi => Update du lieu len
            updateDataTesting()
            
        }
    });
}

function updateDataTesting()
{
    if (type === '2') {
        this_question.answers.forEach(function(value, index) {
            for (var i=0; i<3; i++){
                value[i].splice(2,1)
            }
        });
    }
    // get local storate
    var data = {
        'local_storage_this_question' : this_question,
        'level' : test_level
    };
    $.ajax({
        url: '/updateDataTesting',
        type: 'POST',
        dataType: 'json',
        data: data,
    }).done(function(response) {
            // update testing_id đã có trên db,
            if(response.customer_testing_id == ''){
                // somethings wrongs
            }else {
                console.log(response);
                this_question.customer_testing_id  = response.customer_testing_id;
                localStorage.setItem('testing', JSON.stringify(testing_data));               
                if(response.givePackage == true){
                    Swal.fire({
                        title: 'Notice',
                        text: 'You have completed all free test! You will be receviced free package!',
                        background: 'orange',
                        display: 'flex',
                    });

                } else {
                    $('#modal-after-answertoppic-logined').modal();
                }

            }
        })
        .fail(function(response) {
            console.log(response);
        })
}

// updateThisQuestion = (response) =>{
//     this_question.customer_testing_id  = response.customer_testing_id;
//     console.log(this_question);
//     localStorage.setItem('testing', JSON.stringify(testing_data));
// }

$(document).on('click', '.continues-test', function(event) {
    event.preventDefault();
    if(!list_test_finished.includes(parseInt(topic))){
        list_test_finished.push(parseInt(topic))
    }
    var next_quiz = 0;
    for (var i=1; i<9; i++) {
        if (list_test_finished.indexOf(i) < 0) {
            //Chua thi
            next_quiz = i
            break;
        }
    }
    // call server last time when have many curriculum
    // now use variables topic_arr_free[]
    if(next_quiz == 0){
        window.location.href = '/'
    } else {
        var next_topic = topic_arr_free[next_quiz - 1];
        window.location.href = '/'+next_topic;
    }
    
});
