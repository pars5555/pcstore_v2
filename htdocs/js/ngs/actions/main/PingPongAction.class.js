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
            this.setNotifications(data);
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
    },
    setNotifications: function (data) {
        if (window.localStorage.getItem("unreadNotificationExist") === "exist") {
            jQuery("#notification").addClass("new_notification");
        }
        var self = this;
        if (typeof data.notifications !== 'undefined') {
            data.notifications.each(function (notifications) {
                if (self.notificationNotExist(notifications.id)) {
                    jQuery("#notificationListWrapper").addClass("active");
                    var new_not = jQuery("#notification_example .notification_block").clone(true);
                    jQuery("#notificationListWrapper").prepend(new_not);
                    new_not.attr("id", notifications.id);
                    new_not.find(".f_not_link").attr("href", notifications.url);
                    new_not.find(".f_not_icon img").attr("src", notifications.iconUrl);
                    new_not.find(".f_not_title").html(notifications.title);
                    new_not.find(".f_not_date").html(notifications.datetime);
                    self.setDateCookie(notifications.datetime);
                }
            });
        }
    }
    ,
    notificationNotExist: function (notification_id) {
        var result = true;
        jQuery("#notificationListWrapper .f_notification_block").each(function () {
            var id = jQuery(this).attr("id");
            if (notification_id === id) {
                result = false;
            }
        });
        return result;
    },
    setDateCookie: function (val) {
        var result = new Date(val.slice(0, 4), val.slice(5, 7), val.slice(8, 10), val.slice(11, 13), val.slice(14, 16), val.slice(17, 19));
        result = Date.parse(result);

        if (result > this.getLastNotificationCookie()) {
            document.cookie = "notificationDate=" + result + "; expires = 11 nov 11111 11:11:11 UTC;";
            jQuery("#notification").addClass("new_notification");
            window.localStorage.setItem("unreadNotificationExist","exist");
        }

        return result;
    },
    getLastNotificationCookie: function () {
        var last_cookie = 0;
        if (document.cookie.indexOf("notificationDate") >= 0) {
            var cookie = document.cookie.split(';');
            cookie.each(function (elem) {
                if (elem.indexOf("notificationDate") >= 0) {
                    last_cookie = elem.slice(elem.indexOf("=") + 1, elem.length);
                }
            });
        }
        return last_cookie;
    }

});

