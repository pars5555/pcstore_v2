<?php

require_once (CLASSES_PATH . "/loads/servicecompany/BaseServiceCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class BranchesLoad extends BaseServiceCompanyLoad {

    public function load() {
        $serviceCompanyManager = ServiceCompanyManager::getInstance();
        $companyAndBranchesDtos = $serviceCompanyManager->getCompanyAndBranches($this->getUserId());
        $companyBranchesNamesIdsMap = $this->getServiceCompanyBranchesNamesArrayByCompanyAndBranchesDtos($companyAndBranchesDtos);
        $this->addParam("company_branches", $companyBranchesNamesIdsMap);
        $selectedCompanyBranchDto = null;
        if (isset($this->args[0])) {
            $selectedBranchId = intval($this->secure($this->args[0]));
            if (array_key_exists($selectedBranchId, $companyBranchesNamesIdsMap)) {
                $selectedCompanyBranchDto = $this->getCompanyBrancheByBranchId($companyAndBranchesDtos, $selectedBranchId);
            } else {
                $this->addParam('branch_not_exist', 1);
                return;
            }
        }
        if (!isset($selectedCompanyBranchDto)) {
            $selectedCompanyBranchDto = $companyAndBranchesDtos[0];
        }
        if (!isset($selectedCompanyBranchDto)) {
            $this->addParam('branch_not_exist', 1);
            return;
        }

        $this->addParam("selected_company_branch_id", $selectedCompanyBranchDto->getBranchId());
        $companyPhones = trim($selectedCompanyBranchDto->getPhones());
        $companyPhonesArray = array();
        if (!empty($companyPhones)) {
            $companyPhonesArray = explode(',', $companyPhones);
        }
        $this->addParam("phones", $companyPhonesArray);
        $this->addParam("working_days", $selectedCompanyBranchDto->getWorkingDays());
        $workingHours = $selectedCompanyBranchDto->getWorkingHours();
        $workingStart = "00:00";
        $workingEnd= "00:00";
        if (!empty($workingHours)) {
            list($workingStart, $workingEnd) = explode('-', $workingHours);
        }
        $this->addParam('workingStart', $workingStart);
        $this->addParam('workingEnd', $workingEnd);


        $this->addParam("branch_address", $selectedCompanyBranchDto->getStreet());
        $this->addParam("lat", $selectedCompanyBranchDto->getLat());
        $this->addParam("lng", $selectedCompanyBranchDto->getLng());

        $regions_phrase_ids_array = explode(',', $this->getCmsVar('armenia_regions_phrase_ids'));
        $this->addParam('regions_phrase_ids_array', $regions_phrase_ids_array);
        $region = trim($selectedCompanyBranchDto->getRegion());
        $this->addParam('zip', $selectedCompanyBranchDto->getZip());
        $this->addParam('region_selected', strtolower($region));

        $minutes_block = 30;
        $start_time = '00:00:00';
        $total_day_minutes = 24 * 60;
        $cycleIndex = -1;
        $times = array();
        while (++$cycleIndex * $minutes_block < $total_day_minutes) {

            $timestamp = strtotime($start_time);
            $mins = $cycleIndex * $minutes_block;
            $time = strtotime("+$mins minutes", $timestamp);
            $times[] = date('H:i', $time);
        }
        $this->addParam('times', $times);
    }

    private function getServiceCompanyBranchesNamesArrayByCompanyAndBranchesDtos($companyAndBranchesDtos) {
        $ret = array();
        foreach ($companyAndBranchesDtos as $comAndBranchDto) {
            $street = $comAndBranchDto->getStreet();
            $ret[$comAndBranchDto->getBranchId()] = $street;
        }
        return $ret;
    }

    private function getCompanyBrancheByBranchId($companyAndBranchesDtos, $branchId) {
        foreach ($companyAndBranchesDtos as $comAndBranchDto) {
            if ($comAndBranchDto->getBranchId() == $branchId) {
                return $comAndBranchDto;
            }
        }
        return null;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/servicecompany/branches.tpl";
    }

}

?>