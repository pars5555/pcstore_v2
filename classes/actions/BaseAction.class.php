<?php

require_once (CLASSES_PATH . "/framework/AbstractAction.class.php");
require_once (CLASSES_PATH . "/exceptions/NgsException.class.php");

/**
 * @author Vahagn Sookiasian
 */
abstract class BaseAction extends AbstractAction {

    public function onNoAccess() {
        $this->redirect('');
    }

    public function checkInputFile($requestFileVariableName) {
        $error = $_FILES[$requestFileVariableName]['error'];
        //check for error
        switch ($error) {
            case UPLOAD_ERR_OK :
                return 'ok';
            case UPLOAD_ERR_INI_SIZE :
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';

            case UPLOAD_ERR_FORM_SIZE :
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';

            case UPLOAD_ERR_PARTIAL :
                return 'The uploaded file was only partially uploaded.';

            case UPLOAD_ERR_NO_FILE :
                return 'No file was uploaded.';

            case UPLOAD_ERR_NO_TMP_DIR :
                return 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';

            case UPLOAD_ERR_CANT_WRITE :
                return 'Failed to write file to disk. Introduced in PHP 5.1.0.';

            case UPLOAD_ERR_EXTENSION :
                return 'File upload stopped by extension. Introduced in PHP 5.2.0.';

            default :
                return 'Unknown error';
        }
    }

    public function error($errorParams = array()) {
        $errorParams['status'] = "err";
        echo json_encode($errorParams);
        exit;
    }

    public function ok($params = array()) {
        $params['status'] = "ok";
        echo json_encode($params);
        exit;
    }

}

?>