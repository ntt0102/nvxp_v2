<template> </template>

<script>
export default {
    mounted() {
        var memberId = $('meta[name="user-id"]').attr("content");
        var userIsAdmin = $('meta[name="user-is-admin"]').attr("content");
        Echo.private("Message.User." + memberId).listen(
            "MessageSentEvent",
            message => {
                if (message.actionType == 1) {
                    var contacterId = $("#contacterInfo").attr("data-id");
                    if (contacterId != message.senderId) {
                        var selector = $(".main-header .message");
                        var senderSelector = selector.find(
                            '.container > a[data-sender-id="' +
                                message.senderId +
                                '"]'
                        );
                        //
                        if (senderSelector.length > 0) var isNewSender = 0;
                        else var isNewSender = 1;
                        //
                        var getMessageUrl = $(".main-header .message").attr(
                            "data-get-url"
                        );
                        requestAjax(
                            getMessageUrl,
                            {
                                messageId: message.messageId,
                                isNewSender: isNewSender
                            },
                            getMessageResponse
                        );
                        //
                        var messageCount = Number(
                            selector.find("a > .badge").text()
                        );
                        selector
                            .find("a > .badge")
                            .removeClass("hide")
                            .text(messageCount + 1);
                        selector
                            .find(".dropdown-header > span")
                            .text(messageCount + 1);
                    }
                }
            }
        );
        //
        function getMessageResponse(message) {
            if (message.isNewSender == 1) {
                var indexMessageUrl = $(".main-header .message").attr(
                    "data-url"
                );
                var html = "";
                html +=
                    '<a href="[MESSAGES_URL]" class="dropdown-item" data-sender-id="[SENDER_ID]">';
                html += '  <div class="media">';
                html +=
                    '    <img src="[SENDER_AVATAR]" alt="Ảnh đại diện người gửi" class="img-size-50 mr-3 img-circle">';
                html += '    <div class="media-body">';
                html +=
                    '      <h3 class="dropdown-item-title">[SENDER_NAME]</h3>';
                html +=
                    '      <p class="text-sm content">[MESSAGES_CONTENT]</p>';
                html +=
                    '      <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> <span class="clock">1 giây trước</span> ';
                html += '        <span class="float-right text-sm"> ';
                html +=
                    '           <span title="Tin nhắn chưa đọc" class="badge badge-danger">1</span> ';
                html += "        </span> ";
                html += "      </p> ";
                html += "    </div>";
                html += "  </div>";
                html += "</a>";
                html = html
                    .split("[MESSAGES_URL]")
                    .join(indexMessageUrl + "?id=" + message.senderId);
                html = html.split("[SENDER_ID]").join(message.senderId);
                html = html.split("[SENDER_AVATAR]").join(message.senderAvatar);
                html = html.split("[SENDER_NAME]").join(message.senderName);
                html = html
                    .split("[MESSAGES_CONTENT]")
                    .join(message.messageContent);
                //
                $(".message .container").prepend(html);
            } else {
                var selector = $(".main-header .message");
                var senderSelector = selector.find(
                    '.container > a[data-sender-id="' + message.senderId + '"]'
                );
                senderSelector.find(".content").text(message.messageContent);
                senderSelector.find(".clock").text("1 giây trước");
                var unreadCount = Number(senderSelector.find(".badge").text());
                senderSelector.find(".badge").text(unreadCount + 1);
                //
                var itemHtml = senderSelector.prop("outerHTML");
                senderSelector.remove();
                selector.find(".container").prepend(itemHtml);
            }
            //
            destroyWait();
        }
    }
};
</script>
