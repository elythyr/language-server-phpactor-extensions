<?php

namespace Phpactor\Extension\LanguageServerIndexer\Tests;

use Phpactor\Extension\LanguageServerIndexer\LanguageServerIndexerExtension;
use Phpactor\Extension\LanguageServerIndexer\Tests\Extension\TestExtension;
use Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor\Extension\Rpc\RpcExtension;
use Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor\Extension\Logger\LoggingExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\Extension\Console\ConsoleExtension;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor\Container\Container;
use Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor\TestUtils\Workspace;

class IntegrationTestCase extends TestCase
{
    protected function workspace(): Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }

    protected function container(array $config = []): Container
    {
        $container = PhpactorContainer::fromExtensions([
            ConsoleExtension::class,
            IndexerExtension::class,
            FilePathResolverExtension::class,
            LoggingExtension::class,
            SourceCodeFilesystemExtension::class,
            WorseReflectionExtension::class,
            ClassToFileExtension::class,
            RpcExtension::class,
            ComposerAutoloaderExtension::class,
            ReferenceFinderExtension::class,
            LanguageServerIndexerExtension::class,
            LanguageServerExtension::class,
            TestExtension::class,
        ], array_merge([
            FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../',
            FilePathResolverExtension::PARAM_PROJECT_ROOT => $this->workspace()->path(),
            IndexerExtension::PARAM_INDEX_PATH => $this->workspace()->path('/cache'),
            LoggingExtension::PARAM_ENABLED=> true,
            LoggingExtension::PARAM_PATH=> 'php://stderr',
            WorseReflectionExtension::PARAM_ENABLE_CACHE=> false,
        ], $config));

        return $container;
    }
}
