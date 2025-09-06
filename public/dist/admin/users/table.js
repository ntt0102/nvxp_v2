$("#btnCreate").on("click", function() {
    var url = $(this).data("link");
    $.each(getURLParams(window.location.search), function(key, value) {
        var param = key;
        var paramVal = value;
        url = updateURLParameter(url, param, paramVal);
    });
    window.location.href = url;
});
