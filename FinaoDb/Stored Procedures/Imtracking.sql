DELIMITER //
CREATE PROCEDURE Imtracking (IN tracked_userid INT)
BEGIN
select ft.trackingnotification_id, ft.tracker_userid, ft.tile_id ,ft.finao_id, ft.journal_id, fu.uname, fp.profile_image, ftl.tile_name from fn_trackingnotifications ft join fn_users fu  join  fn_user_profile fp join fn_user_finao_tile ftl on ft.tile_id=ftl.tile_id and fu.userid=fp.user_id and ft.tracker_userid = fu.userid  where updateby=tracker_userid ;
END //
DELIMITER //
