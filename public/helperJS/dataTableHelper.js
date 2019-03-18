
// ====================ServerSide====================
var table;

var dataTableHelper = (function () {
    return {
        init : function (_table_id, _url, _filter, _columns, _order) {
            var _options = {
                processing: true,
                serverSide: true,
                bAutoWidth: true,
                searching: false,
                ajax: {
                    url: _url,
                    type: 'get',
                    data: _filter
                },
                columns: _columns,
                language:{
                    "sProcessing":   '<i class="fa fa-spinner fa-pulse fa-fw"></i> Đang xử lý...',
                    "sLengthMenu":   "Xem _MENU_ mục",
                    "sZeroRecords":  "Không tìm thấy bản ghi nào",
                    "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                    "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                    "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Tìm:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Đầu",
                        "sPrevious": "Trước",
                        "sNext":     "Tiếp",
                        "sLast":     "Cuối"
                    }
                }
            };
            if(_order != undefined){
                _options.order = _order;
            }
            return $('#' + _table_id).DataTable(_options);
        }
    };
})();


function filter() {
    table.draw();
}



// ====================ClientSide====================
// Datatable xử lý html thuần thôi
function format ( obj ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" id="child-table" class="table table-bordered table-striped table-hover">'+
        '<tr>'+
        '<td class="td-child-row">Company name:</td>'+
        '<td>'+obj.data('company-name')+'</td>'+
        '</tr>'+
        '<tr>'+
        '<td class="td-child-row">Job: </td>'+
        '<td>'+obj.data('job')+'</td>'+
        '</tr>'+
        '<td class="td-child-row">Address: </td>'+
        '<td>'+obj.data('address')+'</td>'+
        '</tr>'+
        '<td class="td-child-row">Business time: </td>'+
        '<td>'+obj.data('business-time')+'</td>'+
        '</tr>'+
        '<td class="td-child-row">Description: </td>'+
        '<td>'+obj.data('description')+'</td>'+
        '</tr>'+
        '</table>';
}


table = $('#table_advertise').DataTable({
    "columnDefs": [
        {
            "targets"  : 'no-sort',
            "orderable": false,
        },
        {
            targets: 5,
            className: 'color-column'
        }
    ],
    'sDom': '"top"i',
    "order": []
});

//Child row event click row table
$('#table_advertise tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var icon = $(this).find('i');

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');

        //Change icon
        icon.removeClass("fa-minus-circle");
        icon.addClass("fa-plus-circle");
    }
    else {
        // Open this row
        row.child(format(tr)).show();
        tr.addClass('shown');


        //Change icon
        icon.removeClass("fa-plus-circle");
        icon.addClass("fa-minus-circle");


    }
} );
