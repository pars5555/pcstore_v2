{if !empty($ns.bannersDtos)}
    <div class="banner-slider-container" id="banner-slider-container">
        {*************************** Slider Items ****************************}

        <div class="banner-slider f_banner_slider">
            {foreach from=$ns.bannersDtos item=banner}
                {if $banner->getActive()==1}
                    <a href="{$SITE_PATH}/{$banner->getPath()}" target="_blank" class="slider_item f_slider_item" style="background-image: url({$SITE_PATH}/img/banners/{$banner->getId()}.jpg)">
                    </a>
                {/if}
            {/foreach}
        </div>

        {*************************** Slider Controls ****************************}
        {if $ns.bannersDtos|@count>1}
            <div data-direction="-1" class="slide_left f_slide_control">
                <span class="glyphicon"></span>
            </div>
            <div data-direction="1" class="slide_right f_slide_control">
                <span class="glyphicon"></span>
            </div>
        {/if}
        {*************************** Slider Navigation ****************************}

        {if $ns.bannersDtos|@count>1}
            <nav class="slider_navigation">
                {foreach from=$ns.bannersDtos item=banner name=bannerNav}
                    {if $banner->getActive()==1}
                        <div data-position="{$smarty.foreach.bannerNav.index}" class="slider_nav_item f_slider_nav_item {if $smarty.foreach.bannerNav.index == 0}active{/if}">
                        </div>
                    {/if}
                {/foreach}
            </nav>
        {/if}
    </div>
{/if}