<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120113020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates teams table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table teams (
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
            drop table teams
        ');
    }
}
