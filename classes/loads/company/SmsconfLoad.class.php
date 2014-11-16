<?php

require_once (CLASSES_PATH . "/loads/company/BaseCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class SmsconfLoad extends BaseCompanyLoad {

    public function load() {
        
        $companyManager = CompanyManager::getInstance();
        $userId = $this->getUserId();
        $customer = $this->getCustomer();
        $weekDays = $customer->getSmsReceiveWeekdays();
        $this->addParam("weekDays", $weekDays);

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


        $minutes_block = 30;
        $total_day_minutes = 24 * 60;
        $cycleIndex = 0;
        $values = array();
        $timesDisplayNames = array();
        while (++$cycleIndex * $minutes_block <= $total_day_minutes) {
            $timestamp = strtotime($customer->getSmsReceiveTimeStart());
            $mins = $cycleIndex * $minutes_block;
            $time = strtotime("+$mins minutes", $timestamp);
            $values[] = $mins;
            if ($time < strtotime("23:59:00")) {
                $timesDisplayNames[] = date('H:i', $time) . ' ' . $this->getPhrase(402);
            } else {
                $timesDisplayNames[] = date('H:i', $time) . ' ' . $this->getPhrase(401);
            }
        }
        $this->addParam('values', $values);
        $this->addParam('timesDisplayNames', $timesDisplayNames);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/smsconf.tpl";
    }

}

?>