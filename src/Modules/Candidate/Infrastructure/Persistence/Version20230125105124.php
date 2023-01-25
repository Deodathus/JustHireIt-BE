<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125105124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates skills table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table skills (
                id BINARY(36) not null unique,
                name VARCHAR(255) not null,
                primary key (id),
                index (name)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table skills
        ');
    }
}
