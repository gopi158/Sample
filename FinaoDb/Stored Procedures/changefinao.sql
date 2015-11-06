DELIMITER //
CREATE PROCEDURE changefinao (IN finao_id INT, IN finao_msg VARCHAR(200))
BEGIN
update fn_user_finao set finao_msg= finao_msg where user_finao_id= finao_id;
END //
DELIMITER //
