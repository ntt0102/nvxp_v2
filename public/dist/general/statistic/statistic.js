$(".filter").on("click", function() {
    var url = $(this).attr("url");
    //
    $.each(getURLParams(window.location.search), function(key, value) {
        var param = key;
        var paramVal = value;
        url = updateURLParameter(url, param, paramVal);
    });
    url = updateURLParameter(url, "filterMode", "statistic");
    window.location.href = url;
});
