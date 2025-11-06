<?php declare(strict_types=1);

namespace SyAgeRestriction\Subscriber;

use Shopware\Core\Framework\Validation\BuildValidationEvent;
use Shopware\Core\Framework\Validation\DataValidationDefinition;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SyAgeRestriction\Core\Checkout\Customer\Validation\AgeRestrictionValidator;

class RegisterRouteSubscriber implements EventSubscriberInterface
{
    private AgeRestrictionValidator $ageRestrictionValidator;

    public function __construct(AgeRestrictionValidator $ageRestrictionValidator)
    {
        $this->ageRestrictionValidator = $ageRestrictionValidator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'framework.validation.build_definition' => 'addAgeRestrictionValidation',
        ];
    }

    public function addAgeRestrictionValidation(BuildValidationEvent $event): void
    {
        if ($event->getName() !== 'customer.validation') {
            return;
        }

        /** @var DataValidationDefinition $definition */
        $definition = $event->getDefinition();

        $customDefinition = $this->ageRestrictionValidator->buildDefinition($event->getData());
        
        $definition->merge($customDefinition);
    }
}