DELIMITER //
CREATE PROCEDURE informationinsert (IN password VARCHAR(128),IN uname VARCHAR(55),IN email VARCHAR(128),
IN secondary_email VARCHAR(128),IN fname VARCHAR(100),IN lname VARCHAR(100),IN gender INT,IN location VARCHAR(100),
IN dob DATE,IN age VARCHAR(20),IN socialnetwork VARCHAR(45),IN socialnetworkid VARCHAR(150),IN usertypeid INT,
IN status INT,IN zipcode INT,IN user_id INT,IN mageid INT)
BEGIN
insert into fn_users(password,uname,email,secondary_email,fname,lname,gender,location,dob,age,socialnetwork,socialnetworkid, 	usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate,activkey,mageid)values(password,uname,email,secondary_email,fname,lname,gender,location,dob,age,socialnetwork,socialnetworkid, usertypeid,status,zipcode,NOW(),user_id,user_id,NOW(),'',mageid);
END //
DELIMITER //
