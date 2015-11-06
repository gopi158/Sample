DELIMITER //
DROP PROCEDURE IF EXISTS search_user //
CREATE PROCEDURE `search_user`(IN search VARCHAR(150))
BEGIN

	DECLARE total INT;
	DECLARE usrid INT;
	DECLARE counter INT;
	DECLARE totalfinao INT;
	DECLARE totaltile INT;
	DECLARE totalfollowing INT;
	DECLARE totalfollower INT;
	
	IF (search != '')
	THEN
        CREATE TEMPORARY TABLE IF NOT EXISTS result
            (
				id SERIAL
             	, name VARCHAR(55)
            	, resultid INT
            	, username VARCHAR(256)
            	, resulttype VARCHAR(20)
            	, image VARCHAR(255)
            	, bgimg	VARCHAR(255)
                , mystory VARCHAR(4000)
				, totaltiles INT
		       	, totalfinaos INT
		       	, totalfollowings INT
				, totalfollowers INT
            );

        INSERT  INTO result (name 
            	, resultid 
            	, username
            	, resulttype 
            	, image 
            	, bgimg
                , mystory
				,  totaltiles 
		       	, totalfinaos 
		       	, totalfollowings 
				, totalfollowers)
               				 SELECT CONCAT_WS(' ', usr.fname, usr.lname) AS name
     						, usr.userid
     						, usr.uname
      						, 'user'
      						, profile.profile_image
      						, profile.profile_bg_image
      						, profile.mystory
							, 0
							, 0
							, 0
							, 0
 					FROM   fn_users usr
        						LEFT OUTER JOIN fn_user_profile profile ON usr.userid = profile.user_id
        						AND usr.status = 1
 					WHERE  usr.fname LIKE CONCAT('%',search, '%')
        						OR usr.lname LIKE CONCAT('%',search, '%')
								OR CONCAT_WS(' ', usr.fname, usr.lname) LIKE CONCAT ('%',search, '%');
		
					SELECT count(id) FROM result INTO total;
	
					SET counter := 1;

		WHILE (counter <= total) 
		DO

					SELECT resultid
					FROM result
					WHERE id = counter INTO usrid;

			SELECT  COUNT(user_finao_id)
					FROM    fn_user_finao
					WHERE   userid = usrid
					AND finao_activestatus = 1
					AND finao_status_Ispublic = 1 INTO totalfinao;

            SELECT  COUNT(DISTINCT tile.tile_id)
					FROM    fn_user_finao_tile ftile
                    INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
                                                    AND ftile.userid = usrid
                                                    AND ftile.status = 1
                                                    AND tile.status = 1 INTO totaltile;

			SELECT  COUNT(DISTINCT followerid) AS totalfllwer
					FROM    userfollowers
					WHERE   userid = usrid
					AND isactive = 1  INTO totalfollower ;

			SELECT  COUNT(DISTINCT userid) AS totalfllwing
					FROM    userfollowers
					WHERE   followerid = usrid
					AND isactive = 1  INTO totalfollowing;


					SET SQL_SAFE_UPDATES = 0;
					UPDATE  result
						SET totaltiles = totaltile
		         			, totalfinaos = totalfinao
		         			, totalfollowings = totalfollowing
							, totalfollowers  = totalfollower
						WHERE   id = counter;
		
				SET counter := counter + 1;

		END WHILE;

        INSERT  INTO result (name 
            	, resultid 
            	, resulttype 
            	, image 
                , mystory             
				, totaltiles 
		       	, totalfinaos 
		       	, totalfollowings 
				, totalfollowers)
    SELECT  tilename
            , tilesinfo_id
            , 'tile'
            , tile_imageurl
			, NULL
			, 0
			, 0
			, 0
			, 0
    FROM    fn_tilesinfo
    		WHERE   tilename LIKE CONCAT('%', search, '%') AND status=1;

        SELECT  *
        FROM result limit 20;

		DROP TABLE IF EXISTS result;   

	ELSE

		SIGNAL SQLSTATE '45001' 
		SET MYSQL_ERRNO = 2004;
	END IF;

END //
DELIMITER //