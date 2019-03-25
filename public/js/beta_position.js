let currentTab = 0;
let total_question = 0
var type = $('#type').val()
let tab_number, fakeAnswer
if (type == '8') {
    tab_number = document.getElementsByClassName("position-tab");
    fakeAnswer = [[0,0], [1,1], [2,2]];
} else {
    tab_number = document.getElementsByClassName("tab");
    fakeAnswer = 0;
}
// console.log('type', type, type == '2')

var this_question
var position_this_question
var buttonMemoryChecked = true;

var style = '';
var timeout = 5;
var timerId = null;
$('.badge').text((currentTab+1)+' / '+total_question)

let minLv = 4;
let timeToChange;
let flagChange = 0;

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
                        localStorage.setItem('testing', JSON.stringify(testing_data));
                        total_question = parseInt(this_question.question_data.length)
                        //Display
                        displayTest()

                        if (type === '1'){
                            renderAudio(this_question.question_data[0].question, this_question.question_data[0].answers,
                                this_question.question_data[0].question_image, this_question.question_data[0].answer_image)
                        } else if (type === '8'){
                            renderPosition(this_question.question_data[0][0],this_question.question_data[0][1])
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
    console.log('length answer', current_data.answers)

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
        for (var i = 0; i<length_answered; i++) {
            var question_left = current_data.question_data[i][0]
            var question_right = current_data.question_data[i][1]

            html += '<div class="position-tab" style="display: none">' +
                '                            <div class="matching row" id="test-area">' +
                '                                <div class="div-l col-lg-3 col-md-3 col-sm-3 col-md-offset-1" style="padding-right: 0" >' +
                '                                    <ul class="column-left" data-position="0">' +
                '                                        <li class="list-l-item">' +
                '                                            <img class="image-point-l clicked-img" src="'+question_left[0]+'" data-index="1">' +
                '                                        </li>' +
                '                                        <li class="list-l-item" >' +
                '                                            <img class="image-point-l clicked-img" src="'+question_left[1]+'" data-index="2">' +
                '                                        </li>' +
                '                                        <li class="list-l-item" >' +
                '                                            <img class="image-point-l clicked-img" src="'+question_left[2]+'" data-index="3">' +
                '                                        </li>' +
                '                                    </ul>' +
                '                                </div>' +
                '                                <div class="div-m col-lg-4 col-md-4 col-sm-4"  style="padding: 0" ></div>' +
                '                                <div class="div-r col-lg-3 col-md-3 col-sm-3" style="padding-left: 0" >' +
                '                                    <ul class="column-right" data-position="1">' +
                '                                        <li class="list-l-item">' +
                '                                            <img class="image-point-l clicked-img" src="'+question_right[0]+'" data-index="1">' +
                '                                        </li>' +
                '                                        <li class="list-l-item" >' +
                '                                            <img class="image-point-l clicked-img" src="'+question_right[1]+'" data-index="2">' +
                '                                        </li>' +
                '                                        <li class="list-l-item" >' +
                '                                            <img class="image-point-l clicked-img" src="'+question_right[2]+'" data-index="3">' +
                '                                        </li>' +
                '                                    </ul>' +
                '                                </div>' +
                '                                <div class="col-lg-1"></div>' +
                '                            </div>' +
                '                            <div class="clearfix"></div>' +
                '                        </div>'

            for (var j=0; j<3; j++) {
                // console.log(current_data.answers[i][j], i, j)
                // current_data.answers[i][j][2].hide()
            }
            currentTab++
        }

        if (length_answered < total_question) {
            html += renderPosition(current_data.question_data[length_answered][0], current_data.question_data[length_answered][1])
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
        $('.position-tab').remove()
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
                Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                console.log('test :' )
                console.log(this_question)
                testing_data.question[position] = this_question
                // trừ lv khi sai
                testing_data.level = test_level;

                // total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));

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
                // console.log(response.question_data)
                // ghep cau hoi vao this_question
                Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                // console.log('test :' )
                // console.log(this_question)
                testing_data.question[position] = this_question
                // trừ lv khi timeout
                testing_data.level = test_level;

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
    if (type == "8") {
        //Position
        if (line_array.length == 3) {
            tab_number[currentTab].style.display = "none";
            currentTab += 1
            console.log ("number tab", tab_number.length-1, "tab current", currentTab)

            //Lock and save answered
            let just_answer = line_array
            console.log ("just_answer", line_array)
            line_array = []
            let compare_just_answer = [
                [just_answer[0][0],just_answer[0][1]],
                [just_answer[1][0],just_answer[1][1]],
                [just_answer[2][0],just_answer[2][1]],
            ]

            this_question.answers.push(just_answer)
            just_answer[0][2].hide()
            just_answer[1][2].hide()
            just_answer[2][2].hide()

            if (tab_number.length-1 >= currentTab){
                //An prev xong quay lai tab nay thi` => ko can render html them nua
                showTab(currentTab);
                //Show line
                all_line_array[currentTab-1] = just_answer
                line_array = all_line_array[currentTab]
                console.log('all', all_line_array, currentTab)

                for (var j=0; j<all_line_array[currentTab].length; j++) {
                    all_line_array[currentTab][j][2].show()
                    // $('.column-left img[data-index='+all_line_array[currentTab-1][j][0]+']').addClass('clicked-img').removeClass('unlock-selection')
                    // $('.column-right img[data-index='+all_line_array[currentTab-1][j][1]+']').addClass('clicked-img').removeClass('unlock-selection')
                }

            } else {
                // compare answer
                all_line_array.push(just_answer)
                console.log('allpush', all_line_array)


                console.log(flagChange)
                if(compare_just_answer.compare(fakeAnswer) && parseInt(testing_data.level) > minLv && flagChange == 0 ){
                    console.log('w answer');
                    changeDynamicQuestion(parseInt(testing_data.level) -1 , this_question.answers.length)
                } else {
                    //Save into local storage
                    // console.log (testing_data, 'test')
                    localStorage.setItem('testing', JSON.stringify(testing_data))

                    renderPosition(this_question.question_data[currentTab][0], this_question.question_data[currentTab][1])

                    showTab(currentTab)
                    // sau khi render 20s k next thì sẽ => câu hỏi thấp
                    if(parseInt(testing_data.level) > minLv){
                        setTimeToChange(testing_data.level - 1 , currentTab );
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
            console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
            alert("Please answer the question")
        } else {
            // dừng việc check20s tránh đuplicate lặp timeout
            stopTimeToChange()

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
                // compare answer
                console.log(flagChange)
                if(just_answer != fakeAnswer && parseInt(testing_data.level) > minLv && flagChange == 0 ){
                    console.log('w answer');
                    changeDynamicQuestion(parseInt(testing_data.level) -1 , this_question.answers.length)
                } else {
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
                    // sau khi render 20s k next thì sẽ => câu hỏi thấp
                    if(parseInt(testing_data.level) > minLv){
                        setTimeToChange(testing_data.level - 1 , currentTab );
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
        var x = document.getElementsByClassName("position-tab");
    } else {
        var x = document.getElementsByClassName("tab");
    }
    if (line_array) {
        for (var i=0; i< line_array.length; i++) {
            line_array[i][2].hide()
            // $('.column-left img[data-index='+line_array[i][0]+']').removeClass('clicked-img').addClass('unlock-selection')
            // $('.column-right img[data-index='+line_array[i][1]+']').removeClass('clicked-img').addClass('unlock-selection')
        }

    }
    x[currentTab].style.display = "none";
    var old_line_array = this_question.answers.pop()
    all_line_array[currentTab] = line_array
    line_array = old_line_array
    currentTab += -1;

    if (type == '8') {
        //Show line already in prev
        console.log ('all', all_line_array)
        for (var j=0; j<3; j++) {
            old_line_array[j][2].show()
        }
    }
    //Save into local storage
    localStorage.setItem('testing', JSON.stringify(testing_data))

    showTab(currentTab);

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

    let content = "<div class='tab' style='display: flex;'>" +
        "<img class='question' src='/test/images/" + question + "' alt=''>" +
        '<p class="countDownTimer"></p>' +
        "<div class='answer'"+ style +">" +
        answerHTML +
        "</div>" +
        "</div>";

    $('.button-np').before(content);
    // console.log("conent", content)
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
    $('.button-np').before(content);
    return content
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

function renderPosition(question_left, question_right) {
    var html = ''
    html += '<div class="position-tab" style="display: block">' +
        '                            <div class="matching row" id="test-area">' +
        '                                <div class="div-l col-lg-3 col-md-3 col-sm-3 col-md-offset-1" style="padding-right: 0" >' +
        '                                    <ul class="column-left" data-position="0">' +
        '                                        <li class="list-l-item">' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_left[0]+'" data-index="1">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_left[1]+'" data-index="2">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_left[2]+'" data-index="3">' +
        '                                        </li>' +
        '                                    </ul>' +
        '                                </div>' +
        '                                <div class="div-m col-lg-4 col-md-4 col-sm-4"  style="padding: 0" ></div>' +
        '                                <div class="div-r col-lg-3 col-md-3 col-sm-3" style="padding-left: 0" >' +
        '                                    <ul class="column-right" data-position="1">' +
        '                                        <li class="list-l-item">' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_right[0]+'" data-index="1">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_right[1]+'" data-index="2">' +
        '                                        </li>' +
        '                                        <li class="list-l-item" >' +
        '                                            <img class="image-point-l unlock-selection" src="'+question_right[2]+'" data-index="3">' +
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