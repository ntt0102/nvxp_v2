$('#branch').on('change', function(){
    var url = window.location.href;
    var param = 'branch';
    var paramVal = $('#branch').val();
    url = updateURLParameter(url, param, paramVal);
    //
    param = 'page';
    paramVal = '1';
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});

$('#branch').select2({
    placeholder: "Chọn chi nhánh",
    theme: "bootstrap4",
    allowClear: true
});
