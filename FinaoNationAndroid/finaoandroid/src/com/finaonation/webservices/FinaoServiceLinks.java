package com.finaonation.webservices;

public class FinaoServiceLinks {
	/* All links will be removed except base url link */
	public String NameSpace() {
		return "http://finaonationb.com/mobilewebservices/api.php?json=";
	}

	public String ProfileImagesLink() {
		return "";
	}

	public String bannerImagesLink() {
		return "";
	}

	public String FinaoImagesLink() {
		return "";
	}

	public String FinaoFullImagesLink() {
		return "http://finaonation.com/images/uploads/";
	}

	public String TileImagesLink() {
		return "";
	}

	public String PostImagesLink() {
		return "";
	}

	public String baseurl() {
		return baseurl2() + "mobile/legacy";
		//return "http://finaonationb.com/mobilewebservices/api.php";
	}

	public String baseurl2() {
		return "http://finaogearqa.com/mobile/";
	}
}