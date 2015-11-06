DELIMITER //
CREATE PROCEDURE insertprofile (IN user_id INT, IN user_profile_msg VARCHAR(150), IN user_location VARCHAR(100), IN profile_image VARCHAR(255), IN profile_bg_image VARCHAR(255), IN profile_status_Ispublic INT, IN updateddate DATETIME, IN mystory VARCHAR(4000), IN IsCompleted VARCHAR(10))
BEGIN
insert into fn_user_profile(user_id,createdby,updatedby,user_profile_msg,user_location,profile_image,profile_bg_image,profile_status_Ispublic,updateddate,mystory,IsCompleted) values
(user_id,user_id,user_id,user_profile_msg,user_location,profile_image,profile_bg_image,profile_status_Ispublic,NOW(),mystory,iscompleted);
END //
DELIMITER //
