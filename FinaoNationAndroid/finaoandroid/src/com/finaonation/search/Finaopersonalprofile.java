package com.finaonation.search;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.text.Html;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.view.ViewGroup;
import android.widget.AbsListView;
import android.widget.AbsListView.OnScrollListener;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.beanclasses.GettingPostDetailsitem;
import com.finaonation.beanclasses.InspiredDetailsListPojo;
import com.finaonation.finao.FinaoDetailsView;
import com.finaonation.finao.FollowFriendTilesActivity;
import com.finaonation.finao.FriendProfileBtnActivity;
import com.finaonation.finao.PagerContainer;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.home.FinaoHome;
import com.finaonation.internet.InternetChecker;
import com.finaonation.profile.DisplayHomeImages;
import com.finaonation.profile.GettingInspiredDetailsitem;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class Finaopersonalprofile extends Activity implements OnClickListener {
	public static final String TAG = "Finaopersonalprofile";
	private String headerToken;
	private LinearLayout hide_ll2;
	private ImageLoader imageLoader;
	private String _UserID_SPS_Str, _FName_SPS_Str, _LName_SPS_Str,
			_MyStory_SPS_Str, _Finaos_Count_Str, _Finao_Profile_Pic_Str;
	private String User_ID, User_FName, User_SName, User_Profile_PicPath,
			User_Finao_Count, User_finao_story, User_Tile_Count,
			User_Following_Count, Banner_pic_path, Bannerimg;
	private InternetChecker ic;
	private Button Finao_Btn, Tiles_Btn, Following_Btn, Post_Btn, Inspired_Btn,
			btnFollow;
	private com.finaonation.utils.Finaolistview ProfilePage_LV;
	private TextView Header;
	private PopupWindow pw;
	private TextView ProfileName_TV, ProfileStory_TV;
	private String Profile_Pic_pathProfile_Pic_path, Profile_Pic_path;
	private FinaoServiceLinks fs;
	private SharedPreferences Finao_Preferences;
	private String headertext;
	private String followtileid = "", markpostid = "", followeduserid = "";
	int stateScrollSaved = 0, firstItemSaved = 0, visibleItemCountSaved = 0,
			totalItemCountSaved = 0, profilew, profileh;
	boolean stateHideShow = true;
	ArrayList<InspiredDetailsListPojo> inspiredDetailsListData = new ArrayList<InspiredDetailsListPojo>();
	RelativeLayout hide_ll3, containerLayout;
	private ImageView Profile_Pic_IV, Banner_pic_Iv, tippost, tipinspired;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.newfriendprofilescreen);

	}
	private void refreshFinaoPersonalProfile() {
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		ProfilePage_LV = (com.finaonation.utils.Finaolistview) findViewById(R.id.profilepagelvid);
		Header = (TextView) findViewById(R.id.header);
		ProfileName_TV = (TextView) findViewById(R.id.profilepageprofilenametvid);
		ProfileStory_TV = (TextView) findViewById(R.id.profilepagemystorytvid);
		Banner_pic_Iv = (ImageView) findViewById(R.id.banner_IM);
		Finao_Btn = (Button) findViewById(R.id.profilepagefinaosbtnid);
		Tiles_Btn = (Button) findViewById(R.id.profilepagetilesbtnid);
		Following_Btn = (Button) findViewById(R.id.profilepagefollowingbtnid);
		Profile_Pic_IV = (ImageView) findViewById(R.id.profilepageprofilepicivid);
		Post_Btn = (Button) findViewById(R.id.profilepagepostbtnid);
		Inspired_Btn = (Button) findViewById(R.id.profilepageinspiredbtnid);
		tippost = (ImageView) findViewById(R.id.tipimage1);
		tipinspired = (ImageView) findViewById(R.id.tipimage2);
		Post_Btn = (Button) findViewById(R.id.profilepagepostbtnid);
		Inspired_Btn = (Button) findViewById(R.id.profilepageinspiredbtnid);
		hide_ll2 = (LinearLayout) findViewById(R.id.ll2);
		hide_ll3 = (RelativeLayout) findViewById(R.id.ll3);
		btnFollow = (Button) findViewById(R.id.btnFollow);
		fs = new FinaoServiceLinks();

		imageLoader = new ImageLoader(this);
		ic = new InternetChecker();

		ProfilePage_LV.setSmoothScrollbarEnabled(true);
		ProfilePage_LV.setOnScrollListener(new OnScrollListener() {

			@Override
			public void onScrollStateChanged(AbsListView view, int scrollState) {
				if (stateScrollSaved == 0 && scrollState == 1) {
					if (firstItemSaved == -1 && !stateHideShow) {
						showProfileParts();
						stateHideShow = true;
					}
				}
				stateScrollSaved = scrollState;
			}

			@Override
			public void onScroll(AbsListView view, int firstVisibleItem,
					int visibleItemCount, int totalItemCount) {
				visibleItemCountSaved = visibleItemCount;
				totalItemCountSaved = totalItemCount;
				firstItemSaved = firstVisibleItem;
				if (stateHideShow && firstVisibleItem == 1
						&& visibleItemCount < totalItemCount) {
					hideProfileParts();
					stateHideShow = false;
					ProfilePage_LV.setSelectionAfterHeaderView();
				} else if (firstVisibleItem == -1 && !stateHideShow
						&& visibleItemCount < totalItemCount) {
					showProfileParts();
					stateHideShow = true;
				}
				if (firstItemSaved == 0 && firstVisibleItem == 0
						&& !stateHideShow) {
					firstItemSaved = -1;
				}
			}

			@SuppressLint("NewApi")
			private void hideProfileParts() {
				Banner_pic_Iv.setVisibility(View.GONE);
				hide_ll2.setVisibility(View.GONE);
				hide_ll3.setVisibility(View.GONE);
				int currentapiVersion = android.os.Build.VERSION.SDK_INT;
				if (currentapiVersion >= 12) {
					hide_ll3.animate().scaleX((float) 0).scaleY((float) 0);
				} else {
					hide_ll3.getLayoutParams().width = 1;
					hide_ll3.getLayoutParams().height = 1;
				}
				ProfilePage_LV.setSelectionAfterHeaderView();
			}

			@SuppressLint("NewApi")
			private void showProfileParts() {
				stateHideShow = true;
				Banner_pic_Iv.setVisibility(View.VISIBLE);
				hide_ll2.setVisibility(View.VISIBLE);
				hide_ll3.setVisibility(View.VISIBLE);
				int currentapiVersion = android.os.Build.VERSION.SDK_INT;
				if (currentapiVersion >= 12) {
					hide_ll3.animate().scaleX((float) 1).scaleY((float) 1);
				} else {
					hide_ll3.getLayoutParams().height = profileh;
					hide_ll3.getLayoutParams().width = profilew;
				}
			}
		});
		Bundle b = getIntent().getExtras();
		if (b != null) {
			User_ID = b.getString("Search_UID");
			JsonHelper jh = new JsonHelper();
			MultipartEntity entity = null;
			JSONObject obj;
			try {
				entity = new MultipartEntity();
				entity.addPart("json", new StringBody("user_details"));
				entity.addPart("userid", new StringBody(User_ID));
				obj = jh.getJSONfromURL(fs.baseurl(), headerToken, entity);

				if (obj.has("IsSuccess")
						&& obj.getString("IsSuccess").equalsIgnoreCase("true")) {
					JSONObject data = obj.getJSONArray("item").getJSONObject(0);
					User_FName = data.getString("fname");
					if (!data.getString("lname").equalsIgnoreCase("null"))
						User_SName = data.getString("lname");
					else
						User_SName = "";
					User_Profile_PicPath = data.getString("profile_image");
					Banner_pic_path = data.getString("banner_image");
					User_Finao_Count = data.getString("totalfinaos");
					if (!data.getString("mystory").equalsIgnoreCase("null"))
						User_finao_story = data.getString("mystory");
					else
						User_finao_story = "";
					User_Tile_Count = data.getString("totaltiles");
					User_Following_Count = data.getString("totalfollowings");
				} else {
					User_FName = b.getString("Search_FN");
					User_SName = b.getString("Search_SN");
					User_Profile_PicPath = b.getString("Search_PIC");
					Banner_pic_path = b.getString("Search_BG_PIC");
					User_Finao_Count = b.getString("Search_Finao_Count");
					User_finao_story = b.getString("Search_story");
					User_Tile_Count = b.getString("Search_Tile_Count");
					User_Following_Count = b
							.getString("Search_Following_Count");
				}
			} catch (JSONException e) {
				Log.e(TAG, e.toString());
				e.printStackTrace();
				Banner_pic_path = "";
				Profile_Pic_path = "";
			} catch (Exception e) {
				e.printStackTrace();
			}

		}

		@SuppressWarnings("deprecation")
		SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
		_FName_SPS_Str = Finao_Preferences.getString("FName", "");
		_LName_SPS_Str = Finao_Preferences.getString("LName", "");
		_MyStory_SPS_Str = Finao_Preferences.getString("MyStory", "");
		_Finaos_Count_Str = Finao_Preferences.getString("TotalFinaos", "");
		_Finao_Profile_Pic_Str = Finao_Preferences.getString("Profile_Image",
				"");
		if (_UserID_SPS_Str.equalsIgnoreCase(User_ID))
			btnFollow.setVisibility(View.GONE);
		if (User_Profile_PicPath == null || User_Profile_PicPath.length() == 0) {
			User_Profile_PicPath = getResources().getString(R.id.profile_image);
		}

		Profile_Pic_path = fs.ProfileImagesLink() + User_Profile_PicPath;

		ProfileName_TV.setText(User_FName + " " + User_SName);
		ProfileStory_TV.setText(User_finao_story);

		imageLoader.DisplayImage(Profile_Pic_path, Profile_Pic_IV, false, true);
		imageLoader.DisplayImage(Banner_pic_path, Banner_pic_Iv, false, true);

		ProfileStory_TV.setText(User_finao_story);
		ProfileName_TV.setText(User_FName + " " + User_SName);

		String Finao_Btn_Text = "<big> <font >" + User_Finao_Count
				+ "</font> </big>" + "FINAOs";
		Finao_Btn.setText(Html.fromHtml(Finao_Btn_Text));

		String Finao_Tile_Text = "<big> <font >" + User_Tile_Count
				+ "</font> </big>" + "Tiles";
		Tiles_Btn.setText(Html.fromHtml(Finao_Tile_Text));

		String Finao_Following_Text = "<big> <font >" + User_Following_Count
				+ "</font> </big>" + "Following";
		Following_Btn.setText(Html.fromHtml(Finao_Following_Text));
		Finao_Btn.setOnClickListener(this);
		Tiles_Btn.setOnClickListener(this);
		Following_Btn.setOnClickListener(this);
		Post_Btn.setOnClickListener(this);
		Inspired_Btn.setOnClickListener(this);
		PostBtnclick();
	}
	@Override
	protected void onResume() {
		super.onResume();
		refreshFinaoPersonalProfile();
	}
	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.profilepagefinaosbtnid:
			FinaoBtnClick();
			break;

		case R.id.profilepagetilesbtnid:
			TileBtnClick();
			break;

		case R.id.profilepagefollowingbtnid:
			FollowingBtnClick();
			break;

		case R.id.profilepagepostbtnid:
			PostBtnclick();
			break;

		case R.id.profilepageinspiredbtnid:
			InspiredBtnclick();
			break;

		default:
			break;
		}
	}

	public void Follow_Click(View v) {
		Intent intent = new Intent(getApplicationContext(),
				FollowFriendTilesActivity.class);
		intent.putExtra("userid", User_ID);
		startActivity(intent);
	}

	public void backClicked(View view) {
		finish();
	}

	public void Settingsclick(View v) {
		Intent intent = new Intent(getApplicationContext(),
				SettingActivity.class);
		startActivity(intent);
	}

	private void FinaoBtnClick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(getResources().getColor(R.color.buttextcol));
			Tiles_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					FriendProfileBtnActivity.class);
			intent.putExtra("Btn_key", 1);
			intent.putExtra("userid", _UserID_SPS_Str);
			intent.putExtra("f_userid", User_ID);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", User_FName + " " + User_SName);
			startActivity(intent);

		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void TileBtnClick() {

		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(Color.BLACK);
			Tiles_Btn.setTextColor(getResources().getColor(R.color.buttextcol));
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					FriendProfileBtnActivity.class);
			intent.putExtra("Btn_key", 2);
			intent.putExtra("userid", _UserID_SPS_Str);
			intent.putExtra("f_userid", User_ID);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", User_FName + " " + User_SName);
			startActivity(intent);
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void FollowingBtnClick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(Color.BLACK);
			Tiles_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(getResources().getColor(
					R.color.buttextcol));
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					FriendProfileBtnActivity.class);
			intent.putExtra("Btn_key", 3);
			intent.putExtra("userid", _UserID_SPS_Str);
			intent.putExtra("f_userid", User_ID);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", User_FName + " " + User_SName);
			startActivity(intent);
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void PostBtnclick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(Color.BLACK);
			Tiles_Btn.setTextColor(Color.BLACK);
			// Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(getResources().getColor(R.color.buttextcol));
			Inspired_Btn.setTextColor(Color.BLACK);

			new PostDetailsAssyncTask(headerToken, User_ID).execute();

		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void InspiredBtnclick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(Color.BLACK);
			Tiles_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(getResources().getColor(
					R.color.buttextcol));
			new InspiredDetailsAssyncTask(headerToken, User_ID).execute();
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	/************** Getting Post Detail Data by service ***********/
	private class PostDetailsAssyncTask extends AsyncTask<Void, Void, Integer> {
		String thisHeaderToken, thisUserID;
		ProgressDialog pDialog = new ProgressDialog(Finaopersonalprofile.this);
		String Loading_Msg = null;
		GettingPostDetailsitem gf;

		public PostDetailsAssyncTask(String headerToken, String User_ID) {
			thisUserID = User_ID;
			thisHeaderToken = headerToken;
			gf = new GettingPostDetailsitem(thisHeaderToken, thisUserID);
			Loading_Msg = "Loading Profile Items";
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(Finaopersonalprofile.this,
					"FINAO Nation", Loading_Msg, true, true);
		}

		protected Integer doInBackground(Void... params) {
			inspiredDetailsListData = gf.GetPostDetailsList(thisHeaderToken,
					thisUserID);
			return 0;
		}

		protected void onPostExecute(Integer result) {
			try {
				int no = inspiredDetailsListData.size();
				if (Constants.LOG)
					Log.d(TAG, "no:" + no);
				if (no != 0) {
					Header.setVisibility(View.GONE);
					ProfilePage_LV.setAdapter(new PostDetailListAdapter(
							getApplicationContext(), inspiredDetailsListData));
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Toast.makeText(getApplicationContext(), "No Posts Items",
							Toast.LENGTH_SHORT).show();
				}
				pDialog.dismiss();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}

	}

	// InspiredDetailsAssyncTask
	/************** Getting Inspired Data by service ***********/
	private class InspiredDetailsAssyncTask extends
			AsyncTask<Void, Void, Integer> {
		String thisHeaderToken;
		ProgressDialog pDialog = new ProgressDialog(Finaopersonalprofile.this);
		String Loading_Msg = null;
		GettingInspiredDetailsitem gf;
		String userid = null;

		public InspiredDetailsAssyncTask(String headerToken, String id) {
			thisHeaderToken = headerToken;
			userid = id;
			gf = new GettingInspiredDetailsitem(thisHeaderToken);
			Loading_Msg = "Loading Items";
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(Finaopersonalprofile.this,
					"FINAO Inspired", Loading_Msg, true, true);
		}

		protected Integer doInBackground(Void... params) {
			inspiredDetailsListData = gf.GetInspiredDetailsList(headertext,
					userid);
			return 0;
		}

		protected void onPostExecute(Integer result) {
			try {
				int no = inspiredDetailsListData.size();
				if (Constants.LOG)
					Log.d(TAG, "no:" + no);
				if (no != 0) {
					Header.setVisibility(View.GONE);
					ProfilePage_LV.setAdapter(new ProfileDetailListAdapter(
							getApplicationContext(), inspiredDetailsListData));
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("There are no inspired posts");
					Toast.makeText(getApplicationContext(),
							"No Inspired Items", Toast.LENGTH_SHORT).show();
				}
				pDialog.dismiss();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}

	}

	/************** Profile Details Adapter Setting ***********/
	private class ProfileDetailListAdapter extends BaseAdapter {
		Context con;
		String FinUploadtext;
		String videoimg;
		String imageurl;
		ArrayList<InspiredDetailsListPojo> _InspiredDetailsListData;

		public ProfileDetailListAdapter(Context applicationContext,
				ArrayList<InspiredDetailsListPojo> InspiredDetailsListData) {
			this.con = applicationContext;
			this._InspiredDetailsListData = InspiredDetailsListData;
		}

		@Override
		public int getCount() {
			return _InspiredDetailsListData.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		int i = 0;
		ImageView profile_IM, Video_IM, btninspire, finaostatus;
		TextView profilename_TV, Date_TV, up_Tv, Finaocaptiontvid;
		InspiredDetailsListPojo fhp;
		LayoutInflater li;
		PagerContainer mContainer;
		ViewPager pager;
		ImagePagerAdapter adapter;
		RelativeLayout videocontainer;

		@Override
		public View getView(final int position, View convertVieww,
				ViewGroup parent) {
			li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			fhp = _InspiredDetailsListData.get(position);
			if (Constants.LOG)
				Log.i(TAG,
						"detail count is  : " + _InspiredDetailsListData.size());

			if (i++ > 0) {
				i = 0;
				cleanupMemory();
			}

			FinUploadtext = _InspiredDetailsListData.get(position)
					.getF_Upload_Text();

			if (convertVieww == null) {
				convertVieww = li.inflate(R.layout.finao_imageinflater, null);
			}
			mContainer = (PagerContainer) convertVieww
					.findViewById(R.id.pager_container);
			Finaocaptiontvid = (TextView) convertVieww
					.findViewById(R.id.finaoname);
			btninspire = (ImageView) convertVieww.findViewById(R.id.btninspire);
			btninspire.setVisibility(View.VISIBLE);

			if (_InspiredDetailsListData.get(position).getF_Is_Inspired()
					.equalsIgnoreCase("1"))
				btninspire.setBackgroundResource(R.drawable.inspired);
			else
				btninspire.setBackgroundResource(R.drawable.inspiring);

			finaostatus = (ImageView) convertVieww
					.findViewById(R.id.finaostatusivid);
			if (fhp.getF_Finao_Status().equalsIgnoreCase("1")) {
				finaostatus.setImageResource(R.drawable.btnaheadhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("0")) {
				finaostatus.setImageResource(R.drawable.btnontrackhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("2")) {
				finaostatus.setImageResource(R.drawable.btnbehindhover);
			}

			pager = mContainer.getViewPager();
			videocontainer = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RLV);
			videocontainer.setVisibility(View.GONE);
			adapter = new ImagePagerAdapter(_InspiredDetailsListData.get(
					position).getF_imagearray());
			pager.setAdapter(adapter);
			pager.setOffscreenPageLimit(adapter.getCount());
			if (_InspiredDetailsListData.get(position).getF_imagearray() != null
					&& _InspiredDetailsListData.get(position).getF_imagearray()
							.length() > 0) {
				pager.setPageMargin(-25);
				videocontainer.setVisibility(View.GONE);
			}
			imageurl = fs.ProfileImagesLink()
					+ _InspiredDetailsListData.get(position)
							.getF_Profile_Image();
			Finaocaptiontvid.setText(_InspiredDetailsListData.get(position)
					.getF_Caption());
			profile_IM = (ImageView) convertVieww.findViewById(R.id.Profile_IM);
			profilename_TV = (TextView) convertVieww
					.findViewById(R.id.username);
			Date_TV = (TextView) convertVieww.findViewById(R.id.finaodatetvid);
			up_Tv = (TextView) convertVieww.findViewById(R.id.upload_Tv);
			Finaocaptiontvid.setText(fhp.getF_Caption());
			imageLoader.DisplayImage(imageurl, profile_IM, false, true);
			profilename_TV.setText(fhp.getF_Name());
			Date_TV.setText(fhp.getF_Udate());

			if (FinUploadtext == null || FinUploadtext.equalsIgnoreCase("")) {
				up_Tv.setVisibility(View.GONE);
			} else {
				up_Tv.setVisibility(View.VISIBLE);
				up_Tv.setText(FinUploadtext);
			}

			profile_IM.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {

					Intent intent = new Intent(getApplicationContext(),
							Finaopersonalprofile.class);
					intent.putExtra("Search_UID",
							_InspiredDetailsListData.get(position)
									.get_F_User_Id());
					startActivity(intent);
				}
			});

			btninspire.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					if (_InspiredDetailsListData.get(position)
							.getF_Is_Inspired().equalsIgnoreCase("0")) {
						MultipartEntity entity = new MultipartEntity();
						try {
							entity.addPart("json", new StringBody(
									"getinspiredfrompost"));
							entity.addPart("userpostid", new StringBody(
									_InspiredDetailsListData.get(position)
											.getF_Post_ID()));
							JSONObject obj = new JsonHelper().getJSONfromURL(
									fs.baseurl(), headerToken, entity);
							if (obj.has("IsSuccess")
									&& obj.getString("IsSuccess")
											.equalsIgnoreCase("true")) {
								_InspiredDetailsListData.get(position)
										.setF_Is_Inspired("1");
								v.setBackgroundResource(R.drawable.inspired);
								Toast.makeText(getApplicationContext(),
										"Successfully inspired from post.",
										Toast.LENGTH_SHORT).show();
							}
						} catch (Exception e) {
							Log.e(TAG, e.toString());
							e.printStackTrace();
						}

					}
				}
			});

			convertVieww.setTag(fhp.getF_Type());
			return convertVieww;
		}

		private void cleanupMemory() {
			new Thread() {
				@Override
				public void run() {
					System.gc();
				}
			}.start();
		}

	}

	/************** Post Details Adapter Setting ***********/
	private class PostDetailListAdapter extends BaseAdapter {
		Context con;
		ArrayList<InspiredDetailsListPojo> _PostDetailsListData;

		public PostDetailListAdapter(Context applicationContext,
				ArrayList<InspiredDetailsListPojo> PostDetailsListData) {
			this.con = applicationContext;
			this._PostDetailsListData = PostDetailsListData;
			if (Constants.LOG)
				Log.i(TAG, "no of finao items:" + _PostDetailsListData.size());
		}

		@Override
		public int getCount() {
			return _PostDetailsListData.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		ImageView profile_IM, Video_IM, btninspire, btnoptions, finaostatus;
		TextView profilename_TV, Date_TV, up_Tv, Finaocaptiontvid;
		String FinUploadtext;
		String videoimg;
		int i = 0;
		InspiredDetailsListPojo fhp;
		PagerContainer mContainer;
		ViewPager pager;
		ImagePagerAdapter adapter;
		RelativeLayout rPager, rVideo;

		@Override
		public View getView(final int position, View convertVieww,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			fhp = _PostDetailsListData.get(position);
			if (Constants.LOG)
				Log.i(TAG, "detail count is  : " + _PostDetailsListData.size());
			if (i++ > 0) {
				i = 0;
				cleanupMemory();
			}
			FinUploadtext = fhp.getF_Upload_Text();
			if (convertVieww == null) {
				convertVieww = li.inflate(R.layout.finao_imageinflater, null);
			}
			mContainer = (PagerContainer) convertVieww
					.findViewById(R.id.pager_container);
			Finaocaptiontvid = (TextView) convertVieww
					.findViewById(R.id.finaoname);
			rPager = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RL);
			rVideo = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RLV);

			finaostatus = (ImageView) convertVieww
					.findViewById(R.id.finaostatusivid);
			if (fhp.getF_Finao_Status().equalsIgnoreCase("1")) {
				finaostatus.setImageResource(R.drawable.btnaheadhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("0")) {
				finaostatus.setImageResource(R.drawable.btnontrackhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("2")) {
				finaostatus.setImageResource(R.drawable.btnbehindhover);
			}

			btninspire = (ImageView) convertVieww.findViewById(R.id.btninspire);
			btninspire.setVisibility(View.VISIBLE);

			btnoptions = (ImageView) convertVieww.findViewById(R.id.btnoptions);

			if (fhp.getF_Is_Inspired().equalsIgnoreCase("1"))
				btninspire.setBackgroundResource(R.drawable.inspired);
			else
				btninspire.setBackgroundResource(R.drawable.inspiring);
			pager = mContainer.getViewPager();
			showImageViewPagerContainer();
			hideVideoContainer();

			try {
				if (fhp.getF_imagearray() != null
						&& fhp.getF_imagearray().length() > 0
						&& fhp.getF_imagearray().getJSONObject(0) != null
						&& fhp.getF_imagearray().getJSONObject(0)
								.getString("image_url") != null) {
					adapter = new ImagePagerAdapter(fhp.getF_imagearray());
					pager.setAdapter(adapter);
					pager.setOffscreenPageLimit(adapter.getCount());
					pager.setPageMargin(-25);
				} else {
					hideImageViewPagerContainer();
				}
			} catch (JSONException e1) {
				hideImageViewPagerContainer();
			}
			// remove this when videos get added

			if (fhp.getF_Type() == 2) {
				hideImageViewPagerContainer();
				showVideoContainer();
			}

			profile_IM = (ImageView) convertVieww.findViewById(R.id.Profile_IM);
			profilename_TV = (TextView) convertVieww
					.findViewById(R.id.username);
			Date_TV = (TextView) convertVieww.findViewById(R.id.finaodatetvid);
			up_Tv = (TextView) convertVieww.findViewById(R.id.upload_Tv);

			if (fhp.getF_Caption() != null)
				Finaocaptiontvid.setText(fhp.getF_Caption());

			imageLoader.DisplayImage(Profile_Pic_path, profile_IM, false, true);
			profilename_TV.setText(User_FName + " " + User_SName);
			Date_TV.setText(fhp.getF_Udate());

			if (FinUploadtext == null || FinUploadtext.equalsIgnoreCase("")) {
				up_Tv.setVisibility(View.GONE);
			} else {
				up_Tv.setVisibility(View.VISIBLE);
				up_Tv.setText(FinUploadtext);
			}

			Finaocaptiontvid.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					Intent intent = new Intent(getApplicationContext(),
							FinaoDetailsView.class);
					intent.putExtra("F_FinaoTitle",
							_PostDetailsListData.get(position).getF_Caption());
					intent.putExtra("F_FinId",
							_PostDetailsListData.get(position).getF_FinaoID());
					intent.putExtra("F_Public", "0");
					intent.putExtra("F_FinStatus",
							_PostDetailsListData.get(position)
									.getF_Finao_Status());
					intent.putExtra("F_From", "user");
					intent.putExtra("F_UserId", _UserID_SPS_Str);
					intent.putExtra("F_Profile_Pic_path", Profile_Pic_path);
					intent.putExtra("F_UserName", User_FName + " " + User_SName);
					startActivity(intent);
				}
			});

			btninspire.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					if (_PostDetailsListData.get(position).getF_Is_Inspired()
							.equalsIgnoreCase("0")) {
						MultipartEntity entity = new MultipartEntity();
						try {
							entity.addPart("json", new StringBody(
									"getinspiredfrompost"));
							entity.addPart("userpostid", new StringBody(
									_PostDetailsListData.get(position)
											.getF_Post_ID()));
							JSONObject obj = new JsonHelper().getJSONfromURL(
									fs.baseurl(), headerToken, entity);
							if (obj.has("IsSuccess")
									&& obj.getString("IsSuccess")
											.equalsIgnoreCase("true")) {
								_PostDetailsListData.get(position)
										.setF_Is_Inspired("1");
								v.setBackgroundResource(R.drawable.inspired);
								Toast.makeText(getApplicationContext(),
										"Successfully inspired from post.",
										Toast.LENGTH_SHORT).show();
							}
						} catch (Exception e) {
							Log.e(TAG, e.toString());
							e.printStackTrace();
						}

					}
				}
			});

			btnoptions.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					// To Do
				}
			});
			convertVieww.setTag(fhp.getF_Type());
			return convertVieww;
		}

		private void hideVideoContainer() {
			rVideo.setVisibility(View.GONE);
		}

		private void showVideoContainer() {
			rVideo.setVisibility(View.VISIBLE);
		}

		private void hideImageViewPagerContainer() {
			mContainer.setVisibility(View.GONE);
			pager.setVisibility(View.GONE);
			rPager.setVisibility(View.GONE);
		}

		private void showImageViewPagerContainer() {
			mContainer.setVisibility(View.VISIBLE);
			pager.setVisibility(View.VISIBLE);
			rPager.setVisibility(View.VISIBLE);
		}

		private void cleanupMemory() {
			new Thread() {
				@Override
				public void run() {
					System.gc();
				}
			}.start();
		}

	}

	public void showPopup(Context context, String tilename) {
		LayoutInflater inflater = (LayoutInflater) context
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View popuplayout = inflater.inflate(R.layout.popup_options,
				(ViewGroup) findViewById(R.id.popup_menu_root));
		Button mark = (Button) popuplayout.findViewById(R.id.take_from_lib_btn);
		mark.setText("Flag as inappropriate");

		Button follow = (Button) popuplayout.findViewById(R.id.capture_photo);
		follow.setText("Follow " + tilename + " Tile");

		pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
				LayoutParams.MATCH_PARENT, true);
		pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);

	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
	}

	public void SharePost(View view) {
		JsonHelper js = new JsonHelper();
		MultipartEntity entity = new MultipartEntity();
		JSONObject obj = null;
		try {
			entity.addPart("json", new StringBody("followuser"));
			entity.addPart("tileid", new StringBody(followtileid));
			entity.addPart("followeduserid", new StringBody(followeduserid));
			obj = js.getJSONfromURL(fs.baseurl(), headerToken, entity);

			if (obj != null && obj.has("IsSuccess")
					&& obj.getString("IsSuccess").equalsIgnoreCase("true")) {
				PostBtnclick();
				Toast.makeText(getApplicationContext(),
						"Now you are following this tile.", Toast.LENGTH_SHORT)
						.show();
				markpostid = "";
				followeduserid = "";
				followtileid = "";
			} else {
				Toast.makeText(getApplicationContext(),
						"Already following this tile.",
						Toast.LENGTH_SHORT).show();
			}
		} catch (Exception e) {
			Log.e(TAG, e.toString());
			e.printStackTrace();
		}

		pw.dismiss();
	}

	public void deletepost(View view) {
		JsonHelper js = new JsonHelper();
		MultipartEntity entity = new MultipartEntity();
		JSONObject obj = null;
		try {
			entity.addPart("json", new StringBody("markinappropriatepost"));
			entity.addPart("userpostid", new StringBody(markpostid));
			obj = js.getJSONfromURL(fs.baseurl(), headerToken, entity);

			if (obj != null && obj.has("IsSuccess")
					&& obj.getString("IsSuccess").equalsIgnoreCase("true")) {
				PostBtnclick();
				Toast.makeText(getApplicationContext(),
						"Post successfully marked inappropriate.",
						Toast.LENGTH_SHORT).show();
				markpostid = "";
				followeduserid = "";
				followtileid = "";
			} else {
				Toast.makeText(getApplicationContext(),
						"This post already marked as inappropriate.",
						Toast.LENGTH_SHORT).show();
			}
		} catch (Exception e) {
			Log.e(TAG, e.toString());
			e.printStackTrace();
		}
		pw.dismiss();
	}

	private class ImagePagerAdapter extends PagerAdapter {

		ArrayList<String> imgar = new ArrayList<String>();
		ArrayList<String> capar = new ArrayList<String>();
		JSONArray _f_imagearray;
		View layout;
		ImageView fina_im;
		TextView Furl;
		String str1, finurl;
		FinaoServiceLinks fs;
		JSONObject finao;

		public ImagePagerAdapter(JSONArray f_imagearray) {
			_f_imagearray = f_imagearray;
			for (int i = 0; i < f_imagearray.length(); i++) {
				try {
					finao = _f_imagearray.getJSONObject(i);
					if (finao != null
							&& finao.getString("image_url") != null
							&& !finao.getString("image_url").toString()
									.equalsIgnoreCase(""))
						imgar.add(finao.getString("image_url").toString());
				} catch (JSONException e1) {
					if (finao != null) {
						Log.i(TAG, finao.toString());
					}
					e1.printStackTrace();
				}
			}
		}

		@Override
		public int getCount() {
			return imgar.size();
		}

		@Override
		public boolean isViewFromObject(View view, Object object) {
			return view == ((View) object);
		}

		@Override
		public Object instantiateItem(ViewGroup container, final int position) {

			LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			layout = inflater.inflate(R.layout.finaoimagerow, null);
			fina_im = (ImageView) layout.findViewById(R.id.finaoimg);

			if (_f_imagearray.length() == 1) {
				layout.setPadding(0, 0, 0, 0);
			} else {
				if (position == 0) {
					layout.setPadding(0, 0, 10, 0);
				} else {
					layout.setPadding(10, 0, 10, 0);
				}

			}

			fs = new FinaoServiceLinks();
			str1 = fs.PostImagesLink();
			finurl = str1
					+ imgar.get(position).toString().replaceAll(" ", "%20");
			Drawable drawable = fina_im.getDrawable();
			if (drawable instanceof BitmapDrawable) {
				BitmapDrawable bitmapDrawable = (BitmapDrawable) drawable;
				bitmapDrawable.getBitmap().recycle();
			}
			fina_im.setImageBitmap(null);
			System.gc();
			imageLoader.DisplayImage(finurl, fina_im, true, true);
			// TextView cap = (TextView)layout.findViewById(R.id.Finaocaptiont);
			Furl = (TextView) layout.findViewById(R.id.Finaourl);
			Furl.setText(imgar.get(position).toString());
			// cap.setText(capar.get(position).toString());
			((ViewPager) container).addView(layout, 0);
			layout.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					Intent in = new Intent(getApplicationContext(),
							DisplayHomeImages.class);
					in.putExtra("ProfilePicPath", imgar.get(position));
					startActivity(in);
				}
			});

			return layout;
		}

		private void loadImageCleanMem(String finurl) {
			Drawable drawable = fina_im.getDrawable();
			if (drawable instanceof BitmapDrawable) {
				BitmapDrawable bitmapDrawable = (BitmapDrawable) drawable;
				bitmapDrawable.getBitmap().recycle();
			}
			fina_im.setImageBitmap(null);
			System.gc();
			imageLoader.DisplayImage(finurl, fina_im, true, true);
		}

		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			((ViewPager) container).removeView((View) object);
		}
	}

}
