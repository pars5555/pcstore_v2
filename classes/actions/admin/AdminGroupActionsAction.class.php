<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");



/**
 * @author Vahagn Sookiasian
 */
class AdminGroupActionsAction extends BaseAdminAction {

    public function service() {

        $action = $_REQUEST['action'];
        $params = array();
        switch ($action) {
            case 'delete_user':
                $this->deleteUser(intval($_REQUEST['user_id']));
                break;
            case 'delete_all_unnecessary_items_pictures':
                $ret = $this->deleteAllUnnecessaryItemsPictures();
                $params = array('removed_items_ids' => implode(',', $ret));
                break;
            case 'set_item_spec':
                $itemId = $_REQUEST['item_id'];
                $shortSpec = $_REQUEST['short_spec'];
                $fullSpec = $_REQUEST['full_spec'];
                require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
                $itemManager = ItemManager::getInstance();
                $itemManager->updateTextField($itemId, 'short_description', $shortSpec);
                $itemManager->updateTextField($itemId, 'full_description', $fullSpec);
                break;
            case 'get_item_spec':
                $itemId = $_REQUEST['item_id'];
                require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
                $itemManager = ItemManager::getInstance();
                $itemDto = $itemManager->selectByPK($itemId);
                $params['short_spec'] = $itemDto->getShortDescription();
                $params['full_spec'] = $itemDto->getFullDescription();
                break;
            case 'get_camera_1_snap':
                $url = $this->getCmsVar('pcstore_camera_1_url');
                $login = $this->getCmsVar('pcstore_camera_1_login');
                $pass = $this->getCmsVar('pcstore_camera_1_pass');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $pass);
                $img = curl_exec($ch);
                header("Content-Type: image/jpeg");
                echo $img;
                exit;
            case 'filter_emails':
                require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");
                require_once (CLASSES_PATH . "/managers/UninterestingEmailsManager.class.php");
                $emails = $_REQUEST['emails'];
                $emailsArray = EmailSenderManager::getEmailsFromText($emails);
                $uninterestingEmailsManager = UninterestingEmailsManager::getInstance();
                $filteredEmailsArray = $uninterestingEmailsManager->removeUninterestingEmailsFromList($emailsArray);
                $params['count'] = count($filteredEmailsArray);
                $params['emails'] = implode(';', $filteredEmailsArray);
                break;

            case 'is_price_values_ready':
                $companyId = intval($_REQUEST['company_id']);
                require_once (CLASSES_PATH . "/managers/PriceTextsManager.class.php");
                $priceTextsManager = PriceTextsManager::getInstance();
                $companyPriceValuesReady = $priceTextsManager->isCompanyPriceValuesReady($companyId);
                $params['ready'] = $companyPriceValuesReady ? '1' : '0';
                break;
            case 'delete_price_values_column':
                $companyId = intval($_REQUEST['company_id']);
                $sheetIndex = intval($_REQUEST['sheet_index']);
                $priceIndex = intval($_REQUEST['price_index']);
                $columnLetter = $this->secure($_REQUEST['column_letter']);
                require_once (CLASSES_PATH . "/managers/PriceValuesManager.class.php");
                $priceValuesManager = PriceValuesManager::getInstance();
                $priceValuesManager->moveColumnValuesToLastColumn($companyId, $priceIndex, $sheetIndex, $columnLetter);
                break;
            case 'delete_customer_amessage_after_login':
                $pk = intval($_REQUEST['id']);
                require_once (CLASSES_PATH . "/managers/CustomerMessagesAfterLoginManager.class.php");
                $customerMessagesAfterLoginManager = CustomerMessagesAfterLoginManager::getInstance();
                $customerMessagesAfterLoginManager->deleteByPK($pk);
                break;
            case 'preview_customer_message':
                $pk = intval($_REQUEST['id']);
                require_once (CLASSES_PATH . "/managers/CustomerMessagesAfterLoginManager.class.php");
                $customerMessagesAfterLoginManager = CustomerMessagesAfterLoginManager::getInstance();
                $dto = $customerMessagesAfterLoginManager->selectByPK($pk);
                $params = AbstractDto::dtoToArray($dto);
                break;
            case 'delete_old_hidden_items':
                $monthsNumber = intval($_REQUEST['months_number']);
                require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
                $itemManager = ItemManager::getInstance();
                $params['count'] = $itemManager->deleteOldHiddenItemsByMonthsNumber($monthsNumber);
                break;
            case 'update_companies_price_text':
                $company_id = intval($_REQUEST['company_id']);
                require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
                $companyManager = CompanyManager::getInstance();
                if ($company_id == 0) {
                    $allCompanies = $companyManager->getAllCompanies(true, true);
                } else {
                    $allCompanies [] = $companyManager->selectByPK($company_id);
                }
                $cidsArray = array();
                foreach ($allCompanies as $c) {
                    $cidsArray[] = $c->getId();
                }
                $this->updateCompanyPriceText(implode(',', $cidsArray));
                break;
            case 'deploy_latest_pcstore_changes':

                break;
            case 'update_all_amd_items_price':
                require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
                $itemManager = ItemManager::getInstance();
                $itemManager->UpdateAllAmdItemsPrices();
                break;
        }

        $this->ok($params);
    }

    private function updateCompanyPriceText($companyIdsString) {
        if ($this->getCmsVar('dev_mode') == 'on') {
            exec('d:\xampp\php\php.exe ' . CLASSES_PATH . "/util/UpdateCompaniesPriceText.class.php $companyIdsString 0");
        } else {
            exec('/usr/bin/php ' . CLASSES_PATH . "/util/UpdateCompaniesPriceText.class.php $companyIdsString 0 > /dev/null &");
        }
    }

    private function deleteUser($id) {
        require_once (CLASSES_PATH . "/managers/UserManager.class.php");
        $userManager = UserManager::getInstance();
        $userManager->deleteUserAndDependencies($id);
    }

    public function deleteAllUnnecessaryItemsPictures() {
        ini_set('max_execution_time', '300');
        require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
        $itemManager = ItemManager::getInstance();
        $itemsImagesDir = DATA_IMAGE_DIR . "/items/";
        $handle = opendir($itemsImagesDir);
        if (!$handle) {
            return false;
        }
        $removeItemsIdsArray = array();
        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == "..") {
                continue;
            }
            $itemImageName = $entry;
            $itemId = intval($itemImageName);
            $itemDto = $itemManager->selectByPK($itemId);
            if (!isset($itemDto)) {
                $removeItemsIdsArray [] = $itemId;
                unlink($itemsImagesDir . '/' . $itemImageName);
            }
        }
        closedir($handle);
        return array_unique($removeItemsIdsArray);
    }

}

?>