// Select2 with not search form
$("#status").select2({
    placeholder: "Chọn trạng thái",
    theme: "bootstrap4",
    minimumResultsForSearch: Infinity,
    allowClear: true
});
// Edit
$(".btnEdit").on("click", function(e) {
    var url = $(this).data("url");
    var param = "page";
    var paramVal = getURLParam("page");
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});
// Confirm Delete
$(".btnDelete").on("click", function(e) {
    //
    var name = $(this).data("name");
    var title = "Xóa";
    var type = "red";
    var btnClass = "danger";
    //
    confirmForm($(this), title, type, btnClass, name);
});
