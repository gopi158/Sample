package com.finaonation.jsonhelper;

import java.io.File;
import java.io.InputStream;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;

import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.utils.MD5Utils;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

public class JsonHelperRegister {

	private static final String TAG = null;
	String res;
	static InputStream is = null;
	String thisHeaderToken;

	public JsonHelperRegister(String headerToken) {
		thisHeaderToken = headerToken;
	}

	public String getJSONfromURL(String type, String Fname, String Lname,
			String Emailid, String PwdsorFid, String mediaFilePathorgender) {
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String Url = fs.baseurl();
		try {
			HttpClient httpclient = SingleTon.getInstance().getHttpClient();
			HttpPost httppost = new HttpPost(Url);
			MultipartEntity reqEntity = new MultipartEntity();
			reqEntity.addPart("type", new StringBody(type));
			reqEntity.addPart("fname", new StringBody(Fname));
			reqEntity.addPart("lname", new StringBody(Lname));
			reqEntity.addPart("email", new StringBody(Emailid));
			reqEntity.addPart("json", new StringBody("registration"));
			httppost.setHeader("Authorization", "Basic " + thisHeaderToken);
			httppost.setHeader("Finao-Token", thisHeaderToken);
			if (type.equalsIgnoreCase("1")) {
				reqEntity.addPart("password",
						new StringBody(MD5Utils.MD5(PwdsorFid)));
				if (mediaFilePathorgender.length() != 0)
					reqEntity.addPart("profilepic", new FileBody(new File(
							mediaFilePathorgender)));
				if (Constants.LOG)
					Log.i(TAG, "mediaFilePathorgender :"
							+ mediaFilePathorgender);
			} else {
				// reqEntity.addPart("gender",new
				// StringBody(mediaFilePathorgender));
				reqEntity.addPart("facebookid", new StringBody(PwdsorFid));
			}

			if (Constants.LOG)
				Log.i(TAG, "reqEntity" + reqEntity);
			httppost.setEntity(reqEntity);
			HttpResponse response = httpclient.execute(httppost);
			if (Constants.LOG)
				Log.i(TAG, "response" + response.getStatusLine());
			res = Util.convertResponseToString(response);

		} catch (Exception e) {
			e.printStackTrace();

		}

		return res;
	}

}
