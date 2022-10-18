<?php

namespace FreeShippingGoal\Helpers;

use Plenty\Modules\PlentyMarketplace\Contracts\SubscriptionInformationServiceContract;
use Plenty\Plugin\Application;
use Plenty\Plugin\Log\Loggable;

/**
 * Class SubscriptionInfoHelper
 * 
 * @package FreeShippingGoal\Helpers
 */
class SubscriptionInfoHelper
{
    use Loggable;

    /**
     * @return boolean
     */
    public function isPaid(): bool
    {
        /** @var SubscriptionInformationServiceContract $subscriptionInfoService */
        $subscriptionInfoService = pluginApp(SubscriptionInformationServiceContract::class);
        $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Plenty.Subscription', [
            'subscriptionInfo' => $subscriptionInfoService->getSubscriptionInfo('FreeShippingGoal')
        ]);

        // Exception for my development system
        $pid = $this->plentyID();
        if ($pid === 58289) {
            $this->getLogger(__METHOD__)->info('FreeShippingGoal::Plenty.SubscriptionDev');
            return true;
        }

        // Check if user has paid and show warning in log if he hasn't
        $isPaid = $subscriptionInfoService->isPaid('FreeShippingGoal');
        if (!$isPaid) {
            $this->getLogger(__METHOD__)->warning('FreeShippingGoal::Plenty.Subscription', ['isPaid' => false]);
        }

        return $isPaid;
    }

    /**
     * @return integer
     */
    public function plentyID(): int
    {
        /** @var Application $application */
        $application = pluginApp(Application::class);

        return $application->getPlentyId();
    }
}
