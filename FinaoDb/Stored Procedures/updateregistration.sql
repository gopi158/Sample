DELIMITER //
CREATE PROCEDURE updateregistration (IN userid INT, IN fid VARCHAR(150))
BEGIN
update fn_users set socialnetwork='facebook', socialnetworkid=fid where userid=userid limit 1;
END //
DELIMITER //
