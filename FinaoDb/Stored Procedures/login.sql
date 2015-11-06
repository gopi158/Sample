DELIMITER //
CREATE PROCEDURE login (IN uname VARCHAR(55), IN password VARCHAR(128))
BEGIN
SELECT user.fname, user.lname, profile.mystory, profile.profile_bg_image, profile.profile_image , user.userid
FROM fn_users user
INNER JOIN fn_user_profile profile ON user.userid = profile.user_id
WHERE user.uname =  uname
AND user.password =  password;
END //
DELIMITER //
