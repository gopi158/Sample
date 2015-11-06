DELIMITER //
CREATE PROCEDURE profileimage (IN insert_id INT)
BEGIN
insert into fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values (insert_id, insert_id, NOW(), insert_id, NOW());
END //
DELIMITER //
