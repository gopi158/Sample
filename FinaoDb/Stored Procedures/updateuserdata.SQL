DELIMITER //
CREATE PROCEDURE updateuserdata (IN uname VARCHAR(100), IN lname VARCHAR(100), IN location VARCHAR(100), IN updatedby INT, IN user_id INT)
BEGIN
update fn_users set uname= uname, fname=fname, lname=lname, location=location, updatedby=updatedby, updatedate=NOW() where userid=user_id;
END //
DELIMITER //
