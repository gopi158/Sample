DELIMITER //
DROP PROCEDURE IF EXISTS finaorecentpost //
CREATE PROCEDURE `finaorecentpost`( IN u_name VARCHAR(256), IN usr_id INT )
BEGIN

/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section START-----------------------------------    
*********************************************************************************************************/

		DECLARE counter INT;
		DECLARE total INT;
		DECLARE uniqueuserid INT;
		DECLARE totalinspire INT;
		DECLARE u_id INT;
		DECLARE is_inspired INT;

/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section END-----------------------------------    
*********************************************************************************************************/    



/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section START----------------------------- 
*********************************************************************************************************/

		CREATE TEMPORARY TABLE IF NOT EXISTS finaoid
			(
			ids INT
			);
			
		CREATE TEMPORARY TABLE IF NOT EXISTS final
			(
			id serial
			, finaoid INT
			, username VARCHAR(256)
			, finaomsg VARCHAR(500)
			, finaostatus INT
      		, upload_type INT
      		, uploaddetailid INT
      		, uploadfile VARCHAR(255)
      		, uploadpath VARCHAR(255)
      		, uploadtext VARCHAR(4000)
      		, updatedate DATETIME
      		, imgno INT
      		, video_id INT
      		, videoimg VARCHAR(500)
      		, videourl VARCHAR(500)
      		, uploadsourcetype INT
      		, finaoactivestatus INT
      		, t_id INT
      		, t_name VARCHAR(125)
      		, totalinspired INT
      		, isinpired INT
			);
			
/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section END----------------------------- 
*********************************************************************************************************/ 

		IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;
	
	
	IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = u_id)
	THEN
			
		INSERT INTO finaoid (ids )
				SELECT  user_finao_id
				FROM    fn_user_finao
				WHERE   userid = u_id
        				AND finao_activestatus = 1
        				AND Iscompleted = 0
				ORDER BY user_finao_id DESC;
				
		INSERT INTO final ( finaoid 
					, username
					, finaomsg 
					, finaostatus 
      				, upload_type 
      				, uploaddetailid
      				, uploadfile
      				, uploadpath 
      				, uploadtext 
      				, updatedate
      				, video_id
      				, videoimg 
      				, videourl 
      				, uploadsourcetype 
      				, finaoactivestatus
      				, t_id
      				, t_name
      				, totalinspired
      				, isinpired
      				)
      			
		SELECT  finao.user_finao_id
				, usr.uname
		      	, finao.finao_msg
      			, lookup.code
      			, upload.uploadtype
      			, upload.uploaddetail_id
      			, upload.uploadfile_name
      			, upload.uploadfile_path
      			, upload.upload_text
      			, upload.updateddate
      			, upload.videoid
      			, upload.video_img
      			, upload.video_embedurl
      			, upload.upload_sourcetype
      			, finao.finao_activestatus
				, tile.tile_id
				, tile.tilename
      			, 0
      			, 0
		FROM    fn_user_finao finao
				INNER JOIN fn_user_finao_tile ftile ON ftile.finao_id = finao.user_finao_id
				INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
        		INNER JOIN fn_uploaddetails upload ON finao.user_finao_id = upload.upload_sourceid
        		INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status
        		AND lookup.lookup_status = 1
        		INNER JOIN fn_users usr ON usr.userid = upload.uploadedby
        		INNER JOIN finaoid fina ON fina.ids = finao.user_finao_id
        		WHERE upload.status = 1; 
        		
        SELECT COUNT(id) FROM final INTO total;
        
        SET counter := 1;
					
		WHILE ( counter <= total )
		DO 
		
		SELECT uploaddetailid FROM final WHERE id = counter INTO uniqueuserid;
		
		IF (u_id <> usr_id)
		THEN
			SET is_inspired := 0;
			IF EXISTS (SELECT inspiringpostid FROM inspiringpost WHERE userpostid = uniqueuserid AND inspireduserid = usr_id AND isactive = 1)
			THEN
				SET is_inspired := 1;	
			END IF;
		ELSE
			SET is_inspired := 0;
			
		END IF;
		
		
		SELECT  COUNT(*)
		FROM    inspiringpost
		WHERE userpostid = uniqueuserid INTO totalinspire;
		
		SET SQL_SAFE_UPDATES = 0;				
		UPDATE final
		SET totalinspired := totalinspire
			, isinpired = is_inspired
		WHERE id = counter;
			
		SET is_inspired := 0;	
		SET counter := counter + 1;
		
		END WHILE;
		
		SET SQL_SAFE_UPDATES = 0;
		UPDATE final
		SET video_id := 0
		WHERE upload_type = 35;
		SET SQL_SAFE_UPDATES = 0;				
		UPDATE final
		SET video_id := 2,
			videoimg := ' '
		WHERE upload_type = 62;
		SET SQL_SAFE_UPDATES = 0;
		UPDATE final
		SET video_id := 1,
			imgno := 0
		WHERE upload_type NOT IN (62, 35);		

	SELECT * FROM final ORDER BY updatedate DESC;
	
	ELSE
			SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2001; 
	END IF;	
	
	DROP TEMPORARY TABLE IF EXISTS final;
	DROP TEMPORARY TABLE IF EXISTS finaoid;

END //
DELIMITER //