$('#all-table').on('click', function() { 
    $('.table > input[type="checkbox"]').prop('checked', this.checked);
    updateSelectedTable();
});

$('.table > input[type="checkbox"]').on('click', function() { 
    var checkedLength = $('.table > input[type="checkbox"]:checked').length;
    var allTable = $('.table > input[type="checkbox"]').length == checkedLength;
    $('#all-table').prop('checked', allTable);
    updateSelectedTable();
});
//
function updateSelectedTable(){
    var tables = new Array();
    var table = '';
    $('.table > input[type="checkbox"]:checked').each(function(index){
        table = $(this).attr('id');
        tables.push(table);
    });
    $('#hidTable').val(tables);
}
//
$('#btnExport').on('click', function(){
    var blnTable = $('#hidTable').val() != '';
    if(blnTable){
        var form = $('#formExport');
        var content = 'Bạn chắc chắn muốn sao lưu dữ liệu không?';

        $.confirm({
            title: 'Khôi phục dữ liệu',
            content: content,
            autoClose: 'cancel|8000',
            theme: 'material',
            type: 'green',
            buttons: {
                confirm: {
                    text: 'Có',
                    btnClass: 'btn-success',
                    action: function () {
                        if (form.length) {
                            form.submit();
                        }
                    }
                },
                cancel: {
                    text: 'Không',
                }
            },
            onOpen: function () {
                $('.jconfirm button:nth-child(1)').focus();
            }
        });
    }
    else warningDialog('Chọn Bảng cần sao lưu dữ liệu.');
});

