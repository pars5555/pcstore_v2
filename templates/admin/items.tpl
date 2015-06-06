<div class="container_items">


    {foreach from=$ns.allCompaniesDtos item=companyDto}
        <a href="{$SITE_PATH}/admin/items/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
            <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyDto->getId()}" alt="logo"/>
            {$companyDto->getName()}
        </a>
    {/foreach}

    {if isset($ns.selectedCompanyDto)}
        <div>
            <a href="{$SITE_PATH}/dyn/admin/do_increase_items_availablity_days?company_id={$ns.selectedCompanyDto->getId()}">update items</a>
        </div>
        <h1>{$ns.selectedCompanyDto->getName()}</h1>

        <table>
            <thead>
                <tr>
                    <th>{$ns.lm->getPhrase(108)}</th>
                    <th>{$ns.lm->getPhrase(109)}</th>
                    <th>Spec</th>
                    <th>$</th>
                    <th>{$ns.lm->getPhrase(499)} $</th>
                    <th>Դր.</th>
                    <th>{$ns.lm->getPhrase(499)} Դր.</th>
                    <th>{$ns.lm->getPhrase(111)}</th>
                    <th>{$ns.lm->getPhrase(112)}</th>
                    <th>Sort</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$ns.itemsDtos item=item name=ci}
                    {if ($item->getHidden()==1) && !isset($first_invisible_meet)}
                        <tr><td><td>----------hidden items---------</td></td></tr>
                        {assign var='first_invisible_meet' value=1}
                    {/if}
                    <tr {if $item->getHidden()==1}style="color:gray"{/if}>

                        <td>
                            <div style="cursor: pointer;" item_id="{$item->getId()}">
                                <img src="{if $item->getImage2()!=''}data:image/jpeg;base64,{$item->getImage2()}{else}{$ns.itemManager->getItemDefaultImageByCategoriesIds($item->getCategoriesIds(), '60_60')}{/if}" />
                            </div>
                        </td>
                        <td {if $item->getHidden()==1 || $ns.itemManager->isItemAvailable($item) == 0}style="color:red"{/if}>
                            <span>{$item->getDisplayName()}</span>
                        </td>
                        <td>
                            <button>spec</button>
                        </td>
                        <td>
                            {$item->getDealerPrice()|number_format:2}

                        </td>

                        <td >
                            {$item->getVatPrice()|number_format:2}

                        </td>

                        <td>
                            {$item->getDealerPriceAmd()}

                        </td>

                        <td>
                            {$item->getVatPriceAmd()}

                        </td>
                        <td>
                            <input type="checkbox"{if $item->getHidden()== '1'}checked{/if}/> 
                        </td>

                        <td>
                            <a>{$ns.lm->getPhrase(112)}</a>
                            <br/>
                            <a>{$ns.lm->getPhrase(71)}</a>                       
                        </td>

                        <td>
                            {$item->getOrderIndexInPrice()}                          
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>

    {/if}

</div>