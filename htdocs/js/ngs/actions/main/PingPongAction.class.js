ngs.PingPongAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_ping_pong";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {

            if (typeof data.notifications !== 'undefined') {
                var notifications = data.notifications[0];
                var new_not = jQuery("#notification_example .notification_block").clone(true);
                jQuery("#notificationListWrapper").prepend(new_not);
                new_not.attr("id",notifications.id);
                new_not.find(".f_not_link").attr("href", notifications.url);
                new_not.find(".f_not_icon img").attr("src",notifications.iconUrl);
                new_not.find(".f_not_title").html(notifications.title);
                new_not.find(".f_not_date").html(notifications.datetime);
            }
        }
        else if (data.status === "err") {
            console.log("notifications error");
        }
        window.setTimeout(function () {
            ngs.action('ping_pong', {});
        }, customer_ping_pong_timeout_seconds * 1000);

    },
    supportsAudio: function () {
        var a = document.createElement('audio');
        return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
    }

});

