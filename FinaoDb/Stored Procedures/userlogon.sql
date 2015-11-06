DELIMITER //
CREATE PROCEDURE userlogon (IN email VARCHAR(128), IN pwd VARCHAR(55))
BEGIN
select * from fn_users where email= email and password=pwd;
END //
DELIMITER //
