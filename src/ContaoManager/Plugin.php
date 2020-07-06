<?php

declare(strict_types=1);

/*
 * This file is part of richardhj/contao-privacy-dump.
 *
 * Copyright (c) 2020-2020 Richard Henkenjohann
 *
 * @package   richardhj/contao-privacy-dump.
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2020-2020 Richard Henkenjohann
 * @license   MIT
 */

namespace Richardhj\ContaoPrivacyDump\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Config\ConfigInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\ManagerPlugin\Dependency\DependentPluginInterface;
use Richardhj\ContaoPrivacyDump\RichardhjContaoPrivacyDumpBundle;
use Richardhj\PrivacyDumpBundle\RichardhjPrivacyDumpBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Contao Manager plugin.
 */
class Plugin implements BundlePluginInterface, ConfigPluginInterface, DependentPluginInterface
{
    /**
     * Gets a list of autoload configurations for this bundle.
     *
     * @return ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RichardhjPrivacyDumpBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
            BundleConfig::create(RichardhjContaoPrivacyDumpBundle::class)
                ->setLoadAfter([RichardhjPrivacyDumpBundle::class]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load(__DIR__.'/../Resources/config/privacy_dump.yml');
    }

    public function getPackageDependencies()
    {
        return [
            'richardhj/privacy-dump-bundle',
        ];
    }
}
