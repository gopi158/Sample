DELIMITER //
CREATE PROCEDURE listtrackfinao ()
BEGIN
select * from fn_trackingnotifications where trackingnotification_id<>'';
END //
DELIMITER //
