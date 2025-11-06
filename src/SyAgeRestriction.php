<?php declare(strict_types=1);

namespace SyAgeRestriction;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class SyAgeRestriction extends Plugin
{
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if (!$uninstallContext->keepUserData()) {
            /** @var EntityRepository $systemConfigRepository */
            $systemConfigRepository = $this->container->get('shopware.system_config.repository');
            
            $configKeys = [
                'SyAgeRestriction.config.minAge',
            ];

            $data = array_map(function (string $key) {
                return ['id' => $key];
            }, $configKeys);

            $systemConfigRepository->delete($data, $uninstallContext->getContext());
        }
    }

    public function buildContainer(\Symfony\Component\DependencyInjection\ContainerBuilder $container): void
    {
        parent::buildContainer($container);
        $container->setParameter('sy_age_restriction.base_path', $this->getPath());
    }
}