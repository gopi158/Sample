package com.finaonation.beanclasses;

import org.json.JSONArray;

@SuppressWarnings("unused")
public class FinaoHomePojo {

	private String _F_TitleId, _ProfileUserName, _F_FinaoId, _F_Caption,
			_F_VideoUrl, _F_VideoImage, F_UploadDetailID, F_IsInspired, F_TileName;

	public String getF_TileName() {
		return F_TileName;
	}

	public void setF_TileName(String f_TileName) {
		F_TileName = f_TileName;
	}

	public String getF_IsInspired() {
		return F_IsInspired;
	}

	public void setF_IsInspired(String f_IsInspired) {
		F_IsInspired = f_IsInspired;
	}

	public String get_F_VideoImage() {
		return _F_VideoImage;
	}

	public void set_F_VideoImage(String _F_VideoImage) {
		this._F_VideoImage = _F_VideoImage;
	}

	private String _F_FinaoMsg, _F_notification_Satatus, _F_Finao_Story;
	private String _F_Updated, _F_FinaoStatus, _F_Upload_Text, _F_Video_Img;
	private String _F_Udate, _ProfileImage, _F_Finao_Image, _F_Video_playurl;
	private int _F_Type, _F_Finao_Count, _F_Title_Count, _F_Followers_Count,
			_F_Following_Count;
	public String getF_UploadDetailID() {
		return F_UploadDetailID;
	}

	public void setF_UploadDetailID(String f_UploadDetailID) {
		F_UploadDetailID = f_UploadDetailID;
	}

	private JSONArray ImageArrayJson, VideoArrayJson;

	public JSONArray getVideoArrayJson() {
		return VideoArrayJson;
	}

	public void setVideoArrayJson(JSONArray videoArrayJson) {
		VideoArrayJson = videoArrayJson;
	}

	public JSONArray getImageArrayJson() {
		return ImageArrayJson;
	}

	public void setImageArrayJson(JSONArray imageArrayJson) {
		ImageArrayJson = imageArrayJson;
	}

	public void setProfileUserName(String ProfileUserName) {
		_ProfileUserName = ProfileUserName;
	}

	public String getProfileUserName() {
		return _ProfileUserName;
	}

	public void setF_TitleId(String F_TitleId) {
		_F_TitleId = F_TitleId;
	}

	public String getF_TitleId() {
		return _F_TitleId;
	}

	public void setF_FinaoId(String F_FinaoId) {
		_F_FinaoId = F_FinaoId;
	}

	public String getF_FinaoId() {
		return _F_FinaoId;
	}

	public void setF_notification_Satatus(String F_notification_Satatus) {
		_F_notification_Satatus = F_notification_Satatus;
	}

	public String getF_notification_Satatus() {
		return _F_notification_Satatus;
	}

	public void setF_Updated(String F_Updated) {
		_F_Updated = F_Updated;
	}

	public String getF_Updated() {
		return _F_Updated;
	}

	public void setF_FinaoStatus(String F_FinaoStatus) {
		_F_FinaoStatus = F_FinaoStatus;
	}

	public String getF_FinaoStatus() {
		return _F_FinaoStatus;
	}

	public void setF_Upload_Text(String F_Upload_Text) {
		_F_Upload_Text = F_Upload_Text;
	}

	public String getF_Upload_Text() {
		return _F_Upload_Text;
	}

	public void setF_Type(int i) {
		_F_Type = i;
	}

	public int getF_Type() {
		return _F_Type;
	}

	public void setF_Udate(String F_Udate) {
		_F_Udate = F_Udate;
	}

	public String getF_Udate() {
		return _F_Udate;
	}

	public void setProfileImage(String ProfileImage) {
		_ProfileImage = ProfileImage;
	}

	public String getProfileImage() {
		return _ProfileImage;
	}

	public void setF_Finao_Image(String F_Finao_Image) {
		_F_Finao_Image = F_Finao_Image;
	}

	public String getF_Finao_Image() {
		return _F_Finao_Image;
	}

	public void setF_Video_Img(String F_Video_Img) {
		_F_Video_Img = F_Video_Img;
	}

	public String getF_Video_Img() {
		return _F_Video_Img;
	}

	public void setF_Video_playurl(String F_Video_playurl) {
		_F_Video_playurl = F_Video_playurl;
	}

	public String getF_Video_playurl() {
		return _F_Video_playurl;
	}

	public void setF_FinaoMsg(String F_FinaoMsg) {
		_F_FinaoMsg = F_FinaoMsg;
	}

	public String getF_FinaoMsg() {
		return _F_FinaoMsg;
	}

	public void setF_Caption(String F_Caption) {
		_F_Caption = F_Caption;
	}

	public String getF_Caption() {
		return _F_Caption;
	}

	public void setF_Finao_Count(int F_Finao_Count) {
		_F_Finao_Count = F_Finao_Count;
	}

	public int getF_Finao_Count() {
		return _F_Finao_Count;
	}

	public void setF_Title_Count(int F_Title_Count) {
		_F_Title_Count = F_Title_Count;
	}

	public int getF_Title_Count() {
		return _F_Title_Count;
	}

	public void setF_Followers_Count(int F_Followers_Count) {
		_F_Followers_Count = F_Followers_Count;
	}

	public int getF_Followers_Count() {
		return _F_Followers_Count;
	}

	public void setF_Following_Count(int F_Following_Count) {
		_F_Following_Count = F_Following_Count;
	}

	public int getF_Following_Count() {
		return _F_Following_Count;
	}

	public void setF_Finao_Story(String F_Finao_Story) {
		_F_Finao_Story = F_Finao_Story;
	}

	public String getF_Finao_Story() {
		return _F_Finao_Story;
	}

	public void setF_Videourl(String string) {
		// TODO Auto-generated method stub

	}

}
