DELIMITER //
CREATE PROCEDURE userfinaoid (IN id INT)
BEGIN
SELECT userid FROM  `fn_user_finao` where user_finao_id=id;
END //
DELIMITER //
