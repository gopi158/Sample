DELIMITER //
DROP PROCEDURE IF EXISTS post_list //
CREATE PROCEDURE post_list (IN u_name VARCHAR(256), IN t_id INT)
BEGIN
	
	DECLARE ids INT;
	
		IF u_name > 0 
		THEN
			SET ids := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO ids;	
		END IF;
	
	IF EXISTS (SELECT uploaddetail_id FROM fn_uploaddetails WHERE uploadedby = ids AND status = 1 )	
	THEN
            SELECT  tile.tile_id
                  , tile.tilename
                  , ftile.userid
                  , finao.user_finao_id
                  , tile.status
                  , upload.uploaddetail_id
                  , upload.uploadtype
                  , upload.upload_text
                  , upload.uploadfile_name
                  , upload.uploadfile_path
                  , upload.upload_sourcetype
                  , upload.uploadedby
                  , upload.uploadeddate
                  , upload.videoid
                  , upload.videostatus
                  , upload.video_img
                  , finao.finao_msg
                  , finao.finao_status
                  , finao.iscompleted
                  , profile.profile_image
                  , CONCAT_WS(' ', usr.fname, usr.lname) AS name
            FROM    fn_user_finao_tile ftile
                    INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
                                                    AND ftile.status = 1
                                                    AND tile.status = 1
                    INNER JOIN fn_user_finao finao ON finao.user_finao_id = ftile.finao_id
                                                      AND finao.finao_activestatus = 1
                    INNER JOIN fn_uploaddetails upload ON upload.upload_sourceid = finao.user_finao_id
														AND upload.status = 1
                    INNER JOIN fn_users usr ON usr.userid = ftile.userid
                    INNER JOIN fn_user_profile profile ON profile.user_id = ftile.userid
            WHERE   ftile.userid = ids AND ftile.tile_id = t_id;
            
       ELSE 
       		SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2001;
       
       END IF;

	
	
END //
DELIMITER //