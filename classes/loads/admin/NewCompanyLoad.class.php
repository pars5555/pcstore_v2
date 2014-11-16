<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class NewCompanyLoad extends BaseAdminLoad {

    public function load() {
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/new_company.tpl";
    }

}

?>