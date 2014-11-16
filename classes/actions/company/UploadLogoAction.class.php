<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/util/ImageThumber.php");

/**
 * @author Vahagn Sookiasian
 */
class UploadLogoAction extends BaseCompanyAction {

    private $supported_file_formats = array('jpg', 'png', 'gif');

    public function service() {
        if ($this->getUserLevel() === UserGroups::$ADMIN) {
            $companyId = intval($_REQUEST['company_id']);
        } else {
            $companyId = $this->getUserId();
        }

        $originalLogoFullName = null;

        $file_name = $_FILES['logo_picture']['name'];
        $file_type = $_FILES['logo_picture']['type'];
        $tmp_name = $_FILES['logo_picture']['tmp_name'];
        $file_size = $_FILES['logo_picture']['size'];

        $logoCheck = $this->checkInputFile('logo_picture');

        //start to save new price file

        $fileNameParts = explode('.', $file_name);
        $logoExt = strtolower(end($fileNameParts));
        if ($logoCheck === 'ok' && (!in_array($logoExt, $this->supported_file_formats))) {
            $jsonArr = array('status' => "err", 'message' => "Not supported file format!");
            echo "<script>var l= new parent.ngs.CompanyUploadLogoAction(); l.afterAction('" . json_encode($jsonArr) . "'); </script>";
            return false;
        }
        if ($logoCheck === 'ok') {
            $dir = IMG_TMP_DIR;
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }

            $logoName = 'company_' . $companyId . '_logo';
            $originalLogoFullName = $dir . '/' . $logoName . '_original' . '.' . 'png';
            $resizedLogoFullName_55_30 = $dir . '/' . $logoName . '_55_30' . '.' . 'png';
            $resizedLogoFullName_120_75 = $dir . '/' . $logoName . '_120_75' . '.' . 'png';
            move_uploaded_file($tmp_name, $originalLogoFullName);
            $resret1 = resizeImageToGivenType($originalLogoFullName, $resizedLogoFullName_55_30, 55, 30, 'png');
            $resret2 = resizeImageToGivenType($originalLogoFullName, $resizedLogoFullName_120_75, 120, 75, 'png');
            //resize image
            if ($logoCheck === 'ok' && $resret1 == false) {
                $jsonArr = array('status' => "err", 'message' => "Error resizing image!");
                echo "<script>var l= new parent.ngs.CompanyUploadLogoAction(); l.afterAction('" . json_encode($jsonArr) . "'); </script>";
                return false;
            }
            if (is_file($originalLogoFullName)) {
                unlink($originalLogoFullName);
            }
            $jsonArr = array('status' => "ok", "company_id" => $companyId);
            echo "<script>var l= new parent.ngs.CompanyUploadLogoAction(); l.afterAction('" . json_encode($jsonArr) . "'); </script>";
            return true;
        }
    }

}

?>