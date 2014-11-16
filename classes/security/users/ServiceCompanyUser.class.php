<?php

require_once(CLASSES_PATH . "/security/UserGroups.class.php");
require_once(CLASSES_PATH . "/security/users/AuthenticateUser.class.php");
require_once(CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 * User class for system administrators.
 * 
 * @author Vahagn Sookiasian, Yerem Khalatyan
 */
class ServiceCompanyUser extends AuthenticateUser {

	private $serviceCompanyManager;
	/**
	 * Creates en instance of admin user class and
	 * initializes class members necessary for validation. 
	 * 
	 * @param object $adminId
	 * @return 
	 */
	public function __construct($id) {
		parent::__construct($id);
		$this->setCookieParam("ut", UserGroups::$SERVICE_COMPANY);
	}

	public function setUniqueId($uniqueId, $updateDb = true) {

		if ($updateDb) {
			$uniqueId = ServiceCompanyManager::getInstance()->updateCompanyHash($this->getId());
		}
		$this->setCookieParam("uh", $uniqueId);
	}

	/**
	 * Validates user credentials 
	 * 
	 * @return TRUE - if validation passed, and FALSE - otherwise
	 */
	public function validate($uniqueId = false) {
		if (!$uniqueId) {
			$uniqueId = $this->getUniqueId();
		}
		return ServiceCompanyManager::getInstance()->validate($this->getId(), $uniqueId);
	}

}

?>