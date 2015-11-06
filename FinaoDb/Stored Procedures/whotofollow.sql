DELIMITER //
DROP PROCEDURE IF EXISTS whotofollow //
CREATE PROCEDURE `whotofollow`(IN u_name VARCHAR(256) )
BEGIN              

/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section START-----------------------------------    
*********************************************************************************************************/

		DECLARE counter INT;
		DECLARE total INT;
		DECLARE uniqueuserid INT;
		DECLARE totalinspired INT;
		DECLARE totaltiles INT;
		DECLARE totalfinaos INT;
		DECLARE user_id INT;

/********************************************************************************************************               
--------------------VARIABLE DECLARATION---------------section END-----------------------------------    
*********************************************************************************************************/    



/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section START----------------------------- 
*********************************************************************************************************/

		CREATE TEMPORARY TABLE IF NOT EXISTS whotofollowusers
			(
			id serial
			, userid INT
			, username VARCHAR(256)
			, usrname VARCHAR(255)
			, image VARCHAR(255)
			, tiles INT
			, finaos INT
			, inspired INT
			);
		TRUNCATE TABLE whotofollowusers;

/********************************************************************************************************               
----------------------- TEMP TABLE DECLARATION---------------section END----------------------------- 
*********************************************************************************************************/ 

	 	IF u_name > 0 
		THEN
			SET user_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO user_id;	
		END IF;

	IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = user_id)
	THEN
			INSERT  INTO whotofollowusers
		        	( userid
		        	, username
        			, usrname
        			, image
        			)

        		SELECT DISTINCT
        		        user.userid
        		      , user.uname  
        		      , CONCAT_WS (' ',user.fname, user.lname) AS name
        		      , profile.profile_image
        		FROM    fn_users AS user 
        		       	INNER JOIN fn_user_profile profile ON user.userid = profile.user_id
			INNER JOIN fn_user_finao_tile tile ON tile.userid = user.userid
			INNER JOIN fn_tilesinfo track  ON track.tilename = tile.tile_name AND user.userid NOT IN (SELECT  userid
        			FROM    userfollowers
        			WHERE   followerid = user_id
				)
        		WHERE   user.userid != user_id 
        		ORDER BY user.userid;
	
			SELECT  COUNT(id)
			FROM    whotofollowusers NOLOCK INTO total;

			SET counter:= 1;

		WHILE (counter <= total) DO 

			SELECT  userid
			FROM    whotofollowusers NOLOCK
			WHERE   id = COUNTER INTO uniqueuserid;

			SELECT  COUNT(ip.inspiringpostid)
			FROM    inspiringpost ip 
	        		INNER JOIN fn_uploaddetails upload 
					ON ip.userpostid = upload.uploaddetail_id
			WHERE   ip.inspireduserid = uniqueuserid INTO totalinspired;

           SELECT  COUNT(DISTINCT fn_tilesinfo.tile_id  )
						FROM fn_user_finao_tile 
						INNER JOIN fn_tilesinfo ON 
						fn_user_finao_tile.tile_id= fn_tilesinfo.tile_id 
						WHERE fn_user_finao_tile.STATUS = 1 
						And fn_user_finao_tile.userid = uniqueuserid
						AND fn_tilesinfo.STATUS = 1 INTO totaltiles;

			SELECT  COUNT(finao.user_finao_id)
			FROM    fn_user_finao finao
					INNER JOIN fn_user_finao_tile ftile ON finao.user_finao_id = ftile.finao_id
					INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
			WHERE   finao.finao_activestatus = 1
					AND tile.status = 1
					AND finao.userid = uniqueuserid
					AND finao.finao_status_Ispublic = 1 INTO totalfinaos;

			UPDATE  whotofollowusers
			SET     tiles = totaltiles
		      		, finaos = totalfinaos
		      		, inspired = totalinspired
			WHERE   id = counter;

			SET counter := counter + 1;

		END WHILE;

		SELECT  *
		FROM    whotofollowusers ORDER BY inspired DESC, finaos DESC, tiles DESC LIMIT 3;

	ELSE
			SIGNAL SQLSTATE '45001' SET 
      			MYSQL_ERRNO = 2001; 
	END IF;

	DROP TABLE IF EXISTS whotofollowusers;

END //
DELIMITER //