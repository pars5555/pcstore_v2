ngs.AdminChatManager = {
    initConnection: function () {
        var serverUrl = SITE_URL;
        serverUrl = "95.140.192.34";
        this.socket = new WebSocket("ws://" + serverUrl + ":6583/");
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