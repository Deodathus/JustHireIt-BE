<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Persistence;

use App\Modules\Billing\Domain\Enum\Features;
use App\Modules\Billing\Domain\ValueObject\FeatureId;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'populate features table with default job related permissions';
    }

    public function up(Schema $schema): void
    {
        foreach (Features::cases() as $feature) {
            $this->addSql(
                'insert into features (id, name) values (:id, :name)',
                [
                    'id' => FeatureId::generate()->toString(),
                    'name' => $feature->name,
                ]
            );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            truncate features
        ');
    }
}
