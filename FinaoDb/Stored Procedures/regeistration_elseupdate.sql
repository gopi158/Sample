DELIMITER //
CREATE PROCEDURE regeistration_elseupdate (IN facebookid VARCHAR(150), IN userid INT)
BEGIN
UPDATE fn_users SET socialnetwork='facebook', socialnetworkid=facebookid where userid= userid LIMIT 1;
END //
DELIMITER //

