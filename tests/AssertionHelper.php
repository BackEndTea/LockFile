<?php

declare(strict_types=1);

namespace LockFile\Test;

use ReflectionClass;

/**
 * @internal
 */
trait AssertionHelper
{
    public function assertItThrowsNoExceptions(): void
    {
        $this->addToAssertionCount(1);
    }

    public function assertImplementsInterface(string $class, string $interface): void
    {
        $rc = new ReflectionClass($class);
        $this->assertTrue($rc->implementsInterface($interface));
    }
}
