DELIMITER //
CREATE PROCEDURE regeistration_selectuser (IN email VARCHAR(128))
BEGIN
SELECT userid FROM fn_users WHERE email=email LIMIT 1;
END //
DELIMITER //

