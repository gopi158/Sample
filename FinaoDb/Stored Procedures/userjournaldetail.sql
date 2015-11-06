DELIMITER //
CREATE PROCEDURE userjournaldetail (IN finao_id INT)
BEGIN
select * from fn_user_finao_journal where finao_id=finao_id order by finao_journal_id desc;
END //
DELIMITER //
