var treeLeftZoom = 1.0;
var treeTopZoom = 1.0;

$("#idTreeLeft > ul").treeLeft();
$("#idTreeTop > ul").treeTop();

if ($("#treeToggle").attr("tree-mode") == "left") {
    setFocusedNodePosition($("#idTreeLeft .focus"));
} else {
    setFocusedNodePosition($("#idTreeTop .focus"));
}

$("#treeToggle").on("click", function () {
    var preScrollTop = $(this).attr("scrolltop");
    var preScrollLeft = $(this).attr("scrollleft");
    $(this).attr("scrolltop", $(".tab-content").scrollTop());
    $(this).attr("scrollleft", $(".tab-content").scrollLeft());
    if ($(this).attr("tree-mode") == "top") {
        $("#idTreeTop").addClass("hide");
        $("#idTreeLeft").removeClass("hide");
        setFocusedNodePosition($("#idTreeLeft .focus"));
        //
        $(this).attr("tree-mode", "left");
        $(this)
            .find("i")
            .removeClass("fa-arrows-alt-v")
            .addClass("fa-arrows-alt-h");
        $(this).find("span").text("Dạng ngang");
        //
        if (treeLeftZoom > 0.6) {
            $("#btn_ZoomOut").removeAttr("disabled");
        } else $("#btn_ZoomOut").attr("disabled", "disabled");
        //
        if (treeLeftZoom < 1.5) {
            $("#btn_ZoomIn").removeAttr("disabled");
        } else $("#btn_ZoomIn").attr("disabled", "disabled");
    } else {
        $("#idTreeLeft").addClass("hide");
        $("#idTreeTop").removeClass("hide");
        setFocusedNodePosition($("#idTreeTop .focus"));
        //
        $(this).attr("tree-mode", "top");
        $(this)
            .find("i")
            .addClass("fa-arrows-alt-v")
            .removeClass("fa-arrows-alt-h");
        $(this).find("span").text("Dạng dọc");
        //
        if (treeTopZoom > 0.6) {
            $("#btn_ZoomOut").removeAttr("disabled");
        } else $("#btn_ZoomOut").attr("disabled", "disabled");
        //
        if (treeTopZoom < 1.5) {
            $("#btn_ZoomIn").removeAttr("disabled");
        } else $("#btn_ZoomIn").attr("disabled", "disabled");
    }
    //
    if (preScrollTop != "0") {
        $(".tab-content").scrollTop(preScrollTop);
    }
    if (preScrollLeft != "0") {
        $(".tab-content").scrollLeft(preScrollLeft);
    }
});

$(document).ready(function () {
    $("#btn_ZoomIn").click(function () {
        if ($("#treeToggle").attr("tree-mode") == "left") {
            if (treeLeftZoom < 1.5) {
                zoomDiv($("#idTreeLeft"), (treeLeftZoom += 0.1));
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeLeft .focus"));
            } else $("#btn_ZoomIn").attr("disabled", "disabled");
        } else {
            if (treeTopZoom < 1.5) {
                zoomDiv($("#idTreeTop"), (treeTopZoom += 0.1));
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeTop .focus"));
            } else $("#btn_ZoomIn").attr("disabled", "disabled");
        }
    });
    $("#btn_ZoomOut").click(function () {
        if ($("#treeToggle").attr("tree-mode") == "left") {
            // if(treeLeftZoom > 0){
            if (treeLeftZoom > 0.6) {
                zoomDiv($("#idTreeLeft"), (treeLeftZoom -= 0.1));
                if ($("#btn_ZoomIn").is(":disabled")) {
                    $("#btn_ZoomIn").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeLeft .focus"));
            } else $("#btn_ZoomOut").attr("disabled", "disabled");
            // }
        } else {
            if (treeTopZoom > 0.6) {
                zoomDiv($("#idTreeTop"), (treeTopZoom -= 0.1));
                if ($("#btn_ZoomIn").is(":disabled")) {
                    $("#btn_ZoomIn").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeTop .focus"));
            } else $("#btn_ZoomOut").attr("disabled", "disabled");
        }
    });
    $("#btn_ZoomReset").click(function () {
        if ($("#treeToggle").attr("tree-mode") == "left") {
            if (treeLeftZoom != 1.0) {
                treeLeftZoom = 1.0;
                zoomDiv($("#idTreeLeft"), treeLeftZoom);
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                if ($("#btn_ZoomIn").is(":disabled")) {
                    $("#btn_ZoomIn").removeAttr("disabled");
                }
            }
            setFocusedNodePosition($("#idTreeLeft .focus"));
        } else {
            if (treeTopZoom != 1.0) {
                treeTopZoom = 1.0;
                zoomDiv($("#idTreeTop"), treeTopZoom);
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                if ($("#btn_ZoomIn").is(":disabled")) {
                    $("#btn_ZoomIn").removeAttr("disabled");
                }
            }
            setFocusedNodePosition($("#idTreeTop .focus"));
        }
    });
    $("#btn_FullScreen").click(function () {
        if ($.fullscreen.isFullScreen()) {
            $.fullscreen.exit();
        } else {
            $("#treeContainer").fullscreen();
        }

        return false;
    });
    $(document).bind("fscreenchange", changeFullscreenStatus);
    window.onresize = function () {
        if (window.innerWidth != screen.width) {
            changeFullscreenStatus();
        }
    };
    function changeFullscreenStatus() {
        if ($.fullscreen.isFullScreen()) {
            var loadWaitingHtml = $(".load-waiting")
                .clone()
                .wrap("<p>")
                .parent()
                .html();
            $("#treeContainer").append(loadWaitingHtml).css("overflow", "auto");
            $("#btn_FullScreen > i")
                .removeClass("fa-expand")
                .addClass("fa-compress");
        } else {
            $("#treeContainer > .load-waiting").remove();
            $("#btn_FullScreen > i")
                .removeClass("fa-compress")
                .addClass("fa-expand");
        }
        if ($("#treeToggle").attr("tree-mode") == "left") {
            setFocusedNodePosition($("#idTreeLeft .focus"));
        } else {
            setFocusedNodePosition($("#idTreeTop .focus"));
        }
    }
});

function setFocusedNodePosition(element) {
    if (element.length > 0) {
        element = element.children(".info");
        //
        var top, left;
        var height = element.height();
        var width = element.width();
        //
        $(".table-responsive").scrollTop(0);
        $(".table-responsive").scrollLeft(0);

        var container = $(".table-responsive").offset();
        var position = element.offset();

        if ($("#treeToggle").attr("tree-mode") == "left") {
            top = treeLeftZoom * (position.top - height / 2) - container.top;
            left = treeLeftZoom * (position.left - width / 2) - container.left;
        } else {
            top = treeTopZoom * (position.top - height / 2) - container.top;
            left = treeTopZoom * (position.left - width / 2) - container.left;
        }
        $(".table-responsive").scrollTop(top);
        $(".table-responsive").scrollLeft(left);
    }
}

function zoomDiv(element, value, speed) {
    if (speed == undefined) speed = 200;
    element.animate({ zoom: value }, speed);
    updateWidth(element.children("ul"));

    function updateWidth(tree) {
        var level = 0;
        tree.find("li")
            .not(".hide")
            .each(function () {
                var tmp = $(this).parents("ul").length;
                if (tmp > level) level = tmp;
            });
        tree.width(450 + 33 * level);
    }
}

$(".filter").on("click", function () {
    var url = $(this).attr("url");
    var filterModeTag = "filterMode";
    var filterMode = $(this).attr("filterMode");
    url = updateURLParameter(url, filterModeTag, filterMode);
    //
    $.each(getURLParams(window.location.search), function (key, value) {
        if (key == filterMode) {
            url = updateURLParameter(url, "id", value);
        } else {
            if (filterMode == "base") {
                if (key == "view") {
                    url = updateURLParameter(url, key, value);
                }
            } else {
                if (key == "base") {
                    url = updateURLParameter(url, key, value);
                }
            }
        }
    });
    //
    window.location.href = url;
});

// Show help popup
$(".help").on("click", showContextMenu);

function showContextMenu(event) {
    event.stopPropagation();
    //
    var top, left;
    var height = $(document).height();
    var width = $(document).width();
    //
    selectedUser = $(this).parent().children(".info");
    //
    $(".contextMenu").attr("memberId", selectedUser.attr("memberId"));
    //
    if (selectedUser.attr("parentPoint") == "1") {
        if (
            selectedUser.attr("basePoint") == "1" ||
            selectedUser.attr("hasChilds") == "0"
        ) {
            $(".contextMenu > .basePoint").addClass("hide");
        } else {
            $(".contextMenu > .basePoint").removeClass("hide");
        }
        $(".contextMenu > .branch").removeClass("hide");
        $(".contextMenu > .addChild").removeClass("hide");
    } else {
        $(".contextMenu > .basePoint").addClass("hide");
        $(".contextMenu > .branch").addClass("hide");
        $(".contextMenu > .addChild").addClass("hide");
    }
    if (selectedUser.attr("viewMark") == "1") {
        $(".contextMenu > .viewMark").addClass("hide");
    } else {
        $(".contextMenu > .viewMark").removeClass("hide");
    }
    //
    $(".contextMenu").removeClass("hide");
    var popupHeight = $(".contextMenu").height();
    var popupWidth = $(".contextMenu").width();
    //
    var pageY = event.pageY;
    var pageX = event.pageX;
    top = height - pageY < popupHeight ? pageY - 10 - popupHeight : pageY + 10;
    left = width - pageX < popupWidth ? pageX - 10 - popupWidth : pageX + 10;
    //
    $(".infoPopup").addClass("hide");
    $(".contextMenu").offset({ top: top, left: left });
    //
    $(".help.selected").removeClass("selected");
    $(this).addClass("selected");
}

$(".contextMenu > .basePoint").on("click", function () {
    showWait();
    var url = window.location.href;
    var param = "base";
    var paramVal = $(this).parent().attr("memberId");
    //
    url = updateURLParameter(url, param, paramVal);
    window.location.href = url;
});
$(".contextMenu > .viewMark").on("click", function () {
    showWait();
    var url = window.location.href;
    var param = "view";
    var paramVal = $(this).parent().attr("memberId");
    //
    url = updateURLParameter(url, param, paramVal);
    window.location.href = url;
});
$(".contextMenu > .propose").on("click", function () {
    showWait();
    var url = $(this).attr("url");
    url = url.replace("ID", $(this).parent().attr("memberId"));
    window.location.href = url;
});
$(".contextMenu > .edit").on("click", function () {
    showWait();
    var url = $(this).attr("url");
    url = url.replace("ID", $(this).parent().attr("memberId"));
    //
    window.location.href = url;
});

$(".contextMenu > .branch").on("click", function () {
    showWait();
    var url = $(this).attr("url");
    var id = selectedUser.attr("memberId");
    var name = selectedUser.children(".name").html();
    name = name.split('<div data-original-title="" title=""></div>').join(" ");
    name = name.split("<div></div>").join(" ");
    name = name
        .toLowerCase()
        .replace(
            /^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g,
            function (letter) {
                return letter.toUpperCase();
            }
        );
    var pedigree = selectedUser.attr("pedigree");
    //
    requestAjax(url, { id: id, name: name, pedigree: pedigree }, function (
        data
    ) {
        if (data.status != "error") {
            var redirectUrl =
                $(".contextMenu > .branch").attr("redirect") + "?branch=" + id;
            window.location.href = redirectUrl;
        } else errorDialog("Chọn chi phái thất bại");
        destroyWait();
    });
});

$(".contextMenu > .addChild").on("change", function () {
    showWait();
    var child = $(this).children("select").val();
    var url = $(this).attr("url");
    url +=
        "?pedigree=" +
        (Number(selectedUser.attr("pedigree")) + (child == 4 ? 0 : 1));
    url += "&relation=" + child;
    url +=
        "&" +
        (child == 4 ? "couple" : "parent") +
        "=" +
        selectedUser.attr("memberId");
    //
    window.location.href = url;
});

$(".contextMenu > .detailInfo").on("click", function (event) {
    event.stopPropagation();
    //
    var top, left;
    var height = $(document).height();
    var width = $(document).width();
    //
    updateInfoPopup();
    //
    $(".infoPopup").removeClass("hide");
    var popupHeight = $(".infoPopup").height();
    var popupWidth = $(".infoPopup").width();
    //
    if (
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            navigator.userAgent
        )
    ) {
        top = 0.5 * (height - popupHeight);
        left = 0.5 * (width - popupWidth);
    } else {
        var menuOffset = $(".contextMenu").offset();
        var pageY = menuOffset.top;
        var pageX = menuOffset.left;
        top = height - pageY < popupHeight ? pageY - popupHeight : pageY;
        left = width - pageX < popupWidth ? pageX - popupWidth : pageX;
    }
    //
    $(".contextMenu").addClass("hide");
    $(".infoPopup").offset({ top: top, left: left });
});

function updateInfoPopup() {
    var name = selectedUser.children(".name").html();
    name = name.split('<div data-original-title="" title=""></div>').join(" ");
    name = name.split("<div></div>").join(" ");
    $(".infoPopup .name").text(name);
    $(".infoPopup .memberId").text(selectedUser.attr("memberId"));
    $(".infoPopup .pedigree").text(selectedUser.attr("pedigree"));
    $(".infoPopup .relation").text(selectedUser.attr("relation"));
    //
    var linkName = selectedUser
        .parent()
        .parent()
        .parent()
        .children(".info")
        .children(".name")
        .html();
    if (linkName != undefined) {
        var linkName = linkName
            .split('<div data-original-title="" title=""></div>')
            .join(" ");
        var linkName = linkName.split("<div></div>").join(" ");
        var linkTitle = selectedUser.attr("parentFlag") == 1 ? "Cha" : "Chồng";
        $(".infoPopup .linkTitle").text(linkTitle);
        $(".infoPopup .linkName")
            .text(linkName.toLowerCase())
            .css("textTransform", "capitalize");
        $(".infoPopup .linkName").parent().removeClass("hide");
    } else $(".infoPopup .linkName").parent().addClass("hide");
    //
    var note = selectedUser.attr("note");
    if (note.trim() != "") {
        $(".infoPopup .note").text(note);
        $(".infoPopup .note").parent().removeClass("hide");
    } else $(".infoPopup .note").parent().addClass("hide");
}

$("body").on("click", function () {
    if ($(".jconfirm").length == 0) {
        $(".contextMenu").addClass("hide");
        $(".infoPopup").addClass("hide");
        $(".help.selected").removeClass("selected");
    }
});

$(".contextMenu, .infoPopup").on("click", function (event) {
    event.stopPropagation();
});
