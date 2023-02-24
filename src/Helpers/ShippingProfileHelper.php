<?php

namespace FreeShippingGoal\Helpers;

use Plenty\Modules\Order\Shipping\Contracts\ParcelServicePresetRepositoryContract;
use Plenty\Modules\Order\Shipping\Countries\Contracts\CountryRepositoryContract;
use Plenty\Modules\Order\Shipping\ParcelService\Models\ParcelServicePreset;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

/**
 * Class ShippingProfileHelper
 * 
 * @package FreeShippingGoal\Helpers
 */
class ShippingProfileHelper
{
    use Loggable;

    /**
     * @param integer $shippingCountryId
     * @param integer $shippingProfileId
     * @return float
     */
    public function getFreeShippingValue(int $shippingCountryId, int $shippingProfileId): float
    {
        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        // Sync value with selected shipping profile
        $shouldSync = $configRepo->get('FreeShippingGoal.global.syncGrossValue', 'false');
        if (is_null($shouldSync) || $shouldSync === 'false') {
            $grossValue = (float)$configRepo->get('FreeShippingGoal.global.grossValue', 50);
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.BasketAmount', ['grossValue' => $grossValue]);
            return $grossValue;
        }

        /** @var CountryRepositoryContract $countryRepo */
        $countryRepo = pluginApp(CountryRepositoryContract::class);
        /** @var Country $country */
        $country = $countryRepo->getCountryById($shippingCountryId);

        /** @var ParcelServicePresetRepositoryContract $parcelServicePresetRepo */
        $parcelServicePresetRepo = pluginApp(ParcelServicePresetRepositoryContract::class);
        /** @var ParcelServicePreset $profile */
        $profile = $parcelServicePresetRepo->getPresetById($shippingProfileId);
        $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.ParcelServicePreset', [
            'basket_shippingCountryId' => $shippingCountryId,
            'basket_shippingProfileId' => $shippingProfileId,
            'profile' => $profile
        ]);

        if ($profile instanceof ParcelServicePreset) {
            $regionConstraint = $profile->parcelServiceRegionConstraint->where(
                'shippingRegionId',
                $country->shippingDestinationId
            )->first();
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Constraint', ['regionConstraint' => $regionConstraint]);
            if (!is_null($regionConstraint)) {
                $subConstraint = $regionConstraint->constraint->where(
                    'subConstraintType',
                    '5' // Free Shipping or Flatrate
                )->first();
                $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Constraint', ['subConstraint' => $subConstraint]);
                // Somehow $subConstraint->cost cannot be casted to float, use this workaround instead
                if (strpos(json_encode($subConstraint), '"cost":"0.00"')) {
                    $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.BasketAmount', [
                        'json' => json_encode($subConstraint),
                        'startValue' => $subConstraint->startValue
                    ]);
                    return (float)$subConstraint->startValue;
                }
            }
        }
        $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.BasketAmount', [0]);
        return 0;
    }
}
