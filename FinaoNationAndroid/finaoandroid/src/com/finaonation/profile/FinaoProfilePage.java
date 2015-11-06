package com.finaonation.profile;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.media.audiofx.BassBoost.Settings;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.text.Html;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
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
import com.finaonation.finao.FinaoLoginOrRegister;
import com.finaonation.finao.PagerContainer;
import com.finaonation.finao.ProfileBtnActivity;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.internet.InternetChecker;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.search.Finaopersonalprofile;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class FinaoProfilePage extends Activity implements OnClickListener {
	public static final String TAG = "FinaoProfilePage";
	private TextView ProfileName_TV, ProfileStory_TV;
	private Button Finao_Btn, Tiles_Btn, Following_Btn, Followers_Btn,
			Post_Btn, Inspired_Btn;
	private com.finaonation.utils.Finaolistview ProfilePage_LV;
	private ImageView Profile_Pic_IV, Banner_pic_Iv, tippost, tipinspired;
	private ImageLoader imageLoader;
	private String userid, Fname, Lname, Profileimg, headertext, Bannerimg,
			Finaostory, Profile_Pic_path, Banner_pic_path;
	private SharedPreferences Finao_Preferences;
	private SharedPreferences.Editor editor;
	private ProgressDialog pDialog;
	private String baseurl;
	private InternetChecker ic;
	private FinaoServiceLinks fs = null;
	private PopupWindow pw;
	private String mediaFilePath = "";
	private String delfinaoid, delpostid;
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 1;
	private static final int GALLERY_REQUEST = 2;
	private static final int REQUEST_CODE_CROP_IMAGE = 34;
	private Bitmap imageTaken;
	boolean stateHideShow = true;
	int stateScrollSaved = 0, firstItemSaved = 0, visibleItemCountSaved = 0,
			totalItemCountSaved = 0, profilew, profileh;
	RelativeLayout hide_ll3, containerLayout;
	LinearLayout hide_ll2;
	ArrayList<InspiredDetailsListPojo> inspiredDetailsListData = new ArrayList<InspiredDetailsListPojo>();
	TextView Header;
	String headerToken;
	String url3;
	String Login_Key;
	Activity mActivity;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}

	@SuppressWarnings("deprecation")
	private void refreshProfilePage() {
		mActivity = this;
		setContentView(R.layout.newprofilepage);
		ic = new com.finaonation.internet.InternetChecker();
		imageLoader = new ImageLoader(this);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		editor = Finao_Preferences.edit();
		headerToken = Finao_Preferences.getString("logtoken", "");
		ProfilePage_LV = (com.finaonation.utils.Finaolistview) findViewById(R.id.profilepagelvid);
		// containerLayout = (RelativeLayout)findViewById(R.id.containerLayout);
		ProfileName_TV = (TextView) findViewById(R.id.profilepageprofilenametvid);
		ProfileStory_TV = (TextView) findViewById(R.id.profilepagemystorytvid);
		Finao_Btn = (Button) findViewById(R.id.profilepagefinaosbtnid);
		Tiles_Btn = (Button) findViewById(R.id.profilepagetilesbtnid);
		Following_Btn = (Button) findViewById(R.id.profilepagefollowingbtnid);
		Followers_Btn = (Button) findViewById(R.id.profilepagefollwersbtnid);
		Profile_Pic_IV = (ImageView) findViewById(R.id.profilepageprofilepicivid);
		Banner_pic_Iv = (ImageView) findViewById(R.id.banner_IM);
		tippost = (ImageView) findViewById(R.id.tipimage1);
		tipinspired = (ImageView) findViewById(R.id.tipimage2);
		Post_Btn = (Button) findViewById(R.id.profilepagepostbtnid);
		Inspired_Btn = (Button) findViewById(R.id.profilepageinspiredbtnid);
		hide_ll2 = (LinearLayout) findViewById(R.id.ll2);
		hide_ll3 = (RelativeLayout) findViewById(R.id.ll3);
		Header = (TextView) findViewById(R.id.header);

		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);

		Login_Key = Finao_Preferences.getString("Login_Session", "");

		fs = new FinaoServiceLinks();
		baseurl = fs.baseurl();
		url3 = baseurl;
		userid = Finao_Preferences.getString("User_ID", "");
		Finao_Btn.setOnClickListener(this);
		Tiles_Btn.setOnClickListener(this);
		Following_Btn.setOnClickListener(this);
		Followers_Btn.setOnClickListener(this);
		Profile_Pic_IV.setOnClickListener(this);
		ProfileStory_TV.setOnClickListener(this);
		Post_Btn.setOnClickListener(this);
		Inspired_Btn.setOnClickListener(this);
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
	}

	public void Settingsclick(View v) {
		Intent in = new Intent(FinaoProfilePage.this, SettingActivity.class);
		overridePendingTransition(R.anim.slide_in, R.anim.slide_out);
		startActivity(in);

	}

	@SuppressWarnings("deprecation")
	@Override
	protected void onResume() {
		super.onResume();
		refreshProfilePage();
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		Login_Key = Finao_Preferences.getString("Login_Session", "");
		if (Login_Key.length() == 0) {
			Intent i = new Intent(getApplicationContext(),
					FinaoLoginOrRegister.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(i);
			finish();
		} else if (ic.IsNetworkAvailable(getApplicationContext()) == false) {

			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		} else if (!headerToken.equalsIgnoreCase("")) {
			headertext = Finao_Preferences.getString("headertext", "");
			Finaostory = Finao_Preferences.getString("MyStory", "");
			if(!Finaostory.equalsIgnoreCase("null"))
				ProfileStory_TV.setText(Finaostory);
			ProfileStory_TV.setTextSize((float) 16.5);
			ProfileStory_TV.setScrollbarFadingEnabled(false);
			if(fs != null && url3 != null){
				new CountAssyTask(url3, "no", headerToken).execute();
			}
			//new CountAssyTask(url3, "no", headerToken).execute();
			PostBtnclick();
		}

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
		case R.id.profilepagefollwersbtnid:
			FollweresBtnClick();
			break;
		case R.id.profilepagepostbtnid:
			PostBtnclick();
			break;
		case R.id.profilepageinspiredbtnid:
			InspiredBtnclick();
			break;
		case R.id.profilepageprofilepicivid:
			ShowPopUp();
			break;
		case R.id.profilepagemystorytvid:
			EditStory();
			break;
		default:
			break;
		}
	}

	private void FinaoBtnClick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(getResources().getColor(R.color.buttextcol));
			Tiles_Btn.setTextColor(Color.BLACK);
			Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					ProfileBtnActivity.class);
			intent.putExtra("Btn_key", 1);
			intent.putExtra("userid", userid);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", Fname + " " + Lname);

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
			Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					ProfileBtnActivity.class);
			intent.putExtra("Btn_key", 2);
			intent.putExtra("userid", userid);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", Fname + " " + Lname);
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
			Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(getResources().getColor(
					R.color.buttextcol));
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					ProfileBtnActivity.class);
			intent.putExtra("Btn_key", 3);
			intent.putExtra("userid", userid);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", Fname + " " + Lname);
			startActivity(intent);
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void FollweresBtnClick() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

			Finao_Btn.setTextColor(Color.BLACK);
			Tiles_Btn.setTextColor(Color.BLACK);
			Followers_Btn.setTextColor(getResources().getColor(
					R.color.buttextcol));
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			Inspired_Btn.setTextColor(Color.BLACK);

			Intent intent = new Intent(getApplicationContext(),
					ProfileBtnActivity.class);
			intent.putExtra("Btn_key", 4);
			intent.putExtra("userid", userid);
			intent.putExtra("profilepath", Profile_Pic_path);
			intent.putExtra("username", Fname + " " + Lname);
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
			Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			tipinspired.setVisibility(View.INVISIBLE);
			tippost.setVisibility(View.VISIBLE);
			Post_Btn.setTextColor(getResources().getColor(R.color.buttextcol));
			Inspired_Btn.setTextColor(Color.BLACK);

			new PostDetailsAssyncTask(headerToken, userid).execute();

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
			Followers_Btn.setTextColor(Color.BLACK);
			Following_Btn.setTextColor(Color.BLACK);
			Post_Btn.setTextColor(Color.BLACK);
			tippost.setVisibility(View.INVISIBLE);
			tipinspired.setVisibility(View.VISIBLE);
			Inspired_Btn.setTextColor(getResources().getColor(
					R.color.buttextcol));
			new InspiredDetailsAssyncTask(headerToken).execute();

		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	private void ShowPopUp() {
		LayoutInflater inflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View popuplayout = inflater.inflate(R.layout.popup_layout,
				(ViewGroup) findViewById(R.id.popup_menu_root));
		pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
				LayoutParams.MATCH_PARENT, true);
		pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);
	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
	}

	public void clickCamera(View view) {
		pw.dismiss();
		SimpleDateFormat sdf = new SimpleDateFormat("MM_dd_yyyy_hh_mm_ss_a");
		String timestamp = sdf.format(new Date()).toString();
		File evidenceFilesStoragePath = new File(
				Environment.getExternalStorageDirectory() + "/Finao");
		if (!evidenceFilesStoragePath.exists())
			evidenceFilesStoragePath.mkdir();
		mediaFilePath = evidenceFilesStoragePath + "/_" + timestamp + ".png";
		Uri fileUri = Uri.fromFile(new File(mediaFilePath));
		Intent intentforCam = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		intentforCam.putExtra(MediaStore.EXTRA_OUTPUT, fileUri);
		startActivityForResult(intentforCam, TAKE_PHOTO_CAMERA_REQUEST);

	}

	public void clickGallery(View view) {
		pw.dismiss();
		Intent i = new Intent(Intent.ACTION_PICK,
				android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
		i.setType("image/*");
		startActivityForResult(i, GALLERY_REQUEST);
	}

	public void SharePost(View view) {
		// To Do
	}

	public void deletepost(View view) {
		if (pw != null) {
			pw.dismiss();

			AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(
					mActivity);
			alertDialogBuilder.setTitle("FINAO Nation");
			// set dialog message
			alertDialogBuilder
					.setMessage("Do You Want to Delete this POST?")
					.setCancelable(true)
					.setPositiveButton("Yes",
							new DialogInterface.OnClickListener() {
								public void onClick(DialogInterface dialog,
										int id) {
									deletePostAPICall();
								}
							})
					.setNegativeButton("No",
							new DialogInterface.OnClickListener() {
								public void onClick(DialogInterface dialog,
										int id) {
									dialog.cancel();
								}
							});
			AlertDialog alertDialog = alertDialogBuilder.create();
			alertDialog.show();
		}
	}


	private void deletePostAPICall() {
		JsonHelper helper = new JsonHelper();
		MultipartEntity entity = new MultipartEntity();
		try {
			entity.addPart("json", new StringBody("deletepost"));
			entity.addPart("finao_id", new StringBody(delfinaoid));
			entity.addPart("userpostid", new StringBody(delpostid));
			JSONObject obj = helper.getJSONfromURL(fs.baseurl(), headerToken,
					entity);
			if (obj != null && obj.has("IsSuccess")
					&& obj.getString("IsSuccess").equalsIgnoreCase("true")) {
				delfinaoid = "";
				delpostid = "";
				PostBtnclick();
			} else {
				Toast.makeText(getApplicationContext(),
						"Couldn't delete the post.", Toast.LENGTH_SHORT).show();
			}
		} catch (Exception e) {
			Log.e(TAG, e.toString());
			e.printStackTrace();
		}
	}

	private void EditStory() {
		if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
			Intent in = new Intent(getApplicationContext(),
					ProfileEditStory.class);
			in.putExtra("Profile_Page_Story", ProfileStory_TV.getText()
					.toString());
			in.putExtra("Profile_name", Fname + " " + Lname);
			startActivity(in);
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}

	}

	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == TAKE_PHOTO_CAMERA_REQUEST) {
			switch (resultCode) {
			case RESULT_OK:

				if (Constants.LOG)
					Log.i(TAG, "TAKE_PHOTO_CAMERA_REQUEST media file path is :"
							+ mediaFilePath);
				startCropImage(mediaFilePath);

				break;
			case RESULT_CANCELED:
				imageTaken = null;

			}

		} else if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:

				File f = new File(mediaFilePath);
				Profile_Pic_IV.setImageBitmap(decodeFile(f, 200, 200));
				// new ProfileImageUploadAssyn(mediaFilePath).execute();

				break;
			case RESULT_CANCELED:
				// imageTaken = null;
				break;
			}
		} else if (requestCode == GALLERY_REQUEST) {
			if (Constants.LOG)
				Log.v("RequestCode", "" + requestCode);
			if (requestCode == GALLERY_REQUEST && resultCode == RESULT_OK
					&& null != data) {
				Uri selectedImage = data.getData();
				String[] filePathColumn = { MediaStore.Images.Media.DATA };

				Cursor cursor = getContentResolver().query(selectedImage,
						filePathColumn, null, null, null);
				cursor.moveToFirst();
				int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
				mediaFilePath = cursor.getString(columnIndex);
				cursor.close();
				if (Constants.LOG)
					Log.i(TAG, "media file path in gallary :" + mediaFilePath);

				startCropImage(mediaFilePath);

			}
		}
	}

	public static Bitmap decodeFile(File f, int WIDTH, int HIGHT) {
		try {
			// Decode image size
			BitmapFactory.Options o = new BitmapFactory.Options();
			o.inJustDecodeBounds = true;
			BitmapFactory.decodeStream(new FileInputStream(f), null, o);

			// The new size we want to scale to
			final int REQUIRED_WIDTH = WIDTH;
			final int REQUIRED_HIGHT = HIGHT;
			// Find the correct scale value. It should be the power of 2.
			int scale = 1;
			while (o.outWidth / scale / 2 >= REQUIRED_WIDTH
					&& o.outHeight / scale / 2 >= REQUIRED_HIGHT)
				scale *= 2;

			// Decode with inSampleSize
			BitmapFactory.Options o2 = new BitmapFactory.Options();
			o2.inSampleSize = scale;
			return BitmapFactory.decodeStream(new FileInputStream(f), null, o2);
		} catch (FileNotFoundException e) {
		}
		return null;
	}

	private void startCropImage(String imagePath) {
		Intent intent = new Intent(FinaoProfilePage.this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);
		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);
		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			exitByBackKey();

			return true;
		}
		return super.onKeyDown(keyCode, event);
	}

	protected void exitByBackKey() {
		AlertDialog alertbox = new AlertDialog.Builder(this)
				.setMessage("Do you want to exit application?")
				.setPositiveButton("Yes",
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface arg0, int arg1) {
								System.exit(0);
							}
						})
				.setNegativeButton("No", new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface arg0, int arg1) {
					}
				}).show();
	}

	private class CountAssyTask extends AsyncTask<String, String, JSONObject> {
		String Url;
		String Con;
		String thisHeaderToken;
		String json = null;
		String line = null;

		public CountAssyTask(String url, String con, String headerToken) {
			Url = url;
			Con = con;
			thisHeaderToken = headerToken;
		}

		@Override
		protected JSONObject doInBackground(String... arg0) {
			JSONObject jObj = null;
			DefaultHttpClient httpClient = new DefaultHttpClient();
			HttpPost httpGet = new HttpPost(Url);
			MultipartEntity entity = null;
			try {
				entity = new MultipartEntity();
				entity.addPart("json", new StringBody("user_details"));
			} catch (UnsupportedEncodingException e2) {
				e2.printStackTrace();
			}
			httpGet.setEntity(entity);
			httpGet.setHeader("Authorization", "Basic " + thisHeaderToken);
			httpGet.setHeader("Finao-Token", thisHeaderToken);
			HttpResponse httpResponse = null;
			try {
				httpResponse = httpClient.execute(httpGet);
				HttpEntity httpEntity = httpResponse.getEntity();
				InputStream is = null;
				is = httpEntity.getContent();
				BufferedReader reader = new BufferedReader(
						new InputStreamReader(is, "UTF-8"), 8);
				StringBuilder sb = new StringBuilder();

				while ((line = reader.readLine()) != null) {
					sb.append(line + "\n");
				}
				is.close();
				json = sb.toString();
				Log.i("json", json);
				jObj = new JSONObject(json);
			} catch (ClientProtocolException e1) {
				e1.printStackTrace();
			} catch (IOException e1) {
				e1.printStackTrace();
			} catch (Exception e) {
				Log.e("Buffer Error", "Error converting result " + e.toString());
				e.printStackTrace();
			}
			return jObj;
		}

		protected void onPostExecute(JSONObject obj) {
			super.onPostExecute(obj);
			try {
				JSONArray o = obj.getJSONArray("item");
				JSONObject res = o.optJSONObject(0);
				if (Constants.LOG)
					Log.i(TAG, "Inside onPostExecute res:" + res);
				String _Total_Followers = res.getString("totalfollowers");
				String _Total_Following = res.getString("totalfollowings");
				String _Finaos_Count_Str = res.getString("totalfinaos");
				String _Tiles_Count_Str = res.getString("totaltiles");

				Profile_Pic_path = res.getString("profile_image");
				Banner_pic_path = res.getString("banner_image");

				imageLoader.DisplayImage(Profile_Pic_path, Profile_Pic_IV,
						false, true);
				imageLoader.DisplayImage(Banner_pic_path, Banner_pic_Iv, false, true);
				Fname = res.getString("fname");
				Lname = res.getString("lname");
				Finaostory = res.getString("mystory");

				ProfileName_TV.setText(Fname + " " + Lname);
				if(!Finaostory.equalsIgnoreCase("null"))
					ProfileStory_TV.setText(Finaostory);
				ProfileStory_TV.setTextSize((float) 16.5);
				ProfileStory_TV.setScrollbarFadingEnabled(false);

				String Finao_Btn_Text = "<medium> <font >" + _Finaos_Count_Str
						+ "<br />" + "FINAOs" + "</font> </medium>";
				Finao_Btn.setText(Html.fromHtml(Finao_Btn_Text));

				String Finao_Tile_Text = "<medium> <font>" + _Tiles_Count_Str
						+ "<br />" + "Tiles" + "</font> </medium>";
				Tiles_Btn.setText(Html.fromHtml(Finao_Tile_Text));

				String Finao_Following_Text = "<medium> <font >"
						+ _Total_Following + "<br />" + "Following"
						+ "</font> </medium>";
				Following_Btn.setText(Html.fromHtml(Finao_Following_Text));

				String Finao_Followers_Text = "<medium> <font>"
						+ _Total_Followers + "<br />" + "Followers"
						+ "</font> </medium>";
				Followers_Btn.setText(Html.fromHtml(Finao_Followers_Text));

				SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
						.edit();
				Finao_Preference_Editor.putString("TotalFinaos",
						res.getString("totalfinaos"));
				Finao_Preference_Editor.putString("TotalTiles",
						res.getString("totaltiles"));
				Finao_Preference_Editor.putString("TotalFollowers",
						res.getString("totalfollowers"));
				Finao_Preference_Editor.putString("TotalFollowing",
						res.getString("totalfollowings"));
				Finao_Preference_Editor.putString("Profile_Image",
						Profile_Pic_path);
				Finao_Preference_Editor.putString("FName", Fname);
				Finao_Preference_Editor.putString("LName", Lname);
				Finao_Preference_Editor.putString("MyStory", Finaostory);
				Finao_Preference_Editor.putString("Profile_BG_Image",
						Banner_pic_path);

				Finao_Preference_Editor.commit();

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
		ProgressDialog pDialog = new ProgressDialog(FinaoProfilePage.this);
		String Loading_Msg = null;
		GettingInspiredDetailsitem gf;

		public InspiredDetailsAssyncTask(String headerToken) {
			thisHeaderToken = headerToken;
			gf = new GettingInspiredDetailsitem(thisHeaderToken);
			Loading_Msg = "Loading Inspired Items";
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(FinaoProfilePage.this,
					"FINAO Inspired", Loading_Msg, true, true);
		}

		protected Integer doInBackground(Void... params) {
			inspiredDetailsListData = gf.GetInspiredDetailsList(headertext,
					null);
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

	/************** Getting Post Detail Data by service ***********/
	private class PostDetailsAssyncTask extends AsyncTask<Void, Void, Integer> {
		String thisHeaderToken;
		ProgressDialog pDialog = new ProgressDialog(FinaoProfilePage.this);
		String Loading_Msg = null;
		GettingPostDetailsitem gf;

		public PostDetailsAssyncTask(String headerToken, String User_ID) {
			thisHeaderToken = headerToken;
			pDialog.setCancelable(true);
			gf = new GettingPostDetailsitem(thisHeaderToken, User_ID);
			Loading_Msg = "Loading Profile Items";
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = FinaoCustomProgress.show(FinaoProfilePage.this,
					"FINAO Nation", Loading_Msg, true, true);
		}

		protected Integer doInBackground(Void... params) {
			inspiredDetailsListData = gf.GetPostDetailsList(headertext, userid);
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
					Header.setText("No items");
					Toast.makeText(getApplicationContext(), "No Posts Items",
							Toast.LENGTH_SHORT).show();
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
			if (Constants.LOG)
				Log.i(TAG,
						"no of finao items:" + _InspiredDetailsListData.size());
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

		ImageView profile_IM, Video_IM, Finao_Status, btnoptions;
		TextView profilename_TV, Date_TV, up_Tv, Finaocaptiontvid;
		int i = 0;
		LayoutInflater li;
		PagerContainer mContainer;
		ViewPager pager;
		ImagePagerAdapter adapter;
		RelativeLayout rPager, rVideo;

		@Override
		public View getView(final int position, View convertVieww,
				ViewGroup parent) {
			li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
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
			pager = mContainer.getViewPager();

			rPager = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RL);
			rVideo = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RLV);
			btnoptions = (ImageView) convertVieww.findViewById(R.id.btnoptions);
			btnoptions.setVisibility(View.INVISIBLE);

			Finao_Status = (ImageView) convertVieww
					.findViewById(R.id.finaostatusivid);
			if (_InspiredDetailsListData.get(position).getF_Finao_Status()
					.equalsIgnoreCase("1")) {
				Finao_Status.setImageResource(R.drawable.btnaheadhover);
			} else if (_InspiredDetailsListData.get(position)
					.getF_Finao_Status().equalsIgnoreCase("0")) {
				Finao_Status.setImageResource(R.drawable.btnontrackhover);
			} else if (_InspiredDetailsListData.get(position)
					.getF_Finao_Status().equalsIgnoreCase("2")) {
				Finao_Status.setImageResource(R.drawable.btnbehindhover);
			}
			showImageViewPagerContainer();
			hideVideoContainer();

			try {
				if (_InspiredDetailsListData.get(position).getF_imagearray() != null
						&& _InspiredDetailsListData.get(position)
								.getF_imagearray().length() > 0
						&& _InspiredDetailsListData.get(position)
								.getF_imagearray().getJSONObject(0) != null
						&& _InspiredDetailsListData.get(position)
								.getF_imagearray().getJSONObject(0)
								.getString("image_url") != null) {

					adapter = new ImagePagerAdapter(_InspiredDetailsListData
							.get(position).getF_imagearray());
					pager.setAdapter(adapter);
					pager.setOffscreenPageLimit(adapter.getCount());
					pager.setPageMargin(-25);
				} else {
					hideImageViewPagerContainer();
				}
			} catch (JSONException e) {
				hideImageViewPagerContainer();
				e.printStackTrace();
			}

			// remove this when videos get added

			if (_InspiredDetailsListData.get(position).getF_Type() == 0) {
				hideImageViewPagerContainer();
				hideVideoContainer();
			}

			if (_InspiredDetailsListData.get(position).getF_Type() == 2) {
				hideImageViewPagerContainer();
				showVideoContainer();
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

			imageLoader.DisplayImage(imageurl, profile_IM, false, true);
			profilename_TV.setText(_InspiredDetailsListData.get(position)
					.getF_Name());
			Date_TV.setText(_InspiredDetailsListData.get(position).getF_Udate());

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
			convertVieww.setTag(_InspiredDetailsListData.get(position)
					.getF_Type());
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

		ImageView profile_IM, Video_IM, Finao_Status, btnoptions;
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
			btnoptions = (ImageView) convertVieww.findViewById(R.id.btnoptions);

			pager = mContainer.getViewPager();
			Finao_Status = (ImageView) convertVieww
					.findViewById(R.id.finaostatusivid);
			if (fhp.getF_Finao_Status().equalsIgnoreCase("1")) {
				Finao_Status.setImageResource(R.drawable.btnaheadhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("0")) {
				Finao_Status.setImageResource(R.drawable.btnontrackhover);
			} else if (fhp.getF_Finao_Status().equalsIgnoreCase("2")) {
				Finao_Status.setImageResource(R.drawable.btnbehindhover);
			}
			showImageViewPagerContainer();
			hideVideoContainer();
			if (fhp.getF_imagearray() != null
					&& fhp.getF_imagearray().length() > 0) {
				adapter = new ImagePagerAdapter(fhp.getF_imagearray());
				pager.setAdapter(adapter);
				pager.setOffscreenPageLimit(adapter.getCount());
				pager.setPageMargin(-25);
				hideVideoContainer();
			} else {
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
			profilename_TV.setText(Fname + " " + Lname);
			Date_TV.setText(fhp.getF_Udate());

			if (FinUploadtext == null || FinUploadtext.equalsIgnoreCase("")) {
				up_Tv.setVisibility(View.GONE);
			} else {
				up_Tv.setVisibility(View.VISIBLE);
				up_Tv.setText(FinUploadtext);
			}

			Finaocaptiontvid.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View arg0) {
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
					intent.putExtra("F_UserId", userid);
					intent.putExtra("F_Profile_Pic_path", Profile_Pic_path);
					intent.putExtra("F_UserName", Fname + " " + Lname);

					startActivity(intent);
				}
			});
			btnoptions.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View arg0) {
					delfinaoid = _PostDetailsListData.get(position)
							.getF_FinaoID();
					delpostid = _PostDetailsListData.get(position)
							.getF_Post_ID();
					showPopup(arg0.getContext());
				}
			});

			convertVieww.setTag(fhp.getF_Type());

			return convertVieww;
		}

		public void showPopup(Context context) {
			LayoutInflater inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			View popuplayout = inflater.inflate(R.layout.popup_options,
					(ViewGroup) findViewById(R.id.popup_menu_root));
			pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
					LayoutParams.MATCH_PARENT, true);
			pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);
 
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
		public float getPageWidth(int position) {
			if(getCount()>1)
				return 0.99f;
			else
				return 1.0f;
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
				public void onClick(View arg0) {
					Intent in = new Intent(getApplicationContext(),
							DisplayHomeImages.class);
					in.putExtra("ProfilePicPath", imgar.get(position));
					startActivity(in);
				}
			});

			return layout;
		}

		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			((ViewPager) container).removeView((View) object);
		}
	}

}
