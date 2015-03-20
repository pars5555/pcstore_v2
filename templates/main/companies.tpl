<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
<input type="hidden" value='{$ns.allCompaniesDtosToArray}' id="all_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allCompaniesBranchesDtosToArray}' id="all_companies_branches_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesDtosToArray}' id="all_service_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesBranchesDtosToArray}' id="all_service_companies_branches_dtos_to_array_json"/>
<div id="cl_gmap" style="height:300px"></div>

<div class="container">
    <div class="companies_container">
        {if $ns.userLevel === $ns.userGroupsCompany}
            <div class="company_email_send_text">
                <h3 class="title">{$ns.lm->getPhrase(609)}</h3>

                <span style="font-size: 16px"> {$ns.lm->getPhrase(610)} <span style="font-size: 20px;color:#AA0000">{$ns.customer->getAccessKey()}</span> </span>
            </div>
        {/if}

        <div class="companies-search-wrapper">
            {*}
            <div class="search_block">
            <div class="search_container">
            <input type="text" value="" class="  search_text" placeholder="Search" name="st" id="srchCompanies">
            <button type="submit" class="search_btn">
            <span class="glyphicon"></span>
            </button>
            </div>
            </div>
            {*}
            <form class="show_com_price" method="POST" action="{$SITE_PATH}/companies" autocomplete="off">
                <label>{$ns.lm->getPhrase(454)} {$ns.lm->getPhrase(458)}:</label>
                <div class="select_wrapper">
                    <select id="f_show_only_last_hours_select" name="show_only_last_hours_selected">
                        {foreach from=$ns.show_only_last_hours_values item=value key=key}
                            <option value="{$value}" {if $ns.show_only_last_hours_selected == $value}selected="selected"{/if} class="translatable_element" phrase_id="{$ns.show_only_last_hours_names_phrase_ids_array[$key]}">{$ns.show_only_last_hours_names[$key]}</option>
                        {/foreach}
                    </select>
                </div>
            </form>
            <div class="download_all">
                <a class="button blue" href="{$SITE_PATH}/price/all_zipped_prices">
                    <span>{$ns.lm->getPhrase(659)}:</span>
                    <span class="glyphicon"></span>
                    <!-- <img style="vertical-align: middle" src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/>  -->
                </a>
            </div>
            <div class="company_filter">
                <a href="javascript:void(0)" companyTab="companyListTab" class="f_company_tab_btn tab_title active">{$ns.lm->getPhrase(494)}</a>
                <a href="javascript:void(0)" companyTab="companyServiceTab" class="f_company_tab_btn tab_title">{$ns.lm->getPhrase(579)}</a>
            </div>
        </div>
        <div class="clear"></div>
        {include file="$TEMPLATE_DIR/main/sub_templates/companies_list.tpl"}
        {include file="$TEMPLATE_DIR/main/sub_templates/service_companies_list.tpl"}
    </div>
</div>
