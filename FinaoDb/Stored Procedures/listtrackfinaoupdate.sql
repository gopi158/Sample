DELIMITER //
CREATE PROCEDURE listtrackfinaoupdate (IN finao_journal_id INT, IN finao_journal TEXT, IN journal_status INT )
BEGIN
update fn_user_finao_journal set finao_journal=finao_journal,journal_status= journal_status,status_value=status_value,updatedby=user_id.updateddate= NOW() where finao_journal_id=finao_journal_id;
END //
DELIMITER //
