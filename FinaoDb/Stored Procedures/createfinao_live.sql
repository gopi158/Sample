DELIMITER //
CREATE PROCEDURE createfinao_live (IN tile_name VARCHAR(100))
BEGIN
select * from fn_lookups where lookup_type='tiles' and lookup_name= tile_name;
END //
DELIMITER //
