--
-- Creating a sample table.
--



--
-- Table Book
--
ALTER TABLE `gubg19`.`comments` 
ADD COLUMN `email` VARCHAR(100) NOT NULL AFTER `question`;