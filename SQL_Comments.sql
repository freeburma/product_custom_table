use tutorial; 

-- DROP TABLE wp_custom_inventory;
CREATE TABLE IF NOT EXISTS wp_custom_inventory 
(
	Id int NOT NULL AUTO_INCREMENT primary key, 
    Title TEXT, 
    ProductDescription TEXT, 
    FilePath TEXT,
    ImageName_1 TEXT,
    StoreDate DATETIME
); 


-- ALTER TABLE wp_custom_inventory 
-- 	Add Column test2 varchar(10) after test; 
--     
-- ALTER TABLE wp_custom_inventory 
-- 	Drop test ;


-- ALTER TABLE wp_custom_inventory
-- CHANGE COLUMN `FileName` `ImageName_1` Text NOT NULL;  

SELECT * FROM wp_custom_inventory; 
    
 

