<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Adapter;

use App\Shared\Application\Service\UploadedFile as UploadedFileInterface;
use App\SharedInfrastructure\Exception\CanNotMoveFileException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

final class UploadedFile implements UploadedFileInterface
{
    public function __construct(
        private readonly SymfonyUploadedFile $file
    ) {}

    public function move(string $path, ?string $name = null): void
    {
        try {
            $this->file->move($path, $name);
        } catch (FileException $exception) {
            throw CanNotMoveFileException::fromPrevious($exception);
        }
    }

    public function getName(): string
    {
        return $this->file->getClientOriginalName();
    }
}
