DELIMITER //
CREATE PROCEDURE listjournal ( IN finao_id INT)
BEGIN
select * from fn_user_finao_journal where finao_id= finao_id;
END //
DELIMITER //
