var checkClick = true
$(document).on('click', '#submitLog', function(event) {
    loading = $(this).find('.loading');
    loading.addClass('lds-dual-ring');
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
                    // alert('somethings wrongs');
                }else {
                    changeLocalStorage(response.local_storage)
                    redirectPage();
                }

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
            loading.removeClass('lds-dual-ring');
            checkClick = true;
        });
});

// genButton
$(document).on('click', '#genButton', function(event) {
    loading = $(this).find('.loading');
    loading.addClass('lds-dual-ring');
    event.preventDefault();
    if(!checkClick){
        return false;
    }
    checkClick = false;
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = [];
    } else {
        testing_data.question.forEach((question) => {
            question.html_arr.length = 0;
        })
    }
    // delete line in postion page
    if(typeof type != 'undefined' &&  type === '2' ){
       convertAnswersPosition()
    }
    genName = $('input[name="genName"]').val();
    // get local storate
    var data = {
        'local_storage' : testing_data,
        'username' : genName
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
            $('.modal').hide()
            Swal.fire({
                type: 'success',
                title: 'Your account:',
                // background: 'orange',
                text: 'Username: '+response.username+'\n Password: '+response.password,
                backdrop: `rgba(255, 255, 255, 0.61)`,
                footer: 'Please save your account!',
                allowOutsideClick: false
            }).then(()=>{
                // check if at free-test result
                redirectPage()
            })

        })
        .fail(function(response) {
            if(response.status == 422){
                var errors = response.responseJSON.errors;
                if(errors.username == undefined){
                    $('.genNameError').addClass('hide');
                }else {
                    $('.genNameError').removeClass('hide').html(errors.username);
                }
            } else {
                console.log(response)
                alert('Server Errors: 500!!')
            }
        }).always(function(response) {
            loading.removeClass('lds-dual-ring');
            checkClick = true;
        });;

});

$('form#form-sign-up').on('submit', function(event) {
    event.preventDefault()
    loading = $(this).find('.loading');
    loading.addClass('lds-dual-ring');
    if(!checkClick){
        return false;
    }
    checkClick = false;
    // $('button#regButton').prop('disabled', true)
    url = $('#regButton').data('route');
    //Check repassword
    if(testing_data == undefined){
        testing_data = [];
    } else {
        testing_data.question.forEach((question) => {
            question.html_arr.length = 0;
        })
    }
    // delete line in postion page
    if(typeof type != 'undefined' &&  type === '2' ){
        convertAnswersPosition()
    }
    let post_data = {
        'data':$(this).serialize(),
        'local_storage': testing_data
    };
    console.log(post_data);
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: post_data,
    }).done(function(response) {
            console.log(response);
            if(response.status == 200){
                if(response.local_storage === undefined || response.local_storage.length == 0){
                    //
                }else {
                    localStorage.removeItem('testing');
                    changeLocalStorage(response.local_storage);
                }
                    // check if at free-test result
                    redirectPage()

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
                console.log(response)
                alert('Server Errors')
            }
        })
        .always(function(response) {
            loading.removeClass('lds-dual-ring');
            checkClick = true;
            // $('button#regButton').prop('disabled', false);
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
$("#modal-sign-up").on("hidden.bs.modal", function () {
    $('input[name="genName"]').val('')
    $('.genNameError').addClass('hide');
});
$("#modal-sign-in").on("hidden.bs.modal", function () {
    $('.logpass').val('');
    $('.logname').val('');
    $('.usernameError').addClass('hide');
    $('.passwordError').addClass('hide');
    $('.login-errors').addClass('hide');
});

changeLocalStorage = (response, guest_id = '' ) =>
{
    if(response === '[]'){
        return;
    }
    // console.log('res', response)
        testing_data = {
            level: response[0].level,
            question: [],
            received_free_package_status : parseInt(response[0].received_free_package_status),
            guest_id : '-1'
        };

    if(guest_id == '' || guest_id === undefined) {
        
    } else {
        testing_data.guest_id = guest_id;
    }
    // save html -> localstorage
    response.forEach( function(response_element, index) {
        console.log('for', index)
        html_arr = [];
        response_element.type = response_element.type.toString()

        if(response_element.type === '2'){
            answers = response_element.answers;
        } else {
            answers = response_element.answers.map(Number);
        }
        question = {
            type: response_element.type,
            topic: response_element.topic,
            question_data: response_element.question_data,
            status: response_element.status,
            answers: answers,
            current_index: response_element.current_index,
            level_temp: response_element.level_temp,
            html_arr : html_arr,
            curriculum_ids : response_element.curriculum_ids.map(Number),
            customer_testing_id : response_element.customer_testing_id,
            result: response_element.result,
            count_correct_answer: parseInt(response_element.count_correct_answer)
        };
        // console.log('a', question)
        if (typeof testing_data !== 'undefined') {
            testing_data.question.push(question);
        }
    });
    console.log('end ', testing_data)
    localStorage.setItem('testing', JSON.stringify(testing_data));

}


$(document).on('click', '#logoutBtn', function(event) {
    event.preventDefault();
    if(!checkClick){
        return false;
    }
    checkClick = false;
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = [];
    } else {
        testing_data.question.forEach((question) => {
            question.html_arr.length = 0;
        })
    }
    // delete line in postion page
    if(typeof type != 'undefined' &&  type === '2' ){
        convertAnswersPosition()
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

        window.location.href ='/'
    })
    .fail(function(response) {
        console.log(response);
    })
    .always(function(response) {
        checkClick = true;
    });;

});

$(document).on('click', '.social-link', function(event) {
    event.preventDefault();
    loading = $(this).find('.loading');
    loading.addClass('lds-dual-ring');
    if(!checkClick){
        return false;
    }
    checkClick = false;
    url = $(this).data('route');
    if(testing_data == undefined){
        testing_data = [];
    } else {
        testing_data.question.forEach((question) => {
            question.html_arr.length = 0;
        })
    }
    // delete line in postion page
    if(typeof type != 'undefined' &&  type === '2' ){
       convertAnswersPosition()
    }
    // get local storate
    var data = {
        'local_storage' : testing_data
    };
    $.ajax({
        url: '/sendLocalStorageSocial',
        type: 'POST',
        dataType: 'json',
        data: data,
        async : false,
    })
    .done(function(response) {
        console.log("success");
        window.location.href=url;
    })
    .fail(function(response) {
        console.log(response);
    })
    .always(function(response) {
        loading.removeClass('lds-dual-ring');
        checkClick = true;
    });

});
// get localstorgae from session
$(document).ready(function() {
    var storage = $('.storage').data('storage')
    console.log('storage',storage)
    if(storage !== '')
    {
        localStorage.removeItem('testing');
        changeLocalStorage(storage);
        console.log('change local_storage')
    }
});

$(document).ready(function() {
  $.ajaxSetup({ cache: true });
  $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
    FB.init({
      appId: '2347313838633207', // sua lai ip app
      version: 'v3.0' // or v2.1, v2.2, v2.3, ...
    });     
  });
});

redirectPage = () => {
    if(window.location.pathname === '/free-test-results') {
        window.location.href = '/packages'
    } else {
        window.location.reload(true)
    }
}