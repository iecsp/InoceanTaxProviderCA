<?php declare(strict_types=1);

use InoceanTaxProviderCA\Core\Checkout\Cart\Tax\CanadaTaxProvider;
use InoceanTaxProviderCA\Core\Checkout\Cart\Tax\PromotionTaxApportioner;
use InoceanTaxProviderCA\Service\TaxConfigService;
use InoceanTaxProviderCA\Twig\TaxNameExtension;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(TaxConfigService::class)
        ->args([
            service(SystemConfigService::class),
            service('logger'),
        ]);

    $services->set(PromotionTaxApportioner::class);

    $services->set(CanadaTaxProvider::class)
        ->args([
            service(TaxConfigService::class),
            service(PromotionTaxApportioner::class),
            service('logger'),
        ])
        ->tag('shopware.tax.provider');

    $services->set(TaxNameExtension::class)
        ->args([
            service(TaxConfigService::class),
        ])
        ->tag('twig.extension');
};
