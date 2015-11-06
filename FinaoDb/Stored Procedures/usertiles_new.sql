DELIMITER //
CREATE PROCEDURE usertiles_new ()
BEGIN
select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path from fn_user_finao_tile fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id join fn_lookups fl JOIN fn_uploaddetails fd on fl.lookup_id=fu.tile_id where lookup_type='tiles' AND fd.upload_sourceid = fu.userid AND `lookup_name` = fu.tile_name AND finao_activestatus =1 and iscompleted=0;
END //
DELIMITER //
