/**
 * Change password and avatar
 */

var AVATAR_TYPE_USER = 1;
var AVATAR_TYPE_CUSTOMER = 0;

$(document).ready(function() {
    //open modal to change user avatar
    $(document).on('click', '#change-avatar-user', function() {
        $.callModal('/insurance/customer/modal-change-avatar', 'modal-change-avatar', function() {
            $('#avatar_type').val(AVATAR_TYPE_USER);
            var userId = $('#user_id').text();
            $('#avatar_id').val(userId);
        });
    });

    //change avatar
    $(document).on('click', '#button_change_avatar', function() {
        var formChangeAvatar = $('#form-change-avatar');
        $.validateDynamic(function(){
            formChangeAvatar.validate();
            if (formChangeAvatar.valid()) {
                formChangeAvatar.submit();
            }
        });
    });

    //open modal to change customer avatar
    $('#change-customer-avatar').click(function() {
        $.callModal('/insurance/customer/modal-change-avatar', 'modal-change-avatar', function() {
            $('#avatar_type').val(AVATAR_TYPE_CUSTOMER);
            var customerId = $('#customer_id').val();
            $('#avatar_id').val(customerId);
        });
    });

    //open modal to change user password
    $('#change-user-password').click(function() {
        $.callModal('/insurance/customer/modal-change-password', 'modal-change-password', function() {
            $('#password_type').val(AVATAR_TYPE_USER);
            var userId = $('#user_id').text();
            $('#id_change_password').val(userId);
        });
    });

    //change user password
    $(document).on('click', '#button_update_password', function() {
        var formChangePassword = $('#form-change-password');
        $.validateDynamic(function(){
            formChangePassword.validate();
            if (formChangePassword.valid()) {
                var formData = formChangePassword.serializeArray();
                $.callAjax('post', '/insurance/customer/change-password', formData, $('body'), function(response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 0) {
                        alert(obj.error_msg);
                    } else {
                        $('#form-keep-flash-message').submit();
                    }
                })
            }
        });
    });

});