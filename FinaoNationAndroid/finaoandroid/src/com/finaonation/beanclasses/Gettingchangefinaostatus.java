package com.finaonation.beanclasses;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class Gettingchangefinaostatus {
	private static final String TAG = "Gettingchangefinaostatus";
	private FinaoServiceLinks FS;
	private String baseurl;
	HttpClient client = new DefaultHttpClient();
	private String json = "";
	private String line = "";
	private String result;
	String headerToken;

	public Gettingchangefinaostatus(String thisHeaderToken) {
		headerToken = thisHeaderToken;
	}

	public String changefinaostatus(String _type, String _statuscode,
			String _user_Id, String _finao_Id, String _is_public) {
		FS = new FinaoServiceLinks();
		baseurl = FS.baseurl();
		HttpPost httppost = new HttpPost(baseurl);

		httppost.setHeader("Authorization", "Basic " + headerToken);
		httppost.setHeader("Finao-Token", headerToken);
		MultipartEntity entity = null;
		try {
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("changefinaostatus"));
			entity.addPart("type", new StringBody(_type));
			entity.addPart("finao_status_ispublic", new StringBody(_is_public));
			entity.addPart("status", new StringBody(_statuscode));
			entity.addPart("finaoid", new StringBody(_finao_Id));
		} catch (Exception e) {
		}
		httppost.setEntity(entity);
		try {
			HttpResponse response = client.execute(httppost);
			if (Constants.LOG)
				Log.i(TAG, "response=" + response.toString());
			BufferedReader rd = new BufferedReader(new InputStreamReader(
					response.getEntity().getContent()));
			if (Constants.LOG)
				Log.i(TAG, "BufferedReader is " + rd.toString());
			while ((line = rd.readLine()) != null) {
				json += line + System.getProperty("line.separator");

			}
			if (Constants.LOG)
				Log.v("Home_Response", "" + json);
			JSONObject jsonobj = new JSONObject(json);
			if ("false" == jsonobj.getString("IsSuccess")) {
				Log.i(TAG, "ZZZ Failed = " + baseurl + " Response: " + json);
			} else {
				result = jsonobj.getString("message").toString();
			}
		} catch (JSONException e) {
			Log.e(TAG, "Error parsing data = " + e.toString());
		} catch (UnsupportedEncodingException e) {
			Log.e(TAG, "UnsupportedEncodingException =  " + e.toString());
		} catch (ClientProtocolException e) {
			Log.e(TAG, "ClientProtocolException =  " + e.toString());
		} catch (IOException e) {
			Log.e(TAG, "IOException =  " + e.toString());
		}

		return result;
	}

}
