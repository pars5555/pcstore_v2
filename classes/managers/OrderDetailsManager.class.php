<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/OrderDetailsMapper.class.php");

/**
 * OrdersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class OrderDetailsManager extends AbstractManager {

   
    private $customerCartManager;
    private $itemManager;
    private $bundleItemsManager;

  
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     */
    function __construct() {
        $this->mapper = OrderDetailsMapper::getInstance();


        $this->customerCartManager = CustomerCartManager::getInstance();
        $this->itemManager = ItemManager::getInstance();
        $this->bundleItemsManager = BundleItemsManager::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new OrderDetailsManager();
        }
        return self::$instance;
    }

    public function addOrderDetails($orderId, $customerEmail, $user, $vatIncluded = 0) {
        $userLevel = $user->getLevel();
        $user_id = $user->getId();
        $dtos = $this->customerCartManager->getCustomerCart($customerEmail, $user_id, $userLevel);

        //calculating bundles totals in cart start
        $groupedDtos = $this->customerCartManager->groupBundleItemsInArray($dtos);
        $bundlesCustomerPrices = array();
        foreach ($groupedDtos as $key => $cartItem) {
            if (is_array($cartItem)) {
                list($bundleTotAMD, $bundleTotUSD) = $this->bundleItemsManager->calcBundlePriceForCustomerWithDiscount($cartItem, $userLevel);
                $bundlesCustomerPrices[$cartItem[0]->getBundleId()] = array($bundleTotAMD, $bundleTotUSD);
            }
        }
        //calculating bundles totals in cart end

        $dtosToBeInserted = array();
        foreach ($dtos as $key => $cartDto) {
            $dto = $this->mapper->createDto();
            $dto->setOrderId($orderId);
            if ($cartDto->getItemId() > 0) {
                $dto->setItemId($cartDto->getItemId());
                $dto->setItemDisplayName($cartDto->getCachedItemDisplayName());
                $dto->setItemCount($cartDto->getCount());
                $dto->setCustomerItemPrice($vatIncluded == 1 ? $cartDto->getCustomerVatItemPrice() : $cartDto->getCustomerItemPrice());
                $dto->setItemDealerPrice($vatIncluded == 1 ? $cartDto->getItemVatPrice() : $cartDto->getItemDealerPrice());
                $dto->setItemCompanyId($cartDto->getItemCompanyId());
                $dto->setIsDealerOfItem($cartDto->getIsDealerOfThisCompany());
                $dto->setDiscount($cartDto->getDiscount());
            } elseif ($cartDto->getBundleId() > 0) {
                $dto->setCustomerBundlePriceAmd($bundlesCustomerPrices[$cartDto->getBundleId()][0]);
                $dto->setCustomerBundlePriceUsd($bundlesCustomerPrices[$cartDto->getBundleId()][1]);
                if ($cartDto->getBundleItemId() > 0) {
                    $dto->setBundleId($cartDto->getBundleId());
                    $dto->setItemId($cartDto->getBundleItemId());
                    $dto->setItemDisplayName($cartDto->getBundleCachedItemDisplayName());
                    $dto->setBundleDisplayNameId($cartDto->getBundleDisplayNameId());
                    $dto->setBundleCount($cartDto->getCount());
                    $dto->setItemCount($cartDto->getBundleItemCount());
                    $dto->setCustomerItemPrice($cartDto->getCustomerItemPrice());
                    $dto->setItemDealerPrice($cartDto->getItemDealerPrice());
                    $dto->setItemCompanyId($cartDto->getItemCompanyId());
                    $dto->setIsDealerOfItem($cartDto->getIsDealerOfThisCompany());
                    $dto->setDiscount($cartDto->getDiscount());
                } elseif ($cartDto->getSpecialFeeId() > 0) {
                    $dto->setBundleId($cartDto->getBundleId());
                    $dto->setSpecialFeeId($cartDto->getSpecialFeeId());
                    $dto->setSpecialFeePrice($cartDto->getSpecialFeeDynamicPrice() >= 0 ? $cartDto->getSpecialFeeDynamicPrice() : $cartDto->getSpecialFeePrice());
                    $dto->setSpecialFeeDisplayNameId($cartDto->getSpecialFeeDescriptionTextId());
                    $dto->setItemCount($cartDto->getBundleItemCount());
                    $dto->setBundleCount($cartDto->getCount());
                    $dto->setBundleDisplayNameId($cartDto->getBundleDisplayNameId());
                }
            }
            $dtosToBeInserted[] = $dto;
        }
        return $this->mapper->insertDtos($dtosToBeInserted);
    }

}

?>