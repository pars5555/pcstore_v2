ngs.AdminImportStep3Load = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_import", ajaxLoader);
    },
    getUrl: function () {
        return "import_step3";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_import_step3";
    },
    afterLoad: function () {
        jQuery('.pop_up').css('position','relative');
        jQuery('.pop_up').css('left',500);
        jQuery('.pop_up').css('top',-300);
        jQuery('.pop_up').draggable({containment: "#adminImportItemCategoriesPopup"});
        var thisInstance = this;
        this.subCategoriesSelectionButtonsInit();
        this.imageSelectionButtonsInit();

        jQuery('.price_items_sub_categories_hiddens').change(function () {
            var pk_value = jQuery(this).attr('pk_value');
            var sub_categories = jQuery(this).val();
            ngs.action('import_steps_actions_group_action', {'action': "edit_cell_value", "field_name": "subCategoriesIds", "pk_value": pk_value, 'cell_value': sub_categories});
        });

        jQuery('#is2_select_all').click(function () {
            jQuery('.is2_include_row').prop('checked', true);
            jQuery('.is2_include_row').first().trigger('change');
        });
        jQuery('#is2_select_none').click(function () {
            jQuery('.is2_include_row').prop('checked', false);
            jQuery('.is2_include_row').first().trigger('change');
        });
        jQuery('.is2_include_row').change(function () {
            thisInstance.hilightSelectedRows();
            thisInstance.saveSelectedRowsIds();
        });
        jQuery('.is2_simillar_item_search_texts').keydown(function (e) {
            if (e.which === 13) {
                var pk_value = jQuery(this).attr('pk_value');
                jQuery('#is2_find_simillar_items_button_' + pk_value).trigger('click');
                e.stopPropagation();
            }
        });
        jQuery('.is2_find_simillar_items_button').click(function () {
            var pk_value = jQuery(this).attr('pk_value');
            var searchText = jQuery('#is2_simillar_item_search_text_' + pk_value).val();
            ngs.action('import_steps_actions_group_action',
                    {'action': "find_similar_items",
                        'pk_value': pk_value,
                        'search_text': searchText}
            );
        });
        jQuery('.is2_simillar_items_select').change(function () {
            var simillar_item_id = jQuery(this).val();
            var pk_value = jQuery(this).attr('pk_value');
            ngs.action('import_steps_actions_group_action',
                    {'action': "edit_cell_value",
                        'pk_value': pk_value,
                        'cell_value': simillar_item_id,
                        'field_name': 'simillarItemId'});
            ngs.action('import_steps_actions_group_action',
                    {'action': "get_item_cat_spec",
                        'pk_value': pk_value,
                        'item_id': simillar_item_id,
                        'step_number': 2
                    });
        });
        jQuery('#f_find_all_simillar_items').click(function () {
            jQuery('.is2_find_simillar_items_button').trigger('click');
        });
        jQuery('#import_price_load_container').scroll(function () {
            var stickerTop = parseInt(jQuery('#is2_header_container').offset().top);
            jQuery("#is2_header_content").css(
                    (parseInt(jQuery("#import_price_load_container").scrollTop()) + parseInt(jQuery("#is2_header_container").css('margin-top'))) > stickerTop ?
                    {position: 'fixed', top: jQuery('#import_price_load_container').offset().top + 'px'} : {position: 'relative', top: "0px"});
        });
        this.initItemsPictureUploadFunctionality();
        this.initTableEditableFunctionality();
        this.hilightSelectedRows();
        this.manageItemsSpecButtonsActions();
        this.manageItemsGroupCategorySelection();
        this.saveSelectedRowsIds();
    },
    initItemsPictureUploadFunctionality: function () {
        jQuery('.f_upload_photo_button').click(function () {
            var rowId = jQuery(this).attr('row_id');
            jQuery("#item_picture_" + rowId).trigger('click');
            return false;
        });
        jQuery(".item_picture").change(function () {
            jQuery(this).parent('form').submit();
        });
    },
    manageItemsGroupCategorySelection: function () {
        var thisInstance = this;
        this.calcSelectionCatButtonState();
        jQuery('.is2_cat_checkbox').change(function () {
            thisInstance.calcSelectionCatButtonState();
        });
        jQuery('#is2_selected_price_items_sub_categories_button').click(function () {
            ngs.MainLoad.prototype.mainLoader(false);
            ngs.load("admin_import_item_categories_popup", {
                "categories_ids": '',
                "result_hidden_element_id": 'is2_selected_price_items_sub_categories_ids'
            });
        });
        jQuery('#is2_selected_price_items_sub_categories_ids').change(function () {
            var selectedSubCategoriesIds = jQuery(this).val();
            var pksArray = jQuery('#is2_set_category_for_selection').attr('selected_items_pks').split(',');
            pksArray.each(function (value, index) {
                var pk = value;
                jQuery('#is2_price_item_sub_categories_ids_' + pk).val(selectedSubCategoriesIds);
                jQuery('#is2_price_item_sub_categories_ids_' + pk).trigger('change');
            });
        });
    },
    calcSelectionCatButtonState: function () {
        jQuery('#is2_set_category_for_selection').css({'visibility': jQuery('.is2_cat_checkbox:checked').length > 0 ? 'visible' : 'hidden'});
        var pk_values = new Array();
        var items_sub_categories_ids_array = new Array();
        jQuery('.is2_cat_checkbox:checked').each(function () {
            var pk_value = jQuery(this).attr('pk_value');
            pk_values.push(pk_value);
            var item_sub_categories_ids = jQuery('#is2_price_item_sub_categories_ids_' + pk_value).val();
            items_sub_categories_ids_array.push(item_sub_categories_ids);
        });
        if (items_sub_categories_ids_array.AllValuesSame() === true && items_sub_categories_ids_array.length > 0) {
            jQuery('#is2_selected_price_items_sub_categories_ids').val(items_sub_categories_ids_array[0]);
        } else {
            jQuery('#is2_selected_price_items_sub_categories_ids').val('');
        }
        jQuery('#is2_set_category_for_selection').attr('selected_items_pks', pk_values.join(','));
    },
    manageItemsSpecButtonsActions: function () {
        var thisInstance = this;
        jQuery('.is2_spec_button').click(function () {
            var pkValue = jQuery(this).attr('pk_value');
            var shortSpec = jQuery('#is2_item_short_spec_' + pkValue).val();
            var fullSpec = jQuery('#is2_item_full_spec_' + pkValue).val();
            jQuery('<div>short spec<br><textarea id="item_short_spec_input" style="width:100%;height:80px;border:1px solid gray" >' + shortSpec + '</textarea>' +
                    '<br>full spec<br><textarea id="item_full_spec_input" style="width:100%;min-height:300px;">' +
                    fullSpec + '</textarea></div>').dialog({
                resizable: true,
                width: 1100,
                height: 600,
                modal: true,
                buttons: {
                    "ok": {
                        text: 'ok',
                        click: function () {
                            tinymce.activeEditor.save();
                            var sSpec = jQuery('#item_short_spec_input').val();
                            ngs.action('import_steps_actions_group_action',
                                    {'action': "edit_cell_value", "field_name": "shortSpec",
                                        "pk_value": pkValue,
                                        'cell_value': sSpec});
                            jQuery('#is2_item_short_spec_' + pkValue).text(sSpec);
                            var fSpec = jQuery('#item_full_spec_input').val();
                            ngs.action('import_steps_actions_group_action',
                                    {'action': "edit_cell_value", "field_name": "fullSpec",
                                        "pk_value": pkValue,
                                        'cell_value': fSpec});
                            jQuery('#is2_item_full_spec_' + pkValue).html(fSpec);
                            jQuery(this).remove();
                        }
                    },
                    "cancel": {
                        text: 'cancel',
                        click: function () {
                            jQuery(this).remove();
                        }
                    }

                },
                close: function () {
                    jQuery(this).remove();
                },
                open: function (event, ui) {

                    thisInstance.initTinyMCE("textarea#item_full_spec_input");
                }
            });
        });
    },
    hilightSelectedRows: function ()
    {
        jQuery('.is2_include_row').each(function () {
            if (jQuery(this).prop('checked')) {
                jQuery(this).closest('.table-row').css('background-color', 'yellow');
            } else
            {
                jQuery(this).closest('.table-row').css('background-color', '');
            }
        });
    },
    initTableEditableFunctionality: function () {
        var thisInstance = this;
        jQuery('#ii_table_view .editable_cell').dblclick(function (e) {
            if (jQuery('#ii_cell_edit_input').length > 0)
            {
                e.stopPropagation();
                return;
            }
            var cell = jQuery(this);
            var cellValue = cell.html();
            //var cellOriginalValue = cell.find('span:nth-child(2)').html();
            var dtoFieldName = cell.attr('dtoFieldName');
            var pk_value = cell.attr('pk_value');
            var input = jQuery('<textarea class="text" pk_value="' + pk_value + '" dtoFieldName="' + dtoFieldName + '" id="ii_cell_edit_input"></textarea>');
            input.val(cellValue);
            input.click(function (e) {
                e.stopPropagation();
            });
            input.keydown(function (e) {
                if (e.which === 27) {
                    cell.html(cellValue);
                    e.stopPropagation();
                }
                if (e.which === 13) {
                    thisInstance.updateCellValue();
                    e.stopPropagation();
                }
            });
            cell.html(input);
            jQuery('#ii_cell_edit_input').focusout(function (e) {
                thisInstance.updateCellValue();
                e.stopPropagation();
            });
            input.focus();
            e.stopPropagation();
        });
    },
    updateCellValue: function ()
    {
        var cellInputElement = jQuery('#ii_table_view #ii_cell_edit_input');
        if (cellInputElement.length > 0) {
            var cellValue = cellInputElement.val();
            var dtoFieldName = cellInputElement.attr('dtoFieldName');
            var pk_value = cellInputElement.attr('pk_value');
            ngs.action('import_steps_actions_group_action', {'action': "edit_cell_value", 'cell_value': cellValue, "field_name": dtoFieldName, "pk_value": pk_value});
        }
    },
    saveSelectedRowsIds: function () {
        var includedRowIds = new Array();
        var notIncludedRowIds = new Array();
        jQuery('.is2_include_row').each(function () {
            if (jQuery(this).prop('checked'))
            {
                includedRowIds.push(jQuery(this).attr('pk_value'));
            } else {
                notIncludedRowIds.push(jQuery(this).attr('pk_value'));
            }
        });
        ngs.action('import_steps_actions_group_action', {'action': "set_included_rows", 
            'included_row_ids': includedRowIds.join(','), 'not_included_row_ids': notIncludedRowIds.join(',')});

    },
    imageSelectionButtonsInit: function () {
        $(function () {
            $('.fileupload').fileupload({
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo(document.body);
                    });
                }
            });
        });
    },
    subCategoriesSelectionButtonsInit: function () {
        jQuery('.is2_sub_categories_button').click(function () {
            var pk_value = jQuery(this).attr('pk_value');
            var subCatIds = jQuery('#is2_price_item_sub_categories_ids_' + pk_value).val();
            var itemCategoriesIdsArray = [];
            if (subCatIds != '')
            {
                itemCategoriesIdsArray = subCatIds.split(',');
            }
            ngs.MainLoad.prototype.mainLoader(false);
            ngs.load("admin_import_item_categories_popup", {
                "categories_ids": itemCategoriesIdsArray.join(','),
                "result_hidden_element_id": 'is2_price_item_sub_categories_ids_' + pk_value
            });
        });
    },
    onLoadDestroy: function ()
    {

    }
});

