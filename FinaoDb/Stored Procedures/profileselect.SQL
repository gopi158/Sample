DELIMITER //
CREATE PROCEDURE profileselect (IN userid INT)
BEGIN
SELECT `fname` , `lname` , fu.profile_image FROM fn_users u LEFT JOIN fn_user_profile fu ON fu.user_id = u.userid WHERE fu.user_id =userid;
END //
DELIMITER //
