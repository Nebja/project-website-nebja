<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725133805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE videos CHANGE name name VARCHAR(255) NOT NULL, CHANGE file file VARCHAR(255) NOT NULL, CHANGE made_at made_at INT NOT NULL, CHANGE img_poster img_poster VARCHAR(255) NOT NULL, CHANGE subs_file subs_file VARCHAR(255) NOT NULL, CHANGE youtube_trailer youtube_trailer VARCHAR(255) NOT NULL, CHANGE video_type video_type VARCHAR(255) NOT NULL, CHANGE entry_at entry_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE videos CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE file file VARCHAR(255) DEFAULT NULL, CHANGE made_at made_at INT DEFAULT NULL, CHANGE img_poster img_poster VARCHAR(255) DEFAULT NULL, CHANGE subs_file subs_file VARCHAR(255) DEFAULT NULL, CHANGE youtube_trailer youtube_trailer VARCHAR(255) DEFAULT NULL, CHANGE video_type video_type VARCHAR(255) DEFAULT NULL, CHANGE entry_at entry_at DATETIME DEFAULT NULL');
    }
}
