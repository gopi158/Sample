package com.finaonation.profile;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.GetTiles;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingTiles {
	public ArrayList<GetTiles> GetTilesList(String User_ID, String con,
			String token) {
		ArrayList<GetTiles> Tiles_AL = new ArrayList<GetTiles>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.baseurl();
		MultipartEntity reqEntity = null;
		try {
			reqEntity = new MultipartEntity();
			reqEntity.addPart("json", new StringBody("mytiles"));

		JsonHelper jh = new JsonHelper();
		JSONObject json = jh.getJSONfromURL(str, token, reqEntity);

		if (Constants.LOG)
			Log.i("Tiles_Response", "" + json);
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("item");
			if (Constants.LOG)
				Log.i("res is :", "" + res);
			int length = res.length();

			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				GetTiles fp = new GetTiles();
				if(finao.has("tile_name")){
					fp.setTile_Name(finao.getString("tile_name"));
				}
				else{
					fp.setTile_Name("");
				}
				if(finao.has("image_urls"))
					fp.setTile_Image(finao.getJSONArray("image_urls").getJSONObject(0).getString("image_url"));
				else
					fp.setTile_Image("");
				
				if(finao.has("tile_id"))
					fp.setTile_Id(finao.getString("tile_id"));
				if(finao.getString("type").equalsIgnoreCase("1") || con.equalsIgnoreCase("finao"))
					Tiles_AL.add(fp);

			}

		} catch (Exception e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Tiles_AL;

	}

	FinaoServiceLinks fs = new FinaoServiceLinks();
	String str;
	String str1;
	String URL_Str;
	GetTiles fp;

	public ArrayList<GetTiles> GetFriendTilesList(String User_ID, String token) {

		ArrayList<GetTiles> Tiles_AL = new ArrayList<GetTiles>();
		str = fs.baseurl();
		MultipartEntity entity = null;
		try{
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("mytiles"));
			entity.addPart("id", new StringBody(User_ID));
		}catch(Exception e){}
		JsonHelper jh = new JsonHelper();
		JSONObject json = jh.getJSONfromURL(str, token, entity);

		if (Constants.LOG)
			Log.v("dTiles_Response", "" + json);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("item");
			if (Constants.LOG)
				Log.i("res is :", "" + res);
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				fp = new GetTiles();
				if (finao.has("tile_name")) {
					fp.setTile_Name(finao.getString("tile_name"));
				} else {
					fp.setTile_Name("");
				}
				if(finao.has("image_urls"))
					fp.setTile_Image(finao.getJSONArray("image_urls").getJSONObject(0).getString("image_url"));
				fp.setTile_Id(finao.getString("tile_id"));
				if(finao.getString("type").equalsIgnoreCase("1"))
					Tiles_AL.add(fp);	

			}

		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Tiles_AL;

	}

	public ArrayList<GetTiles> GetTilesListWithoutUserID(String token) {

		ArrayList<GetTiles> Tiles_AL = new ArrayList<GetTiles>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.NameSpace();
		String str1 = str + "usertiles&user_id=";

		String URL_Str = str1;
		if (Constants.LOG)
			Log.v("Tiles_URL", URL_Str);

		JSonHelper jh = new JSonHelper();
		JSONObject json = jh.getJSONfromURL(URL_Str, token);

		if (Constants.LOG)
			Log.v("Tiles_Response", "" + json);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("res");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);
				GetTiles fp = new GetTiles();

				fp.setTile_Name(finao.getString("tile_name"));
				fp.setTile_Image(finao.getString("tile_image"));
				fp.setTile_Id(finao.getString("tile_id"));
				Tiles_AL.add(fp);

			}

		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Tiles_AL;

	}
}
