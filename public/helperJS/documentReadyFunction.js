$(function() {
    // $('.select2').select2();
    // $('.select2-full-width').select2({ width: '100%' });
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    },
});
