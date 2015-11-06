package com.finaonation.profile;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.finao.R;
import com.finaonation.webservices.FinaoServiceLinks;

public class ProfileEditStory extends Activity {

	Activity mActivity;
	EditText EditStory_ED;
	Button Save_Story_Btn;
	String Story_Str = "";
	String Story_Trending = "";
	String FinaoID;
	String _UserID_SPS_Str, _FName_SPS_Str, _LName_SPS_Str, _MyStory_SPS_Str,
			_Finaos_Count_Str, _Finao_Profile_Pic_Str, _Tiles_Count_Str,
			_Zipcode_SPS_Str, _Email_SPS_Str, _Gender_SPS_Str, _DOB_SPS_Str,
			_Age_SPS_Str, _SocialNetwork_SPS_Str, _SocialNetwork_ID_SPS_Str,
			_USerName_SPS_Str, _Location_SPS_Str, _Total_Followers,
			_Total_Following;
	String TAG;
	boolean storyTrending = false;
	boolean story = false;
	@SuppressWarnings("unused")
	private String mSelectedFinaoId = null;
	String headerToken;
	SharedPreferences Finao_Preferences;

	@SuppressWarnings("deprecation")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.editstory);
		mActivity = this;

		gettingIDs();
		TAG = getClass().getName();

		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
		_FName_SPS_Str = Finao_Preferences.getString("FName", "");
		_LName_SPS_Str = Finao_Preferences.getString("LName", "");
		_MyStory_SPS_Str = Finao_Preferences.getString("MyStory", "");
		_Finaos_Count_Str = Finao_Preferences.getString("TotalFinaos", "");
		_Tiles_Count_Str = Finao_Preferences.getString("TotalTiles", "");
		_Finao_Profile_Pic_Str = Finao_Preferences.getString("Profile_Image","");
		_Zipcode_SPS_Str = Finao_Preferences.getString("ZipCode", "");
		_Email_SPS_Str = Finao_Preferences.getString("EMail", "");
		_Gender_SPS_Str = Finao_Preferences.getString("Gender", "");
		_DOB_SPS_Str = Finao_Preferences.getString("DOB", "");
		_Age_SPS_Str = Finao_Preferences.getString("Age", "");
		_SocialNetwork_SPS_Str = Finao_Preferences.getString("Social_Network",
				"");
		_SocialNetwork_ID_SPS_Str = Finao_Preferences.getString(
				"SocialNetWorkID", "");
		_USerName_SPS_Str = Finao_Preferences.getString("UName", "");
		_Location_SPS_Str = Finao_Preferences.getString("Location", "");
		_Total_Followers = Finao_Preferences.getString("TotalFollowers", "");
		_Total_Following = Finao_Preferences.getString("TotalFollowing", "");

		Story_Str = getIntent().getExtras().getString("Profile_Page_Story");
		if (Story_Str != null && Story_Str.length() >= 0) {
			EditStory_ED.setText(Story_Str);
			story = true;
		}

		Story_Trending = getIntent().getExtras().getString("TrendingDetail");
		if (Story_Trending != null && Story_Trending.length() >= 0) {
			EditStory_ED.setText(Story_Trending);
			storyTrending = true;
		}

		mSelectedFinaoId = getIntent().getExtras().getString("FinaoSelectedID");

		Save_Story_Btn.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				if(getIntent().getExtras().getString("FinaoID") == null){
					Finao_Preferences = getSharedPreferences("Finao_Preferences",
							MODE_WORLD_READABLE);
					SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
						.edit();
					Finao_Preference_Editor.putString("Finao_Message", EditStory_ED
						.getText().toString());
					Finao_Preference_Editor.commit();
					new UpdateStoryAssync("bio").execute();
				}
				else{
					new UpdateStoryAssync("finao").execute();
				}
			}
		});
	}

	private void gettingIDs() {
		EditStory_ED = (EditText) findViewById(R.id.editstoryedid);
		Save_Story_Btn = (Button) findViewById(R.id.savestorybtnid);
	}

	public void backClicked(View view){
		finish();
	}
	private class UpdateStoryAssync extends AsyncTask<String, Void, JSONObject> {
		private String method;
		UpdateStoryAssync(String method) {
			this.method = method;
		}

		ProgressDialog pDialog = new ProgressDialog(mActivity);

		protected void onPreExecute() {

			pDialog.setMessage("Updating " + method);
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected JSONObject doInBackground(String... params) {
			JSONObject js = null;
			FinaoServiceLinks FS = new FinaoServiceLinks();
			String url = FS.baseurl();
			MultipartEntity entity = null;
			JsonHelper json = new JsonHelper();
			try {
				if(method.equalsIgnoreCase("bio")){
					entity = new MultipartEntity();
					entity.addPart("json", new StringBody("updateprofile"));
					entity.addPart("name", new StringBody(getIntent().getExtras()
						.getString("Profile_name")));
					entity.addPart("bio", new StringBody(EditStory_ED.getText()
						.toString()));
					
					js = json.getJSONfromURL(url, headerToken, entity);
				}
				else{
					entity = new MultipartEntity();
					entity.addPart("json", new StringBody("changefinaostory"));
					entity.addPart("finao_id", new StringBody(getIntent().getExtras()
						.getString("FinaoID")));
					entity.addPart("finao_msg", new StringBody(EditStory_ED.getText()
						.toString()));
					js = json.getJSONfromURL(url, headerToken, entity);
				}
			} catch (Exception e) {
				Log.e(TAG, e.toString());
			}
			return js;
		}

		protected void onPostExecute(JSONObject result) {
			pDialog.dismiss();
			try {
				if (result != null
						&& result.has("IsSuccess")
						&& result.getString("IsSuccess").equalsIgnoreCase(
								"true")) {
					SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences.edit();
					if(method.equalsIgnoreCase("bio"))
						Finao_Preference_Editor.putString("MyStory", EditStory_ED.getText().toString());
					else
						Finao_Preference_Editor.putString("FinaoTitle", EditStory_ED.getText().toString());
					Finao_Preference_Editor.commit();
					finish();
				} else {
					Toast.makeText(mActivity, method + " updation failed",
							Toast.LENGTH_SHORT).show();
				}
			} catch (Exception e) {
				Log.e(TAG, e.toString());
			}
		}
	}
}
