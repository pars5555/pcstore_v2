<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/NewslettersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class DeleteNewsletterAction extends BaseAdminAction {

    public function service() {
        $newslettersManager = NewslettersManager::getInstance();
        $newsletter_id = $this->secure($_REQUEST['newsletter_id']);
        $newsletter = $newslettersManager->selectByPK($newsletter_id);
        if (isset($newsletter)) {
            $newslettersManager->deleteByPK($newsletter_id);
            $this->ok();
        } else {
            $this->error(array('message' => "Newsletter doesn't exists!"));
        }
    }

}

?>