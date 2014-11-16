ngs.CheckoutLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function() {
        return "checkout";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "main_checkout";
    },
    afterLoad: function() {
    	this.checkoutStepsMenus();
    },
    checkoutStepsMenus: function() {
    	
    }
});
