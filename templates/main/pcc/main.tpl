<div class="container build_pc_container">
    <div class="pc_components f_side_panel f_pc_components" data-side-panel="pc-components" data-side-position="left">
        <div id="itemSections">
            <div class="item-sections-wrapper">
                {section name=pid start=1 loop=$ns.pcc_components_count+1 step=1}
                    {assign var="index" value=$smarty.section.pid.index-1}  
                    <div class="current-section f_component" component_index="{$smarty.section.pid.index}">
                        <a href="javascript:void(0)" class="build-pc-component list-group-item">
                            <div class="build-pc-component-img">
                                <img src="{$SITE_PATH}/img/pc_configurator/{$smarty.section.pid.index}.png" />
                            </div>
                            <p class="build-pc-component-name">{$ns.lm->getPhrase($ns.component_display_names.$index)}</p>
                        </a>
                    </div>
                    {if ($smarty.section.pid.index == 7)}</div><div class="item-sections-wrapper">{/if}
                    {if ($smarty.section.pid.index == $smarty.section.pid.loop)}</div>{/if}
                {/section}
        </div>
    </div>
</div>
<div class="components-list-wrapper" id="pcc_components_container">
    <div class="build-pc-main-container">
        <div id="buildPcWrapper" class=" build-pc-wrapper">
            <div class="list-group" id="component_selection_container">
                {nest ns = pcc_select_component}                
            </div>          
        </div>
        <div class="main_loader hidden pcc_loader" id="pcc_loader"></div>
    </div>
    <div class="total_calculation_container f_side_panel" id="pcc_total_calculation_container" data-side-panel="pcc-total-calculation" data-side-position="right">
        {nest ns = pcc_total_calculations}

        {*}<div class="current-product text-center">
        <img src="https://pcstore.am/images/item_30_30/19013/1" />
        <p>Intel Pentium G1630 2.8GHz LGA 1155, tray by Intel</p>
        </div>
        <ul class="list-group select-components-list">
        <li class="list-group-item">
        Cras justo odio
        <span class="pull-right">12.500</span>
        </li>                
        </ul>
        {*}
    </div>
</div>
</div>
{if isset($ns.configurator_mode_edit_cart_row_id)}
    <input type="hidden" id= "configurator_mode_edit_cart_row_id" value="{$ns.configurator_mode_edit_cart_row_id}"/>
{/if}