DELIMITER //
DROP PROCEDURE IF EXISTS createfinao //
CREATE PROCEDURE createfinao
    (
      IN user_id INT
    , IN finaomsg VARCHAR(200)
    , IN ispublic_status BIT
    , IN finaostatus INT
    , IN tileid INT
    )
    BEGIN

        DECLARE finaoid INT;
        DECLARE tilename VARCHAR(150);
        DECLARE profileimage VARCHAR(255);
	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF EXISTS (SELECT userid FROM fn_users WHERE userid = user_id AND ispublic_status = 1)
		THEN
		IF EXISTS (SELECT lookup_id FROM fn_lookups WHERE lookup_id = tileid)
			THEN
				START TRANSACTION ;
       				INSERT  INTO fn_user_finao
		                ( userid
                		, finao_msg
                		, finao_status_ispublic
                		, createddate
                		, updatedby
                		, updateddate
                		, finao_status
                		)
                		SELECT  user_id
                		      , finaomsg
                		      , ispublic_status
                		      , NOW()
                		      , user_id
                		      , NOW()
                		      , finaostatus; 

			      SELECT  last_insert_id()
			      INTO    finaoid;
 
			      SELECT  tile_imageurl
			      FROM    fn_tilesinfo
			      WHERE   createdby = user_id
		              OR updatedby = user_id limit 1 INTO profileimage;

			     SELECT  lookup_name
			     FROM    fn_lookups
			     WHERE   lookup_id = tileid limit 1 INTO tilename; 
 
		        INSERT  INTO fn_user_finao_tile
                	( tile_id
	                , tile_name
        	        , userid
        	        , finao_id
        	        , tile_profileImagurl
        	        , status
        	        , createddate
        	        , createdby
        	        , updateddate
        	        , updatedby 
        	        )
        	        SELECT  tileid
        	              , tilename
        	              , user_id
        	              , finaoid
        	              , profileimage
        	              , ispublic_status
        	              , NOW()
        	              , user_id
        	              , NOW()
        	              , user_id;
 			SET return_value := 1;
        		SELECT  finaoid;
		ELSE
			SIGNAL SQLSTATE '45001' SET 
			MYSQL_ERRNO = 2010,
      			MESSAGE_TEXT = 'Tile does not exist!'; 
		END IF ;

	ELSE
		SIGNAL SQLSTATE '45001' SET 
   		MYSQL_ERRNO = 2001,
      		MESSAGE_TEXT = 'User does not exist!'; 
	END IF;

	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;

    END //
DELIMITER //
