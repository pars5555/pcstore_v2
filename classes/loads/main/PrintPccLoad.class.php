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
class PrintPccLoad extends BaseGuestLoad {

    public function load() {
        $user = $this->getUser();
        $pccm = PcConfiguratorManager::getInstance();
        $selectedComponents = $pccm->getSelectedComponentsDtosOrderedInArray($user);
        $itemManager = ItemManager::getInstance();
        $this->addParam("selected_components", $selectedComponents);
        list($totalUsd, $totalAmd) = $pccm->getSelectedComponentSubTotalsAndTotals($selectedComponents, $user->getLevel());
        $required_components_ids = $pccm->getRequestComponentRequiredComponents($this->getUser());
        if (count($required_components_ids) === 0) {
            $this->addParam("ready_to_order", "true");
        } else {
            $this->addParam("ready_to_order", "false");
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

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/pcc/print_pcc.tpl";
    }

}

?>