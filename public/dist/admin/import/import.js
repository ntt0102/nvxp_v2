// Select2
$('#table').select2({
    placeholder: "Chọn loại",
    theme: "bootstrap4",
    minimumResultsForSearch: Infinity,
    allowClear: true
});

$('#btnImport').on('click', function(){
    var blnTable = $('#table').val() != '';
    var blnFile = $('#file').get(0).files.length > 0;
    if(blnTable && blnFile){
        var form = $('#formImport');
        var content = 'Bạn chắc chắn muốn khôi phục dữ liệu không?';

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
    else warningDialog('Chọn Bảng và Tệp CSV tương ứng.');
});

