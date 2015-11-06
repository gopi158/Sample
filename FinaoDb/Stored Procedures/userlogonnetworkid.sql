DELIMITER //
CREATE PROCEDURE userlogonnetworkid (IN email VARCHAR(128))
BEGIN
select * from fn_users where email=email;
END //
DELIMITER //
