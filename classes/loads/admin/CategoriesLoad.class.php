<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");


/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CategoriesLoad extends BaseAdminLoad {

    public function load() {
        $categoryManager = CategoryManager::getInstance();
        $rootDto = $categoryManager->getRoot();
        $this->addParam('rootDto', $rootDto);
        $this->addParam('categoryManager', $categoryManager);
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/categories.tpl";
    }

}

?>