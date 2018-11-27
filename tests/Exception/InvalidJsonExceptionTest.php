<?php

declare(strict_types=1);

namespace LockFile\Test\Exception;

use LockFile\Exception\InvalidJsonException;
use LockFile\Exception\LockFileException;
use LockFile\Test\AssertionHelper;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class InvalidJsonExceptionTest extends TestCase
{
    use AssertionHelper;

    public function test_it_implements_lockfile_exception(): void
    {
        $this->assertImplementsInterface(InvalidJsonException::class, LockFileException::class);
    }

    public function test_it_has_the_correct_error_message(): void
    {
        $filename = 'foo/bar.lock';
        $message = 'File "foo/bar.lock" contains invalid JSON and could not be parsed';

        $exception = InvalidJsonException::fromFileName($filename);
        $this->assertSame($message, $exception->getMessage());
    }
}
