DELIMITER //
DROP PROCEDURE IF EXISTS user_session //
CREATE PROCEDURE `user_session`( IN token VARCHAR(100), IN email VARCHAR(100), IN expiretime VARCHAR(100))
BEGIN 
	IF (email <> ' ')
	THEN
        INSERT  INTO user_session
                ( session_id, user_id, session_time )
        SELECT  token, email, expiretime;
	ELSE      
	UPDATE user_session
	SET session_time = expiretime
	WHERE session_id = token;
    END IF;
END //
DELIMITER //
