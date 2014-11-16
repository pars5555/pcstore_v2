<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PcConfiguratorManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class GetSelectedAndRequireComponentsAction extends GuestAction {

    public function service() {
        $pccm = PcConfiguratorManager::getInstance();
        $pccm->manageComponentLoadRequestBeforeLoad();
        $retFieldsArray = array();
        $retFieldsArray['selected_components_ids'] = $pccm->getRequestComponentSelectedComponents();
        $retFieldsArray['required_components_ids'] = $pccm->getRequestComponentRequiredComponents($this->sessionManager->getUser());
        echo json_encode($retFieldsArray);
        return true;
    }

}

?>