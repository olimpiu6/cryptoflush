<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210804174626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coin_markets_data (id INT AUTO_INCREMENT NOT NULL, coin_ticker VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, string VARCHAR(255) NOT NULL, current_price DOUBLE PRECISION NOT NULL, market_cap DOUBLE PRECISION NOT NULL, market_cap_rank INT NOT NULL, total_volume DOUBLE PRECISION NOT NULL, daily_low DOUBLE PRECISION NOT NULL, daily_high DOUBLE PRECISION NOT NULL, daily_price_change DOUBLE PRECISION DEFAULT NULL, daily_price_change_percentage DOUBLE PRECISION DEFAULT NULL, daily_market_cap_change DOUBLE PRECISION DEFAULT NULL, daily_market_cap_change_percentage DOUBLE PRECISION DEFAULT NULL, circulating_supply INT DEFAULT NULL, total_supply INT DEFAULT NULL, max_supply INT DEFAULT NULL, json_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE coin_markets_data');
    }
}
