package com.finaonation.home;

import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

import com.finaonation.beanclasses.FinaoTrendingPojo;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingTrendingItems {

	ArrayList<FinaoTrendingPojo> AllTrendingList = new ArrayList<FinaoTrendingPojo>();
	ArrayList<FinaoTrendingPojo> PhotoTrendingList = new ArrayList<FinaoTrendingPojo>();
	ArrayList<FinaoTrendingPojo> VideoTrendingList = new ArrayList<FinaoTrendingPojo>();

	public ArrayList<FinaoTrendingPojo> GetTrendingList(String token) {

		ArrayList<FinaoTrendingPojo> Trending_AL = new ArrayList<FinaoTrendingPojo>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.NameSpace();
		String str1 = str + "explorefinao";

		String URL_Str = str1;
		if (Constants.LOG)
			Log.v("HomeList_URL", URL_Str);

		JSonHelper jh = new JSonHelper();
		JSONObject json = jh.getJSONfromURL(URL_Str, token);

		if (Constants.LOG)
			Log.v("Home_Response", "" + json);

		try {
			//Get the element that holds the earthquakes ( JSONArray )

			JSONObject MainObj = json.getJSONObject("res");
			if(MainObj.has("image")){
				JSONArray  resimg = MainObj.getJSONArray("image");
				int length1 = resimg.length();
				for(int index=0;index < length1;index++){
					JSONObject finao =  resimg.getJSONObject(index);
					FinaoTrendingPojo ftap = new FinaoTrendingPojo();
					ftap.setVideoID("");
					ftap.setUpload_FileName(finao.getString("uploadfile_name"));
					ftap.setCaption(finao.getString("caption"));
					ftap.setUser_ID(finao.getString("userid"));
					ftap.setFinao_Msg(finao.getString("finao_msg"));
					ftap.setProfile_Image(finao.getString("profile_image"));
					ftap.setFinao_ID(finao.getString("finao_id"));
					PhotoTrendingList.add(ftap);
				}
			}

			if(MainObj.has("video")){
				JSONArray  resvid = MainObj.getJSONArray("video");
				int length2 = resvid.length();
				for(int index=0;index < length2;index++){
					JSONObject finao =  resvid.getJSONObject(index);
					FinaoTrendingPojo ftap = new FinaoTrendingPojo();
					//	        		ftap.setTile_ID(finao.getString("tile_id"));
					//	        		ftap.setTile_Name(finao.getString("tile_name"));
					ftap.setVideoImage(finao.getString("video_img"));
					ftap.setVideoID(finao.getString("videoid"));
					ftap.setVideoSource(finao.getString("videosource"));
					ftap.setCaption("");
					ftap.setUser_ID(finao.getString("userid"));
					ftap.setFinao_Msg(finao.getString("finao_msg"));
					ftap.setProfile_Image(finao.getString("profile_image"));
					ftap.setFinao_ID(finao.getString("finao_id"));

					VideoTrendingList.add(ftap);
				}
			}


			if(MainObj.has("all")){
				JSONArray  resall = MainObj.getJSONArray("all");
				int length = resall.length();
				if(Constants.LOG)
					Log.v("Trending_all_size_Before_Sorting", ""+length);
				for(int index=0;index < length;index++){
					JSONObject finao =  resall.getJSONObject(index);
					FinaoTrendingPojo ftap = new FinaoTrendingPojo();
					ftap.setTile_ID(finao.getString("tile_id"));
					ftap.setVideoID("");
					ftap.setCaption("");
					ftap.setUpload_FileName(finao.getString("uploadfile_name"));
					ftap.setUser_ID(finao.getString("userid"));
					ftap.setFinao_Msg(finao.getString("finao_msg"));
					ftap.setProfile_Image(finao.getString("profile_image"));
					ftap.setFinao_ID(finao.getString("finao_id"));

					AllTrendingList.add(ftap);
				}
			}



		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		Trending_AL.clear();


		Trending_AL.addAll(PhotoTrendingList);
		Trending_AL.addAll(VideoTrendingList);
		Trending_AL.addAll(AllTrendingList);

		return Trending_AL;

	}
}
