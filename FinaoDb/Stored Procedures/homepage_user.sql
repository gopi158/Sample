DELIMITER //
DROP PROCEDURE IF EXISTS homepage_user //
CREATE PROCEDURE `homepage_user`(IN u_name VARCHAR(256), IN s_index INT, IN count INT)
BEGIN
	
 DECLARE countvar INT;
 DECLARE updated_by INT;
 DECLARE counter INT;
 DECLARE total_inspire INT;
 DECLARE is_inspire INT;
 DECLARE postid INT;
 DECLARE u_id INT;

 SET s_index = ifnull(s_index, 0);
 SET count = ifnull(count, 25);

DROP TEMPORARY TABLE IF EXISTS updated;
 CREATE TEMPORARY TABLE updated
    (
      id SERIAL
    , updatedby INT
    )ENGINE=MEMORY;


 DROP TEMPORARY TABLE IF EXISTS final; 
 CREATE  TEMPORARY TABLE final
    (
      f_id SERIAL
    , tile_id INT
    , finao_id INT
    , lookup_name VARCHAR(150)
    , updateby INT
    , username VARCHAR(256)
    , uploadname VARCHAR(255)
    , tile_name VARCHAR(255)
    , finao_msg VARCHAR(200)
    , finao_status INT
    , profile_image VARCHAR(255)
    , name VARCHAR(200)
    , uploaddetail_id INT
    , uploadtype INT
    , videoimg VARCHAR(255)
    , video_url VARCHAR(4000)
    , video_caption VARCHAR(100)
    , upload_text VARCHAR(250)
    , updateddate DATETIME
    , isinpired INT
    )ENGINE=MEMORY;
 
 		IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;
 
 INSERT INTO final 
	 (tile_id
      , finao_id
      , lookup_name
      , updateby
      , username
      , uploadname
      , tile_name
      , finao_msg
      , finao_status
      , profile_image
      , name
      , uploaddetail_id
      , uploadtype
      , videoimg
      , video_url
      , video_caption
      , upload_text
      , updateddate 
      , isinpired
      )

SELECT tile.tile_id
      , finao.user_finao_id
	, ' '
      , upload.updatedby
      , usr.uname
      , upload.uploadfile_name
      , t_ile.tilename
      , finao.finao_msg
      , lookup.code
      , profile.profile_image
      , CONCAT(usr.fname, ' ', usr.lname) AS profile_name
      , upload.uploaddetail_id
      , upload.uploadtype
      , upload.video_img
      , upload.video_embedurl
      , upload.video_caption
      , upload.upload_text
      , upload.updateddate
      , 0
FROM userfollowers follow
INNER JOIN fn_user_finao_tile tile ON follow.userid = tile.userid and follow.tileid = tile.tile_id
INNER JOIN fn_tilesinfo t_ile ON t_ile.tile_id = tile.tile_id
INNER JOIN fn_user_finao finao ON finao.user_finao_id = tile.finao_id
INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status 
INNER JOIN fn_uploaddetails upload ON upload.upload_sourceid = finao.user_finao_id 
INNER JOIN fn_user_profile profile ON profile.user_id = follow.userid
INNER JOIN fn_users usr ON usr.userid = profile.USER_ID
WHERE follow.followerid = u_id AND tile.status = 1 AND upload.status = 1
ORDER BY upload.updateddate DESC LIMIT 100;

INSERT INTO updated
        ( updatedby )
        SELECT  updateby
        FROM    final;

SELECT  COUNT(id)
FROM    updated INTO countvar;

SET counter:= 1;

WHILE (counter <= countvar) DO

SELECT updatedby from updated where updated.id = counter INTO updated_by; 

SELECT uploaddetail_id FROM final WHERE f_id = counter INTO postid;

	SET is_inspire := 0;
	IF EXISTS (SELECT inspiringpostid FROM inspiringpost WHERE userpostid = postid AND inspireduserid = u_id AND isactive = 1)
	THEN
	SET is_inspire := 1;
	END IF;

	UPDATE  final
		SET  isinpired = is_inspire
		WHERE   final.f_id = counter;

 	SET counter := counter + 1;

	END WHILE;
     
SELECT  *
FROM    final
WHERE f_id >= s_index AND f_id < s_index + count
ORDER BY updateddate DESC;

DROP TEMPORARY TABLE IF EXISTS final;
DROP TEMPORARY TABLE IF EXISTS updated;
 
END //
DELIMITER //