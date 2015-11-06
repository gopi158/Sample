DELIMITER //
DROP PROCEDURE IF EXISTS updatepost //
CREATE PROCEDURE updatepost (IN finao_id INT, IN journal VARCHAR(500), IN journalstatus INT, IN userid INT, IN statusvalue INT )
BEGIN
INSERT INTO fn_user_finao_journal(finao_id,finao_journal,journal_status,journal_startdate,user_id,status_value,createdby,createddate,updatedby,updateddate) SELECT
finao_id,journal,journal_status,NOW(),user_id,status_value,user_id,NOW(),user_id,NOW();
SELECT last_insert_id () as journal_id;
END //


DELIMITER //
