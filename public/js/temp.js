let currentTab = 0;
let tab_number = document.getElementsByClassName("tab");
let total_question = 0
var type = $('#type').val()
// console.log('type', type, type == '2')

var this_question
var position_this_question
var buttonMemoryChecked = true;

var style = '';
var timeout = 5;
var timerId = null;
$('.badge').text((currentTab+1)+' / '+total_question)

let fakeAnswer = 0;
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
                        localStorage.setItem('testing', JSON.stringify(testing_data));
                        total_question = parseInt(this_question.question_data.length)
                        //Display
                        displayTest()

                        if (type === '1'){
                            renderAudio(this_question.question_data[0].question, this_question.question_data[0].answers,
                                this_question.question_data[0].question_image, this_question.question_data[0].answer_image)
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
            currentTab++
        }
        if (length_answered < total_question) {
            html += renderAudio(current_data.question_data[length_answered].question, current_data.question_data[length_answered].answers,
                current_data.question_data[length_answered].question_image,current_data.question_data[length_answered].answer_image)
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



    $('.tab').remove()
    $('.button-np').before(html)
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
    tab_number[n].style.display = "flex";
    // console.log(n, currentTab, total_question)
    if (n === 0) {
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "none";

    }else if (n === total_question - 1) {
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
                if(response.question_data.length != 0){
                    Array.prototype.splice.apply(this_question.question_data, [indexIncorrect, this_question.question_data.length - indexIncorrect ].concat(response.question_data));
                    testing_data.question[position] = this_question
                }
                // trừ lv khi sai 
                level_temp = test_level
                // console.log('test :' )
                // console.log(this_question)
                

                // total_question = parseInt(this_question.question_data.length)
                localStorage.setItem('testing', JSON.stringify(testing_data));

                if (type == '1'){
                    //Audio
                    renderAudio(this_question.question_data[indexIncorrect].question, this_question.question_data[indexIncorrect].answers,
                        this_question.question_data[indexIncorrect].question_image, this_question.question_data[indexIncorrect].answer_image)
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
                    testing_data.question[position] = this_question
                }
                 // trừ lv khi timeout 
                    level_temp = test_level
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
    let just_answer = $('.tab').eq(currentTab).find('input:checked')
    if (typeof $(just_answer).val() === 'undefined'){
        //Chua tra loi
        // console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
        alert("Please answer the question")
    } else {
        // dừng việc check20s tránh đuplicate lặp timeout
        stopTimeToChange()

        tab_number[currentTab].style.display = "none";
        currentTab += 1
        console.log ("number tab", tab_number.length-1, "tab current", currentTab)

        //Lock and save answered
        just_answer = just_answer.data('position')
        console.log("push here")
        this_question.answers.push(just_answer)

        if (tab_number.length-1 >= currentTab){
            //An prev xong quay thi => ko can render html them nua
            showTab(currentTab);
        } else {
            // compare answer
            console.log(flagChange) 
            console.log(level_temp)
            if(typeof(level_temp) === 'undefined'){
                level_temp = parseInt(testing_data.level);
            }
            if(just_answer != fakeAnswer && level_temp > minLv && flagChange == 0 ){
                console.log('w answer');
                changeDynamicQuestion(level_temp -1 , this_question.answers.length)
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
                flagChange = 0 
                // sau khi render 20s k next thì sẽ => câu hỏi thấp
                if(level_temp > minLv){
                    setTimeToChange(level_temp - 1 , currentTab );
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
    x[currentTab].style.display = "none";

    currentTab += -1
    console.log("pop here")
    this_question.answers.pop()
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
