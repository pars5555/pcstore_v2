<?php

require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccSelectSpeakerLoad extends PccSelectComponentLoad {

    public function getRequiredCategoriesFormulasArray() {
        return array(CategoriesConstants::SPEAKER);
    }

    public function getSelectedSameItemsCount() {
        if (isset($_REQUEST['speaker'])) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getComponentTypeIndex() {
        return PcConfiguratorManager::$PCC_COMPONENTS['speaker'];
    }

    public function getNeededCategoriesIdsAndOrFormulaArray() {
        return null;
    }

    public function getSelectedComponentItemId() {
        $speaker = null;
        if (isset($_REQUEST['speaker'])) {
            $speaker = $this->secure($_REQUEST['speaker']);
            $this->addParam('selected_component_id', $speaker);
        }
        return $speaker;
    }

    public function getTabHeaderInfoText() {
        return $this->getPhraseSpan(243);
    }

}

?>