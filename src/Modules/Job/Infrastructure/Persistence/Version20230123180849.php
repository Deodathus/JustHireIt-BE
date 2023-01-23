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
                owner_id BINARY(36) not null,
                name VARCHAR(255) not null unique,
                primary key (id)
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
