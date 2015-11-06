DELIMITER //
CREATE PROCEDURE userlogonselectres (IN pwd VARCHAR(55))
BEGIN
select * from fn_users where socialnetworkid= pwd;
END //
DELIMITER //
