
function showNotify(message, type)
{
    if (type == undefined || type == '') {
        type = 'success';
    }

    $.notify(message, type, {position: 'top center'});
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function showModal(modalContent) {
    // Create modal element
    var date = new Date();
    var id = date.getTime();

    var $modal = $('<div class="modal fade" id="modal-'+ id +'" tabindex="-1" role="dialog" aria-labelledby="modal-'+ id +'"></div>');
    $modal.html(modalContent);
    $('body').append($modal);
    $modal.modal('show');
}

function select2Ajax (eleId, initMessage, url, params)
{
    $(eleid).select2({
        language: {
            inputTooShort: function(args) {
                return initMessage
            }
        },
        ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.data.data,
                    pagination: {
                        more: params.page < data.last_page
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
}
function formatRepo (repo) {
    if (repo.loading) return repo.text;
    var markup = "<div><b>" +repo.name+ "</b><br/><small><i class='fa fa-envelope-o'></i> " + repo.email + "<br/> <i class='fa fa-phone'></i>  " + repo.phone_number + "<br/> <i class='fa fa-map'></i>"+ repo.address +"</small></small></div>";
    return markup;
}
function formatRepoSelection (repo) {
    return repo.name || repo.text;
}

function refresh(elementId, optionText, optionValue) {
    $(elementId).val(null).trigger('change');

    var newOption = new Option(optionText, optionValue, false, false);
    $(elementId).append(newOption).trigger('change');
}




var dialog = (function(){
    return {
        show : function(title, data){
            $('#finishModalLabel').html(title);
            $('#modal_content').html(data);
            $('#btnAction').attr('onclick', 'return formHelper.onSubmit("frmDialogCreate")');
            $('#detailModal').modal('show');
        },
        close: function () {
            $('#detailModal').modal('hide');
            $('#detailModal').css('display', 'none').attr('aria-hidden', 'true');
            $('#finishModalLabel').html('');
            $('#modal_content').html('');
        },
    }
})();

var formHelper = (function () {
    return {
        postFormJson: function (objID, onSucess) {
            var url = document.getElementById(objID).action;
            $.post(url, $('#' + objID).serialize(), function (data) {
                onSucess(data);
            }, 'json');
        }
    };
})();

var btn_loading = (function () {
    return {
        loading : function (btn_id) {
            var $btn = $('#' + btn_id);
            $btn.prop('disabled', true);
            $btn.waitMe({
                color: '#3c8dbc'
            });
        },
        hide : function (btn_id) {
            var $btn = $('#' + btn_id);
            $btn.prop('disabled', false);
            $btn.waitMe('hide');
        }
    };
})();
