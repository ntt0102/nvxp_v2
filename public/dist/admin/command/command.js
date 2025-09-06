// Select2
$('#command').select2({
    placeholder: "Chọn loại",
    theme: "bootstrap4",
    minimumResultsForSearch: Infinity,
    allowClear: true
});

$('#btnCommand').on('click', function(){
    var blnCommand = $('#command').val() != '';
    if(blnCommand){
        var form = $('#formCommand');
        var content = 'Bạn chắc chắn muốn thực thi lệnh không?';

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
    else warningDialog('Chọn Lệnh cần thực thi.');
});

