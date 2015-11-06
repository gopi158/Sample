DELIMITER //
CREATE PROCEDURE userprofiledetail ( IN user_id INT)
BEGIN
select * from fn_user_profile where user_id= user_id ;
END //
DELIMITER //
