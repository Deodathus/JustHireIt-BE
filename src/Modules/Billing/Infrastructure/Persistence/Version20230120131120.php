<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates features table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table features (
                id BINARY(36) not null unique,
                name VARCHAR(255) not null unique
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table features
        ');
    }
}
