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
        var serverIpAddress = SITE_URL;
        serverIpAddress = jQuery('#server_ip_address').val();
        serverIpAddress = '95.140.192.34';
        this.socket = new WebSocket("ws://" + serverIpAddress + ":6583");
        this.socket.onopen = function () {
            alert(1);
        };
        this.socket.onmessage = function (message) {
            alert(2);
        };
        this.socket.onclose = function () {
            alert(3);
        };
        this.socket.onerror = function () {
            alert(4);
        };
    }
};