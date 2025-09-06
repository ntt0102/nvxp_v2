$('#show').on('keypress', function(e) {
    if(e.which == 13) {
    	var paramVal = $(this).val();
    	if($.isNumeric(paramVal) && Math.floor(paramVal) == paramVal && paramVal > 0) {
	        var url = window.location.href;
		    var param = 'show';
		    url = updateURLParameter(url, param, paramVal);
		    //
		    param = 'page';
		    paramVal = '';
		    url = updateURLParameter(url, param, paramVal);
		    //
		    window.location.href = url;
		}
		else $(this).addClass('is-invalid');
    }
});