$(document).ready(function() {
    var divBody = $('body');
    var colorWaitMe = '#317def';
    /**
     * function to call modal
     * urlCall is url ajax load view modal - method get
     * modalId is id of div modal
     */

    jQuery.callModal = function(urlCall, modalId, callback) {
        $.ajax({
            method: 'get',
            url: urlCall,
            data: {},
            dataType: 'html',
            beforeSend: function() {
                divBody.waitMe({color: colorWaitMe});
            },
            success: function(response) {
                divBody.waitMe('hide');
                $('#div-fill-modal').html(response);
                $('#'+modalId).modal();
                if (typeof callback == 'function') { // make sure the callback is a function
                    callback.call(this); // brings the scope to the callback
                }
            }
        });
    };

    jQuery.callAjax = function(method, url, data, divWaitMe, callback) {
        $.ajax({
            method: method,
            url: url,
            data : data,
            beforeSend: function() {
                divWaitMe.waitMe({color: colorWaitMe});
            },
            success: function(response) {
                divWaitMe.waitMe('hide');
                if (typeof callback == 'function') {
                    callback.call(this, response);
                }
            }
        });
    };

    jQuery.callAjaxHtml = function(method, url, data, divWaitMe, callback) {
        $.ajax({
            method: method,
            url: url,
            data : data,
            dataType: 'html',
            beforeSend: function() {
                divWaitMe.waitMe({color: colorWaitMe});
            },
            success: function(response) {
                divWaitMe.waitMe('hide');
                if (typeof callback == 'function') {
                    callback.call(this, response);
                }
            }
        });
    };

    jQuery.validateDynamic = function(callback) {
        $.validator.addClassRules({
            dynamic_email: {
                email: true
            },
            dynamic_required: {
                required: true
            },
            dynamic_number: {
                number: true
            },
            dynamic_equal: {
                equalTo: "#password"
            },
            dynamic_file_image: {
                required: true
            }
        });
        if (typeof callback == 'function') {
            callback.call(this);
        }
    }

});