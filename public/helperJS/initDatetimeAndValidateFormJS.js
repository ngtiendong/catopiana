$(document).ready(function() {
    previewUploadImage();

    jQuery.validator.setDefaults({
        highlight: function(element) {
            jQuery(element).parent().addClass('has-error');
        },
        unhighlight: function(element) {
            jQuery(element).parent().removeClass('has-error');
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "Vui lòng nhập dữ liệu",
        remote: "Please fix this field.",
        email: "Vui lòng nhập đúng định dạng địa chỉ email",
        url: "Vui lòng nhập url chính xác.",
        date: "Giá trị ngày chưa đúng",
        dateISO: "Vui lòng nhập đúng định dạng ngày (ISO).",
        number: "Vui lòng nhập vào kiểu dữ liệu là số.",
        digits: "Please enter only digits.",
        creditcard: "Vui lòng nhập đúng số thẻ tín dụng.",
        equalTo: "Vui lòng xác nhận lại giá trị.",
        accept: "Please enter a value with a valid extension.",
        maxlength: jQuery.validator.format("Vui lòng không nhập quá {0} ký tự."),
        minlength: jQuery.validator.format("Vui lòng nhập tối thểu {0} ký tự."),
        rangelength: jQuery.validator.format("Vui lòng nhập giá trị có độ dài từ {0} đến {1} ký tự."),
        range: jQuery.validator.format("Vui lòng nhập giá trị trong khoảng {0} và {1}."),
        max: jQuery.validator.format("Vui lòng nhập giá trị nhỏ hơn hoặc bằng {0}."),
        min: jQuery.validator.format("Vui lòng nhập giá trị lớn hơn hoặc bằng {0}.")
    });

    // Init validation
    jQuery('form.validate').each(function () {
        jQuery(this).validate();
    });

    if (jQuery('.auto-hide-alert').length > 0) {
        setTimeout(function () {
            var elm = jQuery('.auto-hide-alert');
            elm.fadeOut();
            elm.remove();
        }, 5000);
    }

    //Date picker
    initDatePicker();
});

window.onbeforeunload = function(){
    // Show loading
    $('.box .overlay').removeClass('hide');
};

function previewUploadImage()
{
    $(".preview-upload-image").on('change', function(){
        readURL(this);
    });
}

function readURL(input) {
    var imgElm = $(input).parent().find('img.preview-image');
    console.log(imgElm.length);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            imgElm.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        imgElm.show();
    }
}

function initDatePicker(wrapperSelector)
{
    if (wrapperSelector != undefined) {
        var $dateElements, $dateTimeElements;
        if (wrapperSelector instanceof jQuery) {
            $dateElements = wrapperSelector.find('.datepicker');
            $dateTimeElements = wrapperSelector.find('.datetimepicker');
        } else {
            $dateElements = $(wrapperSelector + ' .datepicker');
            $dateTimeElements = $(wrapperSelector + ' .datetimepicker');
        }
        $dateElements.datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            endDate: new Date()
        });
        $dateTimeElements.datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });

    } else {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            endDate: new Date()
        });

        $('.datetimepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });


    }
}