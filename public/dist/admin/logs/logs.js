// Select2
$('#type').select2({
    placeholder: "Chọn loại",
    theme: "bootstrap4",
    minimumResultsForSearch: Infinity,
    allowClear: true
});

$('#type').on('change', function(){
    var url = window.location.href;
    var param = 'type';
    var paramVal = $(this).val();
    url = updateURLParameter(url, param, paramVal);
    //
    param = 'page';
    paramVal = '1';
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});

// multi delete 
$('#all-id').on('click', function() { 
    $('td input[type="checkbox"]').prop('checked', this.checked);
    updateDeleteId();
});

$('th:not(:first-child)').on('click', function() { 
    $('#all-id').click();
});

$('td input[type="checkbox"]').on('click', function() { 
    var checkedLength = $('td input[type="checkbox"]:checked').length;
    var allId = $('td input[type="checkbox"]').length == checkedLength;
    $('#all-id').prop('checked', allId);
    updateDeleteId();
});

$('td:not(:first-child)').on('click', function() { 
    $(this).parent().find('td input[type="checkbox"]').click();
});

function updateDeleteId(){
    var deleteIds = new Array();
    var itemId = '';
    $('td input[type="checkbox"]:checked').each(function(index){
        itemId = $(this).attr('user-id');
        deleteIds.push(itemId);
    });
    $('#multiDeleteId').val(deleteIds);
}

$('#btnMultiDelete').on('click', function(){
    var form = $('#formMultiDelete');
    var content = '';
    if(form.find('input[name="id"]').val() != '')
        content = 'Bạn chắc chắn muốn xóa lịch sử đã chọn không?';
    else
        content = 'Bạn chắc chắn muốn xóa toàn bộ lịch sử không?';

    $.confirm({
        title: 'Xóa tất cả',
        content: content,
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

