<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123190710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates job_post_requirements table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table job_post_requirements (
                job_post_id BINARY(36) not null,
                requirement_id BINARY(36) not null,
                foreign key (job_post_id) references job_posts(id),
                index (job_post_id, requirement_id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table job_post_requirements
        ');
    }
}
