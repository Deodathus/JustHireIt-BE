<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125105549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates candidates_skills table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table candidates_skills (
                skill_id BINARY(36) not null unique,
                candidate_id BINARY(36) not null unique,
                score JSON not null,
                numeric_score float not null,
                foreign key (skill_id) references skills(id),
                foreign key (candidate_id) references candidates(id),
                index (skill_id, candidate_id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table candidates_skills
        ');
    }
}
