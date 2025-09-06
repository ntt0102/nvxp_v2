var treeLeftZoom = 1.0;
var treeTopZoom = 1.0;

$("#idTreeLeft > ul").treeLeft();
$("#idTreeLeft > ul .info").click();
$("#idTreeLeft li.branch").children().children("li").removeClass("hide");
$("#idTreeLeft > ul").width(1080);
//
$("#idTreeTop > ul").treeTop();
$("#idTreeTop > ul .info").click();
$("#idTreeTop li.branch").children().children("li").removeClass("hide");

if ($("#treeToggle").attr("tree-mode") == "left") {
    setFocusedNodePosition($("#idTreeLeft > ul > li"));
} else {
    setFocusedNodePosition($("#idTreeTop > ul > li"));
}

$("#treeToggle").on("click", function () {
    if ($(this).attr("tree-mode") == "top") {
        $("#idTreeTop").addClass("hide");
        $("#idTreeLeft").removeClass("hide");
        setFocusedNodePosition($("#idTreeLeft > ul > li"));
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
        setFocusedNodePosition($("#idTreeTop > ul > li"));
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
});

$(document).ready(function () {
    $("#btn_ZoomIn").click(function () {
        if ($("#treeToggle").attr("tree-mode") == "left") {
            if (treeLeftZoom < 1.5) {
                zoomDiv($("#idTreeLeft"), (treeLeftZoom += 0.1));
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeLeft > ul > li"));
            } else $("#btn_ZoomIn").attr("disabled", "disabled");
        } else {
            if (treeTopZoom < 1.5) {
                zoomDiv($("#idTreeTop"), (treeTopZoom += 0.1));
                if ($("#btn_ZoomOut").is(":disabled")) {
                    $("#btn_ZoomOut").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeTop > ul > li"));
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
                setFocusedNodePosition($("#idTreeLeft > ul > li"));
            } else $("#btn_ZoomOut").attr("disabled", "disabled");
            // }
        } else {
            if (treeTopZoom > 0.6) {
                zoomDiv($("#idTreeTop"), (treeTopZoom -= 0.1));
                if ($("#btn_ZoomIn").is(":disabled")) {
                    $("#btn_ZoomIn").removeAttr("disabled");
                }
                setFocusedNodePosition($("#idTreeTop > ul > li"));
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
            setFocusedNodePosition($("#idTreeLeft > ul > li"));
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
            setFocusedNodePosition($("#idTreeTop > ul > li"));
        }
    });
    $("#btn_FullScreen").click(function () {
        var elem = document.getElementById("treeContainer");
        if (
            (document.fullScreenElement !== undefined &&
                document.fullScreenElement === null) ||
            (document.msFullscreenElement !== undefined &&
                document.msFullscreenElement === null) ||
            (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
            (document.webkitIsFullScreen !== undefined &&
                !document.webkitIsFullScreen)
        ) {
            if (elem.requestFullScreen) {
                elem.requestFullScreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullScreen) {
                elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
            var loadWaitingHtml = $(".load-waiting")
                .clone()
                .wrap("<p>")
                .parent()
                .html();
            $("#treeContainer").append(loadWaitingHtml);
            $(this).find("i").removeClass("fa-expand").addClass("fa-compress");
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            $("#treeContainer > .load-waiting").remove();
            $(this).find("i").removeClass("fa-compress").addClass("fa-expand");
        }
    });
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
            left =
                treeTopZoom * (position.left - width / 2 - 60) - container.left;
        }
        $(".table-responsive").scrollTop(top);
        $(".table-responsive").scrollLeft(left);
    }
}

function zoomDiv(element, value, speed) {
    if (speed == undefined) speed = 200;
    element.animate({ zoom: value }, speed);
}

$(".filter").on("click", function () {
    var url = $(this).attr("url");
    //
    $.each(getURLParams(window.location.search), function (key, value) {
        var param = key;
        var paramVal = value;
        url = updateURLParameter(url, param, paramVal);
    });
    //
    var param = "filterMode";
    var paramVal = $(this).attr("filterMode");
    //
    url = updateURLParameter(url, param, paramVal);
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

$(".contextMenu > .edit").on("click", function () {
    showWait();
    var url = $(this).attr("url");
    url = url.replace("ID", $(this).parent().attr("memberId"));
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
    $(".contextMenu").addClass("hide");
    $(".infoPopup").addClass("hide");
    $(".help.selected").removeClass("selected");
});

$(".contextMenu, .infoPopup").on("click", function (event) {
    event.stopPropagation();
});
