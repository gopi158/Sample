DELIMITER //
CREATE PROCEDURE regeistration_elseinsert (IN email VARCHAR(128), IN fname VARCHAR(128), IN lname VARCHAR(128), IN mageid INT, IN facebookid VARCHAR(150))
BEGIN
INSERT INTO fn_users(email,fname,lname,usertypeid,status,createtime,mageid, socialnetwork, socialnetworkid) values (email,fname,lname,64,1,NOW(),mageid,'facebook',facebookid);
END //
DELIMITER //

