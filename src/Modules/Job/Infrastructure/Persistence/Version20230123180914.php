<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123180914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates job_posts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table job_posts (
                id BINARY(36) not null unique,
                job_id BINARY(36) not null,
                name VARCHAR(255) not null,
                closed BOOLEAN not null default false,
                closed_at DATETIME null,
                closed_by BINARY(36) null,
                primary key (id),
                foreign key (job_id) references jobs(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table job_posts
        ');
    }
}
