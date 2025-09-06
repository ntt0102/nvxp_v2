/**
 * Ajax
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

// Ajax
function requestAjax(url, data, callback) {
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "json",
        success: callback,
    });
}
