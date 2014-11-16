<?php

require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccSelectMonitorLoad extends PccSelectComponentLoad {

    public function getRequiredCategoriesFormulasArray() {
        return array(CategoriesConstants::MONITOR);
    }

    public function getSelectedSameItemsCount() {
        if (isset($_REQUEST['monitor'])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getComponentTypeIndex() {
        return PcConfiguratorManager::$PCC_COMPONENTS['monitor'];
    }

    public function getNeededCategoriesIdsAndOrFormulaArray() {
        return array();
    }

    public function getSelectedComponentItemId() {
        $monitor = null;
        if (isset($_REQUEST['monitor'])) {
            $monitor = $this->secure($_REQUEST['monitor']);
            $this->addParam('selected_component_id', $monitor);
        }
        return $monitor;
    }

    public function getTabHeaderInfoText() {
        return $this->getPhraseSpan(238);
    }

}

?>