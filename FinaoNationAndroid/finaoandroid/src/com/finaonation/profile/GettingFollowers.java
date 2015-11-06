package com.finaonation.profile;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.util.Log;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.FinaoNiotificationsPojo;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingFollowers {
	private static final String TAG = "GettingFollowers";
	FinaoServiceLinks fs = new FinaoServiceLinks();
	String str;
	String str1;
	String str2;
	String Url, URL_Str;

	public GettingFollowers(String url) {
		Url = url;
	}

	public ArrayList<FinaoNiotificationsPojo> GetFollowersList(String User_ID,
			String token) {
		ArrayList<FinaoNiotificationsPojo> Notifications_AL = new ArrayList<FinaoNiotificationsPojo>();
		URL_Str = fs.baseurl();
		MultipartEntity entity = null; 
		try{
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody(Url));
			if(User_ID != null)
				entity.addPart("id", new StringBody(User_ID));
		}catch(Exception e){}
		
		if (Constants.LOG)
			Log.i(TAG, "URL is :" + URL_Str);

		JsonHelper jh = new JsonHelper();
		JSONObject json = jh.getJSONfromURL(URL_Str, token, entity);

		if (Constants.LOG)
			Log.i(TAG, "Followers_Response :" + json);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("res");
			if (Constants.LOG)
				Log.i(TAG, "res :" + res);
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaoNiotificationsPojo fnp = new FinaoNiotificationsPojo();

				fnp.setTracking_ID(finao.getString("tracked_userid"));
				fnp.setTracking_UserID(finao.getString("tracker_userid"));
				fnp.setTracking_TileID(finao.getString("tile_id"));
				fnp.setUName(finao.getString("fname") + "" + finao.getString("lname"));
				fnp.setLName(finao.getString("lname"));
				fnp.setFName(finao.getString("fname"));
				fnp.setFinaocount(finao.getString("totalfinaos"));
				fnp.setTilecount(finao.getString("totaltiles"));
				fnp.setFollowingcount(finao.getString("totalfollowings"));
				fnp.setProfileImage(finao.getString("image"));
				fnp.setTileName(finao.getString("gptilename"));
				fnp.setStaus(finao.getString("status"));
				if(!finao.getString("mystory").equalsIgnoreCase("null"))
					fnp.setStory(finao.getString("mystory"));
				else
					fnp.setStory("");
				Notifications_AL.add(fnp);

			}

		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Notifications_AL;

	}

}
