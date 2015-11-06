package com.finaonation.addfinao;

import java.io.Serializable;

public class FinaosPojo implements Serializable{
	private static final long serialVersionUID = 1L;
	String user_tileid;
	String tile_id;
	String tile_name;
	String userid;
	String finao_id;
	String tile_profileImagurl;
	String status;
	String finao_msg;
	String createddate;
	String createdby;
	String updateddate;
	String updatedby;
	String UploadFilePath;
	String Fin_Status_ISPublic;
	String IS_Completed;
	String IsFollow;
	String IsPublic;
	String Uploadtext,Comp;
	String Videoimage;
	String Caption;
	String Videocaption,Isfollow;


	public String getIsPublic() {
		return IsPublic;
	}
	public void setIsPublic(String isPublic) {
		IsPublic = isPublic;
	}
	public String getIsFollow() {
		return IsFollow;
	}
	public void setIsFollow(String isFollow) {
		IsFollow = isFollow;
	}
	public String getIS_Completed() {
		return IS_Completed;
	}
	public void setIS_Completed(String iS_Completed) {
		IS_Completed = iS_Completed;
	}
	public String getFin_Status_ISPublic() {
		return Fin_Status_ISPublic;
	}
	public void setFin_Status_ISPublic(String fin_Status_ISPublic) {
		Fin_Status_ISPublic = fin_Status_ISPublic;
	}
	public String getUploadFilePath() {
		return UploadFilePath;
	}
	public void setUploadFilePath(String uploadFilePath) {
		UploadFilePath = uploadFilePath;
	}
	public String getUser_tileid() {
		return user_tileid;
	}
	public void setUser_tileid(String user_tileid) {
		this.user_tileid = user_tileid;
	}
	public String getTile_id() {
		return tile_id;
	}
	public void setTile_id(String tile_id) {
		this.tile_id = tile_id;
	}
	public String getTile_name() {
		return tile_name;
	}
	public void setTile_name(String tile_name) {
		this.tile_name = tile_name;
	}
	public String getUserid() {
		return userid;
	}
	public void setUserid(String userid) {
		this.userid = userid;
	}
	public String getFinao_id() {
		return finao_id;
	}
	public void setFinao_id(String finao_id) {
		this.finao_id = finao_id;
	}
	public String getTile_profileImagurl() {
		return tile_profileImagurl;
	}
	public void setTile_profileImagurl(String tile_profileImagurl) {
		this.tile_profileImagurl = tile_profileImagurl;
	}
	public String getStatus() {
		return status;
	}
	public void setStatus(String status) {
		this.status = status;
	}
	public String getCreateddate() {
		return createddate;
	}

	public String getFinao_msg() {
		return finao_msg;
	}
	public void setFinao_msg(String finao_msg) {
		this.finao_msg = finao_msg;
	}
	public void setCreateddate(String createddate) {
		this.createddate = createddate;
	}
	public void setUploadtext(String upload_text) {
		this.Uploadtext = upload_text;
	}
	public String getUploadtext() {
		return Uploadtext;
	}
	public String getCreatedby() {
		return createdby;
	}
	public void setCreatedby(String createdby) {
		this.createdby = createdby;
	}
	public String getUpdateddate() {
		return updateddate;
	}
	public void setUpdateddate(String updateddate) {
		this.updateddate = updateddate;
	}
	public String getUpdatedby() {
		return updatedby;
	}
	public void setUpdatedby(String updatedby) {
		this.updatedby = updatedby;
	}
	public void setIs_complete(String comp) {
		Comp=comp;
	}
	public String getIs_complete() {
		return Comp;
	}
	public void setVideoimage(String videoimage) {
		Videoimage=videoimage;
	}

	public String getVideoimage() {
		return Videoimage;
	}
	public void setCaptiontext(String caption) {
		Caption=caption;
	}
	public String getCaptiontext() {
		return Caption;
	}

	public String getVideoCaptiontext() {
		return Videocaption;
	}
	public void setVideoCaptiontext(String videocaption) {
		Videocaption=videocaption;
	}
	public void setfollowStatus(String isfollow) {
		Isfollow=isfollow;
	}
	public String getfollowStatus() {
		return Isfollow;
	}

}
