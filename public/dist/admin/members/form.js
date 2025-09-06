// Select2
$(function () {
    $("#gender").select2({
        placeholder: "Chọn giới tính",
        theme: "bootstrap4",
        minimumResultsForSearch: Infinity,
        allowClear: true,
    });

    if ($("#gender").hasClass("is-invalid")) {
        $("#gender").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    $("#branch").select2({
        placeholder: "Chọn chi phái",
        theme: "bootstrap4",
        allowClear: true,
    });

    if ($("#branch").hasClass("is-invalid")) {
        $("#branch").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    $("#relation").select2({
        placeholder: "Chọn quan hệ gia phả",
        theme: "bootstrap4",
        allowClear: true,
    });

    if ($("#relation").hasClass("is-invalid")) {
        $("#relation").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    $("#pedigree").select2({
        placeholder: "Chọn hệ",
        theme: "bootstrap4",
        allowClear: true,
    });
    if ($("#name").length == 0) {
        $("#pedigree").focus();
    }

    if ($("#pedigree").hasClass("is-invalid")) {
        $("#pedigree").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    $("#parent").select2({
        placeholder: "Chọn cha",
        theme: "bootstrap4",
        allowClear: true,
    });

    if ($("#parent").hasClass("is-invalid")) {
        $("#parent").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    var coupleName = $("#couple")
        .parent()
        .children("label")
        .text()
        .toLowerCase();
    $("#couple").select2({
        placeholder: "Chọn " + coupleName,
        theme: "bootstrap4",
        allowClear: true,
    });

    if ($("#couple").hasClass("is-invalid")) {
        $("#couple").next().find(".select2-selection").addClass("is-invalid");
    }
    //
    $("#role").select2({
        placeholder: "Chọn vai trò",
        theme: "bootstrap4",
        minimumResultsForSearch: Infinity,
    });

    if ($("#role").hasClass("is-invalid")) {
        $("#role").next().find(".select2-selection").addClass("is-invalid");
    }

    if ($("#isDelete").val() > 0) {
        $("#btnDelete").remove();
    }
    //
    if ($("#id").text() != "") {
        $("#btnFilter")
            .off("click")
            .on("click", function () {
                var url = $(this).data("link");
                url = updateURLParameter(url, "id", $("#id").text());
                var params = getURLParams(window.location.search);
                $.each(params, function (key, value) {
                    var param = key;
                    var paramVal = value;
                    url = updateURLParameter(url, param, paramVal);
                });
                window.location.href = url;
            });
    }
});
//
$("#btnList").on("click", updateParameter);
//
$("#btnCreate").on("click", function () {
    var url = $(this).attr("data-link");
    //
    var param = "pedigree";
    var paramVal = $("#pedigree").val();
    url = updateURLParameter(url, param, paramVal);
    //
    var param = "relation";
    var paramVal = $("#relation").val();
    url = updateURLParameter(url, param, paramVal);
    //
    var param = "parent";
    var paramVal = $("#parent").val();
    url = updateURLParameter(url, param, paramVal);
    //
    window.location.href = url;
});
//
$("#btnCancel").on("click", function () {
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
$(function () {
    updateClassifies();
});
//
function updateClassifies() {
    var data = {};
    $.each(getURLParams(window.location.search), function (key, value) {
        data[key] = value;
    });
    var urlParameter = encodeQueryData(data);
    if (urlParameter != "") {
        $(document).find('input[name="classifies"]').val(urlParameter);
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

// Datepicker
$(".form-group .date").datepicker({
    format: "dd/mm/yyyy",
    clearBtn: true,
    autoclose: true,
    defaultViewDate: { year: 1990, month: 01, day: 01 },
});

$("#branch").on("change", function () {
    var pedigree = $("#pedigree").val();
    var relation = $("#relation").val();
    var upperFlag = $("#upperFlag").is(":checked");
    if (
        pedigree != "" &&
        (relation != "" || (relation == "" && pedigree == "1")) &&
        !upperFlag
    ) {
        showWait();
        var url = window.location.href;
        var param = "branch";
        var paramVal = $(this).val();
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "upper";
        var paramVal = upperFlag ? 1 : 0;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "relation";
        var paramVal = relation;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "pedigree";
        var paramVal = pedigree;
        url = updateURLParameter(url, param, paramVal);
        window.location.href = url;
    }
});

$("#upperFlag").on("change", function () {
    var pedigree = $("#pedigree").val();
    var relation = $("#relation").val();
    var branch = $("#branch").val();
    if (
        pedigree != "" &&
        (relation != "" || (relation == "" && pedigree == "1")) &&
        branch == ""
    ) {
        showWait();
        var url = window.location.href;
        //
        var param = "upper";
        var paramVal = $(this).is(":checked") ? 1 : 0;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "relation";
        var paramVal = relation;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "pedigree";
        var paramVal = pedigree;
        url = updateURLParameter(url, param, paramVal);
        window.location.href = url;
    }
});

$("#relation").on("change", function () {
    var pedigree = $("#pedigree").val();
    var upperFlag = $("#upperFlag").is(":checked");
    var branch = $("#branch").val();
    var name = $("#name").val();
    if (pedigree != "" && (branch != "" || name != undefined || upperFlag)) {
        showWait();
        var url = window.location.href;
        var param = "relation";
        var paramVal = $(this).val();
        url = updateURLParameter(url, param, paramVal);
        //
        if ($("#id").text() == "") {
            var param = "branch";
            var paramVal = branch;
            url = updateURLParameter(url, param, paramVal);
        }
        //
        var param = "upper";
        var paramVal = upperFlag ? 1 : 0;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "pedigree";
        var paramVal = pedigree;
        url = updateURLParameter(url, param, paramVal);
        window.location.href = url;
    }
});
//
$("#pedigree").on("change", function () {
    var pedigree = $(this).val();
    var relation = $("#relation").val();
    var upperFlag = $("#upperFlag").is(":checked");
    var branch = $("#branch").val();
    var name = $("#name").val();
    if (
        (relation != "" || (relation == "" && pedigree == "1")) &&
        (branch != "" || name != undefined || upperFlag)
    ) {
        showWait();
        var url = window.location.href;
        var param = "pedigree";
        var paramVal = pedigree;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "branch";
        var paramVal = branch;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "upper";
        var paramVal = upperFlag ? 1 : 0;
        url = updateURLParameter(url, param, paramVal);
        //
        var param = "relation";
        var paramVal = relation;
        url = updateURLParameter(url, param, paramVal);
        window.location.href = url;
    }
});

$("#admin").on("change", function () {
    var changed = $(this).attr("changed");
    if (changed == 1) {
        if (this.checked) {
            $("#role").parent().parent().parent().removeClass("hide");
            $("#username").parent().parent().parent().removeClass("hide");
            $("#password").parent().parent().parent().removeClass("hide");
        } else {
            $("#role").parent().parent().parent().addClass("hide");
            $("#username").parent().parent().parent().addClass("hide");
            $("#password").parent().parent().parent().addClass("hide");
        }
    } else {
        $(this).prop("checked", !this.checked);
        warningDialog("Không được thay đổi chính mình.");
    }
});

$("#role").on("change", function () {
    var changed = $(this).attr("changed");
    if (changed != 1) {
        $("#role").val("2");
        warningDialog("Không được thay đổi chính mình.");
    }
});
