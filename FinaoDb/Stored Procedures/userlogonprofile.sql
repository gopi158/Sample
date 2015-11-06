DELIMITER //
CREATE PROCEDURE userlogonprofile (IN userid INT )
BEGIN
select profile_image,profile_bg_image,mystory  from fn_user_profile where user_id= userid;
END //
DELIMITER //
