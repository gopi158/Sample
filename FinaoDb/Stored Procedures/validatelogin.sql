DELIMITER //
CREATE PROCEDURE validatelogin (IN email VARCHAR(128), IN password VARCHAR(128))
BEGIN
SELECT userid FROM fn_users WHERE email= email AND password= password AND status=1;
END //
DELIMITER //
