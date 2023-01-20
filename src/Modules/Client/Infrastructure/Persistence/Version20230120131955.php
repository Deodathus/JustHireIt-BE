<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Persistence;

use App\Modules\Client\Domain\Enum\Permissions;
use App\Modules\Client\Domain\ValueObject\PermissionId;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'populate client_group_permissions table with default job related permissions';
    }

    public function up(Schema $schema): void
    {
        foreach (Permissions::cases() as $permission) {
            $this->addSql(
                'insert into client_group_permissions (id, name) values (:id, :name)',
                [
                    'id' => PermissionId::generate()->toString(),
                    'name' => $permission->name,
                ]
            );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            truncate client_group_permissions
        ');
    }
}
