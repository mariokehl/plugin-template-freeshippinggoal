<?php

namespace FreeShippingGoal\Controllers;

use FreeShippingGoal\Helpers\ShippingProfileHelper;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\Controller;

/**
 * Class FreeShippingGoalController
 * 
 * @package FreeShippingGoal\Controllers
 */
class FreeShippingGoalController extends Controller
{
    /**
     * @param BasketRepositoryContract $basketRepo
     * @param ShippingProfileHelper $shippingProfileHelper
     * @return string
     */
    public function getCurrentGoal(
        BasketRepositoryContract $basketRepo,
        ShippingProfileHelper $shippingProfileHelper
    ): string {
        /** @var Basket $basket */
        $basket = $basketRepo->load();

        return json_encode(['minimumGrossValue' => $shippingProfileHelper->getFreeShippingValue($basket->shippingCountryId, $basket->shippingProfileId)]);
    }
}
