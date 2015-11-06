DELIMITER //
CREATE PROCEDURE getimagesrctype (IN srctype varchar (150))
BEGIN
select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)=srctype;
END //
DELIMITER ;

