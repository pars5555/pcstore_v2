<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/NewslettersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SaveNewsletterAction extends BaseAdminAction {

    public function service() {
        $newslettersManager = NewslettersManager::getInstance();
        $title = $this->secure($_REQUEST['title']);
        $html = $_REQUEST['html'];
        $byTitle = $newslettersManager->getByTitle($title);
        if (isset($byTitle)) {
            $newslettersManager->saveNewsletter($byTitle->getId(), $html);
        } else {
            $newslettersManager->addNewsletter($title, $html);
        }
        $this->ok();
    }

}

?>