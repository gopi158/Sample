DELIMITER //
CREATE PROCEDURE regeistration_insertprofileimage (IN insert_id INT, IN uploadfile_name VARCHAR(255))
BEGIN
INSERT INTO fn_user_profile (user_id, profile_image, createdby, createddate, updatedby, updateddate, temp_profile_image) values (insert_id, uploadfile_name, insert_id, NOW(), insert_id, NOW(),uploadfile_name);
END //
DELIMITER //

