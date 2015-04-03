ngs.AdminChatManager = {
    adminInit: function () {
        jQuery('#admin_chat_on_off').change(function () {
            var chatEnable = jQuery(this).is(':checked');
            if (chatEnable) {
                ngs.AdminChatManager.initConnection();
            }
        });
    },
    initConnection: function () {
        var serverUrl = SITE_URL;
        serverUrl = jQuery('#server_ip_address').val();
        this.socket = new WebSocket("ws://" + serverUrl + ":65435");
        this.socket.onopen = function () {
        };
        this.socket.onmessage = function (message) {
        };
        this.socket.onclose = function () {
        };
        this.socket.onerror = function () {
        };
    }
};