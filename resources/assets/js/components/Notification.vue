<template> </template>

<script>
export default {
    mounted() {
        var memberId = $('meta[name="user-id"]').attr("content");
        var notificationsUrl = $(".main-header .notification").attr("data-url");
        var avatarUrl = $(".main-header .notification").attr("data-avatar-url");
        //
        Echo.private("App.User." + memberId).notification(notification => {
            var notificationCount = Number($(".notification .badge").text());
            $(".notification .badge")
                .removeClass("hide")
                .text(notificationCount + 1);
            $(".notification .dropdown-header > span").text(
                notificationCount + 1
            );
            var html = "";
            html +=
                '<a href="[NOTIFICATIONS_URL]?id=[NOTIFICATIONS_ID]" class="dropdown-item">';
            html += '  <div class="media">';
            html +=
                '    <img src="[AVATAR_URL]/[SENDER_AVATAR]" alt="Ảnh đại diện người gửi" class="img-size-50 mr-3 img-circle">';
            html += '    <div class="media-body">';
            html += '      <h3 class="dropdown-item-title">[SENDER_NAME]</h3>';
            html += '      <p class="text-sm">[NOTIFICATIONS_TYPE]</p>';
            html +=
                '      <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> <span class="clock">1 giây trước</span></p>';
            html += "    </div>";
            html += "  </div>";
            html += "</a>";
            html = html.split("[NOTIFICATIONS_URL]").join(notificationsUrl);
            html = html.split("[NOTIFICATIONS_ID]").join(notification.id);
            html = html.split("[AVATAR_URL]").join(avatarUrl);
            html = html
                .split("[SENDER_AVATAR]")
                .join(notification.sender_avatar);
            html = html.split("[SENDER_NAME]").join(notification.sender_name);
            html = html
                .split("[NOTIFICATIONS_TYPE]")
                .join(notification.notifications_type);
            //
            $(".notification .container").prepend(html);
            console.log(html);
        });
    }
};
</script>
