<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/BannersManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportItemsTempManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ImportStepsActionsGroupAction extends BaseAdminAction {

    public function service() {
        $action = $_REQUEST['action'];
        $importItemsTempManager = ImportItemsTempManager::getInstance();
        switch ($action) {
            case 'set_included_rows':
                $includedRowIds = $_REQUEST['included_row_ids'];
                $notIncludedRowIds = $_REQUEST['not_included_row_ids'];
                $includedRowIdsArray = [];
                if (!empty($includedRowIds)) {
                    $includedRowIdsArray = explode(',', $includedRowIds);
                }
                $notIncludedRowIdsArray = [];
                if (!empty($notIncludedRowIds)) {
                    $notIncludedRowIdsArray = explode(',', $notIncludedRowIds);
                }
                $importItemsTempManager->setIncludedRows($includedRowIdsArray, 1);
                $importItemsTempManager->setIncludedRows($notIncludedRowIdsArray, 0);
                $this->ok();
                break;

            case 'step_1_unbind_price_row':
                $price_item_id = $_REQUEST['price_item_id'];
                $importItemsTempManager->setMatchedItemId($price_item_id, 0);
                $importItemsTempManager->updateTextField($price_item_id, 'short_spec', '');
                $importItemsTempManager->updateTextField($price_item_id, 'full_spec', '');
                $this->ok();
                break;
            case 'step_1_link_stock_item_to_price_item':
                $price_item_id = $_REQUEST['price_item_id'];
                $stock_item_id = $_REQUEST['stock_item_id'];

                $importItemsTempManager->setMatchedItemId($price_item_id, $stock_item_id);
                $itemManager = ItemManager::getInstance();
                $stockItem = $itemManager->selectByPK($stock_item_id);
                $importItemsTempManager->updateTextField($price_item_id, 'short_spec', $stockItem->getShortDescription());
                $importItemsTempManager->updateTextField($price_item_id, 'full_spec', $stockItem->getFullDescription());
                $this->ok();
                break;
            case 'edit_cell_value':
                $cell_value = $_REQUEST['cell_value'];
                $field_name = $_REQUEST['field_name'];
                $pk_value = $_REQUEST['pk_value'];
                $importItemsTempManager->updateTextField($pk_value, $importItemsTempManager->getFieldKeyByFieldName($field_name), $cell_value);
                $dto = $importItemsTempManager->selectByPK($pk_value);
                $this->ok(array('cell_value' => $dto->$field_name));
                break;
            case 'import':
                list($newItemsCount, $updatedItemsCount) = $importItemsTempManager->importToItemsTable($this->getCustomerLogin(), $this->secure($_REQUEST['company_id']));
                $_SESSION['success_message'] = "New items count=" . $newItemsCount . "<br> Updated items count=" . $updatedItemsCount;
                $this->redirect('admin/import');
                break;
            case 'find_similar_items':
                $searchText = $this->secure($_REQUEST['search_text']);
                $itemManager = ItemManager::getInstance();
                $itemsDtos = $itemManager->findSimillarItems($searchText, 10);
                $dtosToJSON = AbstractDto::dtosToJSON($itemsDtos);
                $this->ok(array('items' => $dtosToJSON));
                break;
            case 'get_item_cat_spec':
                $item_id = intval($_REQUEST['item_id']);
                if ($item_id > 0) {
                    $itemManager = ItemManager::getInstance();
                    $itemDto = $itemManager->selectByPK($item_id);
                    $this->ok(array('short_description' => $itemDto->getShortDescription(), 'full_description' => $itemDto->getFullDescription()
                        , 'categories_ids' => $itemDto->getCategoriesIds()));
                } else {
                    $this->ok(array('short_description' => '', 'full_description' => '', 'categories_ids' => ''));
                }
                break;
            case 'upload_new_item_picture':
                $row_id = intval($_REQUEST['row_id']);
                $this->uploadNewIntemPicture($row_id);
                break;

            default:
                break;
        }
    }

    private function uploadNewIntemPicture($row_id) {
        $file_name = $_FILES['item_picture']['name'];
        $tmp_name = $_FILES['item_picture']['tmp_name'];
        $pictureExt = explode(".", $file_name);
        $pictureExt = strtolower(end($pictureExt));
        $supported_file_formats = explode(',', 'jpg,png,jpeg');

        if (!in_array(strtolower($pictureExt), $supported_file_formats)) {
            $jsonArr = array('status' => "error", "errText" => 'Picture format is not supported! supported formats are jpg and png only.');
            echo "<script>var l = new parent.ngs.ImportStepsActionsGroupAction(); l.afterAction('" . json_encode($jsonArr) . "'); </script>";
            return false;
        }

        $dir = HTDOCS_TMP_DIR;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $dir = HTDOCS_TMP_DIR . '/import';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $fileName = $row_id;
        $pictureName = $fileName . '.' . $pictureExt;
        $pictureFullName = $dir . '/' . $pictureName;
        move_uploaded_file($tmp_name, $pictureFullName);
        $jsonArr = array('status' => "ok", "action" => 'upload_new_item_picture', 'row_id' => $row_id, 'picture_name' => $pictureName);
        echo "<script>var l = new parent.ngs.ImportStepsActionsGroupAction(); l.afterAction('" . json_encode($jsonArr) . "'); </script>";
        return false;
    }

}

?>