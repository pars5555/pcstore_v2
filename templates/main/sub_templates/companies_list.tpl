<div id="companyListTab" class="company_tab">
    {if (($ns.allCompanies|@count )>0)}
        <h1 class="main_title">{$ns.lm->getPhrase(578)}</h1>
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
            {foreach from=$ns.allCompanies item=company name=cl}
                {assign var="companyId" value = $company->getId()}
                {assign var="passive" value=$company->getPassive()}
                {assign var="url" value=$company->getUrl()}
                <div class="company_container">
                    <div class="company-info f_company_col company_col">
                        <a href="javascript:void(0);" class="company_gmap_pin" company_id="{$companyId}"><img src="{$SITE_PATH}/img/google_map_pin.png" width=40 alt="logo"/></a>
                        <div class="company_rating">
                            <h3 class="company-tittle">
                                <span class="company-status {if $ns.onlineUsersManager->getOnlineUserByEmail($company->getEmail())}online{/if} fontAwesome" title="{if $ns.onlineUsersManager->getOnlineUserByEmail($company->getEmail())}online{else}offline{/if}"></span>
                                <span>{$company->getName()}</span>
                            </h3>
                            {if $passive != 1}
                                {assign var="rating" value=$company->getRating()}
                                <div class="classification" title="{$rating}%">
                                    <div class="cover"></div>
                                    <div class="progress" style="width:{$rating}%;"></div>
                                </div>
                            {/if}
                        </div>
                        {if $ns.userLevel === $ns.userGroupsCompany && $ns.userId == $companyId}
                            <div title="{$ns.lm->getPhrase(377)} {$company->getAccessKey()}"
                                 class="increase_rating translatable_attribute_element" attribute_phrase_id="377" attribute_name_to_translate="title">
                                <img src="{$SITE_PATH}/img/increase_rating.jpg" />
                            </div>
                        {/if}
                        <div class="company-img">
                            {if $company->getShowPrice()!=1}
                                <img {if $passive == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyId}" alt="logo"/>                             
                            {else}    
                                <a {if $url != ''}href="http://{$url}"{/if}
                                                  target="_blank" title="{$url|default:$ns.lm->getPhrase(376)}"
                                                  class="translatable_attribute_element" attribute_phrase_id="{if !empty($url)}376{/if}" attribute_name_to_translate="title"> 
                                    <img {if $passive == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyId}" alt="logo"/> 
                                </a>
                            {/if}
                        </div>

                        <div class="company_toggle_btn f_company_toggle_btn"></div>

                    </div>
                    <div class="company_confirm f_company_col company_col">
                        {if ($ns.userLevel === $ns.userGroupsUser) && $company->getShowPrice()!=1}
                            <div class="form-group">
                                <!-- <label class="input_label label" for="dealerCode">Code</label> -->
                                <input id="company_access_key_input_{$companyId}"  type="text" class="  text" placeholder="Code">
                                <a href="javascript:void(0)" class="f_company_access_key_confirm_btn blue button" company_id="{$companyId}"><span class="glyphicon"></span></a>
                            </div>
                        {else}
                            <div class="documents-slider">
                                <div class="f_left_arrow left-arrow doc-slider-arrow"></div>
                                <div class="f_right_arrow right-arrow doc-slider-arrow"></div>
                                <div id="documentSliderWrapper" class="f_document_slider owl-carousel owl-theme text-center">
                                    {* company last price*}
                                    {if $company->getPriceId()>0}
                                        <a class="price_file" href="{$SITE_PATH}/price/last_price/{$companyId}"> 
                                            {assign var="company_last_price_ext" value=$company->getPriceExt()}
                                            {assign var="priceListDate" value=$company->getPriceUploadDateTime()}
                                            {assign var="icon_local_path" value="`$ns.DOCUMENT_ROOT`/htdocs/img/file_types_icons/`$company_last_price_ext`_icon.png"}
                                            {assign var="icon_path" value="`$SITE_PATH`/img/file_types_icons/`$company_last_price_ext`_icon.png"} <img src = "{if file_exists($icon_local_path)}{$icon_path}{else}{$SITE_PATH}/img/file_types_icons/unknown_icon.png{/if}"  alt="document"/>
                                            <p class="price_date" style="color:{$ns.companiesPriceListManager->getCompanyPriceColor($priceListDate)}"> 
                                                {if $priceListDate}
                                                    {$priceListDate|date_format:"%m/%d"}
                                                    <br />
                                                    {$priceListDate|date_format:"%H:%M"}
                                                {else}
                                                    {$ns.lm->getPhrase(14)}
                                                {/if} 
                                            </p>
                                        </a>
                                    {/if}
                                    {* company previous prices*}
                                    {*assign var="companyHistoryPrices" value = $ns.companiesPriceListManager->getCompanyHistoryPricesOrderByDate($companyId,0,100)*}
                                    {if isset($ns.groupCompaniesZippedPricesByCompanyId[$companyId])}
                                        {foreach from=$ns.groupCompaniesZippedPricesByCompanyId[$companyId] item=pr}
                                            <a  href="{$SITE_PATH}/price/zipped_price_unzipped/{$pr->getId()}"> 
                                                <img  src = "{$SITE_PATH}/img/file_types_icons/zip_icon.png"  alt="zip"/> 
                                                {assign var="uploadDateTime" value = $pr->getUploadDateTime()}
                                                <p >
                                                    {if $uploadDateTime}
                                                        {$uploadDateTime|date_format:"%m/%d"}
                                                        <br />
                                                        {$uploadDateTime|date_format:"%H:%M"}
                                                    {/if}
                                                </p>
                                            </a>
                                        {/foreach}
                                    {/if}
                                </div>
                            </div>
                        {/if}
                    </div>
                    {if $company->getShowPrice()==1}
                        <div class="company-address f_company_col company_col">

                            <p class="address">
                                {if (isset($ns.companyBranchesDtosMappedByCompanyId[$company->getId()]))}
                                    {foreach from=$ns.companyBranchesDtosMappedByCompanyId[$company->getId()] item=branchDto}
                                        {assign var="region_phrase_id" value=$ns.lm->getPhraseIdByPhraseEn($branchDto->getRegion())}
                                    <p> {$branchDto->getStreet()}, {$branchDto->getZip()}, {$ns.lm->getPhrase($region_phrase_id)}
                                    </p>
                                {/foreach}
                            {/if}
                            </p>

                            <p class="offers">
                                {if $passive != 1}
                                    {assign var="company_offers" value=$company->getOffers()}
                                    {if !empty($company_offers)}
                                    <marquee scrollamount="2" behavior="scroll" direction="left">
                                        {assign var="offers" value="^"|explode:$company_offers}
                                        {foreach from=$offers item=offer}
                                            <p>{$offer}</p>
                                        {/foreach}
                                    </marquee>
                                {/if}
                            {/if}
                            </p>
                        </div>
                        <div class="company-tel f_company_col company_col">
                            <p class="tel-number">
                                {if (isset($ns.companyBranchesDtosMappedByCompanyId[$company->getId()]))}
                                    {foreach from=$ns.companyBranchesDtosMappedByCompanyId[$company->getId()] item=branchDto}                                            
                                        {assign var=phones value=","|explode:$branchDto->getPhones()}
                                        {foreach from=$phones item=phone}
                                        <p>{$phone}</p>
                                    {/foreach}
                                {/foreach}
                            {/if}
                            </p>
                        </div>
                    {/if}
                    {if ($ns.userLevel === $ns.userGroupsCompany)}
                        <div class="squaredOne" title="{$ns.lm->getPhrase(399)}"
                             class="translatable_attribute_element" attribute_phrase_id="399" attribute_name_to_translate="title">
                            {assign var="interested_companies_ids_for_sms" value=$ns.customer->getInterestedCompaniesIdsForSms()}
                            {assign var="interested_companies_ids_for_sms_array" value=','|explode:$interested_companies_ids_for_sms}

                            <input type="checkbox" id="receive_sms_from^{$companyId}" autocomplete="off" class="f_receive_sms_from_checkboxes" value="1"	style="visibility: hidden;"
                                   {if in_array($companyId,$interested_companies_ids_for_sms_array)} checked="checked"{/if} >
                            <label class="label" for="receive_sms_from^{$companyId}"></label>
                        </div>
                    {/if}
                </div>
            {/foreach}
        {/if}
    </div>
</div>