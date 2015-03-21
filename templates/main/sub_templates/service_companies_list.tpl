<div id="companyServiceTab" class="company_tab">
    {if (($ns.allServiceCompanies|@count )>0)}
        <h1 class="main_title">{$ns.lm->getPhrase(579)}</h1>
        <div class="table">
            <div class="companies_title_row">
                <h2>
                    {$ns.lm->getPhrase(61)} / {$ns.lm->getPhrase(31)}
                </h2>
                <h2>
                    {$ns.lm->getPhrase(10)}
                </h2>
                <h2>
                    {$ns.lm->getPhrase(13)}
                </h2>
                <h2>
                    {$ns.lm->getPhrase(12)}
                </h2>
            </div>
            {foreach from=$ns.allServiceCompanies item=company name=cl}

                {assign var="companyId" value = $company->getId()}
                <div class="company_container">
                    <div class="company-info">
                            <!-- <span class="company-num">{$smarty.foreach.cl.index+1}</span> -->
                        <a href="javascript:void(0);" class="service_company_gmap_pin" service_company_id="{$companyId}"><img src="{$SITE_PATH}/img/google_map_pin_blue.png" alt="logo"/></a>
                        <div class="company_rating">
                            <h3 class="company-tittle">{$company->getName()}</h3>
                        </div>
                        <div class="company-img">
                            {assign var="url" value=$company->getUrl()}
                            <a {if $url != ''}href="http://{$url}"{/if}
                                              target="_blank" title="{$url|default:$ns.lm->getPhrase(376)}"
                                              class="translatable_attribute_element" attribute_phrase_id="{if !empty($url)}376{/if}" attribute_name_to_translate="title"> <img  src="{$SITE_PATH}/images/sc_small_logo/{$companyId}" alt="logo"/> </a>
                        </div>
                    </div>

                    <div class="company_confirm">
                        {if $company->getHasPrice()==1}
                            {if $company->getPriceId()>0} 
                                {if $company->getShowPrice()==1}                                  
                                    <div id="service_price_files_content_{$companyId}">
                                        <div class="documents-slider">
                                            <div class="f_left_arrow left-arrow doc-slider-arrow"></div>
                                            <div class="f_right_arrow right-arrow doc-slider-arrow"></div>
                                            <div id="documentSliderWrapper" class="f_document_slider owl-carousel owl-theme text-center">

                                                {* company last price*}

                                                <a  href="{$SITE_PATH}/price/service_last_price/{$companyId}"> {assign var="company_last_price_ext" value=$company->getPriceExt()}
                                                    {assign var="priceListDate" value=$company->getPriceUploadDateTime()}
                                                    {assign var="icon_local_path" value="`$ns.DOCUMENT_ROOT`/img/file_types_icons/`$company_last_price_ext`_icon.png"}
                                                    {assign var="icon_path" value="`$SITE_PATH`/img/file_types_icons/`$company_last_price_ext`_icon.png"} <img src = "{if file_exists($icon_local_path)}{$icon_path}{else}{$SITE_PATH}/img/file_types_icons/unknown_icon.png{/if}"  alt="document"/> <span style="color:{$ns.serviceCompaniesPriceListManager->getCompanyPriceColor($priceListDate)}"> {if $priceListDate}
                                                            {$priceListDate|date_format:"%m/%d"}
                                                            <br />
                                                            {$priceListDate|date_format:"%H:%M"}
                                                        {else}
                                                            {$ns.lm->getPhrase(14)}
                                                        {/if} </span> </a>

                                                {* company previouse prices*}
                                                {*assign var="companyHistoryPrices" value = $ns.serviceCompaniesPriceListManager->getCompanyHistoryPricesOrderByDate($companyId,0,100)*}
                                                {if isset($ns.groupServiceCompaniesZippedPricesByCompanyId[$companyId])}
                                                    {foreach from=$ns.groupServiceCompaniesZippedPricesByCompanyId[$companyId] item=pr}
                                                        <a href="{$SITE_PATH}/price/service_zipped_price_unzipped/{$pr->getId()}"> 
                                                            <img src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/> 
                                                            {assign var="uploadDateTime" value = $pr->getUploadDateTime()} 
                                                            <span> 
                                                                {if $uploadDateTime}
                                                                    {$uploadDateTime|date_format:"%m/%d"}
                                                                    <br />
                                                                    {$uploadDateTime|date_format:"%H:%M"}
                                                                {/if} 
                                                            </span> 
                                                        </a>
                                                    {/foreach}
                                                {/if}

                                            </div>
                                        </div>
                                    </div>
                                {else}
                                    <div class="form-group">
                                        <input type="text" id="service_company_access_key_input_{$companyId}" placeholder="{$ns.lm->getPhrase(600)}"
                                               class="service_companies_access_key_inputes text"   service_company_id="{$companyId}"/>
                                        <a href="javascript:void(0)" class="f_company_access_key_confirm_btn blue button" service_company_id="{$companyId}">
                                            <span class="glyphicon"></span>
                                        </a>
                                    </div>
                                {/if}
                            {/if}
                        {/if}
                    </div>

                    <div class="company-address">
                        <span>                                                  
                            {if (isset($ns.serviceCompanyBranchesDtosMappedByServiceCompanyId[$companyId]))}
                                {foreach from=$ns.serviceCompanyBranchesDtosMappedByServiceCompanyId[$companyId] item=branchDto}
                                    {assign var="region_phrase_id" value=$ns.lm->getPhraseIdByPhraseEn($branchDto->getRegion())}
                                    {$branchDto->getStreet()}, {$branchDto->getZip()}, {$ns.lm->getPhrase($region_phrase_id)}
                                    <br/>
                                {/foreach}
                            {/if}
                        </span>
                    </div>
                    <div class="company-tel">
                        {if (isset($ns.serviceCompanyBranchesDtosMappedByServiceCompanyId[$companyId]))}
                            {foreach from=$ns.serviceCompanyBranchesDtosMappedByServiceCompanyId[$companyId] item=branchDto}                                            
                                {assign var=phones value=","|explode:$branchDto->getPhones()}
                                {foreach from=$phones item=phone}
                                    <span>{$phone}</span></br>
                                {/foreach}
                            {/foreach}
                        {/if}
                    </div>

                </div>
            {/foreach}
        {/if}
    </div>
</div>