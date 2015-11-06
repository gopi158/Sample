package com.finaonation.jsonhelper;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;
import java.util.Map;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.utils.MD5Utils;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;
import com.google.gson.GsonBuilder;

public class JsonLogin2 {

	private static final String TAG = "JsonLogin";
	private SharedPreferences Finao_Pref;
	private SharedPreferences.Editor Finao_Preference_Editor;
	String thisHeaderToken;

	public JsonLogin2(String headerToken) {
		thisHeaderToken = headerToken;
	}

	public String getJSONfromURL(String Emailid, String Pwds,
			String headertext, Activity act) {
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String Url = fs.baseurl2() + "login";
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
			   Map<String, String> comment = new HashMap<String, String>();
			    comment.put("email", "testuser@test.com");  //Emailid
			    comment.put("password", "testtest"); //Pwds
				//String payLoad =  "{\"email\":\"testuser@test.com\",\"password\":\"testtest\"}";
			    String jsonPayLoad = new GsonBuilder().create().toJson(comment, Map.class);
			    HttpResponse response = makeRequest(Url, jsonPayLoad);						    	
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
	
	public static HttpResponse makeRequest(String uri, String json) {
	    try {
	        HttpPost httpPost = new HttpPost(uri);
	        httpPost.setEntity(new StringEntity(json));
	        httpPost.setHeader("Accept", "application/json");
	        httpPost.setHeader("Content-type", "application/json");
	        return new DefaultHttpClient().execute(httpPost);
	    } catch (UnsupportedEncodingException e) {
	        e.printStackTrace();
	    } catch (ClientProtocolException e) {
	        e.printStackTrace();
	    } catch (IOException e) {
	        e.printStackTrace();
	    }
	    return null;
	}
}
