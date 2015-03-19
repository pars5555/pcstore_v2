<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/BannersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class AddBannerAction extends BaseAdminAction {

    public function service() {
        $bannersManager = new BannersManager();
        $path = $_REQUEST['path'];
        $file_name = $_FILES['banner_image']['name'];
        $file_type = $_FILES['banner_image']['type'];
        $tmp_name = $_FILES['banner_image']['tmp_name'];
        $file_size = $_FILES['banner_image']['size'];
        if (!($file_size > 0)) {
            $_SESSION["error_message"] = "Please select banner";
            $this->redirect("admin/banners");
        }
        $dir = BANNERS_ROOT_DIR;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $bannerId = $bannersManager->addBanner($path);
        $this->resizeImageToGivenType($tmp_name, BANNERS_ROOT_DIR . "/" . $bannerId . ".jpg");
        $this->redirect("admin/banners");
    }

    private function resizeImageToGivenType($img, $newfilename) {

        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);
            return false;
        }

        $w = $this->getCmsVar("home_banner_width");
        $h = $this->getCmsVar("home_banner_height");

        //Get Image size info
        $imgInfo = getimagesize($img);
        switch ($imgInfo[2]) {
            case IMAGETYPE_GIF :
                $type = 'gif';
                $im = imagecreatefromgif($img);
                break;
            case IMAGETYPE_JPEG :
                $type = 'jpg';
                $im = imagecreatefromjpeg($img);
                break;
            case IMAGETYPE_PNG :
                $type = 'png';
                $im = imagecreatefrompng($img);
                break;
            default :
                trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        //If image dimension is smaller, do not resize
        if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
            $nHeight = $imgInfo[1];
            $nWidth = $imgInfo[0];
        } else {
            //yeah, resize it, but keep it proportional
            if ($w / $imgInfo[0] < $h / $imgInfo[1]) {
                $nWidth = $w;
                $nHeight = $imgInfo[1] * ($w / $imgInfo[0]);
            } else {
                $nWidth = $imgInfo[0] * ($h / $imgInfo[1]);
                $nHeight = $h;
            }
        }

        $nWidth = round($nWidth);
        $nHeight = round($nHeight);

        $newImg = imagecreatetruecolor($nWidth, $nHeight);
        $backgroundColor = imagecolorallocate($newImg, 255, 255, 255);
        imagefill($newImg, 0, 0, $backgroundColor);
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
        imagejpeg($newImg, $newfilename);
        return $newfilename;
    }

}

?>