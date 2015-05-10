ngs.CompanyDealersLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "dealers";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "company_dealers";
    },
    afterLoad: function () {
        this.messagePopup();
        this.deleteDealer();
    },
    messagePopup: function () {
        jQuery(".f_dealers_popup .overlay,.f_dealers_popup .f_pop_up_confirm_btn,.f_dealers_popup .close_button").click(function () {
            jQuery(this).closest(".f_dealers_popup").removeClass("active hide");
        });
    },
    deleteDealer : function(){
        jQuery(".f_delete_dealer").on("click",function(event){
            event.preventDefault();
            var url = jQuery(this).attr("href");
            var dealer_name = jQuery(this).closest(".f_dealer_item").find(".f_dealer_name").html();
            var title = jQuery(".f_delete_dealer_title").val();
            var content = jQuery(".f_delete_dealer_content").val();
            var confirm = jQuery(".f_delete_dealer_confirm").val();
            
            function deleteDealerAction(){
                window.location.href = url;
            }
            
            var mainPopup = ngs.MainLoad.prototype.initPopup(title,content,confirm,true,deleteDealerAction);
            
            mainPopup.find(".f_delete_dealer_name").html(dealer_name);
        });
    }
});
