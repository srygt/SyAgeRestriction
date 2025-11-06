<?php declare(strict_types=1);

namespace SyAgeRestriction\Core\Checkout\Customer\Validation;

use Shopware\Core\Framework\Validation\DataValidationDefinition;
use Shopware\Core\Framework\Validation\DataValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use DateTime;

class AgeRestrictionValidator extends DataValidator
{
    private SystemConfigService $systemConfigService;
    private const CONFIG_MIN_AGE_KEY = 'SyAgeRestriction.config.minAge';

    public function __construct(SystemConfigService $systemConfigService, iterable $constraintFactories)
    {
        parent::__construct($constraintFactories);
        $this->systemConfigService = $systemConfigService;
    }

    public function buildDefinition(array $data): DataValidationDefinition
    {
        $definition = new DataValidationDefinition('customer.register');

        $minAge = (int) $this->systemConfigService->get(self::CONFIG_MIN_AGE_KEY) ?? 18;

        $definition->add('birthday', new Assert\Callback([
            'callback' => function ($birthday, ExecutionContextInterface $context) use ($minAge) {
                if (!$birthday instanceof DateTime) {
                    return; 
                }

                $today = new DateTime();
                $minRequiredDate = (clone $today)->modify("-$minAge years");

                if ($birthday > $minRequiredDate) {
                    $context->buildViolation(
                        'The required minimum age of {{ minAge }} years has not been reached.'
                    )
                    ->setParameter('{{ minAge }}', (string) $minAge)
                    ->setTranslationDomain('SyAgeRestriction.snippets.ageRestriction')
                    ->setCode('SY_AGE_TOO_YOUNG')
                    ->addViolation();
                }
            },
            'groups' => ['registration'],
        ]));

        return $definition;
    }
}