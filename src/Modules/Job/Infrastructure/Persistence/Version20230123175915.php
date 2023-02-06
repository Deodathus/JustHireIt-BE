<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123175915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates companies table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table companies (
                id BINARY(36) not null,
                owner_id BINARY(36) not null,
                name VARCHAR(255) not null unique,
                description VARCHAR(255) not null,
                primary key (id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table job_categories
        ');
    }
}
