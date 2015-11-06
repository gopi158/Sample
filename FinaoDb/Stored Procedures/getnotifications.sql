DELIMITER //
DROP PROCEDURE IF EXISTS getnotifications //
CREATE PROCEDURE `getnotifications`(IN u_name VARCHAR(256), IN i_ndex INT, IN c_ount INT)
BEGIN

DECLARE id INT;
DECLARE l_imit INT;
DECLARE v_and INT;


 CREATE TEMPORARY TABLE IF NOT EXISTS output
    (
      t_id INT
    );
    
		SET v_and := 1;
		    
			IF i_ndex > 0
			THEN
				SET l_imit := c_ount;	
			END IF;
    
    		IF u_name > 0 
		THEN
			SET id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO id;	
		END IF;

IF EXISTS (SELECT userid FROM fn_users WHERE userid =id)
THEN

		SELECT  concat(users.fname, ' ', users.lname, ' ', lookup.lookup_name) AS action
      			, users.userid
      			, users.uname
      			, profile.profile_image
				, notification.createddate
				, notification.isread
		FROM    fn_users users 
        		INNER JOIN fn_trackingnotifications notification  ON users.userid = notification.tracker_userid 
        		INNER JOIN fn_user_profile profile  ON users.userid = profile.user_id
        		INNER JOIN fn_lookups lookup  ON  lookup.lookup_id = notification.notification_action
		WHERE   notification.updateby = id
				AND userid != id ORDER BY createddate DESC;

	INSERT INTO output (t_id)
	SELECT  DISTINCT users.userid
		FROM    fn_users users 
        	INNER JOIN fn_trackingnotifications notification  ON users.userid = notification.tracker_userid 
        	INNER JOIN fn_user_profile profile  ON users.userid = profile.user_id
        	INNER JOIN fn_lookups lookup  ON  lookup.lookup_id = notification.notification_action
		WHERE   notification.updateby = id
		 ORDER BY notification.createddate DESC LIMIT 100;

	UPDATE fn_trackingnotifications SET isread= 0
	WHERE tracker_userid IN (SELECT t_id FROM output);

ELSE
	SIGNAL SQLSTATE '45001' 
	SET MYSQL_ERRNO = 2001; 
END IF;

DROP TEMPORARY TABLE IF EXISTS output;
END //
DELIMITER //