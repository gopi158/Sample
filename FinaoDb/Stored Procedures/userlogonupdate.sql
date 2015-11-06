DELIMITER //
CREATE PROCEDURE userlogonupdate (IN facebook VARCHAR(45), IN socialnetworid VARCHAR(150), IN userid INT )
BEGIN
update fn_users set socialnetwork= facebook, socialnetworkid= socialnetworid where userid=userid;
END //
DELIMITER //
