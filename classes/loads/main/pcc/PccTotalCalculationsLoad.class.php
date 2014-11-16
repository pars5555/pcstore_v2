<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/SpecialFeesManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PcConfiguratorManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccTotalCalculationsLoad extends BaseGuestLoad {

    public function load() {

        $user = $this->getUser();
        $pccm = PcConfiguratorManager::getInstance();
        $pccm->manageComponentLoadRequestBeforeLoad();
        $selectedComponents = $pccm->getSelectedComponentsDtosOrderedInArray($user);
        $selectedItemsIdsFromRequest = $pccm->getSelectedItemsIdsFromRequest();
        $requestioItems = "";
        foreach ($selectedItemsIdsFromRequest as $components) {
            if (empty($components)) {
                continue;
            }
            $requestioItems .= (is_array($components) ? implode(',', $components) : $components) . ',';
        }
        $requestioItems = trim($requestioItems, ',');
        $this->addParam('selected_components_comma_separated', $requestioItems);
        $itemManager = ItemManager::getInstance();
        $this->addParam("selected_components", $selectedComponents);

        list($totalUsd, $totalAmd) = $pccm->getSelectedComponentSubTotalsAndTotals($selectedComponents, $user->getLevel());
        $required_components_ids = $pccm->getRequestComponentRequiredComponents($this->sessionManager->getUser());
        if (count($required_components_ids) === 0) {
            $this->addParam("ready_to_order", "true");
        } else {
            $this->addParam("ready_to_order", "false");
        }
        if (isset($_REQUEST['cem']) && intval($_REQUEST['cem']) > 0) {
            $this->addParam("configurator_mode_edit_cart_row_id", intval($_REQUEST['cem']));
        }

        $this->addParam("pccm", $pccm);
        $this->addParam("total_usd", $totalUsd);
        $this->addParam("total_amd", $totalAmd);

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

        $selectedComponentProfitWithDiscount = $pccm->calcSelectedComponentProfitWithDiscount($selectedComponents, $user->getLevel(), $pc_configurator_discount);

        $pcBuildFeeAMD = $pccm->calcPcBuildFee($selectedComponentProfitWithDiscount);
        $this->addParam("pc_build_fee_amd", $pcBuildFeeAMD);

        $pcGrandTotalAmd = $totalAmd * (1 - $pc_configurator_discount / 100) + $pcBuildFeeAMD;
        $this->addParam("grand_total_amd", $pcGrandTotalAmd);
        $this->addParam("itemManager", $itemManager);
    }

    public function getDefaultLoads($args) {

        $loads = array();
        return $loads;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/pcc/pcc_total_calculations.tpl";
    }

}

?>