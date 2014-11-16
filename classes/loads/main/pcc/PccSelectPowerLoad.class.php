<?php

require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccSelectPowerLoad extends PccSelectComponentLoad {

    public function getRequiredCategoriesFormulasArray() {
        return array(CategoriesConstants::POWER);
    }

    public function getSelectedSameItemsCount() {
        if (isset($_REQUEST['power'])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getComponentTypeIndex() {
        return PcConfiguratorManager::$PCC_COMPONENTS['power'];
    }

    public function getNeededCategoriesIdsAndOrFormulaArray() {
        return null;
    }

    public function getSelectedComponentItemId() {
        $power = 0;
        if (isset($_REQUEST['power'])) {
            $power = $this->secure($_REQUEST['power']);
            $this->addParam('selected_component_id', $power);
        }
        return $power;
    }

    public function getTabHeaderInfoText() {
        return $this->getPhraseSpan(240);
    }

}

?>