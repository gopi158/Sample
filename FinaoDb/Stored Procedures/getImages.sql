DELIMITER //
CREATE PROCEDURE getImages (IN type VARCHAR(150))
BEGIN
select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='type';
END //
DELIMITER ;
