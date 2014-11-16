ngs.LandingpageLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function() {
        return "landingpage";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "main_landingpage";
    },
    afterLoad: function() {
    	this.landinagePageMainSlider();
    	this.hotProductsSlider();
    	this.boxesAnimation();
    },
    boxesAnimation: function(){
        var featuresBlock = document.getElementsByClassName("f_ft_block");
        
        function featureBlockOpacity(counterBlock) {
            featuresBlock[counterBlock].style.opacity = 1;
        }
        jQuery(window).scroll(function(){
         if(jQuery(window).scrollTop() >= jQuery("#featuresWrapper").position().top) {
                var counter = 0;
                if( counter < featuresBlock.length) {
                    featureBlockOpacity(counter);
                    counter++;
                    return featureBlockOpacity();
                }else {
                    return;
                }
    	}   
        });
    },
    landinagePageMainSlider: function(){
	 jQuery("#lpSlider").owlCarousel({
	      navigation : true, // Show next and prev buttons
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      singleItem:true
	  });
    },
    hotProductsSlider: function() {
	  jQuery("#hpSlider").owlCarousel({
	      itemsCustom : [
	        [0, 2],
	        [450, 4],
	        [600, 4],
	        [700, 4],
	        [1000, 4],
	        [1200, 4],
	        [1400, 4],
	        [1600, 4]
	      ],
	      navigation : true
	  });
	  jQuery(".f_hp_left_arrow").click(function(){
            jQuery("#hpSlider").trigger('owl.prev');
	    });
	    jQuery(".f_hp_right_arrow").click(function(){
	        jQuery("#hpSlider").trigger('owl.next');
	    });
    }
});
