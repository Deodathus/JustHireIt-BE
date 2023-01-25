<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125105007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates candidates table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table candidates (
                id BINARY(36) not null unique,
                first_name VARCHAR(255) not null,
                last_name VARCHAR(255) not null,
                primary key (id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table candidates
        ');
    }
}
