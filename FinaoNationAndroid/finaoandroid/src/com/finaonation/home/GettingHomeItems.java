package com.finaonation.home;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.beanclasses.FinaoHomePojo;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingHomeItems {
	private static final String TAG = "GettingHomeItems";
	private String thisHeader = "";
	String thisselfUserId = "";

	public GettingHomeItems(String header) {
		thisHeader = header;
	}

	public ArrayList<FinaoHomePojo> GetHomeList(String User_ID, String header,
			String selfUserId) {
		ArrayList<FinaoHomePojo> Home_AL = new ArrayList<FinaoHomePojo>();
		thisselfUserId = selfUserId;
		thisHeader = header;
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String Url = fs.baseurl();
		HttpClient client = new DefaultHttpClient();
		String json = "";
		String line = "";
		Log.i(TAG, Url);
		HttpPost request = new HttpPost(Url);
		request.setHeader("Authorization", "Basic " + thisHeader);
		request.setHeader("Finao-Token", thisHeader);

		try {
			MultipartEntity entity = new MultipartEntity();
			entity.addPart("json", new StringBody("homepage_user"));
			request.setEntity(entity);
			HttpResponse response = client.execute(request);
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

			// Get the element that holds the earthquakes ( JSONArray )
			if ("false" == jsonobj.getString("IsSuccess")) {
				Log.i(TAG, "ZZZ Failed = " + Url + " Response: " + json);
				Log.i(TAG,
						"ZZZ Failed Error message: "
								+ jsonobj.getString("message"));
			} else {
				JSONArray res = jsonobj.getJSONArray("item");
				if (Constants.LOG)
					Log.i(TAG, "GettingHomeItems res : " + res);
				int length = res.length();
				for (int index = 0; index < length; index++) {
					JSONObject finao = res.getJSONObject(index);
					String match = finao.getString("updateby");
					if (match.compareTo(thisselfUserId) != 0) {
						com.finaonation.beanclasses.FinaoHomePojo fhp = new com.finaonation.beanclasses.FinaoHomePojo();

						fhp.setF_Video_Img("");
						fhp.setF_Video_playurl("");
						fhp.setF_Finao_Image("");

						fhp.setF_TitleId(finao.getString("tile_id"));
						fhp.setF_TileName(finao.getString("tile_name"));
						fhp.setF_FinaoId(finao.getString("finao_id"));
						fhp.setF_notification_Satatus(finao
								.getString("notification_status"));
						fhp.setF_Updated(finao.getString("updateby"));
						fhp.setF_FinaoMsg(finao.getString("finao_msg"));
						fhp.setF_FinaoStatus(finao.getString("finao_status"));
						fhp.setProfileImage(finao.getString("profile_image"));
						fhp.setProfileUserName(finao.getString("profilename"));
						fhp.setF_Type(finao.getInt("type"));
						fhp.setF_UploadDetailID(finao
								.getString("uploaddetail_id"));
						fhp.setF_IsInspired(finao.getString("isinspired"));
						fhp.setF_Upload_Text(finao.getString("upload_text"));
						fhp.setF_Udate(finao.getString("updateddate"));

						try {
							JSONArray imageurls = finao
									.getJSONArray("image_urls");
							if (Constants.LOG)
								Log.i(TAG, "imageurls res : " + imageurls);
							fhp.setImageArrayJson(imageurls);
						} catch (Exception e) {
							Log.e(TAG, "Exception =  " + e.toString());
						}
						Home_AL.add(fhp);
					}
				}
			}

		} catch (JSONException e) {
			Log.e(TAG, "Error parsing data = " + e.toString());
			e.printStackTrace();
		} catch (UnsupportedEncodingException e) {
			Log.e(TAG, "UnsupportedEncodingException =  " + e.toString());
			e.printStackTrace();
		} catch (ClientProtocolException e) {
			e.printStackTrace();
			Log.e(TAG, "ClientProtocolException =  " + e.toString());
		} catch (IOException e) {
			e.printStackTrace();
			Log.e(TAG, "IOException =  " + e.toString());
		}
		return Home_AL;
	}
}
