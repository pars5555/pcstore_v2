<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
<input type="hidden" value='{$ns.allCompaniesDtosToArray}' id="all_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allCompaniesBranchesDtosToArray}' id="all_companies_branches_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesDtosToArray}' id="all_service_companies_dtos_to_array_json"/>
<input type="hidden" value='{$ns.allServiceCompaniesBranchesDtosToArray}' id="all_service_companies_branches_dtos_to_array_json"/>
<div id="cl_gmap" style="height:300px"></div>
{if $ns.userLevel === $ns.userGroupsCompany}
    <div style="text-align: left;margin:30px">
        {$ns.lm->getPhrase(609)}</br></br>
        <span style="font-size: 16px">
            {$ns.lm->getPhrase(610)} <span style="font-size: 20px;color:#AA0000">{$ns.customer->getAccessKey()}</span>
        </span>
    </div>
{/if}
<div class="container">
    <div class="row">
        <div style="margin:25px 0px;" class="companies-search-wrapper row">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" value="" class="form-control" placeholder="Search" name="st" id="srchCompanies">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon  glyphicon-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {$ns.lm->getPhrase(454)} {$ns.lm->getPhrase(458)}
                <select id="f_show_only_last_hours_select" class="form-control">
                    {foreach from=$ns.show_only_last_hours_values item=value key=key}
                        <option value="{$value}" {if $ns.show_only_last_hours_selected == $value}selected="selected"{/if} class="translatable_element" phrase_id="{$ns.show_only_last_hours_names_phrase_ids_array[$key]}">{$ns.show_only_last_hours_names[$key]}</option>
                    {/foreach}
                </select>
            </div>
            <div class="col-md-4">
                <a href="{$SITE_PATH}/price/all_zipped_prices">			
                    <span>Download All:</span>
                    <img style="vertical-align: middle" src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="javascript:void(0)" companyTab="companyListTab" class="f_company_tab_btn btn btn-default btn-primary btn-block">Company</a>
            </div>
            <div class="col-md-6">
                <a href="javascript:void(0)" companyTab="companyServiceTab" class="f_company_tab_btn btn btn-default btn-primary btn-block">Company Service</a>
            </div>
        </div>
        <div id="companyListTab" class="f_company_tab row">

            {if (($ns.allCompanies|@count )>0)}
                <h1 >{$ns.lm->getPhrase(578)}</h1>
                {foreach from=$ns.allCompanies item=company name=cl}
                    {assign var="companyId" value = $company->getId()}
                    {assign var="passive" value=$company->getPassive()}
                    {assign var="url" value=$company->getUrl()}                    
                    <div class="container-fluid">
                        <h3 class="company-tittle">{$company->getName()}</h3>
                        {if $passive != 1}
                            <span>
                                {assign var="rating" value=$company->getRating()}
                                <div class="classification" title="{$rating}%">
                                    <div class="cover"> </div>
                                    <div class="progress" style="width:{$rating}%;"> </div>								
                                </div> 
                            </span>
                        {/if}
                        {if $ns.userLevel === $ns.userGroupsCompany && $ns.userId == $companyId}
                            <div class="clear"></div>
                            <div style="cursor: pointer" title="{$ns.lm->getPhrase(377)} {$company->getAccessKey()}"
                                 class="translatable_attribute_element" attribute_phrase_id="377" attribute_name_to_translate="title">
                                <img src="{$SITE_PATH}/img/increase_rating.png" />
                            </div>
                        {/if}
                        <div class="col-md-2 company-img">
                           <a {if $url != ''}href="http://{$url}"{/if}
                                          target="_blank" title="{$url|default:$ns.lm->getPhrase(376)}"									
                                          class="translatable_attribute_element" attribute_phrase_id="{if !empty($url)}376{/if}" attribute_name_to_translate="title">
                                <img {if $passive == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/big_logo/{$companyId}" alt="logo"/>
                            </a> 
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-4">
                               {if ($ns.userLevel === $ns.userGroupsUser) && !in_array($companyId,$ns.userCompaniesIdsArray)}
                                <div class="form-group">
                                    <label for="dealerCode">Code</label>
                                    <input id="company_access_key_input_{$companyId}"  type="text" class="form-control" placeholder="Code">
                                    <a href="javascript:void(0)" class="btn btn-default btn-primary center-block f_company_access_key_confirm_btn" company_id="{$companyId}">Confirm</a>
                                </div>
                                {else}
                                <div class="documents-slider">
                                    <div class="f_left_arrow left-arrow doc-slider-arrow">
                                    </div>
                                    <div class="f_right_arrow right-arrow doc-slider-arrow">
                                    </div>
                                    <div id="documentSliderWrapper" class="f_document_slider owl-carousel owl-theme text-center">
                                        {* company last price*}							
                                        {if $company->getPriceId()>0}
                                            <a  href="{$SITE_PATH}/price/last_price/{$companyId}"> 
                                                {assign var="company_last_price_ext" value=$company->getPriceExt()} 										
                                                {assign var="priceListDate" value=$company->getPriceUploadDateTime()} 										
                                                {assign var="icon_local_path" value="`$ns.DOCUMENT_ROOT`/img/file_types_icons/`$company_last_price_ext`_icon.png"} 		
                                                {assign var="icon_path" value="`$SITE_PATH`/img/file_types_icons/`$company_last_price_ext`_icon.png"} 		
                                                <img src = "{if file_exists($icon_local_path)}{$icon_path}{else}{$SITE_PATH}/img/file_types_icons/unknown_icon.png{/if}"  alt="document"/>

                                                <span style="color:{$ns.companiesPriceListManager->getCompanyPriceColor($priceListDate)}"> 
                                                    {if $priceListDate}
                                                        {$priceListDate|date_format:"%m/%d"}
                                                        <br />
                                                        {$priceListDate|date_format:"%H:%M"}
                                                    {else}
                                                        {$ns.lm->getPhrase(14)}
                                                    {/if} </span> 
                                            </a>
                                        {/if}
                                        {* company previous prices*}
                                        {*assign var="companyHistoryPrices" value = $ns.companiesPriceListManager->getCompanyHistoryPricesOrderByDate($companyId,0,100)*}	
                                        {foreach from=$ns.groupCompaniesZippedPricesByCompanyId[$companyId] item=pr}
                                            <a  href="{$SITE_PATH}/price/zipped_price_unzipped/{$pr->getId()}"> 
                                                <img  src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/>
                                                {assign var="uploadDateTime" value = $pr->getUploadDateTime()}					
                                                <p > 
                                                    {if $uploadDateTime}
                                                        {$uploadDateTime|date_format:"%m/%d"}
                                                        <br />
                                                        {$uploadDateTime|date_format:"%H:%M"}												
                                                    {/if} </p> 
                                            </a>
                                        {/foreach}
                                    </div>
                                </div>
                                    {/if}
                            </div>
                            <div class="col-md-4">
                                <div class="company-address">
                                    {assign var="addrs" value=";"|explode:$company->getStreet()}					
                                    {assign var="zips" value=","|explode:$company->getZip()}					
                                    {assign var="regions" value=","|explode:$company->getRegion()}	
                                    <h4>Company Info</h4>
                                    <p class="address">
                                        {foreach from=$addrs item=addr key=index}
                                            <span>{assign var="region_phrase_id" value=$ns.lm->getPhraseIdByPhraseEn($regions[$index])}
                                            {$addr}, {$zips[$index]}, {$ns.lm->getPhrase($region_phrase_id)}</span>
                                        {/foreach}</p>
                                    
                                    <p class="offers">
                                        {if $passive != 1}
                                            {assign var="company_offers" value=$company->getOffers()}                                          
                                        <marquee scrollamount="2" behavior="scroll" direction="left">								
                                            {assign var="offers" value="^"|explode:$company_offers}								
                                            {foreach from=$offers item=offer}	
                                                {$offer}<br/>
                                            {/foreach} 
                                        </marquee>								
                                    {/if}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <h4>Tel Number</h4>
                                <p class="tel-number">{assign var=phones value=","|explode:$company->getPhones()}
                                {foreach from=$phones item=phone}
                                <p><strong></strong>{$phone}</p>
                                {/foreach}  
                                </p>
                            </div>
                        </div>
                        {if ($ns.userLevel === $ns.userGroupsCompany)}
                            <div class="squaredOne" style="float:left;margin: 13px 15px 0 0;" title="{$ns.lm->getPhrase(399)}"
                                 class="translatable_attribute_element" attribute_phrase_id="399" attribute_name_to_translate="title">
                                {assign var="interested_companies_ids_for_sms" value=$ns.customer->getInterestedCompaniesIdsForSms()}
                                {assign var="interested_companies_ids_for_sms_array" value=','|explode:$interested_companies_ids_for_sms}

                                <input type="checkbox" id="receive_sms_from^{$companyId}" autocomplete="off" class="f_receive_sms_from_checkboxes" value="1"	style="visibility: hidden;" 
                                       {if in_array($companyId,$interested_companies_ids_for_sms_array)} checked="checked"{/if} >
                                <label for="receive_sms_from^{$companyId}"></label>
                            </div>
                        {/if}
                        <div class="row">
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
        <div id="companyServiceTab" style="display:none;" class="f_company_tab row">
            {if (($ns.allServiceCompanies|@count )>0)}
                <h1 class="avo_style_CompaniesBlockTitle">{$ns.lm->getPhrase(579)}</h1>
                <div class="col-md-9">
                    <h3 class="company-tittle">COMPANY TITLE</h3>
                    <div class="company-rating">RATING</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dealerCode">Code</label>
                                <input id="dealerCode" name="email" type="text" class="form-control" placeholder="Code">
                                <a href="javascript:void(0)" class="btn btn-default btn-primary center-block">Confirm</a>
                            </div>
                            <div class="documents-slider">
                                <div class="f_left_arrow left-arrow doc-slider-arrow">
                                </div>
                                <div class="f_right_arrow right-arrow doc-slider-arrow">
                                </div>
                                <div id="listDocumentSliderWrapper" class="f_document_slider owl-carousel owl-theme text-center">
                                    <div class="item">
                                        1
                                    </div>
                                    <div class="item">
                                        2
                                    </div>
                                    <div class="item">
                                        3
                                    </div>
                                    <div class="item">
                                        4
                                    </div>
                                    <div class="item">
                                        5
                                    </div>
                                    <div class="item">
                                        6
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="company-address">
                                <h4>Company Info</h4>
                                <p class="address">Komitas 14</p>
                                <p class="tel-number">010-34-53-12</p>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>
