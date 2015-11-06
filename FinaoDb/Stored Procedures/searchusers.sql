DELIMITER //
CREATE PROCEDURE searchusers (IN username VARCHAR(50))
BEGIN
select * from fn_users where status=1 and email like '%username%' or fname like '%username%' or lname like '%username%' or uname like '%username%';
END //
DELIMITER //
