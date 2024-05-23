<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240523104203 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E04992AA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57698A6A5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_permission (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), INDEX IDX_6F7DF886FED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE study_class (id INT AUTO_INCREMENT NOT NULL, class_owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B231497F5E237E06 (name), INDEX IDX_B231497FCAF2AAA9 (class_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE study_class_user (study_class_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_BE72856649891E99 (study_class_id), INDEX IDX_BE728566A76ED395 (user_id), PRIMARY KEY(study_class_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE study_class ADD CONSTRAINT FK_B231497FCAF2AAA9 FOREIGN KEY (class_owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE study_class_user ADD CONSTRAINT FK_BE72856649891E99 FOREIGN KEY (study_class_id) REFERENCES study_class (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE study_class_user ADD CONSTRAINT FK_BE728566A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');

        // SETUP DEFAULT DATA
        // ROLES
        $this->addSql('INSERT INTO role (id, name) VALUES (1, "student")');
        $this->addSql('INSERT INTO role (id, name) VALUES (2, "teacher")');
        $this->addSql('INSERT INTO role (id, name) VALUES (3, "director")');

        // PERMISSIONS
        $this->addSql('INSERT INTO permission (id, name) 
            VALUES 
                (1, "ACCESS_VIEW_USERS"),
                (2, "ACCESS_ADD_USER"),
                (3, "ACCESS_VIEW_USER"),
                (4, "ACCESS_VIEW_ROLES"),
                (5, "ACCESS_VIEW_ROLE"),
                (6, "ACCESS_ADD_ROLE"),
                (7, "ACCESS_CHANGE_ROLE"),
                (8, "ACCESS_VIEW_STUDY_CLASSES"),
                (9, "ACCESS_VIEW_STUDY_CLASS"),
                (10, "ACCESS_ADD_STUDY_CLASS"),
                (11, "ACCESS_ADD_STUDENTS_TO_STUDY_CLASS"),
                (12, "ACCESS_REMOVE_STUDENTS_FROM_STUDY_CLASS"),
                (13, "ACCESS_STUDY_CLASS_OWNER"),
                (14, "ACCESS_STUDY_CLASS_MEMBER")
        ');

        // PERMISSIONS OF ROLE
        $this->addSql('INSERT INTO role_permission (role_id, permission_id) 
            VALUES 
                (3, 1),
                (3, 2),
                (3, 3),
                (3, 4),
                (3, 5),
                (3, 6),
                (3, 7),
                (3, 8),
                (3, 9),
                (3, 10),
                (3, 11),
                (3, 12),
                (2, 13),
                (2, 12),
                (2, 11),
                (1, 14)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886FED90CCA');
        $this->addSql('ALTER TABLE study_class DROP FOREIGN KEY FK_B231497FCAF2AAA9');
        $this->addSql('ALTER TABLE study_class_user DROP FOREIGN KEY FK_BE72856649891E99');
        $this->addSql('ALTER TABLE study_class_user DROP FOREIGN KEY FK_BE728566A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE study_class');
        $this->addSql('DROP TABLE study_class_user');
        $this->addSql('DROP TABLE user');
    }
}
