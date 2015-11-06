DELIMITER //
CREATE PROCEDURE updatetracker (IN tracking_id INT, IN status INT)
BEGIN
update fn_tracking set status=status where tracking_id=tracking_id;
END //
DELIMITER //
