SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grades` ;

CREATE TABLE IF NOT EXISTS `grades` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE INDEX `idx_title` ON `grades` (`title` ASC);


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `grades_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_users_grades`
    FOREIGN KEY (`grades_id`)
    REFERENCES `grades` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_users_grades_idx` ON `users` (`grades_id` ASC);


-- -----------------------------------------------------
-- Table `cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cities` ;

CREATE TABLE IF NOT EXISTS `cities` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users_cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users_cities` ;

CREATE TABLE IF NOT EXISTS `users_cities` (
  `users_id` INT UNSIGNED NOT NULL,
  `cities_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`users_id`, `cities_id`),
  CONSTRAINT `fk_table1_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_cities1`
    FOREIGN KEY (`cities_id`)
    REFERENCES `cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_table1_cities1_idx` ON `users_cities` (`cities_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `grades`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `grades` (`id`, `title`) VALUES (NULL, 'Middle school');
INSERT INTO `grades` (`id`, `title`) VALUES (NULL, 'High school');
INSERT INTO `grades` (`id`, `title`) VALUES (NULL, 'College');
INSERT INTO `grades` (`id`, `title`) VALUES (NULL, 'Bachelor');
INSERT INTO `grades` (`id`, `title`) VALUES (NULL, 'Vocational school');

COMMIT;


-- -----------------------------------------------------
-- Data for table `users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Wallace Vivian', 1);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Neil Leo', 2);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Merrill Homer', 3);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Baldric Tylor', 1);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Gosse Charles', 4);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Major Robbie', 3);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Finlay Esmund', 1);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Ulysses Ethelred', 2);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Dave Jemmy', 5);
INSERT INTO `users` (`id`, `name`, `grades_id`) VALUES (NULL, 'Terrance Bennett', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `cities`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Austin');
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Columbus');
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Detroit');
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Sacramento');
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Oakland');
INSERT INTO `cities` (`id`, `title`) VALUES (NULL, 'Orlando');

COMMIT;


-- -----------------------------------------------------
-- Data for table `users_cities`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (1, 1);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (1, 2);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (2, 2);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (3, 6);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (4, 3);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (4, 4);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (4, 5);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (4, 6);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (5, 3);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (5, 5);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (6, 3);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (7, 2);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (7, 4);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (8, 1);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (8, 6);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (9, 6);
INSERT INTO `users_cities` (`users_id`, `cities_id`) VALUES (10, 4);

COMMIT;

