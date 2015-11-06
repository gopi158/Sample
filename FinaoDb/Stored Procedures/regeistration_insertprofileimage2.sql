DELIMITER //
CREATE PROCEDURE regeistration_insertprofileimage2 (IN insert_id INT)
BEGIN
INSERT INTO fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values (insert_id, insert_id, NOW(), insert_id, NOW());
END //
DELIMITER //

