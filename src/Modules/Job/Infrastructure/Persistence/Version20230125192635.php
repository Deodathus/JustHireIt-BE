<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125192635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates applications table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table applications (
                id BINARY(36) not null,
                job_post_id BINARY(36) not null,
                applicant_id BINARY(36) not null,
                introduction VARCHAR(255) not null,
                by_guest bool not null default false,
                primary key (id),
                foreign key (job_post_id) references job_posts(id),
                index (job_post_id, applicant_id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table applications
        ');
    }
}
