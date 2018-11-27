<?php

declare(strict_types=1);

namespace LockFile\Exception;

use RuntimeException;

final class UnableToReadFileException extends RuntimeException implements LockFileException
{
    public static function fromFileName(string $filename): self
    {
        return new self(sprintf(
            'Unable to read from file "%s", check if permissions are set up right.',
            $filename
        ));
    }
}
