DELIMITER //
CREATE PROCEDURE searchusersdetail (IN username VARCHAR(50))
BEGIN
SELECT t.userid as user_id, t.userid as uid, t. *, t1.user_location, t1.profile_image, t2.* FROM fn_users t LEFT JOIN fn_user_profile t1 ON t.userid = t1.user_id LEFT JOIN ( SELECT t.userid, t.user_finao_id, t.finao_msg, t.finao_status_Ispublic, t.finao_activestatus, t.createddate, t.updatedby, t.updateddate, t.finao_status, t.Iscompleted, t.Isdefault, t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid WHERE t.status =1 AND  t2.tilename LIKE  '%tile_name%' OR t.email LIKE  '%username%' OR t.fname LIKE  '%username%' OR t.lname LIKE  '%username%' OR t.uname LIKE  '%username%';
END //
DELIMITER //
