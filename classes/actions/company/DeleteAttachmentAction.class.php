<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class DeleteAttachmentAction extends BaseCompanyAction {

    public function service() {

        $fileName = $this->secure($_REQUEST['file_name']);
        if ($this->getUserLevel() == UserGroups::$COMPANY) {
            $fileFullPath = HTDOCS_TMP_DIR_ATTACHMENTS . "/companies/" . $this->getUserId() . '/' . $fileName;
        } else {
            $fileFullPath = HTDOCS_TMP_DIR_ATTACHMENTS . "/service_companies/" . $this->getUserId() . '/' . $fileName;
        }
        if (file_exists($fileFullPath)) {
            unlink($fileFullPath);
            $this->ok();
        } else {
            $this->error(array('message' => 'File not found!!!'));
        }
    }

}

?>