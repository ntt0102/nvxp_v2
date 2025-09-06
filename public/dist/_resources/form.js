// Confirm Delete
$('#btnDelete').on('click', function(e){
    var form = $('#formDelete');
    $.confirm({
        title: 'Xóa',
        content: 'Bạn chắc chắn muốn xóa không?',
        autoClose: 'cancel|8000',
        theme: 'material',
        type: 'red',
        buttons: {
            confirm: {
                text: 'Có',
                btnClass: 'btn-danger',
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
});

$('form').submit(function( event ) {
    $('input').blur();
});