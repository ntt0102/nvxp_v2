$('#search').on('keypress', function(e) {
    if(e.which == 13) {
        onSearch();
    }
});
//
$('#search').parent().children('div').children('button[type="submit"]').on('click', onSearch);
//
function onSearch(){
    var url = window.location.href;
    var param = 'search';
    var paramVal = $('#search').val();
    url = updateURLParameter(url, param, paramVal);
    //
    var hiddenSelector = $('#search').parent().children('input[type="hidden"]');
    hiddenSelector.each(function(index) {
        param = $(this).attr('name');
        paramVal = $(this).val();
        url = updateURLParameter(url, param, paramVal);
    });
    //
    param = 'page';
    paramVal = '1';
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
}