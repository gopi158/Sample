DELIMITER //
CREATE PROCEDURE getfinaoimageorvideosrctype (IN uploadtype VARCHAR(100), IN srctype VARCHAR(100))
BEGIN
select * from fn_lookups where lookup_type=uploadsourcetype and lookup_name=srctype;
END //
DELIMITER //
