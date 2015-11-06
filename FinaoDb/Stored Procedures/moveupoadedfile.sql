DELIMITER //
CREATE PROCEDURE moveupoadedfile (IN uploadfile_name VARCHAR(255), IN insert_id INT)
BEGIN
insert into fn_user_profile (user_id, profile_image, createdby, createddate, updatedby, updateddate, temp_profile_image) values (insert_id, uploadfile_name, insert_id, NOW(), insert_id, NOW(), uploadfile_name);
END //
DELIMITER //
