$('.btnProcess').on('click', function(e){
    var title = 'Đánh dấu đã sửa';
    var type = 'green';
    var btnClass = 'success';
    confirmForm($(this), title, type, btnClass);
});

$('.btnDelete').on('click', function(e){
    var title = 'Xóa';
    var type = 'red';
    var btnClass = 'danger';
    confirmForm($(this), title, type, btnClass);
});