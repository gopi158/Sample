package com.finaonation.jsonhelper;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.utils.MD5Utils;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

public class JsonLogin {

	private static final String TAG = "JsonLogin";
	private SharedPreferences Finao_Pref;
	private SharedPreferences.Editor Finao_Preference_Editor;
	String thisHeaderToken;

	public JsonLogin(String headerToken) {
		thisHeaderToken = headerToken;
	}

	public String getJSONfromURL(String Emailid, String Pwds,
			String headertext, Activity act) {
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String Url = fs.baseurl();
		String res = null;
		if (Constants.LOG)
			Log.i(TAG, "Emailid" + Emailid);
		if (Constants.LOG)
			Log.i(TAG, "Pwds" + Pwds);
		if (Constants.LOG)
			Log.i(TAG, "headertext" + headertext);
		Finao_Pref = act.getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		Finao_Preference_Editor = Finao_Pref.edit();
		Finao_Preference_Editor.putString("logtoken", headertext);
		Finao_Preference_Editor.commit();
		try {
			HttpClient httpclient = SingleTon.getInstance().getHttpClient();
			HttpPost httppost = new HttpPost(Url);
			httppost.setHeader("Authorization", "Basic " + headertext);
			httppost.setHeader("Finao-Token", headertext);
			MultipartEntity reqEntity = new MultipartEntity();
			reqEntity.addPart("json", new StringBody("login"));
			reqEntity.addPart("username", new StringBody(Emailid));
			reqEntity.addPart("password", new StringBody(MD5Utils.MD5(Pwds)));
			if (Constants.LOG)
				Log.i(TAG, "reqEntity" + reqEntity);
			httppost.setEntity(reqEntity);
			HttpResponse response = httpclient.execute(httppost);
			if (response.getStatusLine().toString()
					.equalsIgnoreCase("HTTP/1.1 200 OK")) {
				if (Constants.LOG)
					Log.i(TAG, "response" + response.getStatusLine());
				res = Util.convertResponseToString(response);
				if (Constants.LOG)
					Log.i(TAG, "res" + res);
			} else if (response.getStatusLine().toString()
					.equalsIgnoreCase("HTTP/1.1 401 Unauthorized")) {
				res = Util.convertResponseToString(response);
			} else {
				Log.i(TAG, "Status returned from server: " + Url + " "
						+ response.getStatusLine().toString());
			}

		} catch (Exception e) {
			e.printStackTrace();

		}
		return res;
	}

}
