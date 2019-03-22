

let currentTab = 0;
let tab_number = document.getElementsByClassName("tab");
let total_question = 0
var type = $('#type').val()
var this_question
var position_this_question

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
                    if (response.status === 1) {
                        //Save local storage
                        testing_data = {
                            level: level,
                            question: []
                        };

                        position_this_question = 0

                        this_question = {
                            type: parseInt(type),
                            question_data: response.question_data,
                            current_index: 0,
                            answer: [],
                            status: 0,
                        };

                        testing_data.question.push(this_question);
                        localStorage.setItem('testing', JSON.stringify(testing_data));
                        total_question = parseInt(this_question.question_data.length)
                        //Display
                        displayTest()
                        render(this_question.question_data[0].question, this_question.question_data[0].answer)
                        showTab(currentTab)


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
            if (current_data.type === parseInt(type) ) {
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
// Chua hoan thanh bai test => gen html dua tren cau hoi va cac dap an da dien truoc do
function generateUnfinishedTest(current_data) {
    var html = ''
    var length_answered = current_data.answer.length;
    // console.log('length answer', length_answered)

    for (var i = 0; i<length_answered; i++) {
        html += '<div class="tab" style="display: none;"><img class="question" src="/test/images/'+current_data.question_data[i].question+'" alt=""><div class="answer">'
        var answer = ""
        for (var j = 0; j < current_data.question_data[i].answer.length; j++) {
            var opacity = 1;
            // console.log('i,j', j, i, current_data.answer[i])
            if (j == current_data.answer[i]) {
                answer += '<label class="col-6" style="opacity: 0.3">' +
                    '<input type="radio" value="' + current_data.question_data[i].answer[j] + '" checked data-position="'+j+'">' +
                    '<img src="/test/images/' + current_data.question_data[i].answer[j] + '" alt="">' +
                    '</label>'
            } else {
                answer += '<label class="col-6" style="opacity: 1"> ' +
                    '<input type="radio" value="' + current_data.question_data[i].answer[j] + '" data-position="'+j+'">' +
                    '<img src="/test/images/' + current_data.question_data[i].answer[j] + '" alt="">' +
                    '</label>'
            }



        }

        html += answer
        html += '</div></div>'
        currentTab++
    }

    html += render(current_data.question_data[length_answered].question, current_data.question_data[length_answered].answer)
    $('.tab').remove()
    $('.button-np').before(html)
    // $.each($('label[style="opacity: 0.3"] > input'), function(index,value){
    //     console.log (value)
    //     $(value).prop('checked', true)
    // })
    // console.log ('html', html)
    displayTest()
    showTab(currentTab)
}


function getNewQuestionData(position) {
    $.ajax({
        method: "POST",
        url: "/get-list-question",
        data: {
            'type': 1,
            'level': test_level
        },
        success: function (response) {
            if (response.status === 1) {
                this_question = {
                    type: parseInt(type),
                    question_data: response.question_data,
                    status: 0,
                    answer: [],
                    current_index: 0
                };
                if (position === -1) {
                    testing_data.question.push(this_question);
                } else {
                    testing_data.question[position] = this_question
                }

                localStorage.setItem('testing', JSON.stringify(testing_data));

                //Display
                displayTest()


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
    }, 700)
}

function showTab(n) {
    for (let i = 0; i < tab_number.length; i++) {
        tab_number[i].style.display = "none";
    }
    tab_number[n].style.display = "flex";
    console.log(n, currentTab, total_question)
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

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}

function currentQ(n) {
    currentTab = n;
    showTab(currentTab);
}

function next(n) {
    // let just_answer = tab_number[currentTab].querySelector('input:checked')
    let just_answer = $('.tab').eq(currentTab).find('input:checked')
    console.log(tab_number[currentTab], currentTab, tab_number, just_answer, just_answer.val())
    if (typeof $(just_answer).val() === 'undefined'){
        //Chua tra loi
        alert("Chua tra loi")
    } else {
        tab_number[currentTab].style.display = "none";
        currentTab += 1
        if (tab_number.length > currentTab){
            showTab(currentTab)
        } else {
            //Lock and save answered
            just_answer = just_answer.data('position')
            console.log(this_question)
            this_question.answer.push(just_answer)
            //Save into local storage
            // console.log (testing_data, 'test')
            localStorage.setItem('testing', JSON.stringify(testing_data))

            //Check finish
            render(this_question.question_data[currentTab].question, this_question.question_data[currentTab].answer)
            showTab(currentTab)
        }

    }

}

function prev() {
    var x = document.getElementsByClassName("tab");
    x[currentTab].style.display = "none";

    // reder html
    currentTab += -1;
    showTab(currentTab);

}

function render(question, answers) {
    let answerHTML = "";
    answers.forEach(function (el, index) {
        answerHTML += "<label class='col-6'>" +
            "<input type='radio' name='' value='"+el+"' data-position='"+index+"'>" +
            "<img src='/test/images/" + el + "' alt=''>" +
            "</label>"

    });
    let content = "<div class='tab' style='display: flex;'>" +
        "<img class='question' src='/test/images/" + question + "' alt=''>" +
        "<div class='answer'>" +
        answerHTML +
        "</div>" +
        "</div>";

    $('.button-np').before(content);

    return content
}

$(document).on('click', 'label', function (event) {
    event.preventDefault();
    $(this).css('opacity', '1');
    $(this).children('input').attr('checked', true);
    $(this).siblings('label').each(function (index, el) {
        $(el).children('input').attr('checked', false);
        $(el).css('opacity', '0.3');
    });
});
