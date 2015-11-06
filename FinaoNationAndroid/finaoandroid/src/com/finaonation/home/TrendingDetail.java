package com.finaonation.home;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.MediaPlayer.OnCompletionListener;
import android.media.MediaPlayer.OnPreparedListener;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.view.ViewPager.LayoutParams;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.MediaController;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.VideoView;

import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.beanclasses.TrendingDetailPojo;
import com.finaonation.finao.R;
import com.finaonation.internet.InternetChecker;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.profile.DisplayHomeImages;
import com.finaonation.profile.ProfileEditStory;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class TrendingDetail extends Activity implements OnTouchListener {

	ImageView Profile_ImgIV, Status_IV;
	TextView Finao_MessageTV, Date_TV;
	ListView Finao_Detail_LV;
	Activity mActivity;
	String Profile_Pic_Path, Finao_Message, User_ID, Finao_ID, Key, Fin_Date,
			Fin_Status, Fin_Is_Completed, Fin_Is_Public, finao_status,
			Iscompleted, _MyStory_SPS_Str, _UserID_SPS_Str, result, Tile_ID;
	TextView FinaoStatus_TV;
	ImageLoader imageLoader;
	Button Options_Btn;
	Dialog dl;
	ImageView imgbtnOntrack;
	ImageView imgbtnahead;
	ImageView imgbtnbehind;
	ImageView imgbtncomplete;
	private PopupWindow pw;
	private String mediaFilePath = "";
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 1;
	private static final int GALLERY_REQUEST = 2;
	private static final int videoplayback = 3;
	public static final String TAG = null;
	private Bitmap imageTaken;
	InternetChecker ic;
	FrameLayout videoframe;
	String headerToken;
	SharedPreferences Finao_Preferences;
	private SharedPreferences.Editor Finao_Preference_Editor;
	int seektime;
	private String rtsp;
	private VideoView videoPlayer;
	private AudioManager mAudioManager;
	MediaController mediaController;
	TextView cap;
	ImageView Img_Iv;
	ImageView playbutton;
	ArrayList<TrendingDetailPojo> Detail_Data = new ArrayList<TrendingDetailPojo>();

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		setContentView(R.layout.trending_detail);
		imageLoader = new ImageLoader(this);
		mActivity = this;
		getIDs();
		ic = new InternetChecker();
		Profile_Pic_Path = getIntent().getExtras().getString("ProfileImage");
		Finao_Message = getIntent().getExtras().getString("FinaoMessage");
		User_ID = getIntent().getExtras().getString("UserID");
		Finao_ID = getIntent().getExtras().getString("FinaoID");
		Key = getIntent().getExtras().getString("Options_Key");
		Fin_Date = getIntent().getExtras().getString("FinDate");
		Fin_Status = getIntent().getExtras().getString("FinStatus");
		Fin_Is_Completed = getIntent().getExtras().getString("FinIsCompleted");
		Fin_Is_Public = getIntent().getExtras().getString("FinIsPublic");
		Tile_ID = getIntent().getExtras().getString("TileID");

		@SuppressWarnings("deprecation")
		final SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		_MyStory_SPS_Str = Finao_Preferences.getString("MyStory", "");
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");

		if (Key.equalsIgnoreCase("one")) {
			Options_Btn.setVisibility(View.GONE);
			Status_IV.setVisibility(View.VISIBLE);
			Date_TV.setVisibility(View.VISIBLE);
			Date_TV.setText(Fin_Date);
			setPorfileImage(Profile_Pic_Path);

			Profile_ImgIV.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
				}
			});

			if (getIntent().getExtras().getString("Follow")
					.equalsIgnoreCase("0")) {
				FinaoStatus_TV.setText("Follow");
			} else if (getIntent().getExtras().getString("Follow")
					.equalsIgnoreCase("1")) {
				FinaoStatus_TV.setText("UnFollow");
			}

			FinaoStatus_TV.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {

					if (FinaoStatus_TV.getText().toString()
							.equalsIgnoreCase("Follow")) {
						TextView bt = (TextView) v
								.findViewById(R.id.finao_statu_tvid);
						bt.setText("UnFollow");
						FinaoServiceLinks fs = new FinaoServiceLinks();
						String str = fs.NameSpace();
						String str1 = str + "addTracker&tracker_userid="
								+ User_ID + "";
						String str2 = str1 + "&tracked_userid="
								+ _UserID_SPS_Str + "";
						String str3 = str2 + "&tracked_tileid=" + Tile_ID + "";
						String str4 = str3 + "&status=1";
						new FollowUnFollowAssyntask(str4).execute();
						if (Constants.LOG)
							Log.d("un follow url", str4);
					} else {
						TextView bt = (TextView) v
								.findViewById(R.id.finao_statu_tvid);
						bt.setText("Follow");
						FinaoServiceLinks fs = new FinaoServiceLinks();
						String str = fs.NameSpace();
						String str1 = str + "addTracker&tracker_userid="
								+ User_ID + "";
						String str2 = str1 + "&tracked_userid="
								+ _UserID_SPS_Str + "";
						String str3 = str2 + "&tracked_tileid=" + Tile_ID + "";
						String str4 = str3 + "&status=0";
						if (Constants.LOG)
							Log.d("follow url", str4);
						new FollowUnFollowAssyntask(str4).execute();
					}

				}
			});

		} else if (Key.equalsIgnoreCase("two")) {

			if (Fin_Is_Public.equalsIgnoreCase("0")) {
				FinaoStatus_TV.setText("Private");
			} else if (Fin_Is_Public.equalsIgnoreCase("1")) {
				FinaoStatus_TV.setText("Public");
			}

			FinaoStatus_TV.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					TextView tv = (TextView) v
							.findViewById(R.id.finao_statu_tvid);
					FinaoServiceLinks FS = new FinaoServiceLinks();
					String str = FS.NameSpace();
					if (tv.getText().toString().equalsIgnoreCase("Private")) {
						tv.setText("Public");
						String Update_String = str
								+ "modifyfiano&user_id="
								+ _UserID_SPS_Str
								+ "&finao_msg=Impresive%20boss&finao_status_ispublic="
								+ 1 + "&updatedby=" + _UserID_SPS_Str
								+ "&finao_status=" + Fin_Status
								+ "&iscompleted=" + Fin_Is_Completed
								+ "&finao_id=" + Finao_ID;

						new IsPublicUpdateTask(Update_String).execute();
					} else {
						tv.setText("Private");
						String Update_String = str
								+ "modifyfiano&user_id="
								+ _UserID_SPS_Str
								+ "&finao_msg=Impresive%20boss&finao_status_ispublic="
								+ 0 + "&updatedby=" + _UserID_SPS_Str
								+ "&finao_status=" + Fin_Status
								+ "&iscompleted=" + Fin_Is_Completed
								+ "&finao_id=" + Finao_ID;
						new IsPublicUpdateTask(Update_String).execute();
					}
				}
			});

			setFinaoImage(Profile_Pic_Path);

			Options_Btn.setVisibility(View.VISIBLE);
			Status_IV.setVisibility(View.VISIBLE);
			Date_TV.setVisibility(View.VISIBLE);
			Date_TV.setText(Fin_Date);
			if (Fin_Status.equalsIgnoreCase("38")) {
				Status_IV.setImageResource(R.drawable.btnontrackhover);
			} else if (Fin_Status.equalsIgnoreCase("39")) {
				Status_IV.setImageResource(R.drawable.btnaheadhover);
			} else if (Fin_Status.equalsIgnoreCase("40")) {
				Status_IV.setImageResource(R.drawable.btnbehindhover);
			} else {
				Status_IV.setImageResource(R.drawable.btnontrackhover);
			}
			Status_IV.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {

					finao_status_alertdailogue(Fin_Status, Fin_Is_Completed,
							Finao_ID, Fin_Is_Public);
				}
			});

		} else {
			setFinaoImage(Profile_Pic_Path);

			Options_Btn.setVisibility(View.GONE);
			Status_IV.setVisibility(View.VISIBLE);
			Date_TV.setVisibility(View.VISIBLE);
			Date_TV.setText(Fin_Date);

			if (Fin_Status.equalsIgnoreCase("38")) {
				Status_IV.setImageResource(R.drawable.btnontrackhover);
			} else if (Fin_Status.equalsIgnoreCase("39")) {
				Status_IV.setImageResource(R.drawable.btnaheadhover);
			} else if (Fin_Status.equalsIgnoreCase("40")) {
				Status_IV.setImageResource(R.drawable.btnbehindhover);
			} else {
				Status_IV.setImageResource(R.drawable.btnontrackhover);
			}
		}
		Profile_ImgIV.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				// ShowPopUp();
			}
		});

		Options_Btn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				ShowOptionsPopUp();
			}
		});

		new TrendDetailsListAssyn(User_ID, Finao_ID, headerToken).execute();
	}

	private class FollowUnFollowAssyntask extends
			AsyncTask<String, Void, String> {

		String URL;
		ProgressDialog pDialog = new ProgressDialog(TrendingDetail.this);

		public FollowUnFollowAssyntask(String str4) {
			this.URL = str4;
		}

		@Override
		protected void onPreExecute() {
			pDialog.setMessage("Updating Please Wait.....");
			pDialog.setCancelable(true);
			pDialog.show();
		}

		@Override
		protected String doInBackground(String... params) {
			JSonHelper jh = new JSonHelper();

			JSONObject json = jh.getJSONfromURL(URL, headerToken);
			try {
				String response = json.getString("res");
				int no = Integer.parseInt(response);
				if (no != 0) {
					Toast.makeText(getApplicationContext(), "Success",
							Toast.LENGTH_SHORT).show();

				}
			} catch (Exception e) {
			}
			return null;
		}

		@Override
		protected void onPostExecute(String result) {
			pDialog.dismiss();

		}
	}

	public class IsPublicUpdateTask extends AsyncTask<String, Void, String> {

		ProgressDialog pDialog = new ProgressDialog(mActivity);
		String URL;

		public IsPublicUpdateTask(String update_String) {
			this.URL = update_String;
		}

		@Override
		protected void onPreExecute() {
			pDialog.setMessage("Updating Please Wait.....");
			pDialog.setCancelable(true);
			pDialog.show();
		}

		@Override
		protected String doInBackground(String... params) {
			JSonHelper jh = new JSonHelper();
			if (Constants.LOG)
				Log.d(TAG, "URL is " + URL);
			JSONObject json = jh.getJSONfromURL(URL, headerToken);
			try {
				String response = json.getString("res");
				Log.i(TAG, "response is " + response);
				int no = Integer.parseInt(response);
				if (no != 0) {
					Toast.makeText(getApplicationContext(), "Success",
							Toast.LENGTH_SHORT).show();
				}
			} catch (Exception e) {
				e.printStackTrace();
			}

			return null;
		}

		@Override
		protected void onPostExecute(String result) {
			pDialog.dismiss();
		}
	}

	@Override
	protected void onResume() {
		super.onResume();
		@SuppressWarnings("deprecation")
		final SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		String mess = Finao_Preferences.getString("Finao_Message", "");
		if (!mess.equalsIgnoreCase("")) {
			Finao_MessageTV.setText(mess);
		} else {
			Finao_MessageTV.setText(Finao_Message);
		}
		SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
				.edit();
		Finao_Preference_Editor.putString("Finao_Message", "");
		Finao_Preference_Editor.commit();
	}

	public void finao_status_alertdailogue(String Userfinao_status,
			String Userfinao_iscompleted, final String Finao_ID,
			final String Fin_ispublic) {
		dl = new Dialog(TrendingDetail.this);
		dl.setCanceledOnTouchOutside(true);
		dl.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dl.setContentView(R.layout.finaostatuschangepopup);
		dl.setTitle("Select One");

		WindowManager.LayoutParams wmlp = dl.getWindow().getAttributes();
		wmlp.gravity = Gravity.CENTER | Gravity.LEFT;
		wmlp.x = 50; // x position
		wmlp.y = 50; // y position

		// -----------------------------------------
		// --Popup Button Start Here----------------
		// -----------------------------------------
		imgbtnOntrack = (ImageView) dl.findViewById(R.id.imgbtnOntrack);
		imgbtnahead = (ImageView) dl.findViewById(R.id.imgbtnahead);
		imgbtnbehind = (ImageView) dl.findViewById(R.id.imgbtnbehind);
		imgbtncomplete = (ImageView) dl.findViewById(R.id.imgbtncomplete);

		if (Userfinao_status.equalsIgnoreCase("38")) {
			finao_status = "38";
			imgbtnOntrack.setImageResource(R.drawable.btnontrackhover);

		} else if (Userfinao_status.equalsIgnoreCase("39")) {
			finao_status = "39";
			imgbtnahead.setImageResource(R.drawable.btnaheadhover);

		} else if (Userfinao_status.equalsIgnoreCase("40")) {
			finao_status = "40";
			imgbtnbehind.setImageResource(R.drawable.btnbehindhover);
		}

		if (Userfinao_iscompleted.equalsIgnoreCase("1")) {
			Iscompleted = "1";
			imgbtncomplete.setImageResource(R.drawable.btncompletehover);
		} else {
			Iscompleted = "0";
			imgbtncomplete.setImageResource(R.drawable.btncomplete);
		}

		imgbtnOntrack.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				setnormalimages();
				finao_status = "38";
				imgbtnOntrack.setImageResource(R.drawable.btnontrackhover);
				Status_IV.setImageResource(R.drawable.btnontrackhover);
				jsonexecute(Finao_ID, Fin_ispublic, headerToken);
			}
		});

		imgbtnahead.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				setnormalimages();
				finao_status = "39";
				Status_IV.setImageResource(R.drawable.btnaheadhover);
				imgbtnahead.setImageResource(R.drawable.btnaheadhover);
				jsonexecute(Finao_ID, Fin_ispublic, headerToken);
			}
		});

		imgbtnbehind.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				setnormalimages();
				finao_status = "40";
				Status_IV.setImageResource(R.drawable.btnbehindhover);
				imgbtnbehind.setImageResource(R.drawable.btnbehindhover);
				jsonexecute(Finao_ID, Fin_ispublic, headerToken);
			}
		});

		imgbtncomplete.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				Iscompleted = "1";
				imgbtncomplete.setImageResource(R.drawable.btncompletehover);
				finish();
				jsonexecute(Finao_ID, Fin_ispublic, headerToken);
			}
		});
		dl.show();

	}

	public void jsonexecute(String Fin_id, String Fin_ispub, String token) {
		try {

			FinaoServiceLinks FS = new FinaoServiceLinks();
			String str = FS.NameSpace();
			String str1 = str + "modifyfiano&user_id=" + _UserID_SPS_Str
					+ "&finao_status_ispublic=" + Fin_ispub + "&updatedby="
					+ _UserID_SPS_Str + "&finao_status=" + finao_status
					+ "&iscompleted=" + Iscompleted + "&finao_id=" + Fin_id;

			String temp = str1;
			temp = temp.replaceAll(" ", "%20");
			String URL_Str = temp;

			if (Constants.LOG)
				Log.v("Status_Update_URL", URL_Str);
			// ArrayList<HashMap<String, String>> mylist = new
			// ArrayList<HashMap<String, String>>();

			if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
				// Get the data (see above)
				JSonHelper jh = new JSonHelper();
				JSONObject json = jh.getJSONfromURL(URL_Str, token);

				try {
					// Get the element
					String res = json.getString("res");
					try {
						String strrr = "OK";
						if (res.equalsIgnoreCase(strrr)) {
							dl.dismiss();
						}
					} catch (Exception e) {
						result = json.getString("res");
					}
				} catch (JSONException e) {
					if (Constants.LOG)
						Log.e("log_tag", "Error parsing data " + e.toString());
				}
			}
		} catch (Exception e) {
			Toast.makeText(getApplicationContext(), "Fail", Toast.LENGTH_SHORT)
					.show();
		}
	}

	@SuppressWarnings("deprecation")
	private void ShowOptionsPopUp() {
		LayoutInflater inflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View popuplayout = inflater.inflate(R.layout.popup_options_layout,
				(ViewGroup) findViewById(R.id.popup_menu_root));
		pw = new PopupWindow(popuplayout, LayoutParams.FILL_PARENT,
				LayoutParams.WRAP_CONTENT, true);
		pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);
	}

	public void moveFinao(View view) {
		if (pw != null) {
			pw.dismiss();

			Intent in = new Intent(getApplicationContext(),
					SelectTileToMove.class);
			in.putExtra("Finao_ID", Finao_ID);
			in.putExtra("Tile_ID", Tile_ID);
			startActivity(in);
		}
	}

	public void deleteFinao(View view) {
		if (pw != null) {
			pw.dismiss();

			AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(
					mActivity);

			// set title
			alertDialogBuilder.setTitle("FINAO Nation");
			// set dialog message
			alertDialogBuilder
					.setMessage("Do You Want to Delete this FINAO")
					.setCancelable(true)
					.setPositiveButton("Yes",
							new DialogInterface.OnClickListener() {
								public void onClick(DialogInterface dialog,
										int id) {
									// if this button is clicked, close
									// current activity
									FinaoServiceLinks fs = new FinaoServiceLinks();
									String str = fs.NameSpace();
									String str1 = str + "deletefinao&user_id="
											+ _UserID_SPS_Str;
									String Delete_Finao_URL = str1 + "&id="
											+ Finao_ID;

									String temp = Delete_Finao_URL.replaceAll(
											" ", "%20");
									if (Constants.LOG)
										Log.d("Delete_Finao_URL", temp);

									JSonHelper jh = new JSonHelper();
									JSONObject json = jh.getJSONfromURL(temp,
											headerToken);
									try {
										String res = json.getString("res");
										String resss = "OK";
										if (res.equalsIgnoreCase(resss)) {
											Toast.makeText(
													mActivity,
													"Finao Deleted Successfully",
													Toast.LENGTH_SHORT).show();
											Intent in = new Intent(mActivity,
													FinaoFooterTab.class);
											in.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
											startActivity(in);
										}
									} catch (Exception e) {
										e.printStackTrace();
									}
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

	public void changeFinao(View view) {
		if (pw != null) {
			pw.dismiss();
		}
		Intent in = new Intent(mActivity, ProfileEditStory.class);
		in.putExtra("TrendingDetail", Finao_MessageTV.getText().toString());
		in.putExtra("FinaoSelectedID", Finao_ID);
		startActivity(in);
	}

	public void cancelOptionPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
	}

	@SuppressWarnings("deprecation")
	private void ShowPopUp() {
		LayoutInflater inflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View popuplayout = inflater.inflate(R.layout.popup_layout,
				(ViewGroup) findViewById(R.id.popup_menu_root));
		pw = new PopupWindow(popuplayout, LayoutParams.FILL_PARENT,
				LayoutParams.WRAP_CONTENT, true);
		pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);
	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
	}

	public void clickCamera(View view) {
		pw.dismiss();
		// Toast.makeText(getBaseContext(), "Tapped CAMERA", Toast.LENGTH_SHORT)
		// .show();

		SimpleDateFormat sdf = new SimpleDateFormat("MM_dd_yyyy_hh_mm_ss_a");
		String timestamp = sdf.format(new Date()).toString();
		File evidenceFilesStoragePath = new File(
				Environment.getExternalStorageDirectory() + "/Finao");
		if (!evidenceFilesStoragePath.exists())
			evidenceFilesStoragePath.mkdir();
		mediaFilePath = evidenceFilesStoragePath + "/_" + timestamp + ".png";
		Uri fileUri = Uri.fromFile(new File(mediaFilePath));
		Intent intentforCam = new Intent(
				android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
		// intentforCam.putExtra(MediaStore.EXTRA_OUTPUT, fileUri);
		startActivityForResult(intentforCam, TAKE_PHOTO_CAMERA_REQUEST);

	}

	public void clickGallery(View view) {
		pw.dismiss();

		Intent i = new Intent(Intent.ACTION_PICK,
				android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
		i.setType("image/*");
		startActivityForResult(i, GALLERY_REQUEST);
	}

	class TrendDetailsListAssyn extends AsyncTask<Void, Void, Integer> {

		private static final String TAG = "TrendingDetailAsync";
		ProgressDialog pd = null;
		String UserID, FinaoID;
		String thisToken;

		public TrendDetailsListAssyn(String user_ID, String finao_ID,
				String token) {
			this.FinaoID = finao_ID;
			this.UserID = user_ID;
			thisToken = token;
		}

		@Override
		protected Integer doInBackground(Void... params) {

			GettingTrendingDetails gt = new GettingTrendingDetails();
			Detail_Data = gt.GetTrendDetails(UserID, FinaoID, thisToken);
			return 0;
		}

		@Override
		protected void onPostExecute(Integer result) {
			int no = Detail_Data.size();
			if (no != 0) {
				Finao_Detail_LV.setAdapter(new Myadapter(
						getApplicationContext(), Detail_Data));
			} else {
				Finao_Detail_LV.setAdapter(null);
				Toast.makeText(getApplicationContext(), "No Items",
						Toast.LENGTH_SHORT).show();
			}
			pd.dismiss();
		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pd = FinaoCustomProgress.show(TrendingDetail.this, "FINAO Details",
					"Loading...", true, true);
		}
	}

	class Myadapter extends BaseAdapter {

		Context con;
		ArrayList<TrendingDetailPojo> List_Data;

		public Myadapter(Context applicationContext,
				ArrayList<TrendingDetailPojo> detail_Data) {
			this.con = applicationContext;
			this.List_Data = detail_Data;
		}

		@Override
		public int getCount() {
			return List_Data.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		@Override
		public View getView(final int position, View vw, ViewGroup vwgroup) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			View v = null;
			TrendingDetailPojo tdp = List_Data.get(position);

			final String Type = tdp.getType();
			final String Upload_File_Path = tdp.getUpload_File_Path();
			String Caption = tdp.getCaption();
			String Video_Img = tdp.getVideo_IMG();
			final String video_Source = tdp.getVideo_Source();

			if (Type.equalsIgnoreCase("finaoimage")) {
				v = li.inflate(R.layout.finaotrendingrow, null);
				Img_Iv = (ImageView) v.findViewById(R.id.tendingimgivid);
				cap = (TextView) v.findViewById(R.id.captxt);
				cap.setVisibility(View.GONE);
				if (tdp.getCaption().length() != 0
						&& !tdp.getCaption().equalsIgnoreCase("")) {
					cap.setVisibility(View.VISIBLE);
					if (Constants.LOG)
						Log.i(TAG, " caption in finaoimage" + tdp.getCaption());
					cap.setText(tdp.getCaption());
				} else {
					cap.setVisibility(View.GONE);
				}
				FinaoServiceLinks fs = new FinaoServiceLinks();
				String str = fs.FinaoImagesLink();
				String path = (str + Upload_File_Path).replaceAll(" ", "%20");
				if (Constants.LOG)
					Log.v("Img_Path", path);
				imageLoader.DisplayImage(path, Img_Iv, true, true);

			} else if (Type.equalsIgnoreCase("finaovideo")) {
				v = li.inflate(R.layout.finaovideorow, null);
				Img_Iv = (ImageView) v.findViewById(R.id.imageView1);
				cap = (TextView) v.findViewById(R.id.videocaptxt);
				playbutton = (ImageView) v.findViewById(R.id.imageView22);
				cap.setVisibility(View.GONE);
				if (tdp.getVideoCaptiontext().length() != 0
						&& !tdp.getVideoCaptiontext().equalsIgnoreCase("")) {
					cap.setVisibility(View.VISIBLE);
					cap.setText(tdp.getVideoCaptiontext());
					if (Constants.LOG)
						Log.w(TAG, " caption in finaoimage"
								+ tdp.getVideoCaptiontext().toString());
				} else {
					cap.setVisibility(View.GONE);
				}
				String path = Video_Img.replaceAll(" ", "%20");
				;
				imageLoader.DisplayImage(path, Img_Iv, true, true);
			} else {
				v = li.inflate(R.layout.finaotextorow, null);
				final TextView mess_tv = (TextView) v
						.findViewById(R.id.textView1);
				mess_tv.setText(tdp.getUploadtext());

			}

			v.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					if (Type.equalsIgnoreCase("finaoimage")) {
						Intent in = new Intent(getApplicationContext(),
								DisplayHomeImages.class);
						in.putExtra("ProfilePicPath", Upload_File_Path);
						startActivity(in);
					} else if (Type.equalsIgnoreCase("finaovideo")) {
						String url = Uri.parse(video_Source).toString();
						videoPlayer = (VideoView) v
								.findViewById(R.id.videoPlayer);
						videoframe = (FrameLayout) v
								.findViewById(R.id.framei_IM);
						if (!videoPlayer.isPlaying()) {
							new gettingRstp(url).execute();
							if (Constants.LOG)
								Log.i(TAG, "url:" + url);
						}
						/*
						 * Intent in = new
						 * Intent(getApplicationContext(),com.finaonation
						 * .finao.Videoplayer.class); in.putExtra("videourl",u);
						 * startActivity(in);
						 */
					}
				}
			});

			return v;
		}

	}

	private class gettingRstp extends AsyncTask<String, String, String> {
		String URL;

		public gettingRstp(String url) {
			URL = url;
		}

		ProgressDialog pDialog;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			/*
			 * pDialog = new ProgressDialog(getApplicationContext());
			 * pDialog.setMessage("Loading..."); pDialog.setCancelable(true);
			 * pDialog.show();
			 */
		}

		@Override
		protected String doInBackground(String... params) {
			String rstpuri = getUrlVideoRTSP(URL);
			if (Constants.LOG)
				Log.i(TAG, "rstpuri:" + rstpuri);
			return rstpuri;
		}

		protected void onPostExecute(String obj) {
			super.onPostExecute(obj);
			rtsp = obj;
			Log.i(TAG, "rtsp  url:" + rtsp);

			videoPlayer.setVisibility(View.VISIBLE);
			videoPlayer.setOnTouchListener(TrendingDetail.this);
			videoframe.setVisibility(View.GONE);
			videoPlayer.setVideoURI(Uri.parse(obj));
			MediaController mc = new MediaController(TrendingDetail.this);
			// mc.setAnchorView(videoPlayer);
			videoPlayer.setMediaController(mc);
			videoPlayer.setOnPreparedListener(new OnPreparedListener() {

				@Override
				public void onPrepared(MediaPlayer mp) {
					videoPlayer.start();
				}
			});
			videoPlayer.setOnCompletionListener(new OnCompletionListener() {

				@Override
				public void onCompletion(MediaPlayer mp) {

					videoPlayer.setVisibility(View.GONE);
					videoframe.setVisibility(View.VISIBLE);

				}
			});

		}

	}

	@Override
	public boolean onTouch(View v, MotionEvent event) {
		if (event.getAction() == MotionEvent.ACTION_DOWN) {
			Intent in = new Intent(getApplicationContext(),
					com.finaonation.finao.Videoplayer.class);
			in.putExtra("videourl", rtsp);
			seektime = videoPlayer.getCurrentPosition();
			Log.i(TAG, "seektime:" + seektime);
			in.putExtra("seektime", seektime);
			startActivityForResult(in, videoplayback);
			// videoframe.setVisibility(View.VISIBLE);
			// videoPlayer.setVisibility(View.GONE);
		}
		return super.onTouchEvent(event);
	}

	public static String getUrlVideoRTSP(String urlYoutube) {
		try {
			String gdy = "http://gdata.youtube.com/feeds/api/videos/";
			DocumentBuilder documentBuilder = DocumentBuilderFactory
					.newInstance().newDocumentBuilder();
			String id = extractYoutubeId(urlYoutube);
			if (id != null) {
				URL url = new URL(gdy + id);
				HttpURLConnection connection = (HttpURLConnection) url
						.openConnection();
				Document doc = documentBuilder.parse(connection
						.getInputStream());
				Element el = doc.getDocumentElement();
				NodeList list = el.getElementsByTagName("media:content");// /media:content
				String cursor = urlYoutube;
				for (int i = 0; i < list.getLength(); i++) {
					Node node = list.item(i);
					if (node != null) {
						NamedNodeMap nodeMap = node.getAttributes();
						HashMap<String, String> maps = new HashMap<String, String>();
						for (int j = 0; j < nodeMap.getLength(); j++) {
							Attr att = (Attr) nodeMap.item(j);
							maps.put(att.getName(), att.getValue());
						}
						if (maps.containsKey("yt:format")) {
							String f = maps.get("yt:format");
							if (maps.containsKey("url")) {
								cursor = maps.get("url");
							}
							if (f.equals("1"))
								return cursor;
						}
					}
				}
				return cursor;
			}
		} catch (Exception ex) {
			if (Constants.LOG)
				Log.e("Get Url Video RTSP Exception======>>", ex.toString());
		}
		return urlYoutube;

	}

	protected static String extractYoutubeId(String url)
			throws MalformedURLException {
		String id = null;
		try {
			String query = new URL(url).getQuery();
			if (query != null) {
				String[] param = query.split("&");
				for (String row : param) {
					String[] param1 = row.split("=");
					if (param1[0].equals("v")) {
						id = param1[1];
					}
				}
			} else {
				if (url.contains("embed")) {
					id = url.substring(url.lastIndexOf("/") + 1);
				}
			}
		} catch (Exception ex) {
			Log.e("Exception", ex.toString());
		}
		if (Constants.LOG)
			Log.e(TAG, "id is " + id);
		return id;
	}

	private void setFinaoImage(String profile_Pic_Path2) {
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.FinaoImagesLink();
		String Profile_Pic_path = profile_Pic_Path2.replaceAll(" ", "%20");
		imageLoader.DisplayImage(Profile_Pic_path, Profile_ImgIV, false, true);
	}

	private void setPorfileImage(String profile_Pic_Path2) {
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str = fs.ProfileImagesLink();
		String Profile_Pic_path = profile_Pic_Path2.replaceAll(" ", "%20");
		imageLoader.DisplayImage(Profile_Pic_path, Profile_ImgIV, true, true);
	}

	private void getIDs() {
		Profile_ImgIV = (ImageView) findViewById(R.id.trending_detail_profile_pic_imgid);
		Finao_MessageTV = (TextView) findViewById(R.id.trending_finmessage_tvid);
		Finao_Detail_LV = (ListView) findViewById(R.id.trending_detail_lvid);
		Options_Btn = (Button) findViewById(R.id.detail_options_buttonid);
		Status_IV = (ImageView) findViewById(R.id.finao_detail_status_ivid);
		Date_TV = (TextView) findViewById(R.id.finao_detail_date_tvid);
		FinaoStatus_TV = (TextView) findViewById(R.id.finao_statu_tvid);
	}

	public void setnormalimages() {
		imgbtnOntrack.setImageResource(R.drawable.btnontrack);
		imgbtnahead.setImageResource(R.drawable.btnahead);
		imgbtnbehind.setImageResource(R.drawable.btnbehind);

	}

	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == TAKE_PHOTO_CAMERA_REQUEST) {
			switch (resultCode) {
			case RESULT_OK:
				imageTaken = (Bitmap) data.getExtras().get("data");

				FileOutputStream out = null;
				try {
					out = new FileOutputStream(mediaFilePath);
					imageTaken.compress(Bitmap.CompressFormat.JPEG, 90, out);
					Profile_ImgIV.setImageBitmap(imageTaken);
					new ProfileImageUploadAssyn(mediaFilePath, headerToken)
							.execute();

				} catch (FileNotFoundException e) {
					e.printStackTrace();
				}

				break;
			case RESULT_CANCELED:
				imageTaken = null;
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

				Profile_ImgIV.setImageURI(selectedImage);

				new ProfileImageUploadAssyn(mediaFilePath, headerToken)
						.execute();

			}
		} else if (requestCode == videoplayback) {
			switch (resultCode) {
			case RESULT_OK:
				int setime = data.getExtras().getInt("seektime");
				Log.e("activiity result", "" + setime);
				videoPlayer.seekTo(setime);
				break;
			case RESULT_CANCELED:
				videoPlayer.stopPlayback();
				videoPlayer.setVisibility(View.GONE);
				videoframe.setVisibility(View.VISIBLE);

			}
		}
	}

	private class ProfileImageUploadAssyn extends
			AsyncTask<String, Void, String> {
		String thisHeaderToken;
		int finao_no;
		String resstring;
		String picturePath;

		ProfileImageUploadAssyn(String path, String headerToken) {
			this.picturePath = path;
			thisHeaderToken = headerToken;
		}

		ProgressDialog pDialog = new ProgressDialog(TrendingDetail.this);

		protected void onPreExecute() {
			pDialog.setMessage("Uploading FINAO Image Please Wait");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected String doInBackground(String... params) {
			FinaoServiceLinks FS = new FinaoServiceLinks();
			String str = FS.NameSpace();
			String str1 = str + "changefinao&finao_id=" + Finao_ID
					+ "&finao_msg="
					+ Finao_MessageTV.getText().toString().trim() + "&user_id="
					+ _UserID_SPS_Str;
			String URL_Str = str1;
			String temp = URL_Str.replaceAll(" ", "%20");
			if (Constants.LOG)
				Log.v("LoginURL", temp);

			try {
				HttpClient httpclient = SingleTon.getInstance().getHttpClient();
				HttpPost httppost = new HttpPost(temp);
				if (Constants.LOG == true)
					Log.v("Edit_Profile_Pic", temp);
				FileBody filebodyVideo = new FileBody(new File(picturePath));
				MultipartEntity reqEntity = new MultipartEntity();
				reqEntity.addPart("image", filebodyVideo);
				httppost.setEntity(reqEntity);
				// DEBUG
				httppost.setHeader("Authorization", "Basic " + thisHeaderToken);
				httppost.setHeader("Finao-Token", thisHeaderToken);
				HttpResponse response = httpclient.execute(httppost);
				String res = Util.convertResponseToString(response);
				if (Constants.LOG == true)
					Log.v("EditProfile_Response ", "" + res);
				JSONObject main_obj = new JSONObject(res);
				resstring = main_obj.getString("res");
			} catch (Exception e) {
				e.printStackTrace();
			}
			return resstring;
		}

		protected void onPostExecute(String result) {

			pDialog.dismiss();

			try {
				String resp = "OK";
				if (resstring.equalsIgnoreCase(resp)) {
					Toast.makeText(getApplicationContext(),
							"Image Updated Successfully", Toast.LENGTH_SHORT)
							.show();
					@SuppressWarnings("deprecation")
					SharedPreferences Finao_Preferences = getSharedPreferences(
							"Finao_Preferences", MODE_WORLD_READABLE);
					SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
							.edit();
					Finao_Preference_Editor.putString("Profile_Image",
							picturePath);
					Finao_Preference_Editor.commit();
				}
			} catch (Exception e) {
			}

		}
	}

}
