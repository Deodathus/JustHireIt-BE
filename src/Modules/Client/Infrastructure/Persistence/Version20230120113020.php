<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120113020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates client_groups table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table client_groups (
                id BINARY(36) not null unique,
                owner_id BINARY(36) not null,
                name VARCHAR(255) not null unique,
                primary key (id),
                foreign key (owner_id) references clients(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table client_groups
        ');
    }
}
