<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126151734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates team_invitations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table team_invitations (
                id BINARY(36) not null,
                team_id BINARY(36) not null,
                creator_id BINARY(36),
                active bool not null default true,
                active_until TIMESTAMP not null,
                foreign key (team_id) references teams(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table team_invitations
        ');
    }
}
