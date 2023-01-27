<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\StoreCategoryCommand;
use App\Modules\Job\Application\Exception\JobCategoryNameAlreadyTaken;
use App\Modules\Job\Domain\Entity\JobCategory;
use App\Modules\Job\Domain\Repository\JobCategoryRepository;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use App\Shared\Application\Messenger\CommandHandler;

final class StoreCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly JobCategoryRepository $categoryRepository
    ) {}

    public function __invoke(StoreCategoryCommand $command): string
    {
        $name = $command->jobCategory->name;

        if ($this->categoryRepository->existsByName($name)) {
            throw JobCategoryNameAlreadyTaken::withName($name);
        }

        $id = JobCategoryId::generate();
        $this->categoryRepository->store(
            new JobCategory(
                $id,
                $name
            )
        );

        return $id->toString();
    }
}
