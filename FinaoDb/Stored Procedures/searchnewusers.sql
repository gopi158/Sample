DELIMITER //
CREATE PROCEDURE searchnewusers (IN userid INT, IN tile_id INT, IN username VARCHAR(150))
BEGIN
IF (username!='')
select * from fn_users where email like '%username%' or fname like '%username%' or lname like '%username%' or uname like '%username%';
ELSE
SELECT t.userid, t . * , t1.user_location, t1.profile_image, t2 . * FROM fn_users t JOIN fn_user_profile t1 ON t.userid = t1.user_id JOIN ( SELECT t . * , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id WHERE t2.tilename LIKE '%tile_name%' AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid GROUP BY t.fname, t.lname ORDER BY t.fname, t.lname;
END IF;
END //
DELIMITER 
