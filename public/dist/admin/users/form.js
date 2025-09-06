// Select2
$(function() {
    $("#role").select2({
        placeholder: "Chọn vai trò",
        theme: "bootstrap4",
        minimumResultsForSearch: Infinity
    });

    if ($("#role").hasClass("is-invalid")) {
        $("#role")
            .next()
            .find(".select2-selection")
            .addClass("is-invalid");
    }

    if ($("#isDelete").val() > 0) {
        $("#btnDelete").remove();
    }
});
//
$("#btnList").on("click", updateParameter);
//
$("#btnCreate").on("click", function() {
    var url = $(this).attr("data-link");
    //
    window.location.href = url;
});
//
$("#btnCancel").on("click", function() {
    window.history.back();
});
//
function updateParameter() {
    var url = $(this).attr("data-link");
    var param = "page";
    var paramVal = $("#page").val();
    url = updateURLParameter(url, param, paramVal);
    //
    var param = "id";
    var paramVal = $("#id").text();
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
}
//
$(function() {
    updateClassifies();
});
//
function updateClassifies() {
    var data = {};
    $.each(getURLParams(window.location.search), function(key, value) {
        data[key] = value;
    });
    var urlParameter = encodeQueryData(data);
    if (urlParameter != "") {
        $(document)
            .find('input[name="classifies"]')
            .val(urlParameter);
        //
        var createLink = $("#btnCreate").attr("data-link");
        createLink += "?" + urlParameter;
        $("#btnCreate").attr("data-link", createLink);
        //
        var listLink = $("#btnList").attr("data-link");
        listLink += "?" + urlParameter;
        $("#btnList").attr("data-link", listLink);
    }
}
