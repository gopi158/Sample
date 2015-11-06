package com.finaonation.beanclasses;

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

import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingFinoDetailsItems {
	private static final String TAG = "GettingFinoDetailsItems";
	String thisHeaderToken;
	FinaoServiceLinks fs;
	String line = "";
	StringBuilder json;

	public GettingFinoDetailsItems(String headerToken) {
		thisHeaderToken = headerToken;
	}

	public ArrayList<InspiredDetailsListPojo> GetFinaoDetailsList(
			String user_Id, String fino_Id, String headerToken) {
		ArrayList<InspiredDetailsListPojo> Finao_AL = new ArrayList<InspiredDetailsListPojo>();
		thisHeaderToken = headerToken;
		fs = new FinaoServiceLinks();
		HttpClient client = new DefaultHttpClient();
		json = new StringBuilder();
		
		HttpPost request = new HttpPost(fs.baseurl());
		MultipartEntity entity = null;
		try {
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("public_posts"));
			entity.addPart("finao_id", new StringBody(fino_Id));
			request.setEntity(entity);
			request.setHeader("Authorization", "Basic " + thisHeaderToken);
			request.setHeader("Finao-Token", thisHeaderToken);
			HttpResponse response = client.execute(request);
			if (Constants.LOG)
				Log.i(TAG, "response=" + response.getStatusLine().toString());
			BufferedReader rd = new BufferedReader(new InputStreamReader(
					response.getEntity().getContent()));
			if (Constants.LOG)
				Log.i("TAG", "BufferedReader is " + rd.toString());
			while ((line = rd.readLine()) != null) {
				json.append(line + System.getProperty("line.separator"));

			}
			if (Constants.LOG)
				Log.v("TAG", "" + json);
			JSONObject jsonobj = new JSONObject(json.toString());

			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = jsonobj.getJSONArray("item");
			if (Constants.LOG)
				Log.i(TAG, "GettingFinoDetailsItems res : " + res.length());
			int length = res.length();
			for (int index = 0; index < length; index++) {
				JSONObject finao = res.getJSONObject(index);
				InspiredDetailsListPojo fhp = new InspiredDetailsListPojo();
				fhp.setF_Udate(finao.getString("updateddate"));
				fhp.setF_Upload_Text(finao.getString("upload_text"));
				if (finao.has("image_urls") && finao.getJSONArray("image_urls").length() > 0) {
					fhp.setF_imagearray(finao.getJSONArray("image_urls"));
					fhp.setF_Video_Img("");
					fhp.setF_Video_playurl("");
					fhp.setF_Type(1);
				} else if (finao.has("videourls") && finao.getJSONArray("videourls").length() > 0) {
					fhp.setF_imagearray(new JSONArray());
					fhp.setF_Video_Img(finao.getString("videoimg"));
					fhp.setF_Video_playurl(finao.getString("videourls"));
					fhp.setF_Type(2);
				} else if (finao.getJSONArray("videourls").length() == 0 && finao.getJSONArray("image_urls").length() == 0) {
					fhp.setF_imagearray(new JSONArray());
					fhp.setF_Video_Img("");
					fhp.setF_Video_playurl("");
					fhp.setF_Type(0);
				}
				Finao_AL.add(fhp);
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
		return Finao_AL;
	}
}
