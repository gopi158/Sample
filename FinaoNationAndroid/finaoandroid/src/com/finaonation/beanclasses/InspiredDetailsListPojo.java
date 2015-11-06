package com.finaonation.beanclasses;

import org.json.JSONArray;

public class InspiredDetailsListPojo {
	int _F_Type;
	String _F_Finao_Image, _F_Video_Img, _F_Video_playurl, _F_Caption, F_FinaoID,
			_F_Upload_Text, _F_Udate, _F_Name, _F_Profile_Image, _F_User_Id, F_Finao_Status, F_Is_Inspired, F_Post_ID;
	public String getF_Post_ID() {
		return F_Post_ID;
	}

	public void setF_Post_ID(String f_Post_ID) {
		F_Post_ID = f_Post_ID;
	}

	public String getF_Is_Inspired() {
		return F_Is_Inspired;
	}

	public void setF_Is_Inspired(String f_Is_Inspired) {
		F_Is_Inspired = f_Is_Inspired;
	}

	public String getF_Finao_Status() {
		return F_Finao_Status;
	}

	public void setF_Finao_Status(String f_Finao_Status) {
		F_Finao_Status = f_Finao_Status;
	}

	public String getF_FinaoID() {
		return F_FinaoID;
	}

	public void setF_FinaoID(String f_FinaoID) {
		F_FinaoID = f_FinaoID;
	}

	public String get_F_User_Id() {
		return _F_User_Id;
	}

	public void set_F_User_Id(String _F_User_Id) {
		this._F_User_Id = _F_User_Id;
	}

	JSONArray _finaoimgurl, _finaovideourl;

	public void setF_Type(int i) {
		_F_Type = i;
	}

	public int getF_Type() {
		return _F_Type;
	}

	public void setF_Name(String name) {
		_F_Name = name;
	}

	public String getF_Name() {
		return _F_Name;
	}

	public void setF_Profile_Image(String image) {
		_F_Profile_Image = image;
	}

	public String getF_Profile_Image() {
		return _F_Profile_Image;
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

	public void setF_Caption(String F_Caption) {
		_F_Caption = F_Caption;
	}

	public String getF_Caption() {
		return _F_Caption;
	}

	public void setF_Upload_Text(String F_Upload_Text) {
		_F_Upload_Text = F_Upload_Text;
	}

	public String getF_Upload_Text() {
		return _F_Upload_Text;
	}

	public void setF_Udate(String F_Udate) {
		_F_Udate = F_Udate;
	}

	public String getF_Udate() {
		return _F_Udate;
	}

	public void setF_imagearray(JSONArray finaoimgurl) {
		_finaoimgurl = finaoimgurl;
	}

	public JSONArray getF_imagearray() {
		return _finaoimgurl;
	}
	
	public void setF_videoarray(JSONArray finaovideourl) {
		_finaovideourl = finaovideourl;
	}

	public JSONArray getF_videoarray() {
		return _finaovideourl;
	}
}
