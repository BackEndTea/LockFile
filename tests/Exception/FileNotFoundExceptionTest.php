<?php

declare(strict_types=1);

namespace LockFile\Test\Exception;

use LockFile\Exception\FileNotFoundException;
use LockFile\Exception\LockFileException;
use LockFile\Test\AssertionHelper;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FileNotFoundExceptionTest extends TestCase
{
    use AssertionHelper;

    public function test_it_implements_lockfile_exception(): void
    {
        $this->assertImplementsInterface(FileNotFoundException::class, LockFileException::class);
    }

    public function test_it_has_the_correct_error_message(): void
    {
        $filename = 'foo/bar.lock';
        $message = 'Unable to find lockfile "foo/bar.lock"';

        $exception = FileNotFoundException::fromFileName($filename);
        $this->assertSame($message, $exception->getMessage());
    }
}
