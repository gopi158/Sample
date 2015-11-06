DELIMITER //
DROP PROCEDURE IF EXISTS public_post //
CREATE PROCEDURE `public_post`(IN f_id INT, IN u_name VARCHAR(256))
BEGIN

/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section START-----------------------------------    
*********************************************************************************************************/

		DECLARE counter INT;
		DECLARE total INT;
		DECLARE uniqueuserid INT;
		DECLARE totalinspire INT;
		DECLARE uuid INT;
		DECLARE inspird INT;
		
/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section END-----------------------------------    
*********************************************************************************************************/    



/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section START----------------------------- 
*********************************************************************************************************/

		CREATE TEMPORARY TABLE IF NOT EXISTS final
			(
			id serial
			, finaoid INT
			, finaomsg VARCHAR(500)
			, finaostatus INT
      		, upload_type INT
      		, uploaddetailid INT
      		, uploadtext VARCHAR(2000)
      		, updatedate DATETIME
      		, imgno INT
      		, video_id INT
      		, videoimg VARCHAR(500)
      		, videourl VARCHAR(500)
      		, uploadsourcetype INT
      		, finaoactivestatus INT
      		, totalinspired INT
      		, uploadfilename VARCHAR(255)
      		, finaouserid INT
            , username VARCHAR(100)
            , isinspired INT
			);

/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section END----------------------------- 
*********************************************************************************************************/ 

		IF u_name > 0 
		THEN
			SET uuid := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO uuid;	
		END IF;

	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE user_finao_id = f_id)
	THEN	
		INSERT INTO final ( finaoid 
					, finaomsg 
					, finaostatus 
      				, upload_type 
      				, uploaddetailid 
      				, uploadtext 
      				, updatedate
      				, video_id
      				, videoimg 
      				, videourl 
      				, uploadsourcetype 
      				, finaoactivestatus
      				, uploadfilename
      				, finaouserid
      				, totalinspired
                    , username
                    , isinspired 
      				)
		
        SELECT  finao.user_finao_id
        		, finao.finao_msg
      			, lookup.code
              	, upload.uploadtype
              	, upload.uploaddetail_id
      			, upload.upload_text
      			, upload.updateddate
      			, upload.videoid
      			, upload.video_img
      			, upload.video_embedurl
      			, upload.upload_sourcetype
      			, finao.finao_activestatus
		       	, upload.uploadfile_name
        		, finao.userid
      			, 0
                , user.uname
                , 0
        FROM    fn_user_finao finao
                INNER JOIN fn_uploaddetails upload ON finao.user_finao_id = upload.upload_sourceid
				INNER JOIN fn_users user ON user.userid = finao.userid
				INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status
        WHERE   user_finao_id = f_id
                AND finao.finao_activestatus = 1 AND lookup.lookup_status = 1;
                
                
        SELECT COUNT(id) FROM final INTO total;
        
        SET counter := 1;
					
		WHILE ( counter <= total )
		DO 
		
		SELECT uploaddetailid FROM final WHERE id = counter INTO uniqueuserid;
		
		SET inspird := 0;
		
		SELECT  COUNT(ip.inspiringpostid)
		FROM    inspiringpost ip 
	       		INNER JOIN fn_uploaddetails upload ON ip.userpostid = upload.uploadedby
		WHERE   upload.uploaddetail_id = uniqueuserid INTO totalinspire;
		
		IF EXISTS (SELECT inspiringpostid FROM inspiringpost WHERE userpostid = uniqueuserid AND inspireduserid = uuid)
		THEN
			SET inspird := 1;
		END IF;				
		
		UPDATE final
		SET totalinspired := totalinspire
			, isinspired := inspird
		WHERE id = counter;
			
		SET counter := counter + 1;
		
		END WHILE;
		
		SELECT * FROM final;
	       
    ELSE
			SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2010; 
	END IF;
	
		DROP TEMPORARY TABLE IF EXISTS final;
	
	END //
	DELIMITER //