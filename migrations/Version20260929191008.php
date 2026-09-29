<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260929191008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_question (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, explication LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_response (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, is_right TINYINT NOT NULL, question_id INT DEFAULT NULL, INDEX IDX_6948EDD61E27F6BF (question_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_selected_response (id INT AUTO_INCREMENT NOT NULL, selected_answer_x_time INT DEFAULT NULL, statistic_id INT DEFAULT NULL, response_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_97253F54FBF32840 (response_id), INDEX IDX_97253F5453B6268F (statistic_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tbl_statistic (id INT AUTO_INCREMENT NOT NULL, t_moyen NUMERIC(10, 2) DEFAULT NULL, t_min NUMERIC(10, 2) DEFAULT NULL, t_max NUMERIC(10, 2) DEFAULT NULL, question_asked_x_time_ INT DEFAULT NULL, question_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2113290F1E27F6BF (question_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tbl_response ADD CONSTRAINT FK_6948EDD61E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id)');
        $this->addSql('ALTER TABLE tbl_selected_response ADD CONSTRAINT FK_97253F5453B6268F FOREIGN KEY (statistic_id) REFERENCES tbl_statistic (id)');
        $this->addSql('ALTER TABLE tbl_selected_response ADD CONSTRAINT FK_97253F54FBF32840 FOREIGN KEY (response_id) REFERENCES tbl_response (id)');
        $this->addSql('ALTER TABLE tbl_statistic ADD CONSTRAINT FK_2113290F1E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_response DROP FOREIGN KEY FK_6948EDD61E27F6BF');
        $this->addSql('ALTER TABLE tbl_selected_response DROP FOREIGN KEY FK_97253F5453B6268F');
        $this->addSql('ALTER TABLE tbl_selected_response DROP FOREIGN KEY FK_97253F54FBF32840');
        $this->addSql('ALTER TABLE tbl_statistic DROP FOREIGN KEY FK_2113290F1E27F6BF');
        $this->addSql('DROP TABLE tbl_question');
        $this->addSql('DROP TABLE tbl_response');
        $this->addSql('DROP TABLE tbl_selected_response');
        $this->addSql('DROP TABLE tbl_statistic');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
