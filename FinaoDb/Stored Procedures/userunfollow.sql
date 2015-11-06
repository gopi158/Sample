DELIMITER //
DROP PROCEDURE IF EXISTS userunfollow //
CREATE PROCEDURE `userunfollow`(
		IN u_id INT
		, IN f_id INT
		, IN t_id INT
		)
BEGIN
		IF EXISTS (SELECT * FROM userfollowers WHERE userid = f_id AND followerid = u_id)
			THEN
				SET SQL_SAFE_UPDATES = 0;
				UPDATE userfollowers
				SET isactive = 0
				WHERE userid = f_id AND followerid = u_id AND tileid = t_id;
			ELSE
				SIGNAL SQLSTATE '45001' 
    			SET MYSQL_ERRNO = 2001; 
			END IF ;
END //
DELIMITER //