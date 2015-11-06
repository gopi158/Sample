DELIMITER //
CREATE PROCEDURE getimageorvideodetailssrctype (IN uploadsourcetype VARCHAR(150), IN srctype VARCHAR(150))
BEGIN
select * from fn_lookups where lookup_type=uploadsourcetype and lookup_name=srctype;
END //
DELIMITER //
