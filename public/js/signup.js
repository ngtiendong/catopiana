var checkClick = true
$(document).on('click', '#submitLog', function(event) {
    if(!checkClick){
        return false;
    }
    checkClick = false;
    var data = {
        "username": $('.logname').val(),
        "password": $('.logpass').val()
    };
    url = $(this).data('route');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
    }).done(function(response) {
            console.log(response);
            if(response.status == 200){
                // console.log(response.local_storage)
                localStorage.removeItem('testing');
                if(response.local_storage === undefined || response.local_storage.length == 0){
                    alert('somethings wrongs');
                }else {
                    changeLocalStorage(response.local_storage)
                }
                window.location.reload(true)

            }
            if(response.status == 401){
                $('.logpass').val('')
                $('.passwordError').addClass('hide');
                $('.usernameError').addClass('hide');
                $('.login-errors').removeClass('hide');
            }
        })
        .fail(function(response) {
            console.log(response);
            if(response.status == 422){
                var errors = response.responseJSON.errors;
                if(errors.username == undefined){
                    $('.usernameError').addClass('hide');
                }else {
                    $('.usernameError').removeClass('hide').html(errors.username);
                }
                if(errors.password == undefined){
                    $('.passwordError').addClass('hide');
                }else {
                    $('.passwordError').removeClass('hide').html(errors.password);
                }
                $('.logpass').val('')
            }
        })
        .always(function() {
            checkClick = true;
        });
});
$("#modal-sign-in").on("hidden.bs.modal", function () {
    $('.logpass').val('');
    $('.logname').val('');
    $('.usernameError').addClass('hide');
    $('.passwordError').addClass('hide');
    $('.login-errors').addClass('hide');
});
// gen with email
$(document).on('click', '#submitReg', function(event) {
    if(!checkClick){
        return false;
    }
    checkClick = false;
    var data = {
        "email": $('.genEmail').val()
    };
    url = $(this).data('route');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
    })
        .done(function(response) {
            console.log(response);
            if(response.status != 200){
                $('.signWindow .warning').css('opacity', 1);
            }
            else{
                window.location.reload()
            }
        })
        .fail(function(response) {
            $('.signWindow .warning').html(response.responseJSON.errors['email'])
            $('.signWindow .warning').css('opacity', 1);
        })
        .always(function() {
            checkClick = true;
            console.log("complete");
        });
});
// genButton
$(document).on('click', '#genButton', function(event) {
    event.preventDefault();
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = '';
    }
    // get local storate
    var data = {
        'local_storage' : testing_data
    };
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
    })
        .done(function(response) {
            // update testing_id đã có trên db,
            if(response.local_storage === undefined || response.local_storage.length == 0){
                // alert('tai khoan chua co du lieu gi tren serve');
            }else {
                localStorage.removeItem('testing');
                changeLocalStorage(response.local_storage)
            }
            // Show account:
            Swal.fire({
                type: 'success',
                title: 'Your account:',
                text: 'Username: '+response.username+'\n Password: '+response.password,
                footer: 'Please save your account!'
            }).then(()=>{
                window.location.reload(true);

            })

        })
        .fail(function(response) {
            console.log(response);
        })
        .always(function(response) {
            console.log(response);
        });

});

$('form#form-sign-up').on('submit', function(event) {
    event.preventDefault()
    $('button#regButton').prop('disabled', true)
    url = $('#regButton').data('route');
    //Check repassword
    if(testing_data == undefined){
        testing_data = '';
    }
    let post_data = {
        'data':$(this).serialize(),
        'local_storage': testing_data
    };
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: post_data,
    }).done(function(response) {
            console.log(response);
            if(response.status == 200){
                if(response.local_storage === undefined || response.local_storage.length == 0){
                    // alert('tai khoan chua co du lieu gi tren serve');
                }else {
                    localStorage.removeItem('testing');
                    changeLocalStorage(response.local_storage);
                    window.location.reload(true);
                }
            }
        })
        .fail(function(response) {
            if(response.status == 422){
                var errors = response.responseJSON.errors;
                if(errors.username == undefined){
                    $('.usernameError').addClass('hide');
                }else {
                    $('.usernameError').removeClass('hide').html(errors.username);
                }
                if(errors.email == undefined){
                    $('.emailError').addClass('hide');
                }else {
                    $('.emailError').removeClass('hide').html(errors.email);
                }
                if(errors.password == undefined){
                    $('.passwordError').addClass('hide');
                }else {
                    $('.passwordError').removeClass('hide').html(errors.password);
                }
                if(errors.fullname == undefined){
                    $('.fullnameError').addClass('hide');
                }else {
                    $('.fullnameError').removeClass('hide').html(errors.fullname);
                }
                $('.regPassword').val('')
                $('.regPasswordConfirm').val('')
            } else {
                alert('Server Errors')
            }
        })
        .always(function() {
            $('button#regButton').prop('disabled', false);
        });
});

$("#modal-register").on("hidden.bs.modal", function () {
    $('.regName').val('');
    $('.regEmail').val('');
    $('.regPassword').val('');
    $('.regPasswordConfirm').val('');
    $('.regFullname').val('');
    $('.usernameError').addClass('hide');
    $('.emailError').addClass('hide');
    $('.passwordError').addClass('hide');
    $('.fullnameError').addClass('hide');
});

changeLocalStorage = (response) =>
{
    console.log('start:' , testing_data)
    // localStorage.removeItem('testing');
    console.log('mid:' , testing_data)
    // if (typeof testing_data == 'undefined') {
        testing_data = {
            level: response[0].level,
            question: []
        };
    // }
    console.log('local_storage:' , testing_data)
    // save html -> localstorage
    response.forEach( function(response_element, index) {
        html_arr = [];
        response_element.type = response_element.type.toString()
        console.log(response_element.type, response_element.topic, response_element.level)
        if (response_element.type === '1'){
            response_element.question_data.forEach( function(question_data_element, index) {
                html_arr.push(renderAudio(question_data_element.question, question_data_element.answers,
                    question_data_element.question_image, question_data_element.answer_image))
            });
        } else if (response_element.type === '2'){
            max_images_in_column = response_element.question_data[0].length
            response_element.question_data.forEach( function(question_data_element, index) {
                html_arr.push(renderPosition(question_data_element[0],question_data_element[1], "unlock-selection", "none"))
            });
        }
        else {
            response_element.question_data.forEach( function(question_data_element, index) {
                html_arr.push(render(question_data_element.question, question_data_element.answers))
            });

        }
        this_question = {
            type: response_element.type,
            topic: response_element.topic,
            question_data: response_element.question_data,
            status: response_element.status,
            answers: response_element.answers.map(Number),
            current_index: response_element.current_index,
            level_temp: response_element.level_temp,
            html_arr : html_arr,
            curriculum_ids : response_element.curriculum_ids.map(Number),
            customer_testing_id : response_element.customer_testing_id
        };
        if (typeof testing_data !== 'undefined') {
            testing_data.question.push(this_question);
        }
        // total_question = parseInt(this_question.question_data.length)
    });
    console.log('end ', testing_data)
    localStorage.setItem('testing', JSON.stringify(testing_data));

}


$(document).on('click', '#logoutBtn', function(event) {
    event.preventDefault();
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = '';
    }
    // get local storate
    data = {
        'local_storage' : testing_data
    };
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data ,
    })
    .done(function(response) {
        localStorage.removeItem('testing');
        window.location.reload(true)
    })
    .fail(function(response) {
        console.log(response);
    });

});


$(document).on('click', '.auth-provider', function(event) {
    alert(1);
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = '';
    }
    var data = {
        'local_storage' : testing_data
    };
    alert(2);
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
    }).done(function(response) {
            console.log(response);
            if(response.status == 200){
                // console.log(response.local_storage)
                localStorage.removeItem('testing');
                if(response.local_storage === undefined || response.local_storage.length == 0){
                    alert('somethings wrongs');
                }else {
                    // changeLocalStorage(response.local_storage)
                    alert('co du lieu');
                }
                window.location.reload(true)

            }
            if(response.status == 401){

            }
        })
        .fail(function(response) {
            console.log(response);
            
        });
});