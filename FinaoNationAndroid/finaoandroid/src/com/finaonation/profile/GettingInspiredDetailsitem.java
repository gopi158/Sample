package com.finaonation.profile;

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

import com.finaonation.beanclasses.InspiredDetailsListPojo;
import com.finaonation.utils.Constants;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingInspiredDetailsitem {
	String thisHeaderToken;
	private static final String TAG = "GettingPostDetailsitem";

	public GettingInspiredDetailsitem(String headerToken) {
		thisHeaderToken = headerToken;
	}

	@SuppressWarnings("unused")
	public ArrayList<InspiredDetailsListPojo> GetInspiredDetailsList(
			String headertext, String id) {
		ArrayList<InspiredDetailsListPojo> post_AL = new ArrayList<InspiredDetailsListPojo>();
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String Url = fs.baseurl();
		String json = "";
		String line = "";
		String res = null;
		if (Constants.LOG)
			Log.i(TAG, "headertext" + headertext);
		try {
			HttpClient httpclient = SingleTon.getInstance().getHttpClient();
			HttpPost httppost = new HttpPost(Url);
			httppost.setHeader("Authorization", "Basic " + headertext);
			httppost.setHeader("Finao-Token", thisHeaderToken);
			MultipartEntity reqEntity = new MultipartEntity();
			reqEntity.addPart("json", new StringBody("getinspired"));
			if (id != null)
				reqEntity.addPart("id", new StringBody(id));
			if (Constants.LOG)
				Log.i(TAG, "reqEntity" + reqEntity);
			httppost.setEntity(reqEntity);
			HttpResponse response = httpclient.execute(httppost);
			if (Constants.LOG)
				Log.i(TAG, "response" + response.getStatusLine());
			res = Util.convertResponseToString(response);
			if (Constants.LOG)
				Log.i(TAG, "response: " + res);

			JSONObject job = new JSONObject(res);
			if (job.getBoolean("IsSuccess")) {
				JSONArray jarry = job.getJSONArray("item");
				if (Constants.LOG)
					Log.i(TAG, "jarry length res : " + jarry.length());
				int length = jarry.length();
				for (int index = 0; index < length; index++) {
					JSONObject finao = jarry.getJSONObject(index);
					InspiredDetailsListPojo fhp = new InspiredDetailsListPojo();
					fhp.setF_FinaoID(finao.getString("finao_id"));
					fhp.setF_Is_Inspired(finao.getString("isinspired"));
					fhp.setF_Post_ID(finao.getString("uploaddetail_id"));
					fhp.setF_Caption(finao.getString("finao_msg"));
					fhp.setF_Finao_Status(finao.getString("finao_status"));
					try {
						if (!finao.getString("upload_text").equalsIgnoreCase(
								"null"))
							fhp.setF_Upload_Text(finao.getString("upload_text"));
					} catch (JSONException e) {
						Log.e(TAG, "Missing data = " + e.toString());
					}
					try {
						fhp.setF_Udate(finao.getString("updateddate"));
					} catch (JSONException e) {
						Log.e(TAG, "Missing data = " + e.toString());
					}
					fhp.setF_Name(finao.getString("name"));
					if (!finao.getString("profileimg").equalsIgnoreCase("null"))
						fhp.setF_Profile_Image(finao.getString("profileimg"));
					else
						fhp.setF_Profile_Image("");
					
					fhp.set_F_User_Id(finao.getString("inspireuserid"));
					
					int type = 0;
					try {
						type = finao.getInt("type");
						fhp.setF_Type(finao.getInt("type"));
					} catch (JSONException e) {

						Log.e(TAG, "Missing data = " + e.toString());
					}
					if (finao.getJSONArray("image_urls") != null && finao.getJSONArray("image_urls").length() > 0) {
							fhp.setF_imagearray(finao
									.getJSONArray("image_urls"));
							fhp.setF_Video_Img("");
							fhp.setF_Video_playurl("");
					} else if (finao.getJSONArray("videourls") != null && finao.getJSONArray("videourls").length() > 0) {
						fhp.setF_imagearray(finao
								.getJSONArray("videourls"));
					} else {
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
