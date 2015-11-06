DELIMITER //
CREATE PROCEDURE addtrackerinfo (IN tile_id INT,IN finao_id INT,IN journal_id INT,IN notification_action INT,IN tracked_userid INT)
BEGIN
insert into fn_trackingnotifications(tracker_userid,tile_id,finao_id,journal_id,notification_action,updateby,updateddate,createdby,createddate)values
(tracker_userid,tile_id,finao_id,journal_id,notification_action,tracked_userid,NOW(),tracked_userid,NOW());
END //
DELIMITER //
