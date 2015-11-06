package com.finaonation.profile;

import java.util.ArrayList;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.util.Log;

import com.finaonation.addfinao.FinaosPojo;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingFriendFinaos {
	public ArrayList<FinaosPojo> GetFriendFianoswithUserID(String Tile_ID,
			String User_ID, String Original_UserID) {

		ArrayList<FinaosPojo> Finao_AL = new ArrayList<FinaosPojo>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.NameSpace();
		String str1 = str + "listfinos&tile_id=" + Tile_ID + "&user_id="
				+ User_ID + "&ispublic=1&actual_user_id=" + Original_UserID
				+ "";
		String Friend_URL_Str = str1;
		String url = Friend_URL_Str.replace(" ", "%20");

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Friend_Finao_List_Url", url);

		JSonHelper jh = new JSonHelper();
		JSONObject json1 = jh.getJSONfromURL(url, "THIS IS BAD");

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Finao_Response", "" + json1);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json1.getJSONArray("res");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosPojo fp = new FinaosPojo();

				fp.setUser_tileid(finao.getString("user_tileid"));
				fp.setTile_id(finao.getString("tile_id"));
				fp.setTile_name(finao.getString("tile_name"));
				fp.setUserid(finao.getString("userid"));
				fp.setFinao_id(finao.getString("finao_id"));
				// fp.setTile_profileImagurl("tile_profileImagurl");
				fp.setStatus(finao.getString("finao_status"));
				fp.setFin_Status_ISPublic(finao
						.getString("finao_status_Ispublic"));
				fp.setIsPublic(finao.getString("finao_status_Ispublic"));
				fp.setIsFollow(finao.getString("isfollow"));
				String datestr = finao.getString("createddate");
				String month = datestr.substring(5, 7);
				String date = datestr.substring(8, 10);
				String month_name = null;

				if (month.equalsIgnoreCase("01")) {
					month_name = "Jan";
				} else if (month.equalsIgnoreCase("02")) {
					month_name = "Feb";
				} else if (month.equalsIgnoreCase("03")) {
					month_name = "Mar";
				} else if (month.equalsIgnoreCase("04")) {
					month_name = "Apr";
				} else if (month.equalsIgnoreCase("05")) {
					month_name = "May";
				} else if (month.equalsIgnoreCase("06")) {
					month_name = "Jun";
				} else if (month.equalsIgnoreCase("07")) {
					month_name = "Jul";
				} else if (month.equalsIgnoreCase("08")) {
					month_name = "Aug";
				} else if (month.equalsIgnoreCase("09")) {
					month_name = "Sep";
				} else if (month.equalsIgnoreCase("10")) {
					month_name = "Oct";
				} else if (month.equalsIgnoreCase("11")) {
					month_name = "Nov";
				} else if (month.equalsIgnoreCase("12")) {
					month_name = "Dec";
				}

				String final_date = date + " " + month_name;
				fp.setCreateddate(final_date);

				fp.setFinao_msg(finao.getString("finao_msg"));
				if (!finao.has("finao_image")) {

				} else {
					fp.setUploadFilePath(finao.getString("finao_image"));
				}
				Finao_AL.add(fp);

			}

		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Finao_AL;
	}
}
