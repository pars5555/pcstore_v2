<div class="container_import">

    {if isset($ns.success_message)}
        {include file="$TEMPLATE_DIR/main/message.tpl" type="success" content="{$ns.success_message}"}
    {/if}

    {if isset($ns.selectedCompanyDto)}
        {$selectedCompanyDto->getName()} Import Price
        <form method="POST" action="{$SITE_PATH}/admin/imp/sheet">
            <div class="select_wrapper">
                <select name="price_index">
                    {foreach from=$ns.price_names item=price_name key=price_index}
                        <option value="{$price_index}">{$price_name}</option>
                    {/foreach}
                </select> 
            </div>
            <input type="hidden" name="company_id" value="{$selectedCompanyDto->getId()}"/>
            <input class="button blue" type="submit" value="next"/>
        </form>
    {else}
        <div class="table_striped admin_companies_list">
            <div class="table_header_group">
                <div class="table-row">
                    <div class="table-cell">
                        Company logo
                    </div>
                    <div class="table-cell">
                        Company name
                    </div>
                </div>
            </div>
            {foreach from=$ns.allCompaniesDtos item=companyDto}
                <a class="table-row" href="{$SITE_PATH}/admin/import/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
                    <span class="table-cell">
                        <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyDto->getId()}" alt="logo"/>
                    </span>
                    <span class="table-cell">
                        {$companyDto->getName()}
                    </span>
                </a>
            {/foreach}
        </div> 
    {/if}


</div>