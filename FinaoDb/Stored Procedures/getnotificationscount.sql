DELIMITER //
DROP PROCEDURE IF EXISTS getnotificationscount //
CREATE PROCEDURE getnotificationscount (IN id INT)
BEGIN

IF EXISTS (SELECT userid FROM fn_users WHERE userid =id)
THEN

		SELECT  COUNT(users.userid) totalcount
		FROM    fn_users users 
        		INNER JOIN fn_trackingnotifications notification  ON users.userid = notification.tracker_userid 
        		INNER JOIN fn_user_profile profile  ON users.userid = profile.user_id
        		INNER JOIN fn_lookups lookup  ON  lookup.lookup_id = notification.notification_action
		WHERE   notification.updateby = id
				AND userid != id AND notification.isread = 1 LIMIT 100; 

ELSE
	SIGNAL SQLSTATE '45001' 
	SET MYSQL_ERRNO = 2001; 
END IF;

DROP TEMPORARY TABLE IF EXISTS output;

END //
DELIMITER //