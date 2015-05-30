<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/NewslettersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class SaveNewsletterLoad extends BaseAdminLoad {

    public function load() {

        $newslettersManager = NewslettersManager::getInstance();
        $allNewsletters = $newslettersManager->getAllNewslettersMap();
        $this->addParam('all_newsletters', $allNewsletters);
        $newslettersIds = array_keys($allNewsletters);
        $this->addParam('selected_newsletter_id', $newslettersIds[0]);
        $this->addParam('selected_newsletter_title', $allNewsletters[$newslettersIds[0]]);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/newsletter/save_newsletter.tpl";
    }

}

?>