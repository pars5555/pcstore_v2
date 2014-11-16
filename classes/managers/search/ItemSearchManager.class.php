<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");

/**
 * PcConfiguratorManager class is responsible for creating,
 */
class ItemSearchManager extends AbstractManager {

    /**
     * @var singleton instnce of class
     */
    private static $instance = null;

    function __construct() {
        
    }

    /**
     * Returns an singleton instance of this class
     *
     * @param object $config
     * @param object $args
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new ItemSearchManager();
        }
        return self::$instance;
    }

    public function getUrlParams($changedParams) {
        $params = array();
        if (isset($_REQUEST["pn"])) {
            $params['pn'] = intval($_REQUEST["pn"]);
        }
        if (isset($_REQUEST["sci"]) && intval($_REQUEST["sci"]) > 0) {
            $params['sci'] = intval($_REQUEST["sci"]);
        }
        if (isset($_REQUEST["cid"])) {
            $params['cid'] = $this->secure($_REQUEST["cid"]);
        }
        if (!empty($_REQUEST["scpids"])) {
            $params['scpids'] = $this->secure($_REQUEST["scpids"]);
        }
        /*
          if (!empty($_REQUEST["mip"])) {
          $params['mip'] = intval($_REQUEST["mip"]);
          }
          if (!empty($_REQUEST["map"])) {
          $params['map'] = intval($_REQUEST["map"]);
          } */
        if (isset($_REQUEST["s"])) {
            $params['s'] = $this->secure($_REQUEST["s"]);
        }
        if (!empty($_REQUEST["st"])) {
            $params['st'] = $this->secure($_REQUEST["st"]);
        }
        if (isset($_REQUEST["shv"])) {
            $params['shv'] = $this->secure($_REQUEST["shv"]);
        }

        if (!empty($changedParams)) {
            foreach ($changedParams as $key => $value) {
                if (empty($value)) {
                    unset($params[$key]);
                } else {
                    $params[$key] = $value;
                }
            }
        }
        return http_build_query($params);
    }

    /*
      public function getUrlParams($paramName = null, $paramValue = null, $paramsToRest = null) {
      //var_dump('sss');
      if (isset($_REQUEST["spg"])) {
      $spg = intval($_REQUEST["spg"]);
      }
      if (isset($_REQUEST["sci"]) && intval($_REQUEST["sci"]) > 0) {
      $sci = intval($_REQUEST["sci"]);
      }
      $tmp1 = $this->secure($_REQUEST["cid"]);
      if (!empty($tmp1)) {
      $cid = $tmp1;
      }
      $tmp2 = $this->secure($_REQUEST["scpids"]);
      if (!empty($tmp2)) {
      $scpids = $tmp2;
      }
      if (isset($_REQUEST["prmin"]) && intval($_REQUEST["prmin"]) > 0) {
      $prmin = intval($_REQUEST["prmin"]);
      }
      if (isset($_REQUEST["prmax"]) && intval($_REQUEST["prmax"]) > 0) {
      $prmax = intval($_REQUEST["prmax"]);
      }
      $tmp3 = $this->secure($_REQUEST["srt"]);
      if (!empty($tmp3)) {
      $srt = $tmp3;
      }
      $tmp4 = $this->secure($_REQUEST["st"]);
      if (!empty($tmp4)) {
      $st = $tmp4;
      }
      $tmp5 = $this->secure($_REQUEST["shov"]);
      if (!empty($tmp5)) {
      $shov = $tmp5;
      }
      if (isset($paramsToRest) && is_array($paramsToRest)) {
      foreach ($paramsToRest as $paramNameToUnset) {
      unset($$paramNameToUnset);
      }
      }
      if (isset($paramName)) {
      $$paramName = $paramValue;
      }

      return http_build_query(array("spg" => $spg, "sci" => $sci, "cid" => $cid, "scpids" => $scpids
      , "prmin" => $prmin, "prmax" => $prmax, "srt" => $srt, "st" => $st, "shov" => $shov));
      }
     */
}

?>