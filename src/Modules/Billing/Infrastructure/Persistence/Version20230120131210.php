<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates team_feature_toggle table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table team_feature_toggle (
                team_id BINARY(36) not null,
                feature_name VARCHAR(255) not null,
                status bool not null,
                foreign key (team_id) references teams(id),
                foreign key (feature_name) references features(name)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table team_feature_toggle
        ');
    }
}
