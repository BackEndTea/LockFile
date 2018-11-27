<?php

declare(strict_types=1);

namespace LockFile\Exception;

use RuntimeException;

final class InvalidJsonException extends RuntimeException implements LockFileException
{
    public static function fromFileName(string $filename): self
    {
        return new self(sprintf(
            'File "%s" contains invalid JSON and could not be parsed',
            $filename
        ));
    }
}
