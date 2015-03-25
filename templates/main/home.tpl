<div class="home_page_main_wrapper">

    <div class="home_page_inner_container">

        {******************************** LEFT PANEL ******************************}
        {include file="$TEMPLATE_DIR/main/main_left_panel.tpl"}


        <div class="right-content">

            {******************************** SLIDER ******************************}
            {if $ns.hideBannerSlider !== true}
                {include file="$TEMPLATE_DIR/main/banner_slider.tpl"} 
            {/if}

            {if $ns.foundItems|@count>0}

                {******************************** FILTER ******************************}
                {include file="$TEMPLATE_DIR/main/filter.tpl"}

                {******************************** LISTING ******************************}
                {include file="$TEMPLATE_DIR/main/listing.tpl"}

                {******************************** PAGING ******************************}
                {nest ns=paging}

            {else}
                <div style="text-align: center">
                    <h1>{$ns.lm->getPhrase(117)}</h1>
                </div>
            {/if}
        </div>
    </div>
</div>
