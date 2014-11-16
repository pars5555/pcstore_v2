<?php

require_once (CLASSES_PATH . "/loads/main/pcc/PccSelectComponentLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PccSelectGraphicsLoad extends PccSelectComponentLoad {

    public function getRequiredCategoriesFormulasArray() {
        return array('(', CategoriesConstants::VIDEO_INTERFACE_AGP, 'or', CategoriesConstants::VIDEO_INTERFACE_PCI_EXPRESS, ')');
    }

    public function getComponentTypeIndex() {
        return PcConfiguratorManager::$PCC_COMPONENTS['graphics'];
    }

    public function getNeededCategoriesIdsAndOrFormulaArray() {
        $pccm = PcConfiguratorManager::getInstance();
        if (isset($_REQUEST['mb'])) {
            $mb = $this->secure($_REQUEST['mb']);
            $motherboard_graphics_slot = $pccm->getMbGraphicsInterface($mb);
        }
        $neededCategoriesIdsAndOrFormulaArray = array();
        if (isset($motherboard_graphics_slot)) {
            //Motherboard graphics slot is AGP
            if ($motherboard_graphics_slot == CategoriesConstants::MB_GRAPHICS_AGP) {
                //then Graphics Card Interface should be AGP
                $neededCategoriesIdsAndOrFormulaArray = array(CategoriesConstants::VIDEO_INTERFACE_AGP, ":", PcConfiguratorManager::PCC_GRAPHICS_INTERFACE_COMPATIBLE_DB);
            } else if ($motherboard_graphics_slot == CategoriesConstants::MB_GRAPHICS_PCI_EXPRESS) {
                //then Graphics Card Interface should be PCI_EXPRESS
                $neededCategoriesIdsAndOrFormulaArray = array(CategoriesConstants::VIDEO_INTERFACE_PCI_EXPRESS, ":", PcConfiguratorManager::PCC_GRAPHICS_INTERFACE_COMPATIBLE_DB);
            }
        }
        return $neededCategoriesIdsAndOrFormulaArray;
    }

    public function getTabHeaderInfoText() {
        return $this->getPhraseSpan(239);
    }

    public function getSelectedItemCount($item) {
        if (isset($_REQUEST['graphics'])) {
            $graphics = $this->secure($_REQUEST['graphics']);
            $graphics = ',' . $graphics . ',';
            return substr_count($graphics, $item->getId());
        } else {
            return 0;
        }
    }

    public function getSelectedComponentItemId() {
        $graphics = null;
        if (isset($_REQUEST['graphics'])) {
            $graphics = $this->secure($_REQUEST['graphics']);
            $this->addParam('selected_components_ids_str', $graphics);
            $graphics = explode(',', $graphics);
            $this->addParam('selected_components_ids_array', $graphics);
        }
        $this->addParam('multi_count_selection_item', true);
        return $graphics;
    }

    public function getComponentMaxPossibleCount($item) {
        $mb = null;
        if (isset($_REQUEST['mb'])) {
            $mb = $this->secure($_REQUEST['mb']);
        }
        $pccm = PcConfiguratorManager::getInstance();
        $interface = $pccm->getGraphicsInterface($item);
        $selected_graphics_count = (int) $this->getSelectedItemCount($item);
        if ($interface == CategoriesConstants::VIDEO_INTERFACE_PCI_EXPRESS) {
            $mb_free_pci_express_graphics_count = (int) $pccm->getMbPciExpressFreePortCount($mb);
            return $selected_graphics_count + $mb_free_pci_express_graphics_count;
        } else if ($interface == CategoriesConstants::VIDEO_INTERFACE_AGP) {
            $mb_free_agp_graphics_count = (int) $pccm->getMbAgpFreePortCount($mb);
            return $selected_graphics_count + $mb_free_agp_graphics_count;
        }
    }

    public function getSelectedSameItemsCount() {
        if (isset($_REQUEST['graphics'])) {
            $graphics = $this->secure($_REQUEST['graphics']);
            $graphics = explode(',', $graphics);
            $graphics = array_unique($graphics);
            return count($graphics);
        } else {
            return 0;
        }
    }

}

?>