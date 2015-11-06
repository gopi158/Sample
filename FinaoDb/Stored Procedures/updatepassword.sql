DELIMITER //
CREATE PROCEDURE updatepassword ( IN activekey VARCHAR(128), IN email VARCHAR (128) ) 
BEGIN 
UPDATE fn_users set activkey=activekey where email= email;
END //
DELIMITER //
