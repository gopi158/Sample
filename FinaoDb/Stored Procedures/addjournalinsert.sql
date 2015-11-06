DELIMITER //
CREATE PROCEDURE addjournalinsert (IN finao_id INT, IN finao_journal TEXT, IN journal_status INT,IN user_id INT, IN status_value INT, IN createdby INT, IN updatedby INT)
BEGIN
insert into fn_user_finao_journal(finao_id,finao_journal,journal_status,journal_startdate,user_id,status_value,createdby,createddate,updatedby,updateddate)values
(finao_id,finao_journal,journal_status,NOW(),user_id,status_value,createdby,NOW(),updatedby,NOW());
END //
DELIMITER //
