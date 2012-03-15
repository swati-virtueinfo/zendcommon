CREATE TABLE admin (id BIGINT AUTO_INCREMENT, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE category_translation (id INT, name VARCHAR(100) NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE category (id INT AUTO_INCREMENT, image_name VARCHAR(100), is_active TINYINT(1) DEFAULT '1', parentid INT NOT NULL, level INT NOT NULL, site_id INT NOT NULL, banner_image VARCHAR(100), is_promote TINYINT(1), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE city_translation (id BIGINT, name VARCHAR(100) NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE city (id BIGINT AUTO_INCREMENT, country_id INT NOT NULL, is_active TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE country_translation (id BIGINT, name VARCHAR(100) NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE country (id BIGINT AUTO_INCREMENT, is_active TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE language (id BIGINT AUTO_INCREMENT, name VARCHAR(55) UNIQUE, lang VARCHAR(2) UNIQUE, is_default TINYINT(1) DEFAULT '0', is_active TINYINT(1) DEFAULT '1', flag VARCHAR(55), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE pages_translation (id BIGINT, title VARCHAR(255), menu_name VARCHAR(255), content TEXT, meta_title VARCHAR(255), meta_keyword VARCHAR(255), meta_description TEXT, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE pages (id BIGINT AUTO_INCREMENT, parent_id BIGINT NOT NULL, url TEXT, is_active TINYINT(1) DEFAULT '1', ord BIGINT DEFAULT 1, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE variable_translation (id BIGINT, value text, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE variable (id BIGINT AUTO_INCREMENT, name VARCHAR(255), is_active TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
ALTER TABLE category_translation ADD CONSTRAINT category_translation_id_category_id FOREIGN KEY (id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE city_translation ADD CONSTRAINT city_translation_id_city_id FOREIGN KEY (id) REFERENCES city(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE country_translation ADD CONSTRAINT country_translation_id_country_id FOREIGN KEY (id) REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE pages_translation ADD CONSTRAINT pages_translation_id_pages_id FOREIGN KEY (id) REFERENCES pages(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE variable_translation ADD CONSTRAINT variable_translation_id_variable_id FOREIGN KEY (id) REFERENCES variable(id) ON UPDATE CASCADE ON DELETE CASCADE;
