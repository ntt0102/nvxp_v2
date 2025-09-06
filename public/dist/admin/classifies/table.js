$('#btnCreate').on('click', function(){
	var constant = $('#constant').val();
	link2createData =  '?constant=' + constant;
	//
	var url = $('#btnCreate').data('link');
	url += link2createData;
	window.location.href = url;
});