DELIMITER //
CREATE PROCEDURE finaodetails ( IN finao_id INT)
BEGIN
select * from fn_user_finao where user_finao_id= finao_id ;
END //
DELIMITER //
