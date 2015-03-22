<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/ItemWarrantiesMapper.class.php");

/**
 * ItemWarrantiesManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class ItemWarrantiesManager extends AbstractManager {

  

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     */
    function __construct() {
        $this->mapper = ItemWarrantiesMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new ItemWarrantiesManager();
        }
        return self::$instance;
    }

    public function addItemWarranty($companyId, $serial_number, $item_buyer, $item_category, $warranty_period, $customer_warranty_start_date, $supplier, $supplier_warranty_start_date, $supplier_warranty_period) {
        $dto = $this->mapper->createDto();
        $dto->setCompanyId($companyId);
        $dto->setSerialNumber($serial_number);
        $dto->setBuyer($item_buyer);
        $dto->setItemCategory($item_category);
        $dto->setCustomerWarrantyPeriod($warranty_period);
        $dto->setCustomerWarrantyStartDate($customer_warranty_start_date);
        $dto->setSupplier($supplier);
        $dto->setSupplierWarrantyStartDate($supplier_warranty_start_date);
        $dto->setSupplierWarrantyPeriod($supplier_warranty_period);
        $this->mapper->insertDto($dto);
    }

    public function editItemWarranty($id, $companyId, $serial_number, $item_buyer, $item_category, $warranty_period, $customer_warranty_start_date, $supplier, $supplier_warranty_start_date, $supplier_warranty_period) {
        $dto = $this->mapper->selectByPK($id);
        $dto->setCompanyId($companyId);
        $dto->setSerialNumber($serial_number);
        $dto->setBuyer($item_buyer);
        $dto->setItemCategory($item_category);
        $dto->setCustomerWarrantyPeriod($warranty_period);
        $dto->setCustomerWarrantyStartDate($customer_warranty_start_date);
        $dto->setSupplier($supplier);
        $dto->setSupplierWarrantyStartDate($supplier_warranty_start_date);
        $dto->setSupplierWarrantyPeriod($supplier_warranty_period);
        $this->mapper->updateByPK($dto);
    }

    public function getCompanyWarrantyItems($companyId, $search_serial_number, $offset, $limit) {
        return $this->mapper->getCompanyWarrantyItems($companyId, $search_serial_number, $offset, $limit);
    }

    public function getCompanyAllWarrantyItems($companyId) {
        return $this->mapper->getCompanyAllWarrantyItems($companyId);
    }

}

?>