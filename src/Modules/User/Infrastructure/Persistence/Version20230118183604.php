<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118183604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table users (
                id BINARY(36) not null unique,
                email varchar(255) not null,
                login varchar(255) not null unique,
                password varchar(255) not null,
                salt varchar(255) not null,
                api_token varchar(255) not null unique,
                created_at timestamp default CURRENT_TIMESTAMP,
                primary key (id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table users
        ');
    }
}
