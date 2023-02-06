<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123180849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates jobs table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table jobs (
                id BINARY(36) not null unique,
                company_id BINARY(36) not null,
                category_id BINARY(36) not null,
                name VARCHAR(255) not null,
                closed BOOLEAN not null default false,
                closed_at DATETIME null,
                closed_by BINARY(36) null,
                primary key (id),
                index (category_id),
                foreign key (company_id) references companies(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table jobs
        ');
    }
}
