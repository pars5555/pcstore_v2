ngs.ServiceCompanyProfileLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "servicecompany", ajaxLoader);
    },
    getUrl: function() {
        return "profile";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "servicecompany_profile";
    },
    afterLoad: function() {
        alert('service company Profile');
    }
});
