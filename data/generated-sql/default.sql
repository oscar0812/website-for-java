
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- scene
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `scene`;

CREATE TABLE `scene`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(16384) NOT NULL,
    `placement` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
