jQuery(document).ready(function(){
    sliderAutoRotate();
});

function sliderAutoRotate(){
    var count = jQuery("#banner-slider-container .f_slider_item").length;
    var step=0;
    window.setInterval(function(){
         jQuery("#banner-slider-container .f_banner-slider").css("left",+step*(-100)+"%");
         step++;
         if(step>count-1){
             step=0;
         };
    },5000);
}