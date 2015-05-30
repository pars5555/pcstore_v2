<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/NewslettersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ManageNewslettersLoad extends BaseAdminLoad {

    public function load() {
        $newslettersManager = NewslettersManager::getInstance();
        $allNewsletters = $newslettersManager->getAllNewslettersMap();
        $this->addParam('all_newsletters', $allNewsletters);
        $newslettersIds = array_keys($allNewsletters);
        $this->addParam('selected_newsletter_id', $newslettersIds[0]);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/newsletter/manage_newsletters.tpl";
    }

}

?>