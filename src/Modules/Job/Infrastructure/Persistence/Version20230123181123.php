<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123181123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates job_post_properties table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table job_post_properties (
                id BINARY(36) not null unique,
                job_post_id BINARY(36) not null,
                type VARCHAR(255) not null,
                value VARCHAR(255) not null,
                primary key (id),
                foreign key (job_post_id) references job_posts(id),
                index (job_post_id, type)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table job_post_properties
        ');
    }
}
