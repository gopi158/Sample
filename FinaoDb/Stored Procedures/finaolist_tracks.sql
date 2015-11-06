DELIMITER //
CREATE PROCEDURE finaolist_tracks ( IN user_id INT, IN actual_user_id INT, IN tile_id INT)
BEGIN
select status as isfollow from fn_tracking where tracker_userid= actual_user_id and tracked_userid= user_id and tracked_tileid= tile_id;
END //
DELIMITER //
