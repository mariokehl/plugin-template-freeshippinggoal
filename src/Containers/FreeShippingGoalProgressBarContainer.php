<?php

namespace FreeShippingGoal\Containers;

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

        // The amount to reach
        $minimumGrossValue = $configRepo->get('FreeShippingGoal.global.grossValue', 50);

        // Current goal amount
        $currAmount = 0;

        // The initial percentage to reach goodie (later on we will rely on afterBasketChanged event)
        $percentage = 0;

        /** @var BasketRepositoryContract $basketRepo */
        $basketRepo = pluginApp(BasketRepositoryContract::class);

        /** @var Basket $basket */
        $basket = $basketRepo->load();

        if ($basket && $basket instanceof Basket) {
            $currAmount = ($minimumGrossValue - $basket->itemSum);
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Plenty.Basket', ['basket' => $basket]);
            $percentage = ($basket->itemSum / $minimumGrossValue) * 100;
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Frontend.Percentage', ['percentage' => $percentage]);
            $percentage = floor($percentage);
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Frontend.Percentage', ['percentage' => $percentage]);
            $percentage = ($percentage > 100) ? 100 : $percentage;
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Frontend.Percentage', ['percentage' => $percentage]);
        }

        // The currency
        $currency = $basket->currency ?? 'EUR';

        // The messages
        $messages = $this->getMessageTemplates($configRepo);
        $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Plenty.MessageTemplates', ['messages' => $messages]);
        $label = '';
        if ($percentage < 100) {
            $label = $this->getMessageTemplates($configRepo, number_format($currAmount, 2, ',', ''), $currency)[self::MESSAGE_TEMPLATE_MISSING];
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Frontend.ProgressText', ['label' => $label, 'percentageLower' => true]);
        } else {
            $label = $messages[self::MESSAGE_TEMPLATE_GOAL];
            $this->getLogger(__METHOD__)->debug('FreeShippingGoal::Frontend.ProgressText', ['label' => $label]);
        }

        return $twig->render('FreeShippingGoal::content.Containers.ProgressBar', [
            'grossValue' => $minimumGrossValue,
            'itemSum'    => $basket->itemSum ?? 0,
            'label'      => $label,
            'percentage' => $percentage,
            'width'      => 'width: ' . number_format($percentage, 0, '', '') . '%',
            'messages'   => $messages,
            'currency'   => $currency
        ]);
    }

    /**
     * @param ConfigRepository $configRepo
     * @param string $amount
     * @param string $currency
     * @return array
     */
    private function getMessageTemplates(ConfigRepository $configRepo, string $amount = '', string $currency = ''): array
    {
        // Set the custom templates
        $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = $configRepo->get('FreeShippingGoal.individualization.messageMissing', '');
        $this->messageTemplates[self::MESSAGE_TEMPLATE_GOAL] = $configRepo->get('FreeShippingGoal.individualization.messageGoal', '');

        // Default templates as fallback
        $hasNoIndividualMessageMissing = !strlen($this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING]);
        $hasNoIndividualMessageGoal = !strlen($this->messageTemplates[self::MESSAGE_TEMPLATE_GOAL]);

        if ($hasNoIndividualMessageMissing || $hasNoIndividualMessageGoal) {
            /** @var Translator $translator */
            $translator = pluginApp(Translator::class);
            if ($hasNoIndividualMessageMissing) {
                $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = $translator->trans('FreeShippingGoal::Frontend.MessageMissing');
            }
            if ($hasNoIndividualMessageGoal) {
                $this->messageTemplates[self::MESSAGE_TEMPLATE_GOAL] = $translator->trans('FreeShippingGoal::Frontend.MessageGoal');
            }
        }

        // Replace markers
        if (strlen($amount) && strlen($currency)) {
            $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = str_replace([':amount', ':currency'], [$amount, $currency], $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING]);
        }

        // Replace german umlauts
        array_walk_recursive($this->messageTemplates, function (&$value) {
            $value = htmlentities($value);
        });

        return $this->messageTemplates;
    }
}
