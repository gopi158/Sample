DELIMITER //
DROP PROCEDURE IF EXISTS sharepost //
CREATE PROCEDURE `sharepost`(IN finaoid INT, IN id INT, IN userpost_id INT)
BEGIN

    DECLARE tileid INT;
    DECLARE postdata VARCHAR(500);
    DECLARE createby INT;
    DECLARE return_value INT;

	SET autocommit = 0; 
	SET return_value := 0;


	IF EXISTS (SELECT  uploaddetail_id
        FROM    fn_uploaddetails
        WHERE   uploaddetail_id = userpost_id)	
		THEN	
		
	SELECT  fn_user_finao_tile.tile_id
        FROM    fn_user_finao_tile
        WHERE   fn_user_finao_tile.finao_id = finaoid LIMIT 1 INTO tileid;

        SELECT  upload_text
        FROM    fn_uploaddetails
        WHERE   uploaddetail_id = userpost_id INTO postdata;

 	   SELECT  uploadedby
        FROM    fn_uploaddetails
        WHERE   uploaddetail_id = userpost_id INTO createby;        

		START TRANSACTION ;

        INSERT  INTO fn_uploaddetails
                ( uploadtype
                , upload_sourcetype
                , upload_sourceid
                , uploadfile_path
                , upload_text
                , status
                , updatedby
                , updateddate
                , uploadedby
                , uploadeddate
        		)
                SELECT  62
                      , 37
                      , finaoid
                      , 'images/uploads/posts/'
                      , postdata
                      , 1
                      , id		
                      , UTC_TIMESTAMP( )
                      , id
                      , UTC_TIMESTAMP( );

        SELECT  MAX(uploaddetail_id) AS uploadid
        FROM    fn_uploaddetails;

		SET return_value := 1;

	ELSE

		SIGNAL SQLSTATE '45001' SET 
   		MYSQL_ERRNO = 2005;

	END IF;

    IF ( return_value = 1 ) 
        THEN
            COMMIT;
        ELSE
            ROLLBACK;
        END IF;

END //
DELIMITER //

    