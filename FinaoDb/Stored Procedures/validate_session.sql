DELIMITER //
DROP PROCEDURE IF EXISTS validate_session //
CREATE PROCEDURE validate_session (IN sessionid VARCHAR(100))
    BEGIN
        SELECT  userid_id
              , session_time
        FROM    user_session NOLOCK
        WHERE   session_id = sessionid;
    END //
DELIMITER //    
