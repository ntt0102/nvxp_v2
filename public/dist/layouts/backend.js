function confirmForm(
    selector,
    title,
    type,
    btnClass,
    name = "",
    urlParameter = null
) {
    var formId = selector.data("form-id");
    var form = $(document).find("#" + formId);
    if (urlParameter == null) {
        urlParameter = window.location.href.split("?").pop();
    }
    form.find('input[name="classifies"]').val(urlParameter);
    //
    $.confirm({
        title: title,
        content:
            "Bạn chắc chắn muốn " +
            title.toLowerCase() +
            " " +
            name +
            " không?",
        autoClose: "cancel|8000",
        theme: "material",
        type: type,
        buttons: {
            confirm: {
                text: "Có",
                btnClass: "btn-" + btnClass,
                action: function() {
                    if (form.length) {
                        form.submit();
                    }
                }
            },
            cancel: {
                text: "Không"
            }
        },
        onOpen: function() {
            $(".jconfirm button:nth-child(1)").focus();
        }
    });
}

// Notification
$(".dropdown.notification > a").on("click", function() {
    if ($(this).attr("aria-expanded") != "true") {
        var url = $(this).data("url");
        requestAjax(url, {}, responseNotification);
    }
});

function responseNotification(data) {
    var notifications = $(".notification .container > a");
    notifications.each(function(index) {
        $(this)
            .find(".clock")
            .text(data[index]);
    });
    //
    destroyWait();
}

// Message
$(".dropdown.message > a").on("click", function() {
    if ($(this).attr("aria-expanded") != "true") {
        var url = $(this).data("url");
        requestAjax(url, {}, responseMessage);
    }
});

function responseMessage(data) {
    var messages = $(".message .container > a");
    messages.each(function(index) {
        $(this)
            .find(".clock")
            .text(data[index]);
    });
    //
    destroyWait();
}

$.fn.getDate = function(format) {
    var gDate = new Date();
    var mDate = {
        S: gDate.getSeconds(),
        M: gDate.getMinutes(),
        H: gDate.getHours(),
        d: gDate.getDate(),
        m: gDate.getMonth() + 1,
        y: gDate.getFullYear()
    };
    // Apply format and add leading zeroes
    return format.replace(/([SMHdmy])/g, function(key) {
        return (mDate[key] < 10 ? "0" : "") + mDate[key];
    });
    return getDate(str);
};
//
$(function() {
    setTimeout(function() {
        $("input[autofocus][onfocus]").focus();
    }, 0);
});
//
$.fn.ImageResize = function(options) {
    var defaults = {
        maxSize: Number.MAX_VALUE,
        onImageResized: null
    };
    var settings = $.extend({}, defaults, options);
    var selector = $(this);
    selector.each(function(index) {
        var control = selector.get(index);
        if (
            $(control)
                .prop("tagName")
                .toLowerCase() == "input" &&
            $(control)
                .attr("type")
                .toLowerCase() == "file"
        ) {
            $(control).attr("accept", "image/*");
            $(control).attr("multiple", "true");
            control.addEventListener("change", handleFileSelect, false);
        } else {
            cosole.log("Invalid file input field");
        }
    });
    function handleFileSelect(event) {
        showWait();
        //Check File API support
        if (window.File && window.FileList && window.FileReader) {
            var count = 0;
            var files = event.target.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                //Only pics
                if (!file.type.match("image")) continue;
                var picReader = new FileReader();
                picReader.addEventListener("load", function(event) {
                    var picFile = event.target;
                    var imageData = picFile.result;
                    var img = new Image();
                    img.src = imageData;
                    img.onload = function() {
                        var width = img.width;
                        var height = img.height;
                        var isResize = false;
                        var latency = testLatency();
                        //
                        if (latency < 200) settings.maxSize = Number.MAX_VALUE;
                        else if (latency < 300) settings.maxSize = 2000;
                        else if (latency < 400) settings.maxSize = 1750;
                        else if (latency < 500) settings.maxSize = 1500;
                        else if (latency < 600) settings.maxSize = 800;
                        else if (latency < 700) settings.maxSize = 600;
                        else if (latency < 800) settings.maxSize = 500;
                        else if (latency < 900) settings.maxSize = 400;
                        //
                        if (img.width > img.height) {
                            if (img.width > settings.maxSize) {
                                width = settings.maxSize;
                                var ration = settings.maxSize / img.width;
                                height = Math.round(img.height * ration);
                                isResize = true;
                            }
                        } else {
                            if (img.height > settings.maxSize) {
                                height = settings.maxSize;
                                var ration = settings.maxSize / img.height;
                                width = Math.round(img.width * ration);
                                isResize = true;
                            }
                        }
                        //
                        if (isResize) {
                            var canvas = $("<canvas/>").get(0);
                            canvas.width = width;
                            canvas.height = height;
                            var context = canvas.getContext("2d");
                            context.drawImage(img, 0, 0, width, height);
                            imageData = canvas.toDataURL();
                        }
                        //
                        // console.log(latency + ' / ' + width + ' / ' + height);
                        //
                        if (
                            settings.onImageResized != null &&
                            typeof settings.onImageResized == "function"
                        ) {
                            settings.onImageResized(imageData);
                            countDown(60);
                        }
                    };
                    img.onerror = function() {};
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        } else {
            console.log("Your browser does not support File API");
        }
    }
};

$("#btnFilter").on("click", function() {
    var url = $(this).data("link");
    var params = getURLParams(window.location.search);
    $.each(params, function(key, value) {
        var param = key;
        var paramVal = value;
        url = updateURLParameter(url, param, paramVal);
    });
    window.location.href = url;
});
