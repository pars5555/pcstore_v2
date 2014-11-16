<div style="max-width:1800px; width:100%;" class="container">
    <div class="row">
        <div id="itemSections" class="item-sections-wrapper">
            <div id="mobileBtnComp" class="mobile-btn">
                <i class="glyphicon glyphicon-align-justify"></i>
            </div>
            {section name=pid start=1 loop=$ns.pcc_components_count+1 step=1}
                {assign var="index" value=$smarty.section.pid.index-1}  
                <div class="current-section">
                    <a href="javascript:void(0)" class="f_component build-pc-component list-group-item" component_index="{$smarty.section.pid.index}">
                        <div class="build-pc-component-img">
                            <img src="{$SITE_PATH}/img/pc_configurator/{$smarty.section.pid.index}.png" />
                        </div>
                        <p class="text-center">{$ns.lm->getPhrase($ns.component_display_names.$index)}</p>
                    </a>
                </div>
            {/section}
        </div>
    </div>
    <div class="components-list-wrapper row" id="pcc_components_container">
        <div id="buildPcWrapper" class="col-md-8 build-pc-wrapper">
            <div class="list-group" id="component_selection_container">
                {nest ns = pcc_select_component}                
            </div>          
        </div>
        <div class="col-md-4" id="pcc_total_calculation_container">
            {nest ns = pcc_total_calculations}

            {*}<div class="current-product text-center">
            <img width="150px" src="https://pcstore.am/images/item_30_30/19013/1" />
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