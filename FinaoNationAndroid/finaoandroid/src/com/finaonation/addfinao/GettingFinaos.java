package com.finaonation.addfinao;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.util.Log;

import com.finaonation.addfinao.FinaosPojo;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingFinaos {

	private static final String TAG = "GettingFinaos1";

	String URL_Str;

	public ArrayList<FinaosPojo> GetFinaosList(String User_ID, String token) {

		ArrayList<FinaosPojo> Finao_AL = new ArrayList<FinaosPojo>();

		fs = new FinaoServiceLinks();
		str = fs.NameSpace();
		URL_Str = str + "listfinos&tile_id=&user_id=" + User_ID;
		if (Constants.LOG)
			Log.i(TAG, "url is " + URL_Str);

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Finao_List_Url", URL_Str);

		JSonHelper js = new JSonHelper();
		JSONObject json = js.getJSONfromURL(URL_Str, token);

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Finao_Response", "" + json);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("res");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosPojo fp = new FinaosPojo();
				fp.setUser_tileid(finao.getString("user_tileid"));
				fp.setTile_id(finao.getString("tile_id"));
				fp.setTile_name(finao.getString("tile_name"));
				fp.setUserid(finao.getString("userid"));
				fp.setFinao_id(finao.getString("finao_id"));
				fp.setTile_profileImagurl(finao
						.getString("tile_profileImagurl"));
				fp.setStatus(finao.getString("finao_status"));
				fp.setfollowStatus(finao.getString("isfollow"));
				fp.setFin_Status_ISPublic(finao
						.getString("finao_status_Ispublic"));
				fp.setIs_complete(finao.getString("Iscompleted"));
				if (finao.has("upload_text")) {
					fp.setUploadtext(finao.getString("upload_text"));
				} else {
					fp.setUploadtext("");
				}

				if (finao.has("caption")) {
					fp.setCaptiontext(finao.getString("caption"));
				} else {
					fp.setCaptiontext("");
				}
				if (finao.has("video_caption")) {
					fp.setVideoCaptiontext(finao.getString("video_caption"));
				} else {
					fp.setVideoCaptiontext("");
				}

				String datestr = finao.getString("updateddate");
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
				if (!finao.has("video_img")) {
					fp.setVideoimage("");
				} else {
					fp.setVideoimage(finao.getString("video_img"));
				}
				Finao_AL.add(fp);

			}

		} catch (JSONException e) {
			Log.e(TAG, "Error parsing data " + e.toString());
		}

		return Finao_AL;
	}

	FinaoServiceLinks fs;
	String str;
	MultipartEntity entity = null;

	public ArrayList<FinaosPojo> GetFinaosListWithTileID(String Tile_ID,
			String User_ID, String token) {

		ArrayList<FinaosPojo> Finao_AL = new ArrayList<FinaosPojo>();
		fs = new FinaoServiceLinks();
		str = fs.baseurl();
		try {
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("public_finao"));
			entity.addPart("tile_id", new StringBody(Tile_ID));
		} catch (Exception e) {
		}

		URL_Str = str;
		String message;
		if (com.finaonation.utils.Constants.LOG)
			Log.v("Tiles_Finao_List_Url", URL_Str);

		JsonHelper js = new JsonHelper();
		JSONObject json = js.getJSONfromURL(URL_Str, token, entity);

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Tiles_Finao_Response", "" + json);

		try {

			JSONArray res = json.getJSONArray("item");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosPojo fp = new FinaosPojo();

				fp.setTile_id(finao.getString("tile_id"));
				fp.setTile_name(finao.getString("tilename"));
				fp.setFinao_id(finao.getString("finao_id"));
				fp.setStatus(finao.getString("finao_status"));
				fp.setFin_Status_ISPublic(finao
						.getString("finao_status_ispublic"));
				if (finao.has("finao_status")
						&& finao.getString("finao_status")
								.equalsIgnoreCase("1"))
					fp.setIS_Completed(finao.getString("finao_status"));
				if (finao.has("finao_image")
						&& !finao.getString("finao_image").equalsIgnoreCase(""))
					fp.setUploadFilePath(finao.getString("finao_image"));
				if (finao.has("finao_msg")) {
					fp.setFinao_msg(finao.getString("finao_msg"));
				} else {
					if (Constants.LOG)
						Log.v("finao.has else ", "else");
					fp.setFinao_msg("");
				}
				if (finao.has("finao_msg")) {
					fp.setFinao_msg(finao.getString("finao_msg"));
				} else {
					if (Constants.LOG)
						Log.v("finao.has else ", "else");
					fp.setFinao_msg("");
				}

				if (finao.has("createddate")) {
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

				}
				Finao_AL.add(fp);

			}

		} catch (JSONException e) {
			try {
				message = json.getString("message");
				Log.e(TAG, "Error parsing data " + message + " " + e.toString());
			} catch (JSONException e1) {
				Log.e(TAG, "Error parsing data " + e.toString());
			}
		}

		return Finao_AL;
	}

	public ArrayList<FinaosPojo> GetFriendFinaosList(String User_ID,
			String Friend_ID, String token) {

		ArrayList<FinaosPojo> Finao_AL = new ArrayList<FinaosPojo>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.NameSpace();
		String str1 = str + "listfinos&user_id=" + Friend_ID
				+ "&actual_user_id=" + User_ID + "&ispublic=1";
		String URL_Str = str1;

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Friend_Finao_List_Url", URL_Str);

		JSonHelper js = new JSonHelper();
		JSONObject json = js.getJSONfromURL(URL_Str, token);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("res");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosPojo fp = new FinaosPojo();
				fp.setUser_tileid(finao.getString("user_tileid"));
				fp.setTile_id(finao.getString("tile_id"));
				fp.setTile_name(finao.getString("tile_name"));
				fp.setUserid(finao.getString("userid"));
				fp.setFinao_id(finao.getString("finao_id"));
				fp.setIs_complete(finao.getString("Iscompleted"));
				fp.setTile_profileImagurl(finao
						.getString("tile_profileImagurl"));
				fp.setStatus(finao.getString("finao_status"));
				fp.setIsPublic(finao.getString("finao_status_Ispublic"));
				fp.setIsFollow(finao.getString("isfollow"));
				if (finao.has("upload_text")) {
					fp.setUploadtext(finao.getString("upload_text"));
				} else {
					fp.setUploadtext("");
				}

				if (finao.has("caption")) {
					fp.setCaptiontext(finao.getString("caption"));
				} else {
					fp.setCaptiontext("");
				}
				if (finao.has("video_caption")) {
					fp.setVideoCaptiontext(finao.getString("video_caption"));
				} else {
					fp.setVideoCaptiontext("");
				}

				String datestr = finao.getString("updateddate");
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
				if (!finao.has("video_img")) {
					fp.setVideoimage("");
				} else {
					if (Constants.LOG)
						Log.v("finao.has if video_img ",
								finao.getString("video_img"));
					fp.setVideoimage(finao.getString("video_img"));
				}
				Finao_AL.add(fp);

			}

		} catch (JSONException e) {
			Log.e(TAG, "Error parsing data " + e.toString());
		}

		return Finao_AL;
	}

	public ArrayList<FinaosPojo> GetFriendFianoswithUserID(String Tile_ID,
			String User_ID, String Original_UserID, String token) {

		ArrayList<FinaosPojo> Finao_AL = new ArrayList<FinaosPojo>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.baseurl();

		String Friend_URL_Str = str;
		MultipartEntity entity = null;
		try {
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("public_finao"));
			entity.addPart("tile_id", new StringBody(Tile_ID));
			entity.addPart("id", new StringBody(User_ID));

		} catch (Exception e) {
		}
		if (com.finaonation.utils.Constants.LOG)
			Log.v("Friend_Finao_List_Url", Friend_URL_Str);

		JsonHelper jh = new JsonHelper();
		Log.i("GetFriendFianoswithUserID ", token);
		JSONObject json1 = jh.getJSONfromURL(Friend_URL_Str, token, entity);

		if (com.finaonation.utils.Constants.LOG)
			Log.v("Finao_Response", "" + json1);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json1.getJSONArray("item");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				FinaosPojo fp = new FinaosPojo();

				fp.setTile_id(finao.getString("tile_id"));
				fp.setFinao_id(finao.getString("finao_id"));
				fp.setStatus(finao.getString("finao_status"));
				fp.setFinao_msg(finao.getString("finao_msg"));

				Finao_AL.add(fp);

			}

		} catch (JSONException e) {
			Log.e(TAG, "Error parsing data " + e.toString());
		}

		return Finao_AL;
	}
}
