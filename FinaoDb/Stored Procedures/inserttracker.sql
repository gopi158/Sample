DELIMITER //
CREATE PROCEDURE inserttracker (IN tracked_userid INT, IN tracked_tileid INT, IN status INT)
BEGIN
insert into fn_tracking(tracker_userid,tracked_userid,tracked_tileid,status)values
(tracked_userid,tracker_userid,tracked_tileid,status);
END //
DELIMITER //
