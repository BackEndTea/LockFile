<?php

declare(strict_types=1);

namespace LockFile\Test\Exception;

use LockFile\Exception\LockFileException;
use LockFile\Exception\UnableToReadFileException;
use LockFile\Test\AssertionHelper;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UnableToReadFileExceptionTest extends TestCase
{
    use AssertionHelper;

    public function test_it_implements_lockfile_exception(): void
    {
        $this->assertImplementsInterface(UnableToReadFileException::class, LockFileException::class);
    }

    public function test_it_has_the_correct_error_message(): void
    {
        $filename = 'foo/bar.lock';
        $message = 'Unable to read from file "foo/bar.lock", check if permissions are set up right.';

        $exception = UnableToReadFileException::fromFileName($filename);
        $this->assertSame($message, $exception->getMessage());
    }
}
