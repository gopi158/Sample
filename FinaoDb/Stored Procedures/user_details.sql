DELIMITER //
DROP PROCEDURE IF EXISTS user_details //
CREATE PROCEDURE `user_details`(IN u_name VARCHAR(256))
BEGIN

	DECLARE u_id INT;
	DECLARE totalinspired INT;
	DECLARE totaltiles INT;
	DECLARE totalfinaos INT;
	DECLARE totalfollowers INT;
	DECLARE totalfollowings INT;
	
	 	IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;

			SELECT  COUNT(ip.inspiringpostid)
			FROM    inspiringpost ip 
	        		INNER JOIN fn_uploaddetails upload 
			ON ip.userpostid = upload.uploaddetail_id
			WHERE   ip.inspireduserid = u_id INTO totalinspired;

			SELECT COUNT(DISTINCT info.tile_id) FROM userfollowers user 
			INNER JOIN fn_tilesinfo info ON info.tile_id = user.tileid 
			WHERE user.userid = u_id AND info.status = 1 AND user.isactive = 1 INTO totaltiles;
			
			SELECT  COUNT(finao.user_finao_id)
			FROM    fn_user_finao finao
					INNER JOIN fn_user_finao_tile ftile ON finao.user_finao_id = ftile.finao_id
					INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
			WHERE   finao.finao_activestatus = 1
					AND tile.status = 1
					AND finao.userid = u_id
					AND finao.finao_status_Ispublic = 1 INTO totalfinaos;
			
		SELECT  COUNT(DISTINCT follow.followerid)
		FROM    userfollowers follow
					INNER JOIN fn_users usr ON follow.followerid = usr.userid
					INNER JOIN fn_user_profile profile ON profile.user_id = follow.followerid
					INNER JOIN fn_user_finao_tile ftile ON ftile.userid = follow.followerid
					INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
													AND tile.status = 1
													AND ftile.status = 1
					INNER JOIN fn_user_finao finao ON finao.user_finao_id = ftile.finao_id
													  AND finao.finao_activestatus = 1
					INNER JOIN fn_tracking track ON follow.followerid = track.tracked_userid
													AND track.status = 1
		WHERE   follow.userid = u_id
					AND follow.isactive = 1 INTO totalfollowers ;

        SELECT  COUNT(DISTINCT follow.userid)
        FROM    userfollowers follow
                INNER JOIN fn_users usr ON follow.userid = usr.userid
                INNER JOIN fn_user_profile profile ON profile.user_id = follow.userid
                INNER JOIN fn_user_finao_tile ftile ON ftile.userid = follow.userid
                INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
                                                AND tile.status = 1
                                                AND ftile.status = 1
                INNER JOIN fn_user_finao finao ON finao.user_finao_id = ftile.finao_id
                                                  AND finao.finao_activestatus = 1
                INNER JOIN fn_tracking track ON follow.userid = track.tracker_userid
                                                AND track.status = 1
        WHERE   follow.followerid = u_id
                AND follow.isactive = 1 INTO totalfollowings;

SELECT  usr.userid
      , usr.uname
      , usr.email
      , prfile.profile_image
      , usr.fname
      , usr.lname
      , usr.gender
      , usr.description
      , usr.dob
      , usr.age
      , usr.socialnetwork
      , usr.socialnetworkid
      , usr.usertypeid
      , usr.status
      , usr.createtime
      , usr.createdby
      , usr.updatedby
      , usr.updatedate
      , totalinspired
      , totaltiles
      , totalfinaos
      , totalfollowings
      , totalfollowers
      , prfile.mystory
      , prfile.profile_bg_image
FROM    fn_users usr
        LEFT OUTER JOIN fn_user_profile prfile ON usr.userid = prfile.user_id
WHERE   usr.status = 1
        AND usr.userid = u_id;
END //
DELIMITER //