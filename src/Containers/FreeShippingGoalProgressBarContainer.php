<?php

namespace FreeShippingGoal\Containers;

use FreeShippingGoal\Helpers\ShippingProfileHelper;
use FreeShippingGoal\Helpers\SubscriptionInfoHelper;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Translation\Translator;

/**
 * @package FreeShippingGoal\Containers
 */
class FreeShippingGoalProgressBarContainer
{
    use Loggable;

    /**
     * The constants
     */
    const MESSAGE_TEMPLATE_MISSING = 'missing';
    const MESSAGE_TEMPLATE_GOAL = 'goal';

    /**
     * Message templates (either default or individualized)
     *
     * @var array
     */
    private $messageTemplates = [
        self::MESSAGE_TEMPLATE_MISSING => '',
        self::MESSAGE_TEMPLATE_GOAL => ''
    ];

    /**
     * Renders the template.
     * 
     * @param Twig $twig The twig instance
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function call(Twig $twig): string
    {
        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        // Is output active in plugin config?
        $shouldRender = $configRepo->get('FreeShippingGoal.global.active', 'true');

        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if (!$subscription->isPaid() || $shouldRender === 'false') {
            return '';
        }

        // Current goal amount
        $currAmount = 0;

        // The initial percentage to reach goodie (later on we will rely on afterBasketChanged event)
        $percentage = 0;

        /** @var BasketRepositoryContract $basketRepo */
        $basketRepo = pluginApp(BasketRepositoryContract::class);

        /** @var Basket $basket */
        $basket = $basketRepo->load();
        $actualItemSum = $basket->itemSum ? ($basket->itemSum + $basket->couponDiscount) : 0;

        /** @var ShippingProfileHelper $shippingProfileHelper */
        $shippingProfileHelper = pluginApp(ShippingProfileHelper::class);
        $minimumGrossValue = $shippingProfileHelper->getFreeShippingValue($basket->shippingCountryId, $basket->shippingProfileId);

        if (($basket && $basket instanceof Basket) && $minimumGrossValue) {
            $currAmount = ($minimumGrossValue - $actualItemSum);
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Basket', ['basket' => $basket]);
            $percentage = ($actualItemSum / $minimumGrossValue) * 100;
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Percentage', ['percentage' => $percentage]);
            $percentage = floor($percentage);
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Percentage', ['percentage' => $percentage]);
            $percentage = ($percentage > 100) ? 100 : $percentage;
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.Percentage', ['percentage' => $percentage]);
        }

        // The currency
        $currency = $basket->currency ?? 'EUR';

        // The messages
        $messages = $this->getMessageTemplates();
        $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.MsgTemplates', ['messages' => $messages]);
        $label = '';
        if ($percentage < 100) {
            $label = $this->getMessageTemplates(number_format($currAmount, 2, ',', ''), $currency)[self::MESSAGE_TEMPLATE_MISSING];
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.ProgressText', ['label' => $label, 'percentageLower' => true]);
        } else {
            $label = $messages[self::MESSAGE_TEMPLATE_GOAL];
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Debug.ProgressText', ['label' => $label]);
        }

        // Excluded shipping countries
        $excludedShippingCountriesAsString = $configRepo->get('FreeShippingGoal.global.excludedShippingCountries', '');
        $excludedShippingCountries = array_map('intval', explode(',', $excludedShippingCountriesAsString));

        return $twig->render('FreeShippingGoal::content.Containers.ProgressBar', [
            'excludedShippingCountries' => $excludedShippingCountries,
            'hidden' => in_array($basket->shippingCountryId, $excludedShippingCountries) || !$minimumGrossValue,
            'additionalClasses' => in_array($basket->shippingCountryId, $excludedShippingCountries) ? 'd-shipping-country-none' : 'd-shipping-country-block',
            'grossValue' => $minimumGrossValue,
            'itemSum' => $actualItemSum ?? 0,
            'label' => $label,
            'percentage' => $percentage,
            'width' => 'width: ' . number_format($percentage, 0, '', '') . '%',
            'messages' => $messages,
            'currency' => $currency
        ]);
    }

    /**
     * @param string $amount
     * @param string $currency
     * @return array
     */
    private function getMessageTemplates(string $amount = '', string $currency = ''): array
    {
        /** @var Translator $translator */
        $translator = pluginApp(Translator::class);

        // Initialize the custom templates
        $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = $translator->trans('FreeShippingGoal::Template.MessageMissing');
        $this->messageTemplates[self::MESSAGE_TEMPLATE_GOAL] = $translator->trans('FreeShippingGoal::Template.MessageGoal');

        // Replace markers
        if (strlen($amount) && strlen($currency)) {
            $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = str_replace([':amount', ':currency'], [$amount, $currency], $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING]);
        }

        return $this->messageTemplates;
    }
}
