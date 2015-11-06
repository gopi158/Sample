DELIMITER //
CREATE PROCEDURE regeistration_insertuser (IN email VARCHAR(128), IN password VARCHAR(128), IN fname VARCHAR(100), IN lname VARCHAR(100), IN mageid INT)
BEGIN
INSERT INTO fn_users (password,email,fname,lname,usertypeid,status,createtime,mageid)
            				VALUES (password,email,fname,lname,64,1,NOW(),mageid);
END //
DELIMITER //

