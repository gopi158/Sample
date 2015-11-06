package com.finaonation.beanclasses;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingPostDetailsitem {
	String thisHeaderToken;
	private static final String TAG = "GettingPostDetailsitem";

	public GettingPostDetailsitem(String headerToken, String user_ID) {
		thisHeaderToken = headerToken;
	}

	String Url, res;

	public ArrayList<InspiredDetailsListPojo> GetPostDetailsList(
			String headertext, String User_ID) {
		ArrayList<InspiredDetailsListPojo> post_AL = new ArrayList<InspiredDetailsListPojo>();
		FinaoServiceLinks fs = new FinaoServiceLinks();
		Url = fs.baseurl();
		res = null;
		if (Constants.LOG)
			Log.i(TAG, "headertext" + headertext);
		try {
			HttpClient httpclient = SingleTon.getInstance().getHttpClient();
			HttpPost httppost = new HttpPost(Url);
			httppost.setHeader("Authorization", "Basic " + headertext);
			httppost.setHeader("Finao-Token", thisHeaderToken);
			MultipartEntity reqEntity = new MultipartEntity();
			reqEntity.addPart("userid", new StringBody(User_ID));
			reqEntity.addPart("json", new StringBody("finaorecentposts"));
			httppost.setEntity(reqEntity);
			HttpResponse response = httpclient.execute(httppost);
			res = Util.convertResponseToString(response);
			if (Constants.LOG)
				Log.i(TAG, "res" + res);

			JSONObject job = new JSONObject(res);
			if (job.getBoolean("IsSuccess")) {
				JSONArray jarry = job.getJSONArray("item");
				if (Constants.LOG)
					Log.i(TAG, "jarry length res : " + jarry.length());
				int length = jarry.length();
				for (int index = 0; index < length; index++) {
					JSONObject finao = jarry.getJSONObject(index);
					InspiredDetailsListPojo fhp = new InspiredDetailsListPojo();
					fhp.setF_Caption(finao.getString("finao_msg"));
					fhp.setF_FinaoID(finao.getString("finao_id"));
					fhp.setF_Is_Inspired(finao.getString("isinspired"));
					fhp.setF_Post_ID(finao.getString("uploaddetail_id"));
					fhp.setF_Finao_Status(finao.getString("finao_status"));
					try {
						fhp.setF_Udate(finao.getString("updateddate"));
					} catch (JSONException e) {
						Log.e(TAG, "Missing data = " + e.toString());
					}
					try {
						if (!finao.getString("upload_text").equalsIgnoreCase(
								"null"))
							fhp.setF_Upload_Text(finao.getString("upload_text"));
						else
							fhp.setF_Upload_Text("");
					} catch (JSONException e) {
						Log.e(TAG, "Missing data = " + e.toString());
					}
					try {
						fhp.setF_Type(finao.getInt("type"));
					} catch (JSONException e) {
						Log.e(TAG, "Missing data = " + e.toString());
					}
					
					if (finao.has("image_urls") && finao.getJSONArray("image_urls").length() > 0) {
							fhp.setF_imagearray(finao.getJSONArray("image_urls"));
							fhp.setF_Video_Img("");
							fhp.setF_Video_playurl("");
					}
					else if (finao.has("videourls") && finao.getJSONArray("videourls").length() > 0) {
						fhp.setF_imagearray(finao.getJSONArray("videourls"));
						fhp.setF_Video_Img(finao.getString("videoimg"));
					}
					else{
						fhp.setF_imagearray(new JSONArray());
						fhp.setF_Video_Img("");
						fhp.setF_Video_playurl("");
					}
					post_AL.add(fhp);
				}
			}
		} catch (JSONException e) {
			e.printStackTrace();
			Log.e(TAG, "Error parsing data = " + e.toString());
		} catch (UnsupportedEncodingException e) {
			Log.e(TAG, "UnsupportedEncodingException =  " + e.toString());
		} catch (ClientProtocolException e) {
			Log.e(TAG, "ClientProtocolException =  " + e.toString());
		} catch (IOException e) {
			Log.e(TAG, "IOException =  " + e.toString());
		}

		return post_AL;
	}
}
