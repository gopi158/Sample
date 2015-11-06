package com.finaonation.beanclasses;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingFinaosList {
	private static final String TAG = "GettingFinaos";
	String User_id, Friend_id, type;
	public static String headerToken;

	public GettingFinaosList(String thisHeaderToken) {
		headerToken = thisHeaderToken;
	}

	FinaoServiceLinks fs;
	String json = "";
	String line = "";
	String Url;

	public ArrayList<FinaosListPojo> GetFinaosList(String _UserID_SPS_Str,
			String F_user_ID, String i, String thisToken) {
		ArrayList<FinaosListPojo> Finao_list = new ArrayList<FinaosListPojo>();
		User_id = _UserID_SPS_Str;
		Friend_id = F_user_ID;
		type = i;
		headerToken = thisToken;

		fs = new FinaoServiceLinks();
		Url = fs.baseurl();
		HttpClient client = new DefaultHttpClient();

		Log.i("url is :", Url);
		HttpPost request = new HttpPost(Url);
		List<NameValuePair> nameValuePairs = null;
		if (type.equalsIgnoreCase("0")) {
			if (Constants.LOG)
				Log.i("bug bug", "if type is 0 ");
			nameValuePairs = new ArrayList<NameValuePair>(2);

		} else {
			if (Constants.LOG)
				Log.i("bug bug", "if type is 1 ");
			nameValuePairs = new ArrayList<NameValuePair>(3);
			nameValuePairs.add(new BasicNameValuePair("otherid", Friend_id));
		}
		nameValuePairs.add(new BasicNameValuePair("userid", User_id));
		nameValuePairs.add(new BasicNameValuePair("type", type));
		nameValuePairs.add(new BasicNameValuePair("json", "finao_list"));
		try {
			if (Constants.LOG)
				Log.i("bug bug",
						"nameValuePairs is " + nameValuePairs.toString());
			request.setHeader("Authorization", "Basic " + headerToken);
			request.setHeader("Finao-Token", headerToken);
			request.setEntity(new UrlEncodedFormEntity(nameValuePairs));
			HttpResponse response = client.execute(request);
			if (Constants.LOG)
				Log.i(TAG, "response=" + response.getStatusLine().toString());
			BufferedReader rd = new BufferedReader(new InputStreamReader(
					response.getEntity().getContent()));
			if (Constants.LOG)
				Log.i("bug bug", "BufferedReader is " + rd.toString());
			while ((line = rd.readLine()) != null) {
				json += line + System.getProperty("line.separator");

			}
			if (Constants.LOG)
				Log.v("Home_Response", "" + json);
			JSONObject jsonobj = new JSONObject(json);

			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = jsonobj.getJSONArray("item");
			if (Constants.LOG)
				Log.i(TAG, "GettingHomeItems res : " + res);
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosListPojo fhp = new FinaosListPojo();
				fhp.setF_FinaoTitle(finao.getString("finao_msg"));
				fhp.setF_FinaoId(finao.getString("finao_id"));
				fhp.setF_Finao_Status(finao.getString("finao_status"));
				fhp.setF_Ispublic_or_Followstatus(finao
						.getString("tracking_status"));
				fhp.setF_Tile_Id(finao.getString("tile_id"));
				Finao_list.add(fhp);
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
		return Finao_list;
	}

}
