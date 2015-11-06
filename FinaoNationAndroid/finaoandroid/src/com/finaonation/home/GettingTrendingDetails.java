package com.finaonation.home;

import java.util.ArrayList;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.util.Log;
import com.finaonation.beanclasses.TrendingDetailPojo;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.utils.Constants;
import com.finaonation.webservices.FinaoServiceLinks;

public class GettingTrendingDetails {
	public ArrayList<TrendingDetailPojo> GetTrendDetails(String User_ID,
			String Fin_ID, String token) {

		ArrayList<TrendingDetailPojo> Detail_AL = new ArrayList<TrendingDetailPojo>();

		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.NameSpace();
		String str1 = str + "finao_details&userid=";
		String str2 = str1 + User_ID;
		String str3 = str2 + "&finaoid=" + Fin_ID;

		String URL_Str = str3;
		if (Constants.LOG)
			Log.v("TrendDetail_URL", URL_Str);

		JSonHelper jh = new JSonHelper();
		JSONObject json = jh.getJSONfromURL(URL_Str, token);

		if (Constants.LOG)
			Log.v("TrendDetail_Response", "" + json);

		try {
			// Get the element that holds the earthquakes ( JSONArray )

			JSONArray res = json.getJSONArray("res");
			int length = res.length();
			for (int index = 0; index < length; index++) {

				JSONObject finao = res.getJSONObject(index);

				com.finaonation.beanclasses.TrendingDetailPojo fhp = new com.finaonation.beanclasses.TrendingDetailPojo();

				fhp.setUpload_File_Path(finao.getString("uploadfile_name"));

				if(finao.has("upload_text")){
					fhp.setUploadtext(finao.getString("upload_text"));
				}else{
				}
				if(finao.has("caption")){
					fhp.setCaption(finao.getString("caption"));
				}else{
				}
				if(finao.has("video_caption")){
					fhp.setVideoCaptiontext(finao.getString("video_caption"));
				}else{
				}


				fhp.setMessage(finao.getString("message"));
				fhp.setType(finao.getString("type"));
				fhp.setVideo_IMG(finao.getString("video_img"));
				fhp.setVideo_Source(finao.getString("videosource"));
				fhp.setVideo_url(finao.getString("video_embedurl"));
				fhp.setvideo_File_Path(finao.getString("video_img"));
				Detail_AL.add(fhp);

			}

		} catch (JSONException e) {
			Log.e("log_tag", "Error parsing data " + e.toString());
		}

		return Detail_AL;

	}
}
