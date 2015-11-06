DELIMITER //
CREATE PROCEDURE userdata ( IN user_id INT)
BEGIN
select userid,uname,email,secondary_email,activkey,lastvisit,superuser,profile_image,fname,lname,gender,location,description,dob,age,socialnetwork,socialnetworkid,usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate from fn_users where userid= user_id;
END //
DELIMITER //
