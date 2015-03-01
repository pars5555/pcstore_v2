<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
<input type="hidden" value='{$ns.allCompaniesDtosToArray}' id="all_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allCompaniesBranchesDtosToArray}' id="all_companies_branches_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesDtosToArray}' id="all_service_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesBranchesDtosToArray}' id="all_service_companies_branches_dtos_to_array_json"/>
<div id="cl_gmap" style="height:300px"></div>
{if $ns.userLevel === $ns.userGroupsCompany}
    <div style="text-align: left;margin:30px">
        {$ns.lm->getPhrase(609)}</br></br>
        <span style="font-size: 16px"> {$ns.lm->getPhrase(610)} <span style="font-size: 20px;color:#AA0000">{$ns.customer->getAccessKey()}</span> </span>
    </div>
{/if}
<div class="container">
    <div class="companies_container">
        <div class="companies-search-wrapper">
            <div class="search_block">
                <div class="search_container">
                    <input type="text" value="" class="  search_text" placeholder="Search" name="st" id="srchCompanies">
                    <button type="submit" class="search_btn">
                        <span class="glyphicon"></span>
                    </button>
                </div>
            </div>
            <div class="show_com_price">
                <label>{$ns.lm->getPhrase(454)} {$ns.lm->getPhrase(458)}:</label>
                <div class="select_wrapper">
                    <select id="f_show_only_last_hours_select" class=" ">
                        {foreach from=$ns.show_only_last_hours_values item=value key=key}
                            <option value="{$value}" {if $ns.show_only_last_hours_selected == $value}selected="selected"{/if} class="translatable_element" phrase_id="{$ns.show_only_last_hours_names_phrase_ids_array[$key]}">{$ns.show_only_last_hours_names[$key]}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="download_all">
                <a class="button blue" href="{$SITE_PATH}/price/all_zipped_prices">
                    <span>Download All:</span>
                    <span class="glyphicon"></span>
                    <!-- <img style="vertical-align: middle" src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/>  -->
                </a>
            </div>
            <div class="company_filter">
                <a href="javascript:void(0)" companyTab="companyListTab" class="f_company_tab_btn tab_title active">Company</a>
                <a href="javascript:void(0)" companyTab="companyServiceTab" class="f_company_tab_btn tab_title">Company Service</a>
            </div>
        </div>
        <div class="clear"></div>
        {include file="$TEMPLATE_DIR/main/sub_templates/companies_list.tpl"}
        {include file="$TEMPLATE_DIR/main/sub_templates/service_companies_list.tpl"}
    </div>
</div>
