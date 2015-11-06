DELIMITER //
CREATE PROCEDURE regeistration_elseselect (IN email VARCHAR(128))
BEGIN
SELECT userid, socialnetworkid FROM fn_users WHERE email=email LIMIT 1;
END //
DELIMITER //

