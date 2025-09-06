// jsRequire('../../../plugins/croppie/croppie.js');
//
$("#imageUpload").on("change", function() {
    if (this.files.length > 0) {
        $("#mdlResizeAvatar").modal("show");
        $("#mdlResizeAvatar .modal-body > div").remove();
        $("<div/>").appendTo("#mdlResizeAvatar .modal-body");
        //
        var boundarySize = window.innerHeight - 200;
        if (boundarySize < 350) boundarySize = 350;
        var borderSize = 50;
        if (
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(
                navigator.userAgent
            )
        ) {
            boundarySize = window.innerWidth;
            borderSize = 10;
        }
        var viewportSize = boundarySize - borderSize;
        // Upload avatar
        $uploadCrop = $("#mdlResizeAvatar .modal-body > div").croppie({
            enableExif: true,
            viewport: {
                width: viewportSize,
                height: viewportSize
                // type: 'circle'
            },
            boundary: {
                width: boundarySize,
                height: boundarySize
            }
        });
        //
        var reader = new FileReader();
        reader.readAsDataURL(this.files[0]);
        reader.onload = function(e) {
            setTimeout(function() {
                $uploadCrop.croppie("bind", {
                    url: e.target.result
                });
            }, 200);
        };
    }
});
