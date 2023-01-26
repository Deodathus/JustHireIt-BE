<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126105123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates application_files table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table application_files (
                id BINARY(36) not null,
                job_post_id BINARY(36) not null,
                file_path VARCHAR(255) not null,
                name VARCHAR(255) not null,
                primary key (id),
                foreign key (job_post_id) references job_posts(id),
                index (job_post_id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table application_files
        ');
    }
}
