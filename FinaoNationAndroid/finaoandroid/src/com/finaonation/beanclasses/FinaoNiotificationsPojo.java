package com.finaonation.beanclasses;

public class FinaoNiotificationsPojo {

	String Tracking_ID,Tracking_UserID,Tracking_TileID,UName,ProfileImage,TileName,Staus,Lname,Fname,Totalfinaos,Totaltiles,Totalfollowings,Finao_msg, Created_Date;

	public String getTracking_ID() {
		return Tracking_ID;
	}

	public void setTracking_ID(String tracking_ID) {
		Tracking_ID = tracking_ID;
	}

	public String getTracking_UserID() {
		return Tracking_UserID;
	}

	public void setTracking_UserID(String tracking_UserID) {
		Tracking_UserID = tracking_UserID;
	}

	public String getTracking_TileID() {
		return Tracking_TileID;
	}

	public void setTracking_TileID(String tracking_TileID) {
		Tracking_TileID = tracking_TileID;
	}

	public String getUName() {
		return UName;
	}

	public void setUName(String uName) {
		UName = uName;
	}

	public String getProfileImage() {
		return ProfileImage;
	}

	public void setProfileImage(String profileImage) {
		ProfileImage = profileImage;
	}

	public String getTileName() {
		return TileName;
	}

	public void setTileName(String tileName) {
		TileName = tileName;
	}

	public String getStaus() {
		return Staus;
	}

	public void setStaus(String staus) {
		Staus = staus;
	}

	public void setLName(String lname) {
		Lname=lname;

	}
	public String getLName() {
		return Lname;
	}

	public void setFName(String fname) {
		Fname=fname;

	}
	public String getFName() {
		return Fname;
	}

	public void setFinaocount(String totalfinaos) {
		Totalfinaos=totalfinaos;

	}
	public String getFinaocount() {
		return Totalfinaos;
	}

	public void setTilecount(String totaltiles) {
		// TODO Auto-generated method stub
		Totaltiles=totaltiles;

	}
	public String getTilecount() {
		return Totaltiles;
	}

	public void setFollowingcount(String totalfollowings) {
		Totalfollowings=totalfollowings;
	}
	public String getFollowingcount() {
		return Totalfollowings;
	}

	public void setStory(String finao_msg) {
		Finao_msg=finao_msg;
	}
	public String getStory() {
		return Finao_msg;
	}

	public void setCreatedDate(String date) {
		Created_Date=date;
	}
	public String getCreatedDate() {
		return Created_Date;
	}
}
