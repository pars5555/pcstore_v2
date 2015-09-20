<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/PriceValuesMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class PriceValuesManager extends AbstractManager {

  

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     */
    function __construct() {
        $this->mapper = PriceValuesMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new PriceValuesManager();
        }
        return self::$instance;
    }

    public function getCompanyPriceSheetValues($companyId, $priceIndex, $sheetIndex) {
        $values = array();
        $dtos = $this->mapper->getCompanyPriceSheetValues($companyId, $priceIndex, $sheetIndex);
        foreach ($dtos as $rowIndex => $dto) {
            $values[$rowIndex]['id'] = $dto->getId();
            for ($i = 0; $i < 26; $i++) {
                $columnChar = chr(65 + $i);
                $fname = 'getColumn' . $columnChar;
                $values[$rowIndex][$columnChar] = $dto->$fname();
            }
        }
        return $values;
    }
    
    public function getCompanyPriceSheetValuesByIds($ids) {
        $values = array();
        $dtos = $this->selectByPKs($ids);
        foreach ($dtos as $rowIndex => $dto) {
            $values[$rowIndex]['id'] = $dto->getId();
            for ($i = 0; $i < 26; $i++) {
                $columnChar = chr(65 + $i);
                $fname = 'getColumn' . $columnChar;
                $values[$rowIndex][$columnChar] = $dto->$fname();
            }
        }
        return $values;
    }

    public function moveColumnValuesToLastColumn($companyId, $priceIndex, $sheetIndex, $columnLetter) {
        $columnLetter = strtolower($columnLetter);
        $lettersArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $letterIndex = array_search($columnLetter, $lettersArray);
        if ($letterIndex !== false) {
            $this->mapper->setColumnValuesToNull($companyId, $priceIndex, $sheetIndex, 'column_' . $columnLetter);
            for ($i = $letterIndex; $i < count($lettersArray) - 1; $i++) {
                $this->mapper->swapColumnsValues($companyId, $priceIndex, $sheetIndex, 'column_' . $lettersArray[$i], 'column_' . $lettersArray[$i + 1]);
            }
        }
    }

    public function addPriceValues($companyId, $priceIndex, $values) {
        $this->setPriceValues($companyId, $priceIndex, $values, false);
    }

    public function setPriceValues($companyId, $priceIndex, $values, $deleteAllRows = true) {
        if ($deleteAllRows == true) {
            $this->deleteByField('company_id', $companyId);
        }
        foreach ($values as $sheetIndex => $sheetContent) {
            if (empty($sheetContent)) {
                continue;
            }
            foreach ($sheetContent as $rowValuesArray) {
                $dto = $this->mapper->createDto();
                $dto->setCompanyId($companyId);
                $dto->setPriceIndex($priceIndex);
                $dto->setSheetIndex($sheetIndex);
                foreach ($rowValuesArray as $columnName => $value) {
                    $fname = 'setColumn' . strtoupper($columnName);
                    $dto->$fname($value);
                }

                $this->mapper->insertDto($dto);
            }
        }
    }

}

?>