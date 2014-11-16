ngs.CompaniesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "companies";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_companies";
    },
    afterLoad: function () {
        this.companiesDocumentsSliderInit();
        this.companiesListDocumentsSliderInit();
        this.initGMaps();
        this.companyTabController();
        this.initAccessKeyInputs();
    },
    initAccessKeyInputs: function () {
        jQuery('.f_company_access_key_confirm_btn').click(function () {
            var companyId = jQuery(this).attr('company_id');
            var accessKey = jQuery('#company_access_key_input_' + companyId).val();
            ngs.action('register_company_dealer', {'access_key': accessKey});
        });
    },
    companyTabController: function () {
        jQuery(".f_company_tab_btn").click(function () {
            jQuery(".f_company_tab").hide(0);
            jQuery("#" + jQuery(this).attr("companyTab")).show(0);
        });
    },
    companiesListDocumentsSliderInit: function () {
        jQuery(".f_document_slider").owlCarousel({
            itemsCustom: [
                [0, 2],
                [450, 4],
                [600, 4],
                [700, 4],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
            ],
            navigation: true,
            navigationText: false,
            rewindNav: false,
            pagination: false
        });
        jQuery(".f_left_arrow").click(function () {
            jQuery(this).siblings(".f_document_slider").trigger('owl.prev');
        });
        jQuery(".f_right_arrow").click(function () {
            jQuery(this).siblings(".f_document_slider").trigger('owl.next');
        });
    },
    companiesDocumentsSliderInit: function () {
        jQuery(".f_document_slider").owlCarousel({
            itemsCustom: [
                [0, 2],
                [450, 4],
                [600, 4],
                [700, 4],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
            ],
            navigation: true,
            navigationText: false,
            rewindNav: false,
            pagination: false
        });
        jQuery(".f_left_arrow").click(function () {
            jQuery(this).siblings(".f_document_slider").trigger('owl.prev');
        });
        jQuery(".f_right_arrow").click(function () {
            jQuery(this).siblings(".f_document_slider").trigger('owl.next');
        });
    },
    initGMaps: function ()
    {

        jQuery(".company_gmap_pin").click(function () {
            thisInstance.map_info_windows.each(function (infoWindow) {
                infoWindow.close();
            });
            var company_id = jQuery(this).attr('company_id');
            thisInstance.map_markers['company_' + company_id].each(function (marker) {
                google.maps.event.trigger(marker, 'click');
            });
            jQuery(window.self).scrollTop(0);
        });
        jQuery(".service_company_gmap_pin").click(function () {
            thisInstance.map_info_windows.each(function (infoWindow) {
                infoWindow.close();
            });
            var company_id = jQuery(this).attr('service_company_id');
            thisInstance.map_markers['service_company_' + company_id].each(function (marker) {
                google.maps.event.trigger(marker, 'click');
            });
            jQuery(window.self).scrollTop(0);
        });
        this.map_markers = {};
        this.map_info_windows = new Array();
        var thisInstance = this;
        if (typeof window.google === 'undefined' || typeof window.google.maps === 'undefined') {
            return false;
        }
        var lat = 40.19;
        var lng = 44.52;
        var zoom = 14;
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: zoom,
            zoomControl: true,
            panControl: true,
            scrollwheel: false,
            center: myLatlng,
            height: '300px',
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('cl_gmap'), mapOptions);
        var styleArray = [
            {
                featureType: "all",
                stylers: [
                    {saturation: -80}
                ]
            }, {
                featureType: "road.arterial",
                elementType: "geometry",
                stylers: [
                    {hue: "#00ffee"},
                    {saturation: 50}
                ]
            }, {
                featureType: "poi.business",
                elementType: "labels",
                stylers: [
                    {visibility: "off"}
                ]
            }
        ];
        map.setOptions({styles: styleArray});

        map.setOptions({minZoom: 3, maxZoom: 19});
        var all_companies_dtos_to_array = jQuery.parseJSON(jQuery('#all_companies_dtos_to_array_json').val());
        var all_companies_branches_dtos_to_array = jQuery.parseJSON(jQuery('#all_companies_branches_dtos_to_array_json').val());
        all_companies_branches_dtos_to_array.each(function (cbdto) {

            var companyDto = thisInstance.findCompanyById(all_companies_dtos_to_array, cbdto.company_id);
            var cname = 'unknown company';
            if (typeof companyDto !== 'undefined')
            {
                cname = companyDto.name;
            }
            var k = (parseInt(companyDto.rating) + 30) / 100 / 2;
            var markerWidth = 100;
            var markerHeight = 100;
            var latlng = new google.maps.LatLng(cbdto.lat, cbdto.lng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: cname + ', ' + cbdto.street,
                icon: {
                    url: 'img/google_map_pin.png',
                    size: new google.maps.Size(markerWidth * k, markerHeight * k),
                    scaledSize: new google.maps.Size(markerWidth * k, markerHeight * k)
                }
            });
            if ('company_' + companyDto.id in thisInstance.map_markers) {
                thisInstance.map_markers['company_' + companyDto.id].push(marker);
            } else
            {
                thisInstance.map_markers['company_' + companyDto.id] = [marker];
            }
            var logoPath = SITE_PATH + '/images/small_logo/' + cbdto.company_id + '/logo.png';
            var priceLogoPath = SITE_PATH + '/img/file_types_icons/xls_icon.png';
            var pricePath = SITE_PATH + '/price/last_price/' + cbdto.company_id;
            var infowindow = new google.maps.InfoWindow({
                content: '<div style="min-width:180px;min-height:70px"><img src="' + logoPath + '" /><br>' + cname + ', ' + cbdto.street +
                        '</div><div style="margin:5px"><a href="' + pricePath + '">' + '<img src="' + priceLogoPath + '" />' + 'Price List' + '</a></div>'
            });
            thisInstance.map_info_windows.push(infowindow);
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, this);
            });
        });
        var all_service_companies_dtos_to_array = jQuery.parseJSON(jQuery('#all_service_companies_dtos_to_array_json').val());
        var all_service_companies_branches_dtos_to_array = jQuery.parseJSON(jQuery('#all_service_companies_branches_dtos_to_array_json').val());
        all_service_companies_branches_dtos_to_array.each(function (scbdto) {

            var serviceCompanyDto = thisInstance.findCompanyById(all_service_companies_dtos_to_array, scbdto.service_company_id);
            var scname = 'unknown company';
            if (typeof serviceCompanyDto !== 'undefined')
            {
                scname = serviceCompanyDto.name;
            }
            var markerWidth = 15;
            var markerHeight = 15;
            var latlng = new google.maps.LatLng(scbdto.lat, scbdto.lng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: scname + ', ' + scbdto.street,
                icon: {
                    url: 'img/google_map_pin_blue.png',
                    size: new google.maps.Size(markerWidth, markerHeight),
                    scaledSize: new google.maps.Size(markerWidth, markerHeight)
                }
            });
            if ('service_company_' + serviceCompanyDto.id in thisInstance.map_markers) {
                thisInstance.map_markers['service_company_' + serviceCompanyDto.id].push(marker);
            } else
            {
                thisInstance.map_markers['service_company_' + serviceCompanyDto.id] = [marker];
            }
            var logoPath = SITE_PATH + '/images/sc_small_logo/' + scbdto.service_company_id + '/logo.png';
            var infowindow = new google.maps.InfoWindow({
                content: '<div style="min-width:140px;min-height:70px"><img src="' + logoPath + '" /><br>' + scname + ', ' + scbdto.street

            });
            thisInstance.map_info_windows.push(infowindow);
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, this);
            });
        });
    },
    findCompanyById: function (all_companies_dtos_to_array, cid)
    {
        for (var dto_index in all_companies_dtos_to_array) {
            if (all_companies_dtos_to_array[dto_index].id == cid) {
                return all_companies_dtos_to_array[dto_index];
            }
        }
    }
});
