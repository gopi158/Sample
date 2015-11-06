DELIMITER //
CREATE PROCEDURE registrationinsert (IN password VARCHAR(128), IN email VARCHAR(128) , IN fname VARCHAR(100), IN lname VARCHAR(100), IN mageid INT)
BEGIN
insert into fn_users(password,email,fname,lname,usertypeid,status,createtime,mageid) 
            				values (password,email,fname,lname ,64,1,NOW(), mageid);
END // 
DELIMITER //
