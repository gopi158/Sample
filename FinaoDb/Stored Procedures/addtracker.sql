DELIMITER //
CREATE PROCEDURE addtracker (IN tracked_userid INT, IN tracked_tileid INT )
BEGIN
select tracking_id from fn_tracking where tracker_userid=tracked_userid and tracked_userid=tracker_userid and tracked_tileid= tracked_tileid;
END //
DELIMITER //
