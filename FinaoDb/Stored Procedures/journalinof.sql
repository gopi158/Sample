DELIMITER //
CREATE PROCEDURE journalinof (IN id INT)
BEGIN
select finao_id from fn_user_finao_journal where finao_journal_id= id;
END //
DELIMITER //
