<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/util/pcc_categories_constants/CategoriesConstants.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PcConfiguratorManager.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PccMessagesManager.class.php");
require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
abstract class PccSelectComponentLoad extends BaseGuestLoad {

    public function load() {
        $pccm = PcConfiguratorManager::getInstance();
        $pccm->manageComponentLoadRequestBeforeLoad();
        $allSelectedComponentsIdsArray = $pccm->getSelectedItemsIdsFromRequest();
        $this->addParam("allSelectedComponentsIdsArray", $allSelectedComponentsIdsArray);
        $itemManager = ItemManager::getInstance();
        $userLevel = $this->getUserLevel();
        $requiredCategoriesFormulasArray = $this->getRequiredCategoriesFormulasArray();
        $neededCategoriesIdsAndOrFormulaArray = $this->getNeededCategoriesIdsAndOrFormulaArray();
        $selected_component_item_id = $this->getSelectedComponentItemId();

        $this->addPccDiscountParam();
        $itemsDtos = $itemManager->getPccItemsByCategoryFormula($this->getUserId(), $userLevel, $requiredCategoriesFormulasArray, $neededCategoriesIdsAndOrFormulaArray, 0, 1000, $selected_component_item_id, '');
        $this->addParam("itemsDtos", $itemsDtos);
        $this->addParam("itemManager", $itemManager);
        $this->addParam('componentLoad', $this);
        $ci = $this->getComponentTypeIndex();
        $this->addParam('componentName', $pccm->getComponentKeywordByIndex($ci));
        $this->addParam('componentIndex', $ci);
        $this->addParam('pcmm', PccMessagesManager::getInstance());
        $this->addParam('tab_header_info_text', $this->getTabHeaderInfoText());
    }

    private function addPccDiscountParam() {
        $vipCustomer = 0;
        if ($this->getUserLevel() === UserGroups::$USER) {
            $customer = $this->getCustomer();
            $userManager = UserManager::getInstance();
            $vipCustomer = $userManager->isVip($customer);
        }
        if ($vipCustomer) {
            $pc_configurator_discount = floatval($this->getCmsVar('vip_pc_configurator_discount'));
        } else {
            $pc_configurator_discount = floatval($this->getCmsVar('pc_configurator_discount'));
        }
        $this->addParam("pc_configurator_discount", $pc_configurator_discount);
    }

    public abstract function getRequiredCategoriesFormulasArray();

    public abstract function getNeededCategoriesIdsAndOrFormulaArray();

    public abstract function getSelectedSameItemsCount();

    public abstract function getComponentTypeIndex();

    public abstract function getTabHeaderInfoText();

    public abstract function getSelectedComponentItemId();

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/pcc/pcc_select_component.tpl";
    }

}

?>