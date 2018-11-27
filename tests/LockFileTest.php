<?php

declare(strict_types=1);

namespace LockFile\Test;

use Generator;
use LockFile\Exception\FileNotFoundException;
use LockFile\Exception\InvalidJsonException;
use LockFile\Exception\LockFileException;
use LockFile\LockFile;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class LockFileTest extends TestCase
{
    use AssertionHelper;

    public function test_it_throws_an_exception_if_the_file_does_not_exist(): void
    {
        $this->expectException(FileNotFoundException::class);
        $this->expectException(LockFileException::class);
        LockFile::fromFile('foo/bar.lock');
    }

    public function test_it_throws_an_exception_if_the_file_contains_invalid_json(): void
    {
        $this->expectException(InvalidJsonException::class);
        $this->expectException(LockFileException::class);
        LockFile::fromFile(__DIR__.'/Fixtures/invalid_composer.lock');
    }

    public function test_it_returns_an_instance_of_itself_when_provided_with_valid_json_file(): void
    {
        LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertItThrowsNoExceptions();
    }

    /**
     * @dataProvider providesProdPackagesContainedByLockFile
     */
    public function test_it_knows_if_it_has_a_prod_package(string $package): void
    {
        $lock = LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertTrue($lock->hasProdPackage($package));
    }

    public function providesProdPackagesContainedByLockFile(): Generator
    {
        yield ['composer/ca-bundle'];

        yield ['nikic/php-parser'];

        yield ['padraic/humbug_get_contents'];

        yield ['psr/container'];
    }

    /**
     * @dataProvider providesProdPackagesNotContainedByLockFile
     */
    public function test_it_knows_if_it_does_not_have_a_prod_package(string $package): void
    {
        $lock = LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertFalse($lock->hasProdPackage($package));
    }

    public function providesProdPackagesNotContainedByLockFile(): Generator
    {
        yield ['acme/foo'];

        yield ['backendtea/lockfile'];

        yield ['phpunit/phpunit'];
    }

    /**
     * @dataProvider providesDevPackagesContainedByLockFile
     */
    public function test_it_knows_if_it_has_a_dev_package(string $package): void
    {
        $lock = LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertTrue($lock->hasDevPackage($package));
    }

    public function providesDevPackagesContainedByLockFile(): Generator
    {
        yield ['phpunit/phpunit'];

        yield ['mockery/mockery'];
    }

    /**
     * @dataProvider providesDevPackagesNotContainedByLockFile
     */
    public function test_it_knows_if_it_does_not_have_a_dev_package(string $package): void
    {
        $lock = LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertFalse($lock->hasDevPackage($package));
    }

    public function providesDevPackagesNotContainedByLockFile(): Generator
    {
        yield ['acme/foo'];

        yield ['backendtea/lockfile'];

        yield ['nikic/php-parser'];

        yield ['padraic/humbug_get_contents'];

        yield ['psr/container'];
    }

    /**
     * @dataProvider providesPackagesContainedByLockFile
     */
    public function test_it_knows_it_has_a_package(string $package): void
    {
        $lock = LockFile::fromFile(__DIR__.'/Fixtures/valid_composer.lock');
        $this->assertTrue($lock->hasPackage($package));
    }

    public function providesPackagesContainedByLockFile(): Generator
    {
        yield ['phpunit/phpunit'];

        yield ['mockery/mockery'];

        yield ['composer/ca-bundle'];

        yield ['nikic/php-parser'];

        yield ['padraic/humbug_get_contents'];

        yield ['psr/container'];
    }
}
