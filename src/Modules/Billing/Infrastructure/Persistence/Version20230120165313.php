<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120165313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates team_members_teams';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table team_members_teams (
                team_id BINARY(36) not null,
                member_id BINARY(36) not null,
                foreign key (team_id) references teams(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table team_members_teams
        ');
    }
}
