DELIMITER //
CREATE PROCEDURE updateuploaddetails (IN id INT,IN user_id INT)
BEGIN
update fn_user_finao set updateddate=NOW(),updatedby=user_id where user_finao_id=id;
END //
DELIMITER //
