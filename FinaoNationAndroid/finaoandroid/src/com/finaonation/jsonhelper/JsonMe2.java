package com.finaonation.jsonhelper;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;
import java.util.Map;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;
import com.google.gson.GsonBuilder;

public class JsonMe2 {

		private static final String TAG = "JsonLogin";
		private SharedPreferences Finao_Pref;
		private SharedPreferences.Editor Finao_Preference_Editor;
		static String thisHeaderToken;

		public JsonMe2(String headerToken) {
			thisHeaderToken = headerToken;
		}

		public String getJSONfromURL(Activity act) {
			FinaoServiceLinks fs = new FinaoServiceLinks();
			String Url = fs.baseurl2() + "customer/me";
			String res = null;
			//if (Constants.LOG)
			//	Log.i(TAG, "Emailid" + Emailid);
			try {
				    HttpResponse response = makeRequest(Url);						    	
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
		
		public static HttpResponse makeRequest(String uri) {
		    try {
		    	HttpGet httpGet = new HttpGet(uri);
		    	httpGet.setHeader("Finao-Token", thisHeaderToken);
		    	httpGet.setHeader("Accept", "application/json");
		        return new DefaultHttpClient().execute(httpGet);
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
