$('#order-by').on('change', function(){
    var url = window.location.href;
    var param = 'order-by';
    var paramVal = $('#order-by').val();
    url = updateURLParameter(url, param, paramVal);
    //
    param = 'page';
    paramVal = '1';
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});

$('#order-by').select2({
    placeholder: "Chọn trường sắp xếp",
    theme: "bootstrap4",
    allowClear: true
});