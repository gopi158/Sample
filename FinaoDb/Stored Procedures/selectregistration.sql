DELIMITER //
CREATE PROCEDURE selectregistration (IN email VARCHAR(128))
BEGIN
select userid, socialnetworkid from fn_users where email= email limit 1;
END //
DELIMITER //
