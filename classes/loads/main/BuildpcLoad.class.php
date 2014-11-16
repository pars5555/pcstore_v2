<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PcConfiguratorManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/LanguageManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class BuildpcLoad extends BaseGuestLoad {

    public function load() {
        $pccm = PcConfiguratorManager::getInstance();


        $this->addParam('pccm', $pccm);
        if (isset($this->args[0]) || isset($_REQUEST['cem'])) {
            $editedPcCartItemId = isset($_REQUEST['cem']) ? $this->secure($_REQUEST['cem']) : $this->secure($this->args[0]);
            $_REQUEST['cem'] = $editedPcCartItemId;
            $pcToBeEdit = $this->getPcToBeEdited($editedPcCartItemId);
            if (isset($pcToBeEdit)) {
                $this->setPcConfiguratorRequestParamsCorrespondingToEditedPcComponents($pcToBeEdit);
                $this->addParam("configurator_mode_edit_cart_row_id", $editedPcCartItemId);
            }
        }
        $this->addParam('pcc_components_count', count(PcConfiguratorManager::$PCC_COMPONENTS));
        $componentDisplayNames = array();
        foreach (PcConfiguratorManager::$PCC_COMPONENTS_DISPLAY_NAMES_IDS as $pid) {
            $componentDisplayNames[] = $pid;
        }
        $this->addParam("component_display_names", $componentDisplayNames);
    }

    private function setPcConfiguratorRequestParamsCorrespondingToEditedPcComponents($pcToBeEdit) {
        foreach ($pcToBeEdit as $key => $item) {
            if (strtotime($item->getItemAvailableTillDate()) + 86400 < time() || $item->getItemHidden() == 1) {
                continue;
            }

            $cat_ids = substr($item->getItemCategoriesIds(), 1, -1);
            $cat_ids = explode(',', $cat_ids);
            $ctype = PcConfiguratorManager::getPcComponentTypeByItemCategoriesIds($cat_ids);

            switch ($ctype) {
                case CategoriesConstants::CASE_CHASSIS :
                    $_REQUEST['case'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::MOTHER_BOARD :
                    $_REQUEST['mb'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::RAM_MEMORY :
                    $_REQUEST['rams'] = implode(',', array_fill(0, $item->getBundleItemCount(), $item->getBundleItemId()));
                    break;
                case CategoriesConstants::CPU_PROCESSOR :
                    $_REQUEST['cpu'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::HDD_HARD_DRIVE :
                    if (!isset($_REQUEST['hdds'])) {
                        $_REQUEST['hdds'] = '';
                    }
                    $hdds = $this->secure($_REQUEST['hdds']);
                    if (!empty($hdds)) {
                        $_REQUEST['hdds'] .= ',';
                    } else {
                        $_REQUEST['hdds'] = "";
                    }
                    $_REQUEST['hdds'] .= implode(',', array_fill(0, $item->getBundleItemCount(), $item->getBundleItemId()));
                    break;
                case CategoriesConstants::SSD_SOLID_STATE_DRIVE :
                    if (!isset($_REQUEST['ssds'])) {
                        $_REQUEST['ssds'] = '';
                    }
                    $ssds = $this->secure($_REQUEST['ssds']);
                    if (!empty($ssds)) {
                        $_REQUEST['ssds'] .= ',';
                    } else {
                        $_REQUEST['ssds'] = "";
                    }
                    $_REQUEST['ssds'] .= implode(',', array_fill(0, $item->getBundleItemCount(), $item->getBundleItemId()));
                    break;
                case CategoriesConstants::COOLER :
                    $_REQUEST['cooler'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::MONITOR :
                    $_REQUEST['monitor'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::OPTICAL_DRIVE :
                    if (!isset($_REQUEST['opts'])) {
                        $_REQUEST['opts'] = '';
                    }
                    $opts = $this->secure($_REQUEST['opts']);
                    if (!empty($opts)) {
                        $_REQUEST['opts'] .= ',';
                    } else {
                        $_REQUEST['opts'] = "";
                    }
                    $_REQUEST['opts'] .= implode(',', array_fill(0, $item->getBundleItemCount(), $item->getBundleItemId()));
                    break;
                case CategoriesConstants::POWER :
                    $_REQUEST['power'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::VIDEO_CARD :
                    $_REQUEST['graphics'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::KEYBOARD :
                    $_REQUEST['keyboard'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::MOUSE :
                    $_REQUEST['mouse'] = $item->getBundleItemId();
                    break;
                case CategoriesConstants::SPEAKER :
                    $_REQUEST['speaker'] = $item->getBundleItemId();
                    break;
            }
        }
    }

    private function getPcToBeEdited($edited_pc_cart_item_id) {
        $customerCartManager = CustomerCartManager::getInstance();
        $userLevel = $this->getUserLevel();
        $user_id = $this->getUserId();
        return $customerCartManager->getCustomerCart($this->getCustomerLogin(), $user_id, $userLevel, $edited_pc_cart_item_id);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/pcc/main.tpl";
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $componentPage = 'case';
        if (isset($_REQUEST['cp'])) {
            $componentPage = $this->secure($_REQUEST['cp']);
        }
        $loadName = "pcc_select_" . $componentPage;
        $loads['pcc_select_component']["load"] = "loads/main/pcc/" . $this->generateLoadClassName($loadName);
        $loads['pcc_select_component']["args"] = array("parentLoad" => &$this);
        $loads['pcc_select_component']["loads"] = array();


        $loadName = "pcc_total_calculations";
        $loads[$loadName]["load"] = "loads/main/pcc/" . $this->generateLoadClassName($loadName);
        $loads[$loadName]["args"] = array("parentLoad" => &$this);
        $loads[$loadName]["loads"] = array();

        return $loads;
    }

}

?>