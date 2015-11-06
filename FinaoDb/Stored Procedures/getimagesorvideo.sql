DELIMITER //
CREATE PROCEDURE getimagesorvideo (IN uploadtype VARCHAR(150),IN lookup_name VARCHAR(150))
BEGIN
select * from fn_lookups where lookup_type=uploadtype and lookup_name=type;
END //
DELIMITER //
