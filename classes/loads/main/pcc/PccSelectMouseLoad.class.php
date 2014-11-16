<?php

require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccSelectMouseLoad extends PccSelectComponentLoad {

    public function getRequiredCategoriesFormulasArray() {
        return array(CategoriesConstants::MOUSE);
    }

    public function getSelectedSameItemsCount() {
        if (isset($_REQUEST['mouse'])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getComponentTypeIndex() {
        return PcConfiguratorManager::$PCC_COMPONENTS['mouse'];
    }

    public function getNeededCategoriesIdsAndOrFormulaArray() {
        return array();
    }

    public function getSelectedComponentItemId() {
        $mouse = 0;
        if (isset($_REQUEST['mouse'])) {
            $mouse = $this->secure($_REQUEST['mouse']);
            $this->addParam('selected_component_id', $mouse);
        }
        return $mouse;
    }

    public function getTabHeaderInfoText() {
        return $this->getPhraseSpan(241);
    }

}

?>