<?php

declare(strict_types=1);

namespace LockFile\Exception;

use InvalidArgumentException;

final class FileNotFoundException extends InvalidArgumentException implements LockFileException
{
    public static function fromFileName(string $filename): self
    {
        return new self(sprintf(
            'Unable to find lockfile "%s"',
            $filename
        ));
    }
}
