$('#constant').on('change', function(){
    var url = window.location.href;
    var param = 'constant';
    var paramVal = $('#constant').val();
    url = updateURLParameter(url, param, paramVal);
    //
    param = 'page';
    paramVal = '1';
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});

$('#constant').select2({
    placeholder: "Chọn nhóm",
    theme: "bootstrap4",
    allowClear: true
});

