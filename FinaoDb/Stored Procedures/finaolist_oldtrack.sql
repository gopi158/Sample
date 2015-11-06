DELIMITER //
CREATE PROCEDURE finaolist_oldtrack (IN user_id INT, IN actual_user_id INT )
BEGIN
select status as isfollow from fn_tracking where tracker_userid= actual_user_id and tracked_userid= user_id;
END //
DELIMITER //
