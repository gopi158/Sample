DELIMITER //
CREATE PROCEDURE regeistration_elseselect2 (IN userid INT)
BEGIN
SELECT user.fname, user.lname, profile.mystory, profile.profile_bg_image, profile.profile_image FROM fn_users user, fn_user_profile profile WHERE user.userid=profile.user_id AND user.userid= userid LIMIT 1;
END //
DELIMITER //

