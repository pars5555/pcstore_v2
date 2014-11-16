<?php

/**
 * CustomerNotificationDto class is extended class from AbstractDto.
 *
 * @author	Vahagn Sookiasian
 */
class CustomerNotificationDto {

    public $id;
    public $datetime;
    public $title;
    public $url;
    public $iconUrl;
    public $formatedDateTime;
    private $lm;

    function __construct($datetime, $title, $url, $iconUrl = "") {
        $this->lm = LanguageManager::getInstance();
        $this->setDatetime($datetime);
        $this->title = $title;
        $this->url = $url;
        $this->iconUrl = $iconUrl;
        $this->id = uniqid('notif_', true);
    }

    function getDatetime() {
        return $this->datetime;
    }

    function getTitle() {
        return $this->title;
    }

    function setDatetime($datetime) {
        $this->datetime = $datetime;

        $to_time = time();
        $from_time = strtotime($datetime);
        $minutes = round(($to_time - $from_time) / 60);
        if ($minutes < 60) {
            $this->formatedDateTime = $minutes . $this->lm->getPhrase(653) . ' ' . $this->lm->getPhrase(651);
            return;
        }
        if ($minutes < 1440) {
            $hours = floor($minutes / 60);
            $this->formatedDateTime = $hours . $this->lm->getPhrase(652) . ' ' . ($minutes - $hours * 60) . $this->lm->getPhrase(653) . ' ' . $this->lm->getPhrase(651);
            return;
        }
        $this->formatedDateTime = $datetime;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function getIconUrl() {
        return $this->iconUrl;
    }

    function setIconUrl($iconUrl) {
        $this->iconUrl = $iconUrl;
    }

    function getId() {
        return $this->id;
    }

}

?>
