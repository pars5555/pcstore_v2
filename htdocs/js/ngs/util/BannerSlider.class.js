jQuery(document).ready(function () {
    bannerSlider.initSlider();
});

var bannerSlider = {
    //************************ Init Slider ***********************//
    initSlider: function () {
        this.initSliderElements();
        this.sliderAutoRotate();
        this.sliderControl();
        this.sliderSwipeControl();
        this.sliderNavigation();
        this.sliderResponsiveSize();
    },
    //********************* Slider Constants *******************//
    initSliderElements: function () {
        var slider = jQuery("#banner-slider-container");
        this.slider = slider;
        this.sliderContent = slider.find(".f_banner_slider");
        this.sliderItem = slider.find(".f_slider_item");
        this.sliderControlBtn = slider.find(".f_slide_control");
        this.sliderNavBtn = slider.find(".f_slider_nav_item");
        this.sliderLength = parseInt(this.sliderItem.length);
        this.sliderCurPos = 0;
        this.sliderIntervalId = null;
        this.sliderRotateSpeed = 5;
    },
    //***************** Slider Auto Rotate ***************//
    sliderAutoRotate: function () {
        clearInterval(this.sliderIntervalId);
        var self = this;
        this.sliderIntervalId = setInterval(function () {
            self.sliderRotate();
        }, this.sliderRotateSpeed * 1000);
    },
    //***************** Slider Control ***************//
    sliderControl: function () {
        var self = this;
        this.sliderControlBtn.on("click", function () {
            var direction = jQuery(this).attr("data-direction");
            self.sliderRotate(direction);
            self.sliderAutoRotate();
        });
    },
    //***************** Slider Swipe Control ***************//
    sliderSwipeControl: function () {
        var self = this;
        this.slider.on("swipeleft swiperight", function (event) {
            var direction = 1;
            if (event.type == "swiperight") {
                direction = -1;
            }
            ;
            self.sliderRotate(direction);
            self.sliderAutoRotate();
        });
    },
    //***************** Slider Navigation ***************//
    sliderNavigation: function () {
        var self = this;
        this.sliderNavBtn.on("click", function () {
            var position = jQuery(this).attr("data-position");
            self.sliderRotate(position, true);
            self.sliderAutoRotate();
        });
    },
    //***************** Change Slider Navigation Active Button ***************//
    changeNavActiveBtn: function (nav_btn_num) {
        jQuery(this.sliderNavBtn).removeClass("active");
        jQuery(this.sliderNavBtn[nav_btn_num]).addClass("active");
    },
    //***************** Slider Rotate ***************//
    sliderRotate: function (position, navPos) {
        var new_pos, left;
        var navPos = typeof navPos === "undefined" ? false : navPos;
        var position = typeof position === "undefined" ? 1 : parseInt(position);

        new_pos = this.sliderCurPos + position;

        if (new_pos < 0) {
            new_pos = this.sliderLength - 1;
        }
        if (new_pos > this.sliderLength - 1) {
            new_pos = 0;
        }

        if (navPos === true) {
            new_pos = position;
        }

        left = -new_pos * 100 + "%";
        this.sliderContent.css("left", left);

        this.sliderCurPos = new_pos;

        this.changeNavActiveBtn(this.sliderCurPos);
    },
    sliderResponsiveSize: function () {
        var self = this;
        self.slider.height(self.slider.width() / 3 + "px");
        jQuery(window).resize(function () {
            self.slider.height(self.slider.width() / 3 + "px");
        });
    }
};
