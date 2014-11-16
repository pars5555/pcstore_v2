ngs.DialogsManager = {
    closeDialog: function(title, contentHtml, buttonTitle, func, resizable) {

        if (typeof resizable === 'undefined' || resizable === null)
        {
            resizable = false;
        }
        jQuery(contentHtml).dialog({
            resizable: resizable,
            title: title,
            show: {effect: "slide", direction: "up", duration: 400},
            hide: {effect: "slide", direction: "up", duration: 400},
            modal: true,
            buttons: [
                {
                    text: buttonTitle,
                   
                    click: function() {
                        if (typeof func === 'function') {
                            func();
                        }
                        jQuery(this).remove();
                    }
                }
            ],
            close: function() {
                jQuery(this).remove();
            }
        });
    },
    actionOrCancelDialog: function(actionButtonTitle, actionButtonId, closeAfterAction, cancelButtonId, title, contentHtml, actionFunc, resizable, width, height, removeOnClose) {
        if (typeof actionButtonId === 'undefined' || actionButtonId === '')
        {
            actionButtonId = this.randomString(10);
        }
        if (typeof removeOnClose === 'undefined' || removeOnClose == null)
        {
            removeOnClose = true;
        }
        if (typeof cancelButtonId === 'undefined' || cancelButtonId === '')
        {
            cancelButtonId = this.randomString(10);
        }
        if (typeof resizable === 'undefined' || resizable === null)
        {
            resizable = false;
        }
        jQuery(contentHtml).dialog({
            resizable: resizable,
            title:title,
            modal: true,
            width: width,
            height: height,
            buttons: {
                "Action": {
                    text: actionButtonTitle,                    
                    id: actionButtonId,
                    click: function() {
                        if (typeof actionFunc === 'function') {
                            jQuery('#' + actionButtonId).attr('disabled', true);
                            jQuery('#' + cancelButtonId).attr('disabled', true);
                            actionFunc();
                        }
                        if (closeAfterAction)
                        {
                            jQuery(this).dialog('close');
                        }
                    }
                },
                "Cancel": {
                    text:49,                   
                    id: cancelButtonId,
                    click: function() {
                        jQuery(this).dialog('close');
                    }
                }
            },
            close: function() {
                if (removeOnClose == true) {
                    jQuery(this).remove();
                }
            }
        });
    },
    randomString: function(length) {
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');

        if (!length) {
            length = Math.floor(Math.random() * chars.length);
        }

        var str = '';
        for (var i = 0; i < length; i++) {
            str += chars[Math.floor(Math.random() * chars.length)];
        }
        return str;
    }

};