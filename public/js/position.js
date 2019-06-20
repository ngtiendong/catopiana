var line_array = []
var all_line_array = []

// Variable to solve prev button

$(document).on('click', '.list-l-item img', function (e) {
    play_sound("sounds/demand.mp3")
    // $('.list-l-item img').removeClass('animated rubberBand')
    // $(this).addClass('animated rubberBand');
    e.preventDefault()
    if ($(this).hasClass("clicked-img")) {
        // Already click
        // 1. Check line of this element => if has => remove line and class "clicked-img" of both in 2 column as well
        var this_img = this
        if (line_array.length > 0) {
            //Check left or right column
            var flag_column_position = parseInt($(this_img).closest('ul').data('position'))
            line_array.forEach(function (value, index) {
                console.log(index, value, flag_column_position)
                // console.log(value[flag_column_position], $(this_img).data('index'))
                if (value[flag_column_position] == $(this_img).data('index')) {
                    //remove data array line
                    line_array.splice(index, 1)
                    //remove svg line
                    value[2].remove()
                    //Remove clicked img class
                    // console.log('img[data-index='+value[0]+']', $('img[data-index='+value[0]+']'))
                    $(this_img).closest('.matching').find('.column-left img[data-index=' + value[0] + ']').removeClass('clicked-img').addClass('unlock-selection')
                    $(this_img).closest('.matching').find('.column-right img[data-index=' + value[1] + ']').removeClass('clicked-img').addClass('unlock-selection')
                }
            })
        }
        // 2. If not line => just remove class "clicked-img" of this element


    } else {
        //Remove class clicked in same column
        $(this).closest('ul').find('.clicked-img.unlock-selection').removeClass('clicked-img')
        //Add clicked this image
        $(this).addClass('clicked-img')
    }

    // Check clicked on 2 column to create line
    // Class unlink-selection to avoid case that 2 img which had already line before
    var elements_click = $(this).closest('.matching').find('.clicked-img.unlock-selection')
    if (elements_click.length == 2) {
        //Create line
        var start = ($(this).closest('ul').attr('class') == 'column-left' ? 1 : 0)
        var left_element = document.getElementsByClassName('clicked-img unlock-selection')[0]
        var right_element = document.getElementsByClassName('clicked-img unlock-selection')[1]

        //Push to line array
        line_array.push([$('.column-left .clicked-img.unlock-selection').data('index'),
            $('.column-right .clicked-img.unlock-selection').data('index'), createLine(left_element, right_element, start)])
        //Delete unlock-selection class
        $(elements_click).each(function () {
            $(this).removeClass('unlock-selection')
        })
    }
    if (line_array.length == this_question.question_data[this_question.current_index]['left'].length) {
        autonext()
    }
})

function nextButtonPosition () {
    //Position
    console.log("condition line array / just answer", line_array)
    if (line_array.length == this_question.question_data[this_question.current_index]['left'].length) {
        tab_number[this_question.current_index].style.display = "none";
        this_question.current_index += 1
        var currentTab = parseInt(this_question.current_index)

        //Lock and save answered
        let just_answer = [...line_array]

        let compare_just_answer = [];


        // Hide all line previous position tab
        for (var i = 0; i < this_question.question_data[this_question.current_index-1]['left'].length;  i++) {
            compare_just_answer.push([just_answer[i][0],just_answer[i][1]])
            line_array[i][2].hide()
        }
        this_question.answers.push(just_answer)
        console.log('answers', this_question.answers)
        localStorage.setItem('testing', JSON.stringify(testing_data))

        console.log("show tab, current tab", currentTab)
        if (all_line_array.length-1 >= currentTab){
            //An prev xong quay lai tab nay thi` => ko can render html them nua

            showTab(currentTab);
            //Show line
            all_line_array[currentTab-1] = just_answer
            line_array = [...all_line_array[currentTab]]
            console.log('all line array', all_line_array, currentTab)

            for (var j=0; j<all_line_array[currentTab].length; j++) {
                all_line_array[currentTab][j][2].show()
            }

        } else {
            current_index_max += 1
            // check answer
            if(parseInt(type) != -1) {
                countCorrectAnswerPosition(just_answer)
            }
             // dừng việc check20s tránh đuplicate lặp timeout
            // stopTimeToChange()
            // compare answer
            all_line_array.push(just_answer)
            console.log('all push', all_line_array)
            console.log('next, answers', this_question.answers)
            line_array.length = 0

            // console.log(flagChange)
            if(this_question.count_correct_answer == 5 && this_question.level_temp == 1){
                // dung 5 cau trong 1 level 1
                changeDynamicQuestion(this_question.level_temp + 1 , this_question.current_index)
            } else if(this_question.count_correct_answer == 3 && this_question.level_temp == 2){
                // dung 3 cau level 2
                changeDynamicQuestion(this_question.level_temp + 1 , this_question.current_index)
            } else if(doubleFalse && this_question.level_temp != 1 ){
                // sai 2 cau lien tiep khac level 1
                changeDynamicQuestion(this_question.level_temp -1 , this_question.current_index)
            } else {
                // Save into local storage
                console.log (testing_data, 'test')
                localStorage.setItem('testing', JSON.stringify(testing_data))

                showTab(currentTab)
                // sau khi render 20s k next thì sẽ => câu hỏi thấp
                // if(parseInt(testing_data.level) > minLv){
                //     setTimeToChange(testing_data.level - 1 , currentTab + 1 );
                // }
            }
        }
    } else {
        errorAnswer();
    }
}

function renderPosition(question_left, question_right, class_img, tab_css) {
    var html = '';
    var tab_class = 'image-point-l '+class_img;
    var li_left = '', li_right = '';
    for (var i = 0; i < question_left.length; i++) {
        li_left +=   '<li class="list-l-item">' +
                        '<img class="'+tab_class+'" src="'+question_left[i]+'" data-index="'+ i +'">' +
                    '</li>';
        li_right +=   '<li class="list-l-item">' +
                        '<img class="'+tab_class+'" src="'+question_right[i]+'" data-index="'+ i +'">' +
                    '</li>';

    }
    html += '<div class="tab" style="display: '+tab_css+'">' +
        '                            <div class="matching row" id="test-area">' +
        '                                <div class="div-l col-lg-3 col-md-3 col-sm-3 col-md-offset-1" style="padding-right: 0" >' +
        '                                    <ul class="column-left" data-position="0">' +
                                                li_left +
        '                                    </ul>' +
        '                                </div>' +
        '                                <div class="div-m col-lg-4 col-md-4 col-sm-4"  style="padding: 0" ></div>' +
        '                                <div class="div-r col-lg-3 col-md-3 col-sm-3" style="padding-left: 0" >' +
        '                                    <ul class="column-right" data-position="1">' +
                                                li_right +
        '                                    </ul>' +
        '                                </div>' +
        '                                <div class="col-lg-1"></div>' +
        '                            </div>' +
        '                            <div class="clearfix"></div>' +
        '                        </div>'

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

function gen_line_from_localstorage(old_line_array, current_tab) {
    line_array.length = 0
    for (var j = 0; j < old_line_array.length; j++) {
        if (jQuery.isEmptyObject(old_line_array[j][2])) {
            //Create line
            var left = old_line_array[j][0]
            var right = old_line_array[j][1]
            var left_element = document.getElementsByClassName('tab')[current_tab]
                .getElementsByClassName('column-left')[0].getElementsByClassName('clicked-img')[left]
            var right_element = document.getElementsByClassName('tab')[current_tab]
                .getElementsByClassName('column-right')[0].getElementsByClassName('clicked-img')[right]

            //Push to line array
            line_array.push([$(left_element).data('index'), $(right_element).data('index'), createLine(left_element, right_element, 0)])
        }
        else {
            line_array = [...old_line_array]
            old_line_array[j][2].show('draw', {
                animOptions: {
                    duration: 1000,
                    timing: 'cubic-bezier(0.58, 0, 0.42, 1)'
                }
            })

        }
    }
}

function createLine(left_element, right_element, start=0) {
    var first, end, param, size;
    if (check_mobile()){
        size = 1
    } else{
        size = 4
    }
    // console.log(left_element.width, left_element.height, right_element.width, right_element.height)
    if (start == 0) {
        first = LeaderLine.pointAnchor(left_element, {
            x: left_element.width,
            y: left_element.height/2
        })
        end = LeaderLine.pointAnchor(right_element, {
            x: 0,
            y: right_element.height/2
        })
        param = { size: size, dropShadow: true, startSocket: 'right', endSocket: 'left', startPlug: 'arrow3', endPlug: 'arrow3', gradient: {
                startColor: 'rgb(17, 148, 51)',
                endColor: 'rgb(17, 148, 51)'
            }, hide: true
        }
    } else {
        first = LeaderLine.pointAnchor(right_element, {
            x: 0,
            y: right_element.height/2
        })
        end = LeaderLine.pointAnchor(left_element, {
            x: left_element.width,
            y: left_element.height/2
        })
        param = { size: size, dropShadow: true, startSocket: 'left', endSocket: 'right', startPlug: 'arrow3', endPlug: 'arrow3', gradient: {
                startColor: 'rgb(17, 148, 51)',
                endColor: 'rgb(17, 148, 51)'
            }, hide: true
        }

    }
    var line = new LeaderLine(
        first, end
        , param
    );

    line.show('draw', {
        animOptions: {
            duration: 500,
            timing: 'cubic-bezier(.1, -0.6, 0.2, 0)'
        }
    })

    return line

}

function submitPosition() {
    console.log("condition line array / just answer", line_array)
    if (line_array.length == this_question.question_data[this_question.current_index]['left'].length) {
        //Lock and save answered
        let just_answer = [...line_array]
        if (this_question.answers.length === this_question.question_data.length) {
            this_question.answers.pop()
        }
        this_question.answers.push(just_answer)
        this_question.status = 1
        localStorage.setItem('testing', JSON.stringify(testing_data))

        let candidate_answers = this_question.answers;
        console.log('answer', candidate_answers, this_question, just_answer)
        
        var login = $('#testForm').data('login');
        if(login) {
            updateDataTesting();
        }
        
        if(!list_test_finished.includes(parseInt(topic))){
            list_test_finished.push(parseInt(topic))
        }
        redirectAfterSubmit(parseInt(topic))
        
    } else {
        errorAnswer();
    }
}

function filterCorrectPosition() {
    let result = 0
    this_question.answers.forEach(function(value, index){
        for (var k=0; k<value.length; k++) {
            if (value[k][0] == value[k][1] ) {
                result += 1
            }
        }
    })
    return result
}

function convertAnswersPosition()
{
    if(typeof this_question != 'undefined'){
        this_question.answers.forEach(function(value, index) {
            for (var i=0; i<value.length; i++){
                value[i].splice(2,1)
            }
        });
    }
}

countCorrectAnswerPosition = (just_answer) => {
    position_current_answer = this_question.answers.length - 1;
    let correct_just = checkAnswerPosition(just_answer, position_current_answer)
    if(correct_just == true) {
        this_question.count_correct_answer += 1;
        doubleFalse = false;
    } else {
        if(position_current_answer > 0 && !checkAnswerPosition(this_question.answers[position_current_answer - 1 ], position_current_answer - 1)) {
            doubleFalse = true;
        }
    }
    console.log('anss:', this_question.count_correct_answer )
    console.log('doubleFalse:', doubleFalse )
}

checkAnswerPosition = (answer, position_current_answer) => {
    let correct = true;
    result = this_question.result[position_current_answer];
    // console.log('rrrr ', result);
    // console.log('aaaa ',answer);
    for (var k=0; k<answer.length; k++) {
        ans = answer[k].filter(function(value, index, array){ return index < 2});
        // console.log('fite', ans);
        // console.log('ádasdasd', result.containsArray(ans));
        if (!result.containsArray(ans)) {
            correct = false;
            // console.log('false')
            break;
        }
    }
    // console.log('true')
    return correct;
}

Array.prototype.containsArray = function(val) {
    var hash = {};
    for(var i=0; i<this.length; i++) {
        hash[this[i]] = i;
    }
    return hash.hasOwnProperty(val);
}
