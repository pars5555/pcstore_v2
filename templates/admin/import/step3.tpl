<h3 class="main_title">
    {$ns.companyDto->getName()} Import Price (Step3)
</h3>
<a href="{$SITE_PATH}/admin/imp/step4?company_id={$ns.companyDto->getId()}" class="button blue" >Next</a>



<div id="is2_header_container" style="margin-bottom:20px;">
    <div id="is2_header_content">
        <button id="is2_select_all" class="button blue inline small">Select All</button>
        <button id="is2_select_none" class="button blue inline small">Select None</button>

        <div id="is2_set_category_for_selection" style="display:inline-block;">            
            <button class="button blue inline small" id="is2_selected_price_items_sub_categories_button">...</button>
            <input type="hidden" id="is2_selected_price_items_sub_categories_ids" value=""/>
        </div>
    </div>
</div>

{*price new items table*}
<div class="table table_striped" style="width: 100%;" id="ii_table_view">
    <div class="table_header_group">	
        <div class="table-row">
            <div class="table-cell">

            </div>
            {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle name=columnNamesForeach}
                <div class="table-cell" {if $dtoFieldName=='displayName'}style="min-width:400px"{/if}>
                    {$columnTitle}
                </div>
            {/foreach}
            <div class="table-cell">
                categories
            </div>		
            <div class="table-cell">
                spec
            </div>		
            <div class="table-cell">
                <button class=" button blue inline small" id="f_find_all_simillar_items">fine all simillar items</button>
            </div>		
            <div class="table-cell">
                Picture
            </div>		
        </div>
    </div>
    {foreach from=$ns.priceRowsDtos item=rowDto}
        <div class="table-row" ii_table_pk_value="{$rowDto->id}">
            <div class="table-cell">
                <input type="checkbox" class="is2_include_row" pk_value="{$rowDto->id}"  
                       {if isset($ns.new_items_row_ids)} 
                           {if $rowDto->import == 1}
                               checked="checked"
                           {/if}							   
                       {/if}/>
            </div>
            {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle name=columnNamesForeach}

                {if $dtoFieldName=="warrantyMonths"}
                    {assign var=originalFieldName value="originalWarranty"} 
                {else}
                    {assign var=cap value=$dtoFieldName|@ucfirst}
                    {assign var=originalFieldName value="original`$cap`"} 
                {/if}		

                <div class="table-cell" dtoFieldName="{$dtoFieldName}" dtoOriginalFieldName="{$originalFieldName}" 
                     style='max-width:200px; overflow: hidden;text-overflow: ellipsis;'>							
                    <span class="editable_cell" id="ii_table_editable_span_{$rowDto->getId()}_{$dtoFieldName}" dtoFieldName='{$dtoFieldName}' pk_value="{$rowDto->id}"
                          style="width:100%;">{$rowDto->$dtoFieldName|default:"empty"}</span><br>
                    <span style="color:#888">{$rowDto->$originalFieldName}</span>
                </div>

            {/foreach}
            <div class="table-cell" >                
                <button class="is2_sub_categories_button button blue inline small" pk_value="{$rowDto->getId()}" >...</button>
                <input type="hidden" pk_value="{$rowDto->getId()}" id="is2_price_item_sub_categories_ids_{$rowDto->getId()}" class="price_items_sub_categories_hiddens" value="{$rowDto->getSubCategoriesIds()}"/>
                <div style="margin-right:10px;float:left">
                    <input type="checkbox" class="is2_cat_checkbox" pk_value="{$rowDto->getId()}"/>
                </div>
            </div>

            <div class="table-cell">							
                <button class="is2_spec_button button blue inline small" pk_value="{$rowDto->getId()}">spec</button>
                <textarea class="text" style="display: none" pk_value="{$rowDto->getId()}" id="is2_item_short_spec_{$rowDto->getId()}">{$rowDto->getShortSpec()}</textarea>
                <textarea class="text" style="display: none" pk_value="{$rowDto->getId()}" id="is2_item_full_spec_{$rowDto->getId()}">{$rowDto->getFullSpec()}</textarea>
            </div>
            <div class="table-cell">
                <input type="text" id="is2_simillar_item_search_text_{$rowDto->getId()}" class="is2_simillar_item_search_texts text" pk_value="{$rowDto->getId()}" value="{$rowDto->getSupposedModel()}" style="margin-bottom:10px;"/>
                <button class="is2_find_simillar_items_button button blue inline small" id="is2_find_simillar_items_button_{$rowDto->getId()}" pk_value="{$rowDto->getId()}">load</button>
                <div class="is2_simillar_items_select_wrapper select_wrapper select_wrapper_min inline-block" style="margin-top:10px;">
                    <select class="is2_simillar_items_select" id="simillar_items_select_{$rowDto->getId()}" pk_value="{$rowDto->getId()}">
                    </select>                                                        
                </div>
            </div>
            <div class="table-cell">
                <a class="button blue f_upload_photo_button" row_id="{$rowDto->getId()}" type="submit">upload</a>
                <img id="is2_item_picture_{$rowDto->getId()}" src="" alt="" style="max-width: 100px;max-height: 60px"/>
                <form class="picture_form" target="is2_upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/admin/do_import_steps_actions_group" style="width:0; height:0;visibility: none;border:none;">        
                    <input type="file" class="item_picture"  id="item_picture_{$rowDto->getId()}" name="item_picture" accept="image/*" style="display:none">
                    <input type="hidden" name="action" value="upload_new_item_picture"/>
                    <input type="hidden" name="row_id" value="{$rowDto->getId()}"/>
                </form>

            </div>

        </div>

    {/foreach}

</div>

<iframe name="is2_upload_target" style="width:0;height:0;border:0px solid #fff;display: none;"></iframe>

<input type="hidden" id="is1_company_id" value="{$ns.company_id}" />
<input type="hidden" id="is1_used_columns_indexes_array" value="{$ns.used_columns_indexes_array}" />

<div  class="pop_up_container main_pop_up adminItemCategoriesPopup" id="adminImportItemCategoriesPopup" >
    <div class="overlay"></div>
    <div class="pop_up">
        <div class="close_button"></div>
        <h3 class="pop_up_title f_pop_up_title">{$ns.lm->getPhrase(105)}</h3>
        <div id="adminImportItemCategoriesPopupBody" class="pop_up_content f_pop_up_content">

        </div>
    </div>
</div>