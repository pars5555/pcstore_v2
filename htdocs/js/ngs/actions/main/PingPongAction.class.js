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
            jQuery('#notificationListWrapper').empty();

            if (typeof data.notifications !== 'undefined') {
                var notifications = data.notifications;
                if (notifications.length > 0)
                {
                    jQuery('.notification').css({'display': 'block'});
                } else
                {
                    jQuery('.notification').css({'display': 'none'});
                }
                jQuery(notifications).each(function (index, notification) {
                    var row = jQuery('#notificationRowTemplate').html().replace("%date%", notification.formatedDateTime).replace("%title%", notification.title).replace("%url%", notification.url).replace("%icon%", (notification.iconUrl != "" ? '<img src="' + notification.iconUrl + '" />' : ''));
                    jQuery(row).removeAttr('id');
                    jQuery('#notificationListWrapper').append(jQuery(row));
                });
            }
        }
        else if (data.status === "err") {

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

