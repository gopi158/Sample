DELIMITER //
DROP PROCEDURE IF EXISTS tile_post //
CREATE PROCEDURE tile_post (IN t_id INT, IN l_id INT)
BEGIN
	DECLARE lid INT;
	DECLARE id SERIAL;
	
	SET lid := l_id;

	IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE tile_id = t_id)
		THEN
			
		SELECT  id
				, tile.tile_id
      			, tile.tile_name
      			, tile.userid
      			, tile.finao_id
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
      			, CONCAT_WS(' ' , usr.fname , usr.lname) as name
		FROM    fn_user_finao_tile tile
        		INNER JOIN fn_uploaddetails upload ON tile.finao_id = upload.upload_sourceid
        		INNER JOIN fn_user_finao finao ON tile.finao_id = finao.user_finao_id
        		INNER JOIN fn_user_profile profile ON profile.user_id = finao.userid
        		INNER JOIN fn_users usr	ON usr.userid = profile.user_id
		WHERE   tile.tile_id = t_id
        		AND upload.uploadfile_path != ' ' AND finao.finao_activestatus 
        		ORDER BY upload.uploadeddate DESC LIMIT l_id;
        
        ELSE
        		SIGNAL SQLSTATE '45001' 
				SET MYSQL_ERRNO = 2001; 
        END IF;
END //
DELIMITER //