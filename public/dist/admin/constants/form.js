$('#btnCreate, #btnCancel, #btnList').on('click', function(){
    window.location.href = $(this).data('link');
});
//
function updateStatusParameter(){
    var url = $(this).data('link');
    window.location.href = url;
}
//
commaSeparateEvent(['value']);
//
$(function () {
    $('#description').richText();
})

$('#expand').on('change', function() {
    if(this.checked) {
        $('#description').parent().parent().parent().parent().removeClass('hide');
    }
    else {
        $('#description').parent().parent().parent().parent().addClass('hide');
    }
});