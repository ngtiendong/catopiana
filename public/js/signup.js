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
    })
        .done(function(response) {
            console.log(response);
            if(response.status == 200){
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
        testing_data = null;
    }
    console.log(testing_data);

    var data = {
        'data' : testing_data
    };
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
    })
        .done(function(response) {
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
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
    }).done(function(response) {
            console.log(response);
            if(response.status == 200){
                window.location.href = '/';
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
