ngs.ServiceCompanyDealersLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "servicecompany", ajaxLoader);
    },
    getUrl: function() {
        return "dealers";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "servicecompany_dealers";
    },
    afterLoad: function() {
        
    }
});
