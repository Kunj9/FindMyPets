CREATE TABLE IF NOT EXISTS `Pets` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `posted_by` VARCHAR(255),
    `breed` VARCHAR(255),
    `species` VARCHAR(255),
    `gender` VARCHAR(10),
    `found_datetime` DATETIME DEFAULT NULL,
    `lost_datetime` DATETIME DEFAULT NULL,
    `additional_details` TEXT,
    `status` VARCHAR(10),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`posted_by`) REFERENCES Users(`username`)
);