DELIMITER //
CREATE PROCEDURE followingimages (IN tracker_userid INT)
BEGIN
select concat(fname,' ',lname) as uname,fu.profile_image from fn_user_profile fu right join fn_users f on fu.user_id=f.userid where f.userid=tracker_userid;
END //
DELIMITER //
