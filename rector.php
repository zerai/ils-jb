<?php declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\CodeQuality\Rector\MethodCall\LiteralGetToRequestClassConstantRector;
use Rector\Symfony\Set\SymfonySetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->phpVersion(PhpVersion::PHP_74);
    $rectorConfig->symfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml');
    $rectorConfig->paths([
        __DIR__ . '/config',
        //__DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/_jobposting/src',
        __DIR__ . '/_jobposting/tests',
        //__DIR__ . '/tools',
    ]);

    $rectorConfig->skip([
        __DIR__ . '/tests/Behat/Installer/Context',
        __DIR__ . '/tests/Behat/DefaultContext/Context',
        LiteralGetToRequestClassConstantRector::class => [
            __DIR__ . '/tests',
            __DIR__ . '/_jobposting/tests',
        ],
    ]);

    // register a single rule
    //$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SymfonySetList::SYMFONY_54,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ]);
};
