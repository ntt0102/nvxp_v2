<template>
     
</template>

<script>
    export default {
        mounted() {
            var myId = $('meta[name="user-id"]').attr('content');
            //
            Echo.private('Message.User.' + myId).listen('MessageSentEvent', (message) => {
                var contacterId = $('#contacterInfo').attr('data-id');
                var isOpen = contacterId == message.senderId;
                var inboxContent = '';
                var inboxTime = '';
                //
                if(isOpen) {
                    switch(message.actionType){
                        case 1:
                            var messageTime = $().getDate('H:M');
                            var latestMsgSenderId = $('.direct-chat-msg').last().attr('data-sender-id');
                            var contacterName = $('#contacterInfo').attr('data-name');
                            var contacterAvatar = $('#contacterInfo').attr('data-avatar');
                            var html = '';
                            html += '<div class="direct-chat-msg [NONE]" data-msg-id="[MESSAGE_ID]" data-sender-id="[SENDER_ID]"> ';
                            html += '   <div class="direct-chat-info clearfix [HIDE]"> ';
                            html += '     <span class="direct-chat-name float-left"> ';
                            html += '       [SENDER_NAME]  ';
                            html += '       <span class="direct-chat-timestamp float-right ml-2 mr-2">[MESSAGE_TIME]</span> ';
                            html += '     </span> ';
                            html += '   </div> ';
                            html += '   <a href="#" class="[HIDE]"><img class="direct-chat-img" src="[SENDER_AVATAR]"></a> ';
                            html += '  <div class="direct-chat-text"  title="[MESSAGE_TIME]"> ';
                            html += '   <span>[MESSAGE_CONTENT]</span> ';
                            html += '  </div> ';
                            html += '</div> ';
                            html = html.split('[NONE]').join(latestMsgSenderId != contacterId ? '' : 'none');
                            html = html.split('[MESSAGE_ID]').join(message.messageId);
                            html = html.split('[SENDER_ID]').join(contacterId);
                            html = html.split('[HIDE]').join(latestMsgSenderId != contacterId ? '' : 'hide');
                            html = html.split('[SENDER_NAME]').join(contacterName);
                            html = html.split('[MESSAGE_TIME]').join(messageTime);
                            html = html.split('[SENDER_AVATAR]').join(contacterAvatar);
                            html = html.split('[MESSAGE_CONTENT]').join(message.messageContent);
                            var selector = $('.direct-chat-messages');
                            selector.append(html);
                            selector.scrollTop(selector.prop("scrollHeight"));
                            $('[title!=""]').tooltip({
                                container: 'body'
                            });
                            // update inbox
                            inboxContent = message.messageContent;
                            inboxTime = messageTime;
                            break;
                        case 2:
                            $('.direct-chat-msg[data-msg-id="' + message.messageId + '"]').find('.direct-chat-text > span').text(message.messageContent);
                            // inbox update
                            var latestMessageId = $('.direct-chat-msg').last().attr('data-msg-id');
                            if(message.messageId == latestMessageId){
                                inboxContent = message.messageContent;
                                inboxTime = $('.direct-chat-msg[data-msg-id="' + message.messageId + '"]').find('.direct-chat-timestamp').text();
                            }
                            break;
                        case 3:
                            var messageSelector = $('.direct-chat-msg[data-msg-id="' + message.messageId + '"]');
                            var nextMessageSelector = messageSelector.next();
                            if(! messageSelector.hasClass('none') && nextMessageSelector.length != 0){
                                nextMessageSelector.removeClass('none');
                                nextMessageSelector.find('.direct-chat-info').removeClass('hide');
                                nextMessageSelector.children('a').removeClass('hide');
                            }
                            // inbox update
                            var latestMessageId = $('.direct-chat-msg').last().attr('data-msg-id');
                            if(message.messageId == latestMessageId){
                                var prevMessageSelector = messageSelector.prev();
                                var inboxContent = prevMessageSelector.find('.direct-chat-text > span').text();
                                var inboxTime = prevMessageSelector.find('.direct-chat-timestamp').text();
                            }
                            //
                            messageSelector.remove();
                            if($('.direct-chat-msg').length == 0) $('#inbox .message-item[data-contacter-id="' + contacterId + '"]').remove();
                            break;
                    }
                    if(inboxContent != '') {
                        var contacter = new Object();
                        contacter.Id = contacterId;
                        contacter.Name = $('#contacterInfo').attr('data-name');
                        contacter.Avatar = $('#contacterInfo').attr('data-avatar');
                        updateInbox(inboxContent, inboxTime, contacter);
                    }
                    $('#messageContent').focus();
                    var markAsReadUrl = $('#messageInfo').attr('data-markAsRead-url');
                    requestAjax(markAsReadUrl, {contacterId: contacterId}, null);
                }
                else{
                    var messageId = message.actionType == 1 ? message.messageId : message.latestMessageId;
                    //
                    if(messageId != '' && messageId != null){
                        var contacterSelector = $('#inbox .message-item[data-contacter-id="' + message.senderId + '"]');
                        if(contacterSelector.length > 0) var isNewSender = 0;
                        else var isNewSender = 1;
                        //
                        var getMessageUrl = $('.main-header .message').attr('data-get-url');
                        requestAjax(getMessageUrl, {messageId: messageId, isNewSender: isNewSender, actionType: message.actionType}, getMessageResponse);
                    }
                    else {
                        $('#inbox .message-item[data-contacter-id="' + message.senderId + '"]').remove();
                    }
                }
            });

            function getMessageResponse(message){
                var contacter = new Object();
                contacter.Id = message.senderId;
                if(message.isNewSender == 1) {
                    contacter.Name = message.senderName;
                    contacter.Avatar = message.senderAvatar;
                }
                var messageTime = $().getDate('H:M');
                if(message.actionType == 1)
                    updateInbox(message.messageContent, messageTime, contacter, true);
                else updateInbox(message.messageContent, messageTime, contacter, false, true);
                //
                destroyWait();
            }
        }
    }
</script>
