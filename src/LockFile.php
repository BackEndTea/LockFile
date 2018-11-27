<?php

declare(strict_types=1);

namespace LockFile;

use LockFile\Exception\FileNotFoundException;
use LockFile\Exception\InvalidJsonException;
use LockFile\Exception\UnableToReadFileException;

final class LockFile
{
    private $packages;

    private $devPackages;

    private function __construct(array $content)
    {
        $packages = [];

        foreach ($content['packages'] as $package) {
            $packages[$package['name']] = $package;
        }
        $this->packages = $packages;

        $devPackages = [];

        foreach ($content['packages-dev'] as $devPackage) {
            $devPackages[$devPackage['name']] = $devPackage;
        }
        $this->devPackages = $devPackages;
    }

    public static function fromFile(string $fileName): self
    {
        if (!file_exists($fileName)) {
            throw FileNotFoundException::fromFileName($fileName);
        }

        $fileContent = file_get_contents($fileName);

        if (!\is_string($fileContent)) {
            throw new UnableToReadFileException($fileName);
        }

        $jsonContent = json_decode($fileContent, true);

        if ($jsonContent === null) {
            throw InvalidJsonException::fromFileName($fileName);
        }

        return new self($jsonContent);
    }

    public function hasPackage(string $package): bool
    {
        return $this->hasDevPackage($package) || $this->hasProdPackage($package);
    }

    public function hasProdPackage(string $package): bool
    {
        return array_key_exists($package, $this->packages);
    }

    public function hasDevPackage(string $devPackage): bool
    {
        return array_key_exists($devPackage, $this->devPackages);
    }
}
