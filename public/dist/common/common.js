$(function () {
    // $('body>div').last().remove();
});
if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/sw.js")
            .then((registration) => {
                console.log(
                    "Service Worker registered with scope:",
                    registration.scope
                );
            })
            .catch((error) => {
                console.log("Service Worker registration failed:", error);
            });
    });
}
//
if (document.head.querySelector('meta[name="csrf-token"]')) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
//
// Import Js
function jsRequire(url) {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", url, false); // <-- the 'false' makes it synchronous
    ajax.onreadystatechange = function () {
        var script = ajax.response || ajax.responseText;
        if (ajax.readyState === 4) {
            switch (ajax.status) {
                case 200:
                    eval.apply(window, [script]);
                    // console.log("script loaded: ", url);
                    break;
                default:
                    console.log("ERROR: script not loaded: ", url);
            }
        }
    };
    ajax.send(null);
}
// Tooltip
$("img").attr("title", "");
$('[title!=""]').tooltip({
    container: "body",
});

// Loading
$(destroyWait);
//
$(document).ajaxSend(function (event, xhr, options) {
    var listUrl = $(".load-waiting .ajax > option")
        .map(function () {
            return this.value;
        })
        .get();
    if (jQuery.inArray(options.url, listUrl) == -1) {
        showWait();
    }
});
// .ajaxComplete( function(event, xhr, options) {
//     destroyWait();
// });
//
$("a:not(.load-none)").on("click", showWait);
$("form").on("submit", showWait);
$("tr.load").on("dblclick", showWait);
$("select.load").on("change", showWait);
$(".btn.load").on("click", showWait);
//
function showWait() {
    $(".load-waiting > div > div").text("");
    $(".load-waiting").removeClass("d-none");
}
//
function destroyWait() {
    $(".load-waiting").addClass("d-none");
}

// Separrate Numver
function commaSeparateCurrency(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, "$1" + "." + "$2");
    }
    return val;
}
function preprocessCurrency(val) {
    val = val.toString().trim();
    val = val
        .split(" ")
        .join("")
        .split(".")
        .join("")
        .split(",")
        .join("")
        .split("đ")
        .join("");
    if (val != "" && $.isNumeric(val)) {
        val = Number(val).toString();
    }
    return val;
}
function commaSeparateEvent(idArr) {
    $.each(idArr, function (index, val) {
        $("#_" + val).on("keyup", function () {
            var value = preprocessCurrency($(this).val());
            var valueSeparate = commaSeparateCurrency(value);
            $(this).val(valueSeparate);
            $("#" + val).val(value != "" ? value : "0");
        });
    });
}

$.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = ev.keyCode ? ev.keyCode : ev.which;
            if (keycode == "13") {
                fnc.call(this, ev);
            }
        });
    });
};

function errorDialog(message) {
    $.dialog({
        icon: "fas fa-exclamation-triangle",
        title: "Lỗi",
        content: message,
        type: "red",
        theme: "material",
    });
}

function warningDialog(message) {
    $.dialog({
        icon: "fas fa-exclamation-triangle",
        title: "Cảnh báo",
        content: message,
        type: "orange",
        theme: "material",
    });
}

function infoDialog(message) {
    $.dialog({
        icon: "fas fa-info-circle",
        title: "Thông báo",
        content: message,
        type: "blue",
        theme: "material",
    });
}

function errorAlert(message, url) {
    $.alert({
        icon: "fas fa-exclamation-triangle",
        title: "Lỗi",
        content: message,
        type: "red",
        theme: "material",
        buttons: {
            cancel: {
                text: "Đóng",
                action: function () {
                    if (url != undefined) window.location.href = url;
                    else location.reload();
                },
            },
        },
        onOpen: function () {
            $(".jconfirm button:nth-child(1)").focus();
        },
    });
}

$(".page-item > a").on("click", function () {
    var url = window.location.href;
    var param = "page";
    var paramVal = $(this).data("page");

    url = updateURLParameter(url, param, paramVal);
    window.location.href = url;
});

function updateURLParameter(url, param, paramVal) {
    if (paramVal != undefined || paramVal != "") {
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";

        if (additionalURL) {
            var tmpAnchor = additionalURL.split("#");
            var TheParams = tmpAnchor[0];
            TheAnchor = tmpAnchor[1];
            if (TheAnchor) additionalURL = TheParams;

            tempArray = additionalURL.split("&");

            for (var i = 0; i < tempArray.length; i++) {
                if (tempArray[i].split("=")[0] != param) {
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        } else {
            var tmpAnchor = baseURL.split("#");
            var TheParams = tmpAnchor[0];
            TheAnchor = tmpAnchor[1];

            if (TheParams) baseURL = TheParams;
        }

        if (TheAnchor) paramVal += "#" + TheAnchor;

        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    } else return url;
}

// function toggleFullScreen(elem) {
//     // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
//     if (
//         (document.fullScreenElement !== undefined &&
//             document.fullScreenElement === null) ||
//         (document.msFullscreenElement !== undefined &&
//             document.msFullscreenElement === null) ||
//         (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
//         (document.webkitIsFullScreen !== undefined &&
//             !document.webkitIsFullScreen)
//     ) {
//         if (elem.requestFullScreen) {
//             elem.requestFullScreen();
//         } else if (elem.mozRequestFullScreen) {
//             elem.mozRequestFullScreen();
//         } else if (elem.webkitRequestFullScreen) {
//             elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
//         } else if (elem.msRequestFullscreen) {
//             elem.msRequestFullscreen();
//         }
//         $(".fullscreen").html('<i class="fas fa-compress"></i>');
//         $(".fullscreen").attr("data-original-title", "Thu nhỏ màn hình");
//         $(".fullscreen").tooltip("hide");
//     } else {
//         if (document.cancelFullScreen) {
//             document.cancelFullScreen();
//         } else if (document.mozCancelFullScreen) {
//             document.mozCancelFullScreen();
//         } else if (document.webkitCancelFullScreen) {
//             document.webkitCancelFullScreen();
//         } else if (document.msExitFullscreen) {
//             document.msExitFullscreen();
//         }
//         $(".fullscreen").html('<i class="fas fa-expand"></i>');
//         $(".fullscreen").attr("data-original-title", "Phóng to màn hình");
//         $(".fullscreen").tooltip("hide");
//     }
// }

// Back to Top
$(function () {
    $(".wrapper").scroll(function () {
        if ($(this).scrollTop() > 100) {
            $("#goTop").fadeIn();
        } else {
            $("#goTop").fadeOut();
        }
    });
    $("#goTop").on("click", function () {
        $(".wrapper").animate({ scrollTop: 0 }, 600);
        return false;
    });
});
// Countdown
function countDown(seconds) {
    if (typeof seconds !== "undefined" && seconds > 0) {
        if (typeof interval !== "undefined") {
            clearInterval(interval);
        }
        // Set the date we're counting down to
        var countDownDate = new Date();
        countDownDate.setSeconds(countDownDate.getSeconds() + seconds);
        countDownDate.getTime();

        // Update the count down every 1 second
        interval = setInterval(function () {
            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            // var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            $(".load-waiting > div > div").text("Chờ " + seconds + " s");

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(interval);
                $(".load-waiting > div > div").text("Chờ ...");
            }
        }, 0);
    }
}
//
function testLatency() {
    var fullDomain =
        location.protocol +
        "//" +
        location.hostname +
        (location.port ? ":" + location.port : "");
    var startTime = new Date().getTime(),
        endTime;
    $.ajax({
        type: "POST",
        url: fullDomain + "/latency",
        async: false,
        cache: false,
        global: false,
        success: function () {
            endTime = new Date().getTime();
        },
    });
    return endTime - startTime;
}

/*
 * Returns a map of querystring parameters
 *
 * Keys of type <fieldName>[] will automatically be added to an array
 *
 * @param String url
 * @return Object parameters
 */
function getURLParams(url) {
    var regex = /([^=&?]+)=([^&#]*)/g,
        params = {},
        parts,
        key,
        value;

    while ((parts = regex.exec(url)) != null) {
        (key = parts[1]), (value = parts[2]);
        var isArray = /\[\]$/.test(key);

        if (isArray) {
            params[key] = params[key] || [];
            params[key].push(value);
        } else {
            params[key] = value;
        }
    }
    return params;
}

/*
 * Returns a map of querystring parameter
 *
 *
 * @param String parameter name
 * @return Object parameter value
 */
function getURLParam(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split("&");
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split("=");
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return "";
}

// image viewer
$(".zoom-in").on("click", function () {
    var src = $(this).attr("src");
    imageViewer(src);
});
function imageViewer(src) {
    $('<div class="image-viewer"></div>').appendTo("body");
    //
    $("<div>")
        .css("background-image", "url(" + src + ")")
        .click(function (e) {
            $(this).parent().remove();
        })
        .appendTo(".image-viewer");
    //
    $('<i class="far fa-times-circle"></i>')
        .click(function () {
            $(this).parent().remove();
        })
        .appendTo(".image-viewer");
}

function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(
        url
    );
}

function encodeQueryData(data) {
    var ret = new Array();
    for (var d in data)
        if (data[d] != undefined) {
            ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
        }
    return ret.join("&");
}

// Refresh By F5 Button
document.onkeydown = fkey;
document.onkeypress = fkey;
document.onkeyup = fkey;

var wasPressed = false;

function fkey(e) {
    e = e || window.event;
    if (wasPressed) return;
    //
    if (e.code == "F5") {
        showWait();
        wasPressed = true;
    }
}
