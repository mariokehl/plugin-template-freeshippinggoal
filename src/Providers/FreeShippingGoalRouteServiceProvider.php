<?php

namespace FreeShippingGoal\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class FreeShippingGoalRouteServiceProvider
 * 
 * @package FreeShippingGoal\Providers
 */
class FreeShippingGoalRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('plugin/free-shipping-goal/current','FreeShippingGoal\Controllers\FreeShippingGoalController@getCurrentGoal');
    }
}