package com.finaonation.addfinao;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.os.StrictMode;
import android.util.Log;

import com.finaonation.utils.Constants;

public class JsonHelper {

	private static final String TAG = "JsonHelper";
	static InputStream is = null;
	static JSONObject jObj = null;
	static String json = "";
	JSONObject jArray = null;
	static String result = "";

	public JSONObject getJSONfromURL(String url, String token,
			MultipartEntity reqEntity) {
		StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder()
				.permitAll().build();
		StrictMode.setThreadPolicy(policy);
		// http post
		try {
			HttpClient httpclient = new DefaultHttpClient();
			HttpPost httppost = new HttpPost(url);
			httppost.setHeader("Authorization", "Basic " + token);
			httppost.setHeader("Finao-Token", token);
			if (reqEntity != null) {
				httppost.setEntity(reqEntity);
			}
			HttpResponse response = httpclient.execute(httppost);
			HttpEntity entity = response.getEntity();
			is = entity.getContent();

		} catch (Exception e) {
			Log.e(TAG, "Error in http connection " + e.toString());
		}

		// convert response to string
		try {
			BufferedReader reader = new BufferedReader(new InputStreamReader(
					is, "UTF-8"), 8);
			StringBuilder sb = new StringBuilder();
			String line = null;
			while ((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}
			is.close();
			result = sb.toString();
			if (Constants.LOG)
				Log.i(TAG, "result" + result.toString());
		} catch (Exception e) {
			Log.e(TAG, "Error converting result " + e.toString());
		}

		// try parse the string to a JSON object
		try {

			jArray = new JSONObject(result);
		} catch (Exception e) {
			Log.e(TAG, "Error parsing data " + e.toString());
		}

		return jArray;
	}
}
