<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/PriceTranslationsMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class PriceTranslationsManager extends AbstractManager {

  

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     */
    function __construct() {
        $this->mapper = PriceTranslationsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new PriceTranslationsManager();
        }
        return self::$instance;
    }

    public function getAllRussianRows() {
        return $this->selectByField('language_code', 'ru');
    }

    public function getAllArmenianRows() {
        return $this->selectByField('language_code', 'am');
    }

    public static function convertSentenceArrayToUcfirst($sentenseArray) {
        $ret = array();
        foreach ($sentenseArray as $sentence) {
            $ret[] = self::mb_ucfirst($sentence);
        }
        return $ret;
    }

    private static function mb_ucfirst($string) {
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }

    public function translateItemDisplayNameNonEnglishWordsToEnglish($itemDisplayName) {
        $armDtos = $this->getAllArmenianRows();
        $armWords = array();
        $armToEngWords = array();
        foreach ($armDtos as $dto) {
            $armWords[] = $dto->getPhrase();
            $armToEngWords[] = $dto->getPhraseEnglish();
        }
        $armToEngWords = self::convertSentenceArrayToUcfirst($armToEngWords);
        foreach ($armWords as $key => $armWord) {
            $itemDisplayName = preg_replace('/' . addcslashes($armWord, "/+{[}]-.*?$^") . '\b/iu', $armToEngWords[$key], $itemDisplayName);
        }

        $rusDtos = $this->getAllRussianRows();
        $rusWords = array();
        $rusToEngWords = array();
        foreach ($rusDtos as $dto) {
            $rusWords[] = $dto->getPhrase();
            $rusToEngWords[] = $dto->getPhraseEnglish();
        }
        $rusToEngWords = self::convertSentenceArrayToUcfirst($rusToEngWords);
        foreach ($rusWords as $key => $rusWord) {
            $itemDisplayName = preg_replace('/' . addcslashes($rusWord, "/+{[}]-.*?$^") . '\b/iu', $rusToEngWords[$key], $itemDisplayName);
        }
        return $itemDisplayName;
    }

}

?>