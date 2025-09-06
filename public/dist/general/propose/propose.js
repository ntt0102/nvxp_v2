function readURL(input) {
    if (input != undefined && input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
            $("#preview").attr("src", e.target.result);
            $("#hd-image").val(e.target.result);
            $("#delete-image").removeClass("hide");
        };
    } else {
        $("#preview").attr("src", "");
        $("#hd-image").val("");
        $("#delete-image").addClass("hide");
    }
}
$(function () {
    var data = {};
    $.each(getURLParams(window.location.search), function (key, value) {
        data[key] = value;
    });
    //
    var urlParameter = encodeQueryData(data);
    $(document).find('input[name="param"]').val(urlParameter);
    //
    var description = "";
    if ($("input[name='memberId']").val() != "0") {
        description += "Sửa: \n";
        description += "[Thông tin cần sửa] \n\n";
        description += "Thêm: \n";
        description += "- Vợ: [Tên vợ], \n";
        description += "- Con trai: [Tên các con trai], \n";
        description += "- Con gái: [Tên các con gái]";
        $("#desc-title").attr("title", description);
    } else {
        description += "Góp ý xây dựng trang web";
    }
    $("#description").attr("placeholder", description);
});

$("#btnCancel").on("click", function () {
    var view = $("input[name='memberId']").val();
    if (view != "0") {
        window.location.href = updateURLParameter(
            $(this).attr("route"),
            "view",
            view
        );
    } else {
        window.history.back();
    }
});
