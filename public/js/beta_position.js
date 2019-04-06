let currentTab = 0;
let total_question = 0
var type = $('#type').val()
let tab_number, fakeAnswer
if (type == '8') {
    tab_number = document.getElementsByClassName("tab");
    fakeAnswer = [[0,0], [1,1], [2,2]];
} else {
    tab_number = document.getElementsByClassName("tab");
    fakeAnswer = 0;
}

var this_question
var position_this_question
var buttonMemoryChecked = true;

var style = '';
var timeout = 5;
var timerId = null;
$('.badge').text((currentTab+1)+' / '+total_question)

let minLv = 1;
let timeToChange;
let flagChange = 0;
let level_temp;

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
        let just_answer = $('.tab').eq(currentTab).find('input:checked')
        if (typeof $(just_answer).val() === 'undefined'){
            //Chua tra loi
            alert("Please answer the question")
        } else {
            swal.fire({
                title: 'Please enter your name below..',
                input: 'text',
                inputPlaceholder: '...',
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                background: 'orange',
                display: 'flex',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            resolve()
                        } else {
                            resolve('You need to enter name:)')
                        }
                    })
                }
            }).then((name) => {
                if (name.value) {
                    //Lock and save answered
                    just_answer = just_answer.data('position')
                    this_question.answers.push(just_answer)
                    this_question.status = 1
                    //Save into local storage
                    localStorage.setItem('testing', JSON.stringify(testing_data));

                    let candidate_answers = this_question.answers;
                    console.log('answer', candidate_answers, this_question, just_answer)

                    let correct = candidate_answers.filter(answer => answer == 0).length
                    Swal.fire({
                        title: `${name.value} \n Your score: `+correct+'/'+total_question,
                        text: 'Please write down your account below:',
                        background: 'orange',
                        display: 'flex',
                    })

                    //Display test not finished
                    displayTestUnFinishedAfterSubmit()
                } else {

                }
            })
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

                        this_question = {
                            type: type,
                            question_data: response.question_data,
                            current_index: 0,
                            answers: [],
                            status: 0,
                        };

                        testing_data.question.push(this_question);
                        // localStorage.setItem('testing', JSON.stringify(testing_data));
                        total_question = parseInt(this_question.question_data.length)
                        //Display
                        displayTest()

                        if (type === '1'){
                            renderAudio(this_question.question_data[0].question, this_question.question_data[0].answers,
                                this_question.question_data[0].question_image, this_question.question_data[0].answer_image)
                        } else if (type === '8'){
                            renderPosition(this_question.question_data[0][0],this_question.question_data[0][1], "unlock-selection", "none")
                        }
                        else {
                            render(this_question.question_data[0].question, this_question.question_data[0].answers)
                        }
                        showTab(currentTab)

                        if(type == '6'){
                            //Memory
                            if(timerId != null){
                                clearTimeout(timerId);
                                timeout = 5;
                            }
                            buttonMemoryChecked = false;
                            hideQuestion(currentTab);
                        }

                        // check khi start lan dau qua 20s chuyen cau hoi lv thap
                        if(level > minLv){
                            setTimeToChange(level - 1 , 1)
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
            this_question = testing_data.question[i];
            // console.log('current this question', this_question)

            if (this_question.type == type ) {
                // Da ton tai bai test type nay trong lich su
                position_this_question = i
                if (this_question.status === 0) {
                    // Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
                    console.log('current', this_question)
                    // this_question = current_data
                    total_question = parseInt(this_question.question_data.length)
                    generateUnfinishedTest(this_question)
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
    console.log('Local storage answers', current_data.answers)

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
            currentTab++
        }
        if (length_answered < total_question) {
            html += renderAudio(current_data.question_data[length_answered].question, current_data.question_data[length_answered].answers,
                current_data.question_data[length_answered].question_image,current_data.question_data[length_answered].answer_image)
        }

    }
    else if(type == '8') {
        all_line_array = current_data.answers.slice();
        // console.log('all line array init', all_line_array)

        for (var i = 0; i<length_answered; i++) {
            var question_left = current_data.question_data[i][0]
            var question_right = current_data.question_data[i][1]

            html += renderPosition(question_left, question_right, "clicked-img", "none")

            currentTab++
        }

        if (length_answered < total_question) {
            html += renderPosition(current_data.question_data[length_answered][0], current_data.question_data[length_answered][1], "unlock-selection", "block")
        }
    }
    else {
        for (var i = 0; i<length_answered; i++) {
            var visibility
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
            currentTab++
        }
        // console.log(current_data.question_data[length_answered])
        if (length_answered < total_question){
            html += render(current_data.question_data[length_answered].question, current_data.question_data[length_answered].answers)
        }
    }

    if (type == '8') {
        $('.tab').remove()
        $('#prevBtn').before(html)
    } else {
        $('.tab').remove()
        $('.button-np').before(html)
    }

    displayTest()
    showTab(currentTab)

    if(type === '6'){
        //Memory
        if(timerId != null){
            clearTimeout(timerId);
            timeout = 5;
        }
        buttonMemoryChecked = false;
        hideQuestion(currentTab);
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
                this_question = {
                    type: type,
                    question_data: response.question_data,
                    status: 0,
                    answers: [],
                    current_index: 0
                };
                if (position == -1) {
                    position_this_question = testing_data.question.length
                    testing_data.question.push(this_question);
                } else {
                    testing_data.question[position] = this_question
                }

                total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));

                //Display
                displayTest()

                if (type == '1'){
                    //Audio
                    renderAudio(this_question.question_data[0].question, this_question.question_data[0].answers,
                        this_question.question_data[0].question_image, this_question.question_data[0].answer_image)
                }else if (type === '8'){
                    renderPosition(this_question.question_data[0][0],this_question.question_data[0][1])
                }
                else {
                    render(this_question.question_data[0].question, this_question.question_data[0].answers)
                }
                showTab(currentTab)

                if(type === '6'){
                    //Memory
                    if(timerId != null){
                        clearTimeout(timerId);
                        timeout = 5;
                    }
                    buttonMemoryChecked = false;
                    hideQuestion(currentTab);
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

function showTab(n) {
    //Badge
    // console.log("currentTab", currentTab)
    $('.badge').text((currentTab+1)+' / '+total_question)
    //Button
    for (let i = 0; i < tab_number.length; i++) {
        tab_number[i].style.display = "none";
    }
    if (type == '8') {
        tab_number[n].style.display = "block";
    } else {
        tab_number[n].style.display = "flex";
    }
    // console.log(n, currentTab, total_question)
    if (n === 0) {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "none";

    }else if (n === total_question - 1) {
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
                if(response.question_data.length != 0){
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    console.log('test :' )
                    console.log(this_question)
                    // testing_data.question[position] = this_question
                }
                // trừ lv khi sai
                level_temp = test_level;

                // total_question = parseInt(this_question.question_data.length)
                // localStorage.setItem('testing', JSON.stringify(testing_data));

                if (type == '1'){
                    //Audio
                    renderAudio(this_question.question_data[indexIncorrect].question, this_question.question_data[indexIncorrect].answers,
                        this_question.question_data[indexIncorrect].question_image, this_question.question_data[indexIncorrect].answer_image)
                }else if (type == '8'){
                    renderPosition(this_question.question_data[indexIncorrect][0],this_question.question_data[indexIncorrect][1])
                }
                else {
                    render(this_question.question_data[indexIncorrect].question, this_question.question_data[indexIncorrect].answers)
                }

                if(type === '6'){
                    //Memory
                    if(timerId != null){
                        clearTimeout(timerId);
                        timeout = 5;
                    }
                    buttonMemoryChecked = false;
                    hideQuestion(currentTab);
                }
                showTab(indexIncorrect)
                flagChange = 0;
                if(level_temp > minLv){
                    console.log('vào đây dynamyc')
                    setTimeToChange(level_temp - 1 , currentTab );
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
                     // ghep cau hoi vao this_question
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    // testing_data.question[position] = this_question
                }
                 // trừ lv khi timeout
                    level_temp = test_level
                // console.log(response.question_data)

                // total_question = parseInt(this_question.question_data.length)
                // localStorage.setItem('testing', JSON.stringify(testing_data));
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
    if (type == "8") {
        //Position
        console.log("condition line array / just answer", line_array)
        if (line_array.length == 3) {
            tab_number[currentTab].style.display = "none";
            currentTab += 1

            //Lock and save answered
            let just_answer = [...line_array]

            let compare_just_answer = [
                [just_answer[0][0],just_answer[0][1]],
                [just_answer[1][0],just_answer[1][1]],
                [just_answer[2][0],just_answer[2][1]],
            ]

            // Hide all line previous position tab
            line_array[0][2].hide()
            line_array[1][2].hide()
            line_array[2][2].hide()

            this_question.answers.push(just_answer)
            localStorage.setItem('testing', JSON.stringify(testing_data))


            if (tab_number.length-1 >= currentTab){
                //An prev xong quay lai tab nay thi` => ko can render html them nua
                console.log("show tab, current tab", currentTab)
                showTab(currentTab);
                //Show line
                all_line_array[currentTab-1] = just_answer
                line_array = [...all_line_array[currentTab]]
                console.log('all line array', all_line_array, currentTab)

                for (var j=0; j<all_line_array[currentTab].length; j++) {
                    all_line_array[currentTab][j][2].show()
                }

            } else {
                // compare answer
                all_line_array.push(just_answer)
                console.log('all push', all_line_array)
                console.log('next, answers', this_question.answers)
                line_array.length = 0

                // console.log(flagChange)
                if(compare_just_answer.compare(fakeAnswer) && parseInt(testing_data.level) > minLv && flagChange == 0 ){
                    console.log('w answer');
                    // changeDynamicQuestion(parseInt(testing_data.level) -1 , this_question.answers.length)
                } else {
                    // Save into local storage
                    // console.log (testing_data, 'test')
                    localStorage.setItem('testing', JSON.stringify(testing_data))

                    renderPosition(this_question.question_data[currentTab][0], this_question.question_data[currentTab][1], "unlock-selection", "block")

                    showTab(currentTab)
                    // sau khi render 20s k next thì sẽ => câu hỏi thấp
                    if(parseInt(testing_data.level) > minLv){
                        // setTimeToChange(testing_data.level - 1 , currentTab );
                    }
                }
            }
        } else {
            alert("Please answer the question")
        }
    }
    else {
        // let just_answer = tab_number[currentTab].querySelector('input:checked')
        let just_answer = $('.tab').eq(currentTab).find('input:checked')
        if (typeof $(just_answer).val() === 'undefined'){
            //Chua tra loi
            // console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
            alert("Please answer the question")
        } else {
            // dừng việc check20s tránh đuplicate lặp timeout


            tab_number[currentTab].style.display = "none";
            currentTab += 1
            console.log ("number tab", tab_number.length-1, "tab current", currentTab)

            //Lock and save answered
            just_answer = just_answer.data('position')
            this_question.answers.push(just_answer)

            if (tab_number.length-1 >= currentTab){
                //An prev xong quay thi => ko can render html them nua
                showTab(currentTab);
            } else {
                stopTimeToChange()
                // compare answer
                console.log(flagChange)
                 if(typeof(level_temp) === 'undefined'){
                level_temp = parseInt(testing_data.level);
                }
                if(just_answer != fakeAnswer && level_temp > minLv && flagChange == 0 ){
                    console.log('w answer');
                    changeDynamicQuestion(level_temp -1 , this_question.answers.length)
                }  else {
                    //Save into local storage
                    // console.log (testing_data, 'test')
                    localStorage.setItem('testing', JSON.stringify(testing_data))

                    if (type == '1'){
                        //Audio
                        renderAudio(this_question.question_data[currentTab].question, this_question.question_data[currentTab].answers,
                            this_question.question_data[currentTab].question_image, this_question.question_data[currentTab].answer_image)
                    }
                    else {
                        render(this_question.question_data[currentTab].question,this_question.question_data[currentTab].answers)
                    }

                    if(type === '6'){
                        //Memory
                        if(timerId != null){
                            clearTimeout(timerId);
                            timeout = 5;
                        }
                        buttonMemoryChecked = false;
                        hideQuestion(currentTab);
                    }
                    showTab(currentTab)
                    flagChange = 0
                    // sau khi render 20s k next thì sẽ => câu hỏi thấp
                    if(level_temp > minLv){
                        setTimeToChange(level_temp - 1 , currentTab );
                    }
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
    if (type == '8') {
        var x = document.getElementsByClassName("tab");
    } else {
        var x = document.getElementsByClassName("tab");
    }

    if (line_array) {
        for (var i=0; i < line_array.length; i++) {
            line_array[i][2].hide()
        }
    }

    x[currentTab].style.display = "none";

    var old_line_array = this_question.answers.pop()

    //Save into local storage
    localStorage.setItem('testing', JSON.stringify(testing_data))

    // console.log('Old line array : ' ,old_line_array);
    // console.log('line array', line_array)
    console.log('current tag ', currentTab)
    let temp_arr = [...line_array]

    if (all_line_array.length > currentTab) {
        all_line_array[currentTab] = temp_arr
    } else {
        all_line_array.push(temp_arr)
    }

    currentTab += -1;

    showTab(currentTab);

    if (type == '8') {
        //Show line already in prev
        line_array.length = 0

        for (var j=0; j<3; j++) {
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
    }
    console.log('all line array after all prev ', all_line_array)
}


function hideQuestion(currentTab){
    var x = document.getElementsByClassName("tab");
    $(x[currentTab]).children('answer').css('visibility' ,'hidden');

    timerId = setInterval(function() {
        if (timeout == 0) {
            $(x[currentTab]).children('img').css('visibility' ,'hidden')
            $(x[currentTab]).children('.answer').css('visibility' ,'visible')
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

function renderPosition(question_left, question_right, class_img, tab_css) {
    var html = ''
    var tab_class = 'image-point-l '+class_img
    html += '<div class="tab" style="display: '+tab_css+'">' +
        '                            <div class="matching row" id="test-area">' +
        '                                <div class="div-l col-lg-3 col-md-3 col-sm-3 col-md-offset-1" style="padding-right: 0" >' +
        '                                    <ul class="column-left" data-position="0">' +
        '                                        <li class="list-l-item">' +
        '                                            <img class="'+tab_class+'" src="'+question_left[0]+'" data-index="0">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="'+tab_class+'" src="'+question_left[1]+'" data-index="1">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="'+tab_class+'" src="'+question_left[2]+'" data-index="2">' +
        '                                        </li>' +
        '                                    </ul>' +
        '                                </div>' +
        '                                <div class="div-m col-lg-4 col-md-4 col-sm-4"  style="padding: 0" ></div>' +
        '                                <div class="div-r col-lg-3 col-md-3 col-sm-3" style="padding-left: 0" >' +
        '                                    <ul class="column-right" data-position="1">' +
        '                                        <li class="list-l-item">' +
        '                                            <img class="'+tab_class+'" src="'+question_right[0]+'" data-index="0">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="'+tab_class+'" src="'+question_right[1]+'" data-index="1">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="'+tab_class+'" src="'+question_right[2]+'" data-index="2">' +
        '                                        </li>' +
        '                                    </ul>' +
        '                                </div>' +
        '                                <div class="col-lg-1"></div>' +
        '                            </div>' +
        '                            <div class="clearfix"></div>' +
        '                        </div>'

    $('#prevBtn').before(html);
    return html
}

Array.prototype.compare = function(array) {
    if (!array) {
        return false;
    }
    if (this.length !== array.length) {
        return false;
    }
    for (var i = 0, l = this.length; i < l; i++) {
        if (this[i] instanceof Array && array[i] instanceof Array) {
            if (!this[i].compare(array[i])) {
                return false;
            }
        }
        else if (this[i] !== array[i]) {
            return false;
        }
    }
    return true;
}

function createLine(left_element, right_element) {
    var line = new LeaderLine(
        LeaderLine.pointAnchor(left_element, {
            x: left_element.width,
            y: left_element.height/2
        })
        ,
        LeaderLine.pointAnchor(right_element, {
            x: 0,
            y: right_element.height/2
        })
        , { size: 4, dropShadow: true, startSocket: 'right', endSocket: 'left', startPlug: 'arrow3', endPlug: 'arrow3', gradient: {
                startColor: 'rgb(17, 148, 51)',
                endColor: 'rgb(17, 148, 51)'
            }
        }
    );

    return line

}
