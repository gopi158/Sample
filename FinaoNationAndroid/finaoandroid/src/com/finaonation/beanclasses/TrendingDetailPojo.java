package com.finaonation.beanclasses;

import java.io.Serializable;

public class TrendingDetailPojo implements Serializable {
	/**
	 * 
	 */
	private static final long serialVersionUID = -647777507872819079L;
	String Upload_File_Path, Caption, Type, Video_IMG, Video_Source, URl,
			Video_path, Message, Videocaption, Upload_text;

	public String getVideo_IMG() {
		return Video_IMG;
	}

	public void setVideo_IMG(String video_IMG) {
		Video_IMG = video_IMG;
	}

	public String getVideo_Source() {
		return Video_Source;
	}

	public void setVideo_Source(String video_Source) {
		Video_Source = video_Source;
	}

	public String getType() {
		return Type;
	}

	public void setType(String type) {
		Type = type;
	}

	public String getUpload_File_Path() {
		return Upload_File_Path;
	}

	public void setUpload_File_Path(String upload_File_Path) {
		Upload_File_Path = upload_File_Path;
	}

	public String getCaption() {
		return Caption;
	}

	public void setCaption(String caption) {
		Caption = caption;
	}

	public void setVideo_url(String url) {
		URl = url;
	}

	public String getVideo_url() {
		return URl;
	}

	public void setvideo_File_Path(String video) {
		Video_path = video;
	}

	public String getvideo_File_Path() {
		return Video_path;
	}

	public void setMessage(String message) {
		Message = message;
	}

	public String getMessage() {
		return Message;
	}

	public void setVideoCaptiontext(String videocaption) {
		Videocaption = videocaption;

	}

	public String getVideoCaptiontext() {
		return Videocaption;
	}

	public void setUploadtext(String upload_text) {
		Upload_text = upload_text;

	}

	public String getUploadtext() {
		return Upload_text;
	}

}
