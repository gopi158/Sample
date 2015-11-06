DELIMITER //
CREATE PROCEDURE getfinaoimageorvideo (IN uploadtype VARCHAR(100), IN type VARCHAR(100))
BEGIN
select * from fn_lookups where lookup_type= uploadtype and lookup_name= type;
END //
DELIMITER //
