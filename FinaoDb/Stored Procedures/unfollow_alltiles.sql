DELIMITER //
DROP PROCEDURE IF EXISTS unfollow_alltiles //
CREATE PROCEDURE `unfollow_alltiles`(IN u_name VARCHAR (256), IN f_name VARCHAR(256))
BEGIN
	
	DECLARE return_value INT;
	DECLARE uniqid INT;
	DECLARE uniq_til_id INT;
	DECLARE counter INT;
	DECLARE total INT;
	DECLARE u_id INT;
	DECLARE f_id INT;
	
	 	IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;
		
		IF f_name > 0 
		THEN
			SET f_id := f_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = f_name INTO f_id;	
		END IF;
		
	SET autocommit = 0;
	SET return_value := 0;
	
			CREATE TEMPORARY TABLE IF NOT EXISTS tileids
    				(
      				ids SERIAL
    				, t_id INT
    				);
    				
	IF EXISTS (SELECT userid FROM fn_users WHERE userid = u_id )
	THEN
			START TRANSACTION ;
			
			INSERT INTO tileids (t_id)		
				SELECT DISTINCT tile_id FROM fn_user_finao_tile WHERE userid = f_id ORDER BY tile_id;
			
			SELECT COUNT(ids) FROM tileids INTO total;
			
			SET counter :=1;
				
		WHILE (counter <= total)
		DO		
				SELECT t_id FROM tileids WHERE ids= counter INTO uniq_til_id;
			
			IF EXISTS (SELECT userid FROM `userfollowers` WHERE userid = f_id AND followerid = u_id AND tileid = uniq_til_id )
			THEN
				SET SQL_SAFE_UPDATES = 0;
				UPDATE userfollowers
				SET isactive = 0
				WHERE userid = f_id AND followerid = u_id AND tileid = uniq_til_id ;
			ELSE
				SIGNAL SQLSTATE '45001' 
    			SET MYSQL_ERRNO = 2001; 
			END IF ;
		SET counter := counter + 1;
		END WHILE;
		SET return_value := 1;
		ELSE
				SIGNAL SQLSTATE '45001' 
				SET	MYSQL_ERRNO = 2009;
		END IF;	
			
		IF (return_value = 1)
		THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
        
    DROP TEMPORARY TABLE IF EXISTS tileids;
    DROP TEMPORARY TABLE IF EXISTS followed_tile;
        
	END //
	DELIMITER //