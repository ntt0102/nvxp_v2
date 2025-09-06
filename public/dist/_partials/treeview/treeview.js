$.fn.extend({
    treeLeft: function(o) {
        var openedClass = "fa-minus-circle";
        var closedClass = "fa-plus-circle";

        if (typeof o != "undefined") {
            if (typeof o.openedClass != "undefined") {
                openedClass = o.openedClass;
            }
            if (typeof o.closedClass != "undefined") {
                closedClass = o.closedClass;
            }
        }

        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree-left");
        tree.find("li.branch").each(init);
        // Show focused node
        showFocusedNode(tree.find(".focus"), true);
        //
        tree.removeClass("hide");
        tree.find('ul>li').removeClass("hide");

        function init() {
            var tree = $(".tree-left");
            var branch = $(this);
            branch.prepend('<i class="indicator fas ' + closedClass + '"></i>');
            branch.children(".indicator, .info").on("click", function(e) {
                var li = $(this).parent();
                //
                if (li.children().children("li").length) {
                    var icon = li.children(".indicator");
                    icon.toggleClass(openedClass + " " + closedClass);
                    li.children()
                        .children("li")
                        .toggleClass("hide");
                    updateWidth(tree);
                } else {
                    var url = tree
                        .parent()
                        .parent()
                        .attr("url");
                    var memberId = li.children(".info").attr("memberId");
                    requestAjax(url, { memberId: memberId }, function(data) {
                        if (data.status == "success") {
                            var ul = tree.find(".ul" + data.memberId);
                            ul.append(data.html.split("[_]").join(" "));
                            ul.find(".help").on("click", showContextMenu);
                            //
                            var icon = tree
                                .find(".li" + data.memberId)
                                .children(".indicator");
                            icon.toggleClass(openedClass + " " + closedClass);
                            //
                            updateWidth(tree);
                            ul.find("li.branch").each(init);
                        }
                        destroyWait();
                    });
                }
            });
            branch
                .children()
                .children("li")
                .addClass("hide");
        }

        function updateWidth(tree) {
            var level = 0;
            tree.find("li")
                .not(".hide")
                .each(function() {
                    var tmp = $(this).parents("ul").length;
                    if (tmp > level) level = tmp;
                });
            tree.width(450 + 33 * level);
        }

        function showFocusedNode(element, focus) {
            if (element.length > 0) {
                element
                    .children(".info")
                    .css("color", focus != undefined ? "red" : "blue");
                element.children(".info").click();
                showFocusedNode(element.parent().parent());
            }
        }
    }
});

$.fn.extend({
    treeTop: function(o) {
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree-top");
        tree.find("li.branch").each(init);
        // Show focused node
        showFocusedNode(tree.find(".focus"), true);
        //
        tree.removeClass("hide");

        function init() {
            var tree = $(".tree-top");
            var branch = $(this);
            branch.children(".info").on("click", function(e) {
                var li = $(this).parent();
                //
                if (li.children().children("li").length) {
                    li.children()
                        .children("li")
                        .toggleClass("hide");
                } else {
                    var url = tree
                        .parent()
                        .parent()
                        .attr("url");
                    var memberId = li.children(".info").attr("memberId");
                    requestAjax(url, { memberId: memberId }, function(data) {
                        if (data.status == "success") {
                            var ul = tree.find(".ul" + data.memberId);
                            ul.append(
                                data.html.split("[_]").join("<div></div>")
                            );
                            ul.find(".help").on("click", showContextMenu);
                            ul.find("li.branch").each(init);
                        }
                        destroyWait();
                    });
                }
            });
            branch
                .children()
                .children("li")
                .addClass("hide");
            //
            branch
                .children(".btn-base")
                .prev()
                .prev()
                .css("margin-left", "2em");
        }

        function showFocusedNode(element, focus) {
            if (element.length > 0) {
                element
                    .children(".info")
                    .css("border-color", focus != undefined ? "red" : "blue");
                element
                    .children(".info")
                    .css("color", focus != undefined ? "red" : "blue");
                element.children(".info").click();
                showFocusedNode(element.parent().parent());
            }
        }
    }
});
