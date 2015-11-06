DELIMITER //
CREATE PROCEDURE registration (IN email VARCHAR(150))
BEGIN
SELECT userid from fn_users where email= email limit 1;	
END // 
DELIMITER //
