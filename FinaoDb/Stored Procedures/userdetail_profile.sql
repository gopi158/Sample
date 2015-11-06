DELIMITER //
CREATE PROCEDURE userdetail_profile (IN userid INT)
BEGIN
select profile_image,mystory from fn_user_profile where user_id= userid;
END //
DELIMITER //
