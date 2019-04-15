var line_array = []
var all_line_array = []

// Variable to solve prev button

    $(document).on('click', '.list-l-item img',function(e){
        e.preventDefault()
        if ($(this).hasClass("clicked-img")){
            // Already click
            // 1. Check line of this element => if has => remove line and class "clicked-img" of both in 2 column as well
            var this_img = this
            if (line_array.length > 0) {
                //Check left or right column
                var flag_column_position = parseInt($(this_img).closest('ul').data('position'))
                line_array.forEach(function(value, index) {
                    console.log(index, value, flag_column_position)
                    // console.log(value[flag_column_position], $(this_img).data('index'))
                    if (value[flag_column_position] == $(this_img).data('index')){
                        //remove data array line
                        line_array.splice(index,1)
                        //remove svg line
                        value[2].remove()
                        //Remove clicked img class
                        // console.log('img[data-index='+value[0]+']', $('img[data-index='+value[0]+']'))
                        $(this_img).closest('.matching').find('.column-left img[data-index='+value[0]+']').removeClass('clicked-img').addClass('unlock-selection')
                        $(this_img).closest('.matching').find('.column-right img[data-index='+value[1]+']').removeClass('clicked-img').addClass('unlock-selection')
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
            var left_element = document.getElementsByClassName('clicked-img unlock-selection')[0]
            var right_element = document.getElementsByClassName('clicked-img unlock-selection')[1]

            //Push to line array
            line_array.push([$('.column-left .clicked-img.unlock-selection').data('index'), $('.column-right .clicked-img.unlock-selection').data('index'), createLine(left_element, right_element)])
            //Delete unlock-selection class
            $(elements_click).each(function(){
                $(this).removeClass('unlock-selection')
            })
        }
    })

function nextButtonPosition () {
    //Position
    console.log("condition line array / just answer", line_array)
    if (line_array.length == 3) {
        tab_number[this_question.current_index].style.display = "none";
        this_question.current_index += 1
        var currentTab = parseInt(this_question.current_index)

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
             // dừng việc check20s tránh đuplicate lặp timeout
            stopTimeToChange()
            // compare answer
            all_line_array.push(just_answer)
            console.log('all push', all_line_array)
            console.log('next, answers', this_question.answers)
            line_array.length = 0

            // console.log(flagChange)
            if(compare_just_answer.compare(fakeAnswer) && parseInt(testing_data.level) > minLv && flagChange == 0 ){
                console.log('w answer');
                changeDynamicQuestion(parseInt(testing_data.level) -1 , this_question.answers.length)
            } else {
                // Save into local storage
                console.log (testing_data, 'test')
                localStorage.setItem('testing', JSON.stringify(testing_data))

                showTab(currentTab)
                // sau khi render 20s k next thì sẽ => câu hỏi thấp
                if(parseInt(testing_data.level) > minLv){
                    setTimeToChange(testing_data.level - 1 , currentTab + 1 );
                }
            }
        }
    } else {
        // alert("Please answer the question")
        Swal.fire('Please answer the question')

    }
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

    // $('#prevBtn').before(html);
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

function submitPosition() {
    console.log("condition line array / just answer", line_array)
    if (line_array.length == 3) {

        //Lock and save answered
        let just_answer = [...line_array]

        this_question.answers.push(just_answer)
        this_question.status = 1
        localStorage.setItem('testing', JSON.stringify(testing_data))

        let candidate_answers = this_question.answers;
        console.log('answer', candidate_answers, this_question, just_answer)
        let correct = filterCorrectPosition()
        var login = $('#testForm').data('login');
        showDialogScore(correct, total_question*max_images_in_column, login)
        //Display test not finished
        displayTestUnFinishedAfterSubmit()

    } else {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Please answer the question!',
        })
    }
}

function filterCorrectPosition() {
    let result = 0
    this_question.answers.forEach(function(value, index){
        for (var k=0; k<max_images_in_column; k++) {
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
            for (var i=0; i<3; i++){
                value[i].splice(2,1)
            }
        });
    }
}