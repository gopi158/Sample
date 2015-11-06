DELIMITER //
DROP PROCEDURE IF EXISTS inspired //
CREATE PROCEDURE `inspired`(IN u_name VARCHAR(256), IN usr_id INT)
BEGIN

		DECLARE total INT;
		DECLARE i_type INT;
		DECLARE counter INT;
		DECLARE uniqid INT;
		DECLARE totalfinao INT;
		DECLARE t_inspired INT;
		DECLARE i_id INT;
		DECLARE is_inspired INT;
		DECLARE u_id INT;
		

		CREATE TEMPORARY TABLE IF NOT EXISTS ids  
				(	
					s_inc SERIAL
					, id INT
					, userpostid INT
					, updatetime DATETIME
				);
				TRUNCATE TABLE ids;

		CREATE TEMPORARY TABLE IF NOT EXISTS output  
				(
      					o_id SERIAL
    					, userid INT
    					, username VARCHAR(256)
						, profileimg VARCHAR(500)
    					, inspireuserid INT
    					, upload_text VARCHAR(500)
    					, finaoid INT
    					, name VARCHAR(128)
    					, uploadfilename VARCHAR(1000)
    					, video_url VARCHAR(255)
    					, finao_status INT
    					, updatedate DATETIME
    					, finaomsg VARCHAR(500)
    					, imgurl VARCHAR(255)
    					, uploadid INT
    					, status INT
    					, t_id INT
						, t_name VARCHAR(125)
						, video_img VARCHAR(500)
    					, totalinspired INT
    					, type INT
    					, isinspired INT
    				);
    				TRUNCATE TABLE output;
    				
		IF u_name > 0 
		THEN
			SET i_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO i_id;	
		END IF;    				
		

	IF EXISTS (SELECT userpostid  FROM inspiringpost WHERE inspireduserid = i_id AND isactive = 1)
	THEN
		
		INSERT  INTO ids (id, userpostid, updatetime)
        				SELECT  upload.uploadedby, 	inspire.userpostid, inspire.modification
				FROM    fn_uploaddetails upload
        				INNER JOIN inspiringpost inspire ON upload.uploaddetail_id = inspire.userpostid
				WHERE   inspire.inspireduserid = i_id;
		
		INSERT INTO output 
					(
						userid
							, username
							, profileimg
      						, inspireuserid
      						, upload_text
      						, finaoid
      						, name
      						, uploadfilename
      						, video_url
      						, finao_status
      						, updatedate
      						, finaomsg
      						, imgurl
      						, uploadid
      						, status 
							, video_img
							, t_id
							, t_name
							, totalinspired
							, type
							, isinspired
					)
				
						SELECT  i_id
									, usr.uname
      								, profile.profile_image
      								, upload.uploadedby AS userid
      								, upload.upload_text
      								, finao.user_finao_id
									, CONCAT_WS(  ' ', usr.fname, usr.lname ) AS name
      								, upload.uploadfile_name
      								, video_embedurl
      								, lookup.code
      								, ids.updatetime
      								, finao.finao_msg
      								, info.tile_imageurl
      								, upload.uploaddetail_id
      								, upload.status
      								, upload.video_img
      								, info.tile_id
      								, info.tilename
									, 0
									, 0
									, 0
						FROM    fn_user_finao finao
        								INNER JOIN fn_uploaddetails upload ON finao.user_finao_id = upload.upload_sourceid
        								INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao. finao_status
        								INNER JOIN fn_user_finao_tile tile ON tile.finao_id = finao.user_finao_id
        								INNER JOIN fn_tilesinfo info ON info.tile_id = tile.tile_id
        								AND info.status =1
        								INNER JOIN fn_users usr ON usr.userid = finao.userid
										INNER JOIN fn_user_profile profile ON usr.userid = profile.user_id
        								INNER JOIN ids ON ids.id = upload.uploadedby
                          								AND ids.userpostid = upload.uploaddetail_id
						WHERE   tile.status = 1 AND finao.finao_activestatus =1 GROUP BY (upload.uploaddetail_id) ; 

		
					SELECT COUNT(o_id) FROM output INTO total;
					SET counter := 1;
			
			WHILE (counter <= total)
			DO
			
			SELECT uploadid FROM output WHERE o_id = counter INTO uniqid;
			
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
			
			SELECT  COUNT(inspireduserid) 
			FROM    inspiringpost WHERE userpostid = uniqid into t_inspired;
        								
        	IF EXISTS (SELECT inspiringpostid FROM inspiringpost WHERE userpostid = uniqid AND inspireduserid = i_id )
			THEN
				SET i_type := 1;
			ELSE
				SET i_type := 0;
			END IF;
										
			SET SQL_SAFE_UPDATES = 0;
			UPDATE output
			SET totalinspired = t_inspired
			, type = i_type
			, isinspired = is_inspired
			WHERE userid = i_id AND o_id = counter ;

			SET counter := counter + 1;
			
			END WHILE;
			
	ELSE
		
		SIGNAL SQLSTATE '45001' 
	  	SET MYSQL_ERRNO = 2001;
	  	
	END IF;
	
	SELECT	* FROM output order by updatedate desc;
		
	
DROP TEMPORARY TABLE IF EXISTS ids;
DROP TEMPORARY TABLE IF EXISTS output;
END //
DELIMITER //