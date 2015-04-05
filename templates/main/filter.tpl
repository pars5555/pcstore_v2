
<div class="table filter_conainer_box">
    <div class="table-cell">
        <div class="filter_container">
            <h3>Filter</h3> 
            <div class="form-group">
                <label class="label" for="sort_by">
                    {$ns.lm->getPhrase(116)}:
                </label>
                <div class="select_wrapper">
                    <select id="sort_by">                                    
                        {foreach from=$ns.sort_by_values item=value key=key}
                            <option value="{$value}" {if $value==$ns.selected_sort_by_value}selected="selected"{/if}>{$ns.sort_by_display_names[$key]}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            {if ($ns.companiesIds|@count > 1)}          
                <div class="form-group">                        
                    <label class="label" for="selected_company_id">{$ns.lm->getPhrase(66)}: </label>
                    <div class="select_wrapper">
                        <select id='selected_company_id'>
                            {foreach from=$ns.companiesIds item=value key=key}
                                {if ($key == 0)}
                                    <option value="{$value}" {if $ns.selectedCompanyId == 0}selected="selected"{/if} class="translatable_element" phrase_id="153">{$ns.companiesNames[$key]}</option>
                                {else}
                                    <option value="{$value}" {if $ns.selectedCompanyId == $value}selected="selected"{/if} >{$ns.companiesNames[$key]}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
            {/if}  
            <div class="form-group">
                <label class="label" for="listing_cols">
                    Listing Cols:
                </label>
                <div class="select_wrapper">
                    <select id="listing_cols">                                    
                        {foreach from=$ns.listing_cols_values item=value key=key}
                            <option value="{$value}" {if $value==$ns.listing_cols}selected="selected"{/if}>{$value} cols</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            {*}
            {*}
            <div class="form-group show_var_products">    
                <div class="table-cell">
                </div>           
                <div class="table-cell">        
                    <label class="checkbox_container" for="show_only_vat_items">                        
                        <span class="checkbox {if $ns.show_only_vat_items!=0}checked{/if}"></span>
                        <span class="checkbox_label">{$ns.lm->getPhrase(378)}</span>
                        <input class="hidden" type="checkbox" id="show_only_vat_items" {if $ns.show_only_vat_items!=0}checked{/if}/>
                    </label>
                </div>   
            </div>           
        </div>           
    </div>           

    <div class="table-cell">
        {nest ns=paging}
    </div>           
</div>