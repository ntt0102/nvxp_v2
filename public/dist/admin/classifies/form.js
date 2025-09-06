$(function(){
    $('#constant').focus();
});
// Select2
$('#constant').select2({
    placeholder: "Chọn nhóm",
    theme: "bootstrap4",
    allowClear: true
});
$(function(){
    if($('#constant').hasClass('is-invalid')){
        $('#constant').next().find('.select2-selection').addClass('is-invalid');
    }
});
// 
$('#btnCreate, #btnCancel, #btnList').on('click', function(){
	window.location.href = updateConstantParameter($(this));
});
//
function updateConstantParameter(selecter){
	var url = selecter.data('link');
    var param = 'constant';
    var paramVal = $('#constant').val();
    //
    return updateURLParameter(url, param, paramVal);
}
//
$('#constant').on('change', function(){
    updateClassifies();
});
//
$(function(){
    updateClassifies();
});
//
function updateClassifies(){
    var data = {'constant': $('#constant').val()};
    //
    var urlParameter = encodeQueryData(data);
    $(document).find('input[name="classifies"]').val(urlParameter);
}