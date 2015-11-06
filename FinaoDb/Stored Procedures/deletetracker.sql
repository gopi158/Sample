DELIMITER //
CREATE PROCEDURE deletetracker (IN tracked_userid INT)
BEGIN
delete from fn_tracking where tracker_userid=tracked_userid and tracked_userid=tracker_userid and tracker_userid=tracked_userid;
END //
DELIMITER //
