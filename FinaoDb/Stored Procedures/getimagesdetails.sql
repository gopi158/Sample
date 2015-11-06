DELIMITER //
CREATE PROCEDURE getimagesdetails (IN type varchar (150))
BEGIN
select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)=type;
END //
DELIMITER ;

