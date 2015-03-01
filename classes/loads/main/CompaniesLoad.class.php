<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyBranchesManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyBranchesManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompaniesPriceListManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CompaniesLoad extends BaseUserCompanyLoad {

    public function load() {

        $companyManager = CompanyManager::getInstance();
        $serviceCompanyManager = ServiceCompanyManager::getInstance();
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $companyDealersManager = CompanyDealersManager::getInstance();
        $serviceCompaniesPriceListManager = ServiceCompaniesPriceListManager::getInstance();
        $show_only_last_hours_values = array(0, 10, 24, 72, 168);
        $ph_all = $this->getPhrase(461);
        $ph_last = $this->getPhrase(456);
        $ph_hours = $this->getPhrase(455);
        $ph_days = $this->getPhrase(459);
        $ph_week = $this->getPhrase(460);
        $ph_updated = $this->getPhrase(457);
        $show_only_last_hours_names_phrase_ids_array = array(461, "`456` 10 `455` `457`", "`456` 24 `455` `457`", "`456` 3 `459` `457`", "`456` `460` `457`");
        $show_only_last_hours_names = array($ph_all, $ph_last . ' 10 ' . $ph_hours . ' ' . $ph_updated, $ph_last . ' 24 ' . $ph_hours . ' ' . $ph_updated,
            $ph_last . ' 3 ' . $ph_days . ' ' . $ph_updated, $ph_last . ' ' . $ph_week . ' ' . $ph_updated);
        $show_only_last_hours_selected = 0;
        if (isset($_REQUEST['show_only_last_hours_selected'])) {
            $show_only_last_hours_selected = intval($_REQUEST['show_only_last_hours_selected']);
        }
        $this->addParam("show_only_last_hours_values", $show_only_last_hours_values);
        $this->addParam("show_only_last_hours_names", $show_only_last_hours_names);
        $this->addParam("show_only_last_hours_names_phrase_ids_array", $show_only_last_hours_names_phrase_ids_array);
        $this->addParam("show_only_last_hours_selected", $show_only_last_hours_selected);

        $searchText = "";
        if (isset($_REQUEST['search_text'])) {
            $searchText = $this->secure($_REQUEST['search_text']);
        }
        $this->addParam("search_text", $searchText);

        $userLevel = $this->getUserLevel();
        $userId = $this->getUserId();
        $companiesList = array();
        $allServiceCompaniesWithBranches = $serviceCompanyManager->getAllServiceCompaniesWithBranches();
        foreach ($allServiceCompaniesWithBranches as $serviceCompanyDto) {
            $serviceCompanyDto->setShowPrice(1);
        }
        if ($userLevel == UserGroups::$USER) {
            $serviceCompanyDealersManager = ServiceCompanyDealersManager::getInstance();
            $userserviceCompaniesIdsArray = $serviceCompanyDealersManager->getUserCompaniesIdsArray($userId);
            foreach ($allServiceCompaniesWithBranches as $serviceCompanyDto) {
                if (in_array($serviceCompanyDto->getId(), $userserviceCompaniesIdsArray)) {
                    $serviceCompanyDto->setShowPrice(1);
                } else {
                    $serviceCompanyDto->setShowPrice(0);
                }
            }
        }
        if ($userLevel == UserGroups::$ADMIN) {
            $companiesList = $companyManager->getAllCompaniesByPriceHours($show_only_last_hours_selected, $searchText, true, true);
        } else {
            $companiesList = $companyManager->getAllCompaniesByPriceHours($show_only_last_hours_selected, $searchText);
        }
        foreach ($companiesList as $c) {
            $c->setShowPrice(1);
        }

        if ($this->getUserLevel() === UserGroups::$USER) {
            $userCompaniesIdsArray = $companyDealersManager->getUserCompaniesIdsArray($userId);
            foreach ($companiesList as $c) {
                if (in_array($c->getId(), $userCompaniesIdsArray)) {
                    $c->setShowPrice(1);
                } else {
                    $c->setShowPrice(0);
                }
            }
        }


        $this->addParam('allCompanies', $companiesList);
        $this->addParam('allServiceCompanies', $allServiceCompaniesWithBranches);


        //for google map pins
        $this->addParam('allCompaniesDtosToArray', json_encode(AbstractDto::dtosToArray($companiesList, array("id" => "id", "name" => "name", "rating" => "rating"))));
        $this->addParam('allServiceCompaniesDtosToArray', json_encode(AbstractDto::dtosToArray($allServiceCompaniesWithBranches, array("id" => "id", "name" => "name"))));
        $companyBranchesManager = CompanyBranchesManager::getInstance();
        $serviceCompanyBranchesManager = ServiceCompanyBranchesManager::getInstance();
        $cids = $this->getCompanyIdsArray($companiesList);
        $scids = $this->getCompanyIdsArray($allServiceCompaniesWithBranches);
        $companiesBranchesDtos = $companyBranchesManager->getCompaniesBranches($cids);
        $serviceCompaniesBranchesDtos = $serviceCompanyBranchesManager->getServiceCompaniesBranches($scids);

        $groupCompanyBranchesByCompanyId = $this->groupCompanyBranchesByCompanyId($companiesBranchesDtos);
        $groupServiceCompanyBranchesByServiceCompanyId = $this->groupServiceCompanyBranchesByServiceCompanyId($serviceCompaniesBranchesDtos);
        $this->addParam('companyBranchesDtosMappedByCompanyId', $groupCompanyBranchesByCompanyId);
        $this->addParam('serviceCompanyBranchesDtosMappedByServiceCompanyId', $groupServiceCompanyBranchesByServiceCompanyId);

        $this->addParam('allCompaniesBranchesDtosToArray', json_encode(AbstractDto::dtosToArray($companiesBranchesDtos)));
        $this->addParam('allServiceCompaniesBranchesDtosToArray', json_encode(AbstractDto::dtosToArray($serviceCompaniesBranchesDtos)));

        $this->addParam("companiesPriceListManager", $companiesPriceListManager);
        $this->addParam("serviceCompaniesPriceListManager", $serviceCompaniesPriceListManager);
        $companiesZippedPricesByDaysNumber = $companiesPriceListManager->getCompaniesZippedPricesByDaysNumber($cids, 365);
        $serviceCompaniesZippedPricesByDaysNumber = $serviceCompaniesPriceListManager->getCompaniesZippedPricesByDaysNumber($cids, 365);
        $groupCompaniesZippedPricesByCompanyId = $this->groupCompaniesZippedPricesByCompanyId($companiesZippedPricesByDaysNumber);
        $groupServiceCompaniesZippedPricesByCompanyId = $this->groupServiceCompaniesZippedPricesByCompanyId($serviceCompaniesZippedPricesByDaysNumber);
        $this->addParam("groupCompaniesZippedPricesByCompanyId", $groupCompaniesZippedPricesByCompanyId);
        $this->addParam("groupServiceCompaniesZippedPricesByCompanyId", $groupServiceCompaniesZippedPricesByCompanyId);
    }

    public function getCompanyIdsArray($companiesList) {
        if (empty($companiesList)) {
            return array();
        }
        $ret = array();
        foreach ($companiesList as $dto) {
            $ret [] = $dto->getId();
        }
        return $ret;
    }

    public function groupCompaniesZippedPricesByCompanyId($companiesZippedPricesByDaysNumber) {
        $ret = array();
        foreach ($companiesZippedPricesByDaysNumber as $dto) {
            if (!isset($ret[$dto->getCompanyId()]) || count($ret[$dto->getCompanyId()]) <= 20) {
                $ret[$dto->getCompanyId()][] = $dto;
            }
        }
        return $ret;
    }

    public function groupServiceCompaniesZippedPricesByCompanyId($companiesZippedPricesByDaysNumber) {
        $ret = array();
        foreach ($companiesZippedPricesByDaysNumber as $dto) {
            if (!isset($ret[$dto->getServiceCompanyId()]) || count($ret[$dto->getServiceCompanyId()]) <= intval($this->getCmsVar('company_list_zip_price_first_load_limit'))) {
                $ret[$dto->getServiceCompanyId()][] = $dto;
            }
        }
        return $ret;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/companies.tpl";
    }

    private function groupCompanyBranchesByCompanyId($companiesBranchesDtos) {
        $ret = array();
        foreach ($companiesBranchesDtos as $companiesBrancheDto) {
            $companyId = $companiesBrancheDto->getCompanyId();
            $ret [$companyId][] = $companiesBrancheDto;
        }
        return $ret;
    }

    private function groupServiceCompanyBranchesByServiceCompanyId($serviceCompaniesBranchesDtos) {
        $ret = array();
        foreach ($serviceCompaniesBranchesDtos as $companiesBrancheDto) {
            $companyId = $companiesBrancheDto->getServiceCompanyId();
            $ret [$companyId][] = $companiesBrancheDto;
        }
        return $ret;
    }

}

?>