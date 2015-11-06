DELIMITER //
DROP PROCEDURE IF EXISTS `cleanAllTables`//
CREATE PROCEDURE `cleanAllTables`(IN dbname VARCHAR(50))
BEGIN
DECLARE total INT;
DECLARE counter INT;
DECLARE t_name VARCHAR(50);
DECLARE remove VARCHAR(100);

Create Temporary Table IF NOT EXISTS final  (t_id SERIAL, name VARCHAR(50));

INSERT INTO final (name)
SELECT Table_name
FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = dbname
AND Table_name NOT IN ('fn_lookups', 'fn_tilesinfo', 'fn_profanity_words');

SELECT COUNT(t_id) FROM final INTO total;

SET counter := 1;

WHILE (counter <= total  )
DO
	SELECT name FROM final WHERE t_id = counter INTO t_name;
	SET @s = CONCAT('TRUNCATE', ' ', t_name);
	PREPARE remove FROM @s;
	EXECUTE remove;
SET counter := counter + 1;

END WHILE;

DROP Temporary TABLE IF EXISTS final;



END //
DELIMITER //