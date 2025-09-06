$(".result-item").on("click", function() {
    var filterMode = $("#filterMode").val();
    if (filterMode != "") {
        showWait();
        var url = $("#url").val();
        var fnc = $("#url").attr("fnc");
        switch (Number(fnc)) {
            case 1:
                $.each(getURLParams(window.location.search), function(
                    key,
                    value
                ) {
                    if (key == "base" || key == "view") {
                        url = updateURLParameter(url, key, value);
                    }
                });
                //
                var param = filterMode;
                var paramVal = $(this).attr("dataId");
                url = updateURLParameter(url, param, paramVal);
                window.location.href = url;
                break;
            case 2:
                var gender = $(this).attr("dataGender");
                if (gender == "1") {
                    var ajaxUrl = $("#url").attr("ajax");
                    var id = $(this).attr("dataId");
                    var name = $(this).attr("dataName");
                    var pedigree = $(this).attr("dataPedigree");
                    //
                    requestAjax(
                        ajaxUrl,
                        { id: id, name: name, pedigree: pedigree },
                        function(data) {
                            if (data.status != "error") {
                                url += "&branch=" + id;
                                window.location.href = url;
                            } else errorDialog("Chọn chi phái thất bại");
                        }
                    );
                } else {
                    warningDialog("Không thể chọn người này.");
                    destroyWait();
                }
                break;
            case 3:
                $.each(getURLParams(window.location.search), function(
                    key,
                    value
                ) {
                    url = updateURLParameter(url, key, value);
                });
                //
                var param = "id";
                var paramVal = $(this).attr("dataId");
                url = updateURLParameter(url, param, paramVal);
                window.location.href = url;
                break;
            default:
                break;
        }
    }
});

$("#filterMode").on("change", filter);
$("input[type='text']").keypress(function(event) {
    var keycode = event.keyCode ? event.keyCode : event.which;
    if (keycode == "13") {
        filterOrRedirect();
    }
});
function filter() {
    $("form")
        .find("[name]")
        .each(function() {
            if ($(this).val() == "") {
                $(this).attr("disabled", "disabled");
            }
        });
    $("form").submit();
}

function filterOrRedirect() {
    $("form")
        .find("[name]")
        .each(function() {
            if ($(this).val() == "") {
                $(this).attr("disabled", "disabled");
            }
        });
    var filterMode = $("#filterMode").val();
    if (filterMode != "") {
        var url = $("#url").val();
        switch (filterMode) {
            case "modify":
                var url = $("#url").val();
                var values = {};
                $.each($("form").serializeArray(), function(i, field) {
                    // console.log(field);
                    if (field.name != "_token") {
                        url = updateURLParameter(url, field.name, field.value);
                    }
                });
                window.location.href = url;
                break;
            default:
                $("form").submit();
                break;
        }
    }
}

$(function() {
    if (
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            navigator.userAgent
        )
    ) {
        if ($(".result-item").length != 0) {
            $("#btnFilter").click();
        }
    }
});
