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
                    <input type="text" value="" class="form-control search_text" placeholder="Search" name="st" id="srchCompanies">
                    <button type="submit" class="search_btn">
                        <span class="glyphicon"></span>
                    </button>
                </div>
            </div>
            <div class="show_com_price">
                <label>{$ns.lm->getPhrase(454)} {$ns.lm->getPhrase(458)}:</label>
                <div class="select_wrapper">
                    <select id="f_show_only_last_hours_select" class="form-control">
                        {foreach from=$ns.show_only_last_hours_values item=value key=key}
                            <option value="{$value}" {if $ns.show_only_last_hours_selected == $value}selected="selected"{/if} class="translatable_element" phrase_id="{$ns.show_only_last_hours_names_phrase_ids_array[$key]}">{$ns.show_only_last_hours_names[$key]}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="download_all">
                <a href="{$SITE_PATH}/price/all_zipped_prices"> <span>Download All:</span> <img style="vertical-align: middle" src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/> </a>
            </div>
            <div class="company_filter">
                <a href="javascript:void(0)" companyTab="companyListTab" class="f_company_tab_btn company_tab_btn active">Company</a>
                <a href="javascript:void(0)" companyTab="companyServiceTab" class="f_company_tab_btn company_tab_btn">Company Service</a>
            </div>
        </div>
        <div class="clear"></div>
        <div id="companyListTab" class="f_company_tab company_tab">

            {if (($ns.allCompanies|@count )>0)}
                <h1 >{$ns.lm->getPhrase(578)}</h1>
                {foreach from=$ns.allCompanies item=company name=cl}
                    {assign var="companyId" value = $company->getId()}
                    {assign var="passive" value=$company->getPassive()}
                    {assign var="url" value=$company->getUrl()}
                    <div class="company_container">
                        <div class="company-info">
                            <h3 class="company-tittle">{$company->getName()}</h3>
                            {if $passive != 1}
                                <span> {assign var="rating" value=$company->getRating()}
                                    <div class="classification" title="{$rating}%">
                                        <div class="cover"></div>
                                        <div class="progress" style="width:{$rating}%;"></div>
                                    </div> 
                                </span>
                            {/if}
                            <a href="javascript:void(0);" class="company_gmap_pin" company_id="{$companyId}"><img src="{$SITE_PATH}/img/google_map_pin.png" width=40 alt="logo"/></a>
						   {if $ns.userLevel === $ns.userGroupsCompany && $ns.userId == $companyId}
                                <div class="clear"></div>
                                <div title="{$ns.lm->getPhrase(377)} {$company->getAccessKey()}"
                                     class="translatable_attribute_element" attribute_phrase_id="377" attribute_name_to_translate="title">
                                    <img src="{$SITE_PATH}/img/increase_rating.png" />
                                </div>
                            {/if}
                        </div>
                        <div class="company-img">
                            <a {if $url != ''}href="http://{$url}"{/if}
                                              target="_blank" title="{$url|default:$ns.lm->getPhrase(376)}"
                                              class="translatable_attribute_element" attribute_phrase_id="{if !empty($url)}376{/if}" attribute_name_to_translate="title"> <img {if $passive == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/big_logo/{$companyId}" alt="logo"/> </a>
                        </div>
                        <div class="company_confirm">
                            {if ($ns.userLevel === $ns.userGroupsUser) && !in_array($companyId,$ns.userCompaniesIdsArray)}
                                <div class="form-group">
                                    <!-- <label class="input_label" for="dealerCode">Code</label> -->
                                    <input id="company_access_key_input_{$companyId}"  type="text" class="form-control text" placeholder="Code">
                                    <a href="javascript:void(0)" class="f_company_access_key_confirm_btn blue button" company_id="{$companyId}"><span class="glyphicon"></span></a>
                                </div>
                            {else}
                                <div class="documents-slider">
                                    <div class="f_left_arrow left-arrow doc-slider-arrow"></div>
                                    <div class="f_right_arrow right-arrow doc-slider-arrow"></div>
                                    <div id="documentSliderWrapper" class="f_document_slider owl-carousel owl-theme text-center">
                                        {* company last price*}
                                        {if $company->getPriceId()>0}
                                            <a  href="{$SITE_PATH}/price/last_price/{$companyId}"> {assign var="company_last_price_ext" value=$company->getPriceExt()}
                                                {assign var="priceListDate" value=$company->getPriceUploadDateTime()}
                                                {assign var="icon_local_path" value="`$ns.DOCUMENT_ROOT`/img/file_types_icons/`$company_last_price_ext`_icon.png"}
                                                {assign var="icon_path" value="`$SITE_PATH`/img/file_types_icons/`$company_last_price_ext`_icon.png"} <img src = "{if file_exists($icon_local_path)}{$icon_path}{else}{$SITE_PATH}/img/file_types_icons/unknown_icon.png{/if}"  alt="document"/> <span style="color:{$ns.companiesPriceListManager->getCompanyPriceColor($priceListDate)}"> {if $priceListDate}
                                                        {$priceListDate|date_format:"%m/%d"}
                                                        <br />
                                                        {$priceListDate|date_format:"%H:%M"}
                                                    {else}
                                                        {$ns.lm->getPhrase(14)}
                                                    {/if} </span> </a>
                                                {/if}
                                                {* company previous prices*}
                                                {*assign var="companyHistoryPrices" value = $ns.companiesPriceListManager->getCompanyHistoryPricesOrderByDate($companyId,0,100)*}
                                                {if isset($ns.groupCompaniesZippedPricesByCompanyId[$companyId])}
                                                    {foreach from=$ns.groupCompaniesZippedPricesByCompanyId[$companyId] item=pr}
                                                <a  href="{$SITE_PATH}/price/zipped_price_unzipped/{$pr->getId()}"> <img  src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/> {assign var="uploadDateTime" value = $pr->getUploadDateTime()}
                                                    <p >
                                                        {if $uploadDateTime}
                                                            {$uploadDateTime|date_format:"%m/%d"}
                                                            <br />
                                                            {$uploadDateTime|date_format:"%H:%M"}
                                                        {/if}
                                                    </p> </a>
                                                {/foreach}
                                            {/if}
                                    </div>
                                </div>
                            {/if}
                        </div>
                        <div class="company-address">
                            {assign var="addrs" value=";"|explode:$company->getStreet()}
                            {assign var="zips" value=","|explode:$company->getZip()}
                            {assign var="regions" value=","|explode:$company->getRegion()}
                            <h4>Company Info</h4>
                            <p class="address">
                                {foreach from=$addrs item=addr key=index}
                                    <span>{assign var="region_phrase_id" value=$ns.lm->getPhraseIdByPhraseEn($regions[$index])}
                                        {$addr}, {$zips[$index]}, {$ns.lm->getPhrase($region_phrase_id)}</span>
                                    {/foreach}
                            </p>

                            <p class="offers">
                                {if $passive != 1}
                                    {assign var="company_offers" value=$company->getOffers()}
                                <marquee scrollamount="2" behavior="scroll" direction="left">
                                    {assign var="offers" value="^"|explode:$company_offers}
                                    {foreach from=$offers item=offer}
                                        {$offer}
                                        <br/>
                                    {/foreach}
                                </marquee>
                            {/if}
                            </p>
                        </div>
                        <div class="company-tel">
                            <h4>Tel Number</h4>
                            <p class="tel-number">
                                {assign var=phones value=","|explode:$company->getPhones()}
                                {foreach from=$phones item=phone}
                                <p>
                                    {$phone}
                                </p>
                            {/foreach}
                            </p>
                        </div>
                        {if ($ns.userLevel === $ns.userGroupsCompany)}
                            <div class="squaredOne" title="{$ns.lm->getPhrase(399)}"
                                 class="translatable_attribute_element" attribute_phrase_id="399" attribute_name_to_translate="title">
                                {assign var="interested_companies_ids_for_sms" value=$ns.customer->getInterestedCompaniesIdsForSms()}
                                {assign var="interested_companies_ids_for_sms_array" value=','|explode:$interested_companies_ids_for_sms}

                                <input type="checkbox" id="receive_sms_from^{$companyId}" autocomplete="off" class="f_receive_sms_from_checkboxes" value="1"	style="visibility: hidden;"
                                       {if in_array($companyId,$interested_companies_ids_for_sms_array)} checked="checked"{/if} >
                                <label for="receive_sms_from^{$companyId}"></label>
                            </div>
                        {/if}
                    </div>
                {/foreach}
            {/if}
        </div>
        <div id="companyServiceTab" style="display:none;" class="f_company_tab company_tab">
            {if (($ns.allServiceCompanies|@count )>0)}
    <h1 class="avo_style_CompaniesBlockTitle">{$ns.lm->getPhrase(579)}</h1>
    <table class="avo_style_companyesTable" cellspacing="0">

        <thead>
            <tr>
                <th></th>
                <th>{$ns.lm->getPhrase(61)}</th>
                <th>{$ns.lm->getPhrase(31)}</th>                                
                <th>{$ns.lm->getPhrase(10)}</th>                                
                <th>{$ns.lm->getPhrase(12)}</th>
                <th>{$ns.lm->getPhrase(13)}</th>                     
            </tr>
        </thead>
        <tbody>
            {foreach from=$ns.allServiceCompanies item=company name=cl}

                {assign var="companyId" value = $company->getId()}

                <tr class="{if $smarty.foreach.cl.index % 2 == 1}avo_style_blueTableBox{/if}">
                    <td style="text-align: center">{$smarty.foreach.cl.index+1}
                    </td>
                    <td>                      						
                        {$company->getName()}

                    </td>
                    <td>
                        <a href="javascript:void(0);" class="service_company_gmap_pin" service_company_id="{$companyId}"><img src="{$SITE_PATH}/img/google_map_pin_blue.png" width=20 alt="logo"/></a>
                            {assign var="url" value=$company->getUrl()}	
                        <a {if $url != ''}href="http://{$url}"{/if}
                                          target="_blank" title="{$url|default:$ns.lm->getPhrase(376)}"									
                                          class="translatable_attribute_element" attribute_phrase_id="{if !empty($url)}376{/if}" attribute_name_to_translate="title">
                            <img  src="{$SITE_PATH}/images/sc_small_logo/{$companyId}" alt="logo"/>
                        </a>
                    </td>


                    <td style="display: flex">					
                        {if $company->getHasPrice()==1}
                            {if $company->getPriceId()>0} 
                                {if $company->getShowPrice()==1} 
                                    <div style="float:left;margin-right: 7px;margin-top:12px">
                                        <a href="javascript:void(0);" class="service_price_scroll_left_a" service_company_id="{$companyId}">
                                            <img src = "{$SITE_PATH}/img/price_left_arrow.png"  alt=">"/> 
                                        </a>
                                    </div>

                                    <div style="overflow: hidden;float:left;max-width: 120px;min-width: 120px;">
                                        <div id="service_price_files_content_{$companyId}">                                                                    
                                         
                                            {* company last price*}							                            

                                            <a  style="display: inline-block;white-space: nowrap" href="{$SITE_PATH}/price/service_last_price/{$companyId}"> 
                                                {assign var="company_last_price_ext" value=$company->getPriceExt()} 										
                                                {assign var="priceListDate" value=$company->getPriceUploadDateTime()} 										
                                                {assign var="icon_local_path" value="`$ns.DOCUMENT_ROOT`/img/file_types_icons/`$company_last_price_ext`_icon.png"} 		
                                                {assign var="icon_path" value="`$SITE_PATH`/img/file_types_icons/`$company_last_price_ext`_icon.png"} 		
                                                <img style="float:left;" src = "{if file_exists($icon_local_path)}{$icon_path}{else}{$SITE_PATH}/img/file_types_icons/unknown_icon.png{/if}"  alt="document"/>
                                                <div style="clear: both"></div>
                                                <span style="word-wrap: break-word;float:left;color:{$ns.serviceCompaniesPriceListManager->getCompanyPriceColor($priceListDate)}"> 
                                                    {if $priceListDate}
                                                        {$priceListDate|date_format:"%m/%d"}
                                                        <br />
                                                        {$priceListDate|date_format:"%H:%M"}
                                                    {else}
                                                        {$ns.lm->getPhrase(14)}
                                                    {/if} </span> 
                                            </a>

                                            {* company previouse prices*}
                                            {*assign var="companyHistoryPrices" value = $ns.serviceCompaniesPriceListManager->getCompanyHistoryPricesOrderByDate($companyId,0,100)*}	
                                            {foreach from=$ns.groupServiceCompaniesZippedPricesByCompanyId[$companyId] item=pr}
                                                <a  style="display: inline-block;white-space: nowrap;margin-left:5px" href="{$SITE_PATH}/price/service_zipped_price_unzipped/{$pr->getId()}"> 
                                                    <img style="float:left" src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/>
                                                    <div style="clear: both"></div>
                                                    {assign var="uploadDateTime" value = $pr->getUploadDateTime()}					
                                                    <span style="word-wrap: break-word;float:left;"> 
                                                        {if $uploadDateTime}
                                                            {$uploadDateTime|date_format:"%m/%d"}
                                                            <br />
                                                            {$uploadDateTime|date_format:"%H:%M"}												
                                                        {/if} </span> 
                                                </a>
                                            {/foreach}




                                        </div>
                                    </div>
                                    <div style="float:left;margin-left: 7px;margin-top:12px">
                                        <a href="javascript:void(0);" class="service_price_scroll_right_a" service_company_id="{$companyId}">
                                            <img src = "{$SITE_PATH}/img/price_right_arrow.png"  alt="<"/> 
                                        </a>
                                    </div>  
                                {else}
                                    <input type="text" id="service_company_access_key_input_{$companyId}" placeholder="{$ns.lm->getPhrase(600)}" 
                                           class="service_companies_access_key_inputes translatable_attribute_element" 
                                           attribute_name_to_translate="placeholder" attribute_phrase_id="600"
                                           service_company_id="{$companyId}" style="font-size: 13px"/>
                                    <button class="add_service_company_buttons" service_company_id="{$companyId}">add</button>
                                {/if}                            
                            {/if}
                        {/if}
                    </td>


                    <td> 
                        <span style="display: inline-block;"> 
                            {assign var=phones value=","|explode:$company->getPhones()}
                            {foreach from=$phones item=phone}
                                {$phone}<br/>
                            {/foreach}  
                        </span>
                    </td>


                    <td style="white-space: normal;">

                        {assign var="addrs" value=";"|explode:$company->getStreet()}					
                        {assign var="zips" value=","|explode:$company->getZip()}					
                        {assign var="regions" value=","|explode:$company->getRegion()}					

                        <span style="display: inline-block;">
                            {foreach from=$addrs item=addr key=index}
                                {assign var="region_phrase_id" value=$ns.lm->getPhraseIdByPhraseEn($regions[$index])}
                                {$addr}, {$zips[$index]}, {$ns.lm->getPhrase($region_phrase_id)}<br/>
                            {/foreach}  
                        </span>
                    </td>
                    {/foreach}
        </tbody>
    </table>
{/if}
        </div>
    </div>
</div>
