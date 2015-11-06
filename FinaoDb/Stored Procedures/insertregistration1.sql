DELIMITER //
CREATE PROCEDURE insertregistration1 (IN email VARCHAR(128), IN fname VARCHAR(100), IN lname VARCHAR(100),IN genval INT, IN mageid INT, IN facebook VARCHAR(45), IN fid VARCHAR(150))
BEGIN
insert into fn_users(email,fname,lname,gender,usertypeid,status,createtime,mageid, socialnetwork, socialnetworkid) 
            				values (email,fname,lname,genval,64,1,NOW(),mageid,facebook,fid);
END //
DELIMITER //
