package com.finaonation.home;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.UUID;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.FinaoHomePojo;
import com.finaonation.finao.FinaoDetailsView;
import com.finaonation.finao.FinaoLoginOrRegister;
import com.finaonation.finao.NotificationActivity;
import com.finaonation.finao.PagerContainer;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.profile.DisplayHomeImages;
import com.finaonation.search.Finaopersonalprofile;
import com.finaonation.utils.Constants;
import com.finaonation.utils.DeviceUuidFactory;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class FinaoHome extends Activity {

	public static final String TAG = "FinaoHome";
	public static final String NOTIFICATION_DATA = "NOTIFICATION_DATA";
	private ImageLoader imageLoader;
	private com.finaonation.utils.Finaolistview HomeList_LV;
	private String _UserID_SPS_Str;
	private Boolean share;
	private ArrayList<FinaoHomePojo> Followers_List_Data = new ArrayList<FinaoHomePojo>();
	private SharedPreferences Finao_Preferences;
	private SharedPreferences.Editor Finao_Preference_Editor;
	private TextView Header;
	private PopupWindow pw;
	private String headerToken;
	private FinaoHomePojo fhp;
	private String followtileid = "", markpostid = "", followeduserid = "";
	private String F_name;
	private String FinTitle;
	private String FinDate;
	private String ProfilePicPath;
	private String FinStatus;
	private String FinUploadtext;

	@SuppressWarnings("unused")
	private String str;
	private String Profile_Pic_path;
	private FinaoServiceLinks fs = new FinaoServiceLinks();
	private String finurl;
	Toast toast;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.finaohomepage);
	}

	private void refreshHomeContent() {
		imageLoader = new ImageLoader(this);
		Header = (TextView) findViewById(R.id.header);
		HomeList_LV = (com.finaonation.utils.Finaolistview) findViewById(R.id.homelistlvid);
		@SuppressWarnings("deprecation")
		SharedPreferences Finao_Preferences1 = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		_UserID_SPS_Str = Finao_Preferences1.getString("User_ID", "");
		com.finaonation.internet.InternetChecker ic = new com.finaonation.internet.InternetChecker();

		boolean b = ic.IsNetworkAvailable(getApplicationContext());
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		DeviceUuidFactory uuid = new DeviceUuidFactory();
		UUID ff = uuid.getDeviceUuidFactory(getApplicationContext());
		if (Constants.LOG)
			Log.i(TAG, "uuid:" + ff.toString());
		if (b == true) {
			new ProfilePageAssyncTask(headerToken).execute();
		} else {
			toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection and Come back.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
			toast.show();
		}
	}

	@SuppressWarnings("deprecation")
	@Override
	protected void onResume() {
		super.onResume();
		refreshHomeContent();
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		share = Finao_Preferences.getBoolean("share", false);

		String Login_Key = Finao_Preferences.getString("Login_Session", "");
		headerToken = Finao_Preferences.getString("logtoken", "");
		if (share) {
			Intent shareIntent = new Intent(android.content.Intent.ACTION_SEND);
			shareIntent.setType("text/plain");
			shareIntent.putExtra(android.content.Intent.EXTRA_SUBJECT,
					"My FNIAO");
			shareIntent.putExtra(android.content.Intent.EXTRA_TEXT,
					"http://www.finaonation.com");

			startActivity(Intent.createChooser(shareIntent, "Share FINAO via"));

			Finao_Preference_Editor = Finao_Preferences.edit();
			Finao_Preference_Editor.putBoolean("share", false);
			Finao_Preference_Editor.commit();
		} else if (Login_Key.length() == 0) {
			Intent i = new Intent(getApplicationContext(),
					FinaoLoginOrRegister.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(i);
			finish();
		}

		JsonHelper js = new JsonHelper();
		MultipartEntity entity = new MultipartEntity();
		try {
			entity.addPart("json", new StringBody("getnotificationscount"));
			JSONObject obj = js.getJSONfromURL(fs.baseurl(), headerToken,
					entity);
			if (obj.has("item")) {
				JSONArray arr = obj.getJSONArray("item");
				int count = Integer.parseInt(arr.getJSONObject(0).getString(
						"count"));
				Log.i(TAG, "count = " + count);
				if (count > 0) {
					Toast.makeText(
							getApplicationContext(),
							""
									+ count
									+ " Notifications waiting for you. Click Settings, notifications to see details please.",
							Toast.LENGTH_LONG).show();
					if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN) {
						createNotificationJellyBean(count);
					} else
						createNotification(Calendar.getInstance()
								.getTimeInMillis(), Integer.toString(count));
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
			Log.e(TAG, "error = " + e.toString());
		}

	}

	private void createNotification(long when, String count) {
		Log.i(TAG, "count = " + count);
		String notificationContent = "";// "Click for more details";
		String notificationTitle = count
				+ " unread notifications are available.";
		Bitmap largeIcon = BitmapFactory.decodeResource(getResources(),
				R.drawable.ic_launcher);
		int smalIcon = R.drawable.heeaderlogo;
		Intent intent = new Intent(this, NotificationActivity.class);
		PendingIntent pendingIntent = PendingIntent.getActivity(
				getApplicationContext(), 0, intent,
				Intent.FLAG_ACTIVITY_NEW_TASK);
		NotificationManager notificationManager = (NotificationManager) getApplicationContext()
				.getSystemService(Context.NOTIFICATION_SERVICE);

		/* build the notification */
		NotificationCompat.Builder notificationBuilder = new NotificationCompat.Builder(
				getApplicationContext())
				.setWhen(when)
				.setContentText(notificationContent)
				.setContentTitle(notificationTitle)
				.setSmallIcon(smalIcon)
				.setAutoCancel(true)
				.setTicker(notificationTitle)
				.setLargeIcon(largeIcon)
				.setDefaults(
						Notification.DEFAULT_LIGHTS
								| Notification.DEFAULT_VIBRATE
								| Notification.DEFAULT_SOUND)
				.setContentIntent(pendingIntent);
		Notification notification = notificationBuilder.build();
		notificationManager.notify((int) when, notification);
	}

	// Build.VERSION.SDK_INT>=Build.VERSION_CODES.JELLY_BEAN
	private void createNotificationJellyBean(int count) {
		Intent intent = new Intent(this, NotificationActivity.class);
		PendingIntent pIntent = PendingIntent.getActivity(this, 0, intent, 0);
		Log.i(TAG, "count = " + count);
		// Build notification
		// Actions are just fake
		Notification noti = new Notification.Builder(this)
				.setContentTitle(count + " unread notifications are available.")
				.setContentText("").setSmallIcon(R.drawable.heeaderlogo)
				.setContentIntent(pIntent)
				.addAction(R.drawable.heeaderlogo, "Call", pIntent)
				.addAction(R.drawable.heeaderlogo, "More", pIntent)
				.addAction(R.drawable.heeaderlogo, "And more", pIntent).build();
		NotificationManager notificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
		// hide the notification after its selected
		noti.flags |= Notification.FLAG_AUTO_CANCEL;

		notificationManager.notify(0, noti);
	}

	public void Settingsclick(View v) {
		Intent in = new Intent(FinaoHome.this, SettingActivity.class);
		overridePendingTransition(R.anim.slide_in, R.anim.slide_out);
		startActivity(in);
	}

	private class ProfilePageAssyncTask extends
			AsyncTask<String, Void, Integer> {

		ProgressDialog pDialog;
		String Loading_Msg = null;
		String header;
		GettingHomeItems gh = null;

		public ProfilePageAssyncTask(String headerToken) {
			header = headerToken;
			Loading_Msg = "Loading Home items";
			gh = new GettingHomeItems(header);
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = FinaoCustomProgress.show(FinaoHome.this, "FINAO Nation",
					Loading_Msg, true, true);
		}

		protected Integer doInBackground(String... params) {
			SharedPreferences Finao_Preferences = getSharedPreferences("Finao_Preferences", Context.MODE_WORLD_READABLE);
			String selfUserId = Finao_Preferences.getString("User_ID", "");
			Followers_List_Data = gh.GetHomeList(_UserID_SPS_Str, header, selfUserId);

			return 0;
		}

		protected void onPostExecute(Integer result) {
			int no = Followers_List_Data.size();
			if (Constants.LOG)
				Log.d(TAG, "no:" + no);
			if (no != 0) {
				HomeList_LV.setAdapter(new HomeListAdapter(
						getApplicationContext(), Followers_List_Data));
			} else {
				HomeList_LV.setAdapter(null);
				Header.setVisibility(View.VISIBLE);
			}
			pDialog.dismiss();
		}

	}

	@SuppressWarnings("unused")
	private class HomeListAdapter extends BaseAdapter {

		Context con;
		ArrayList<FinaoHomePojo> hlist;
		ViewHolder holder = null;

		public HomeListAdapter(Context applicationContext,
				ArrayList<FinaoHomePojo> hlist) {
			this.con = applicationContext;
			this.hlist = hlist;
			if (Constants.LOG)
				Log.i(TAG, "no of home items:" + hlist.size());
		}

		@Override
		public int getCount() {
			return hlist.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		private class ViewHolder {
			ImageView profile_IM, video_PlayIM;
			ImageView finao_IM;
			ImageView finaoStatus_IM;
			TextView profilename_TV;
			TextView Date_TV, up_Tv;
			TextView Finaostory_TV, FinaoFoll_TV;
			TextView Finaocaptiontvid;
			TextView Finaostoryline;
			RelativeLayout Finaoimgi_RL;
			ImageView Is_Inspired, btnoptions;
		}

		int i = 0;
		PagerContainer mContainer;
		ViewPager mPager;
		LinearLayout lPager;
		ViewPager pager;
		LayoutInflater li;

		@Override
		public View getView(final int position, View convertView,
				ViewGroup viewGroup) {
			li = (LayoutInflater) con
					.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
			if (i++ > 4) {
				i = 0;
				new Thread() {
					@Override
					public void run() {
						System.gc();
					}
				}.start();
			}
			if (convertView == null || convertView.getTag() == null) {
				convertView = li.inflate(R.layout.finaohomerow, null);
				holder = new ViewHolder();
				holder.profile_IM = (ImageView) convertView
						.findViewById(R.id.Profile_IMs);
				holder.finao_IM = (ImageView) convertView
						.findViewById(R.id.finaoimgivid);
				holder.finaoStatus_IM = (ImageView) convertView
						.findViewById(R.id.finaostatusivid);
				holder.profilename_TV = (TextView) convertView
						.findViewById(R.id.finaorowfingmsgtvid);

				holder.Date_TV = (TextView) convertView
						.findViewById(R.id.finaodatetvid);
				holder.Finaostory_TV = (TextView) convertView
						.findViewById(R.id.plvstory);
				holder.Finaostoryline = (TextView) convertView
						.findViewById(R.id.finaostoryline);

				holder.FinaoFoll_TV = (TextView) convertView
						.findViewById(R.id.finao_statu_tvid);
				holder.up_Tv = (TextView) convertView
						.findViewById(R.id.upload_Tv);
				holder.Finaocaptiontvid = (TextView) convertView
						.findViewById(R.id.Finaocaptiontvid);
				holder.video_PlayIM = (ImageView) convertView
						.findViewById(R.id.video);
				holder.Finaoimgi_RL = (RelativeLayout) convertView
						.findViewById(R.id.finaoimgi_RL);
				holder.Is_Inspired = (ImageView) convertView
						.findViewById(R.id.btninspire);
				holder.btnoptions = (ImageView) convertView
						.findViewById(R.id.btnoptions);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}
			fhp = Followers_List_Data.get(position);
			F_name = fhp.getProfileUserName();
			FinTitle = fhp.getF_FinaoMsg();
			FinDate = fhp.getF_Udate();
			ProfilePicPath = fhp.getProfileImage();
			FinStatus = fhp.getF_FinaoStatus();
			FinUploadtext = fhp.getF_Upload_Text();
			Profile_Pic_path = fs.ProfileImagesLink() + ProfilePicPath;
			imageLoader
					.DisplayImage(Profile_Pic_path, holder.profile_IM, false, true);
			holder.profilename_TV.setText(F_name);
			holder.Finaostoryline.setVisibility(View.GONE);
			holder.Date_TV.setText(FinDate);
			holder.up_Tv.setTextSize((float) 16.5);
			if (FinUploadtext.equalsIgnoreCase("")) {
				holder.up_Tv.setVisibility(View.GONE);
			} else {
				holder.up_Tv.setVisibility(View.VISIBLE);
				holder.up_Tv.setText(FinUploadtext);
			}
			if (fhp.getF_IsInspired().equalsIgnoreCase("0"))
				holder.Is_Inspired.setBackgroundResource(R.drawable.inspiring);
			else
				holder.Is_Inspired.setBackgroundResource(R.drawable.inspired);

			if (FinStatus.equalsIgnoreCase("1")) {
				holder.finaoStatus_IM
						.setImageResource(R.drawable.btnaheadhover);
			} else if (FinStatus.equalsIgnoreCase("0")) {
				holder.finaoStatus_IM
						.setImageResource(R.drawable.btnontrackhover);
			} else if (FinStatus.equalsIgnoreCase("2")) {
				holder.finaoStatus_IM
						.setImageResource(R.drawable.btnbehindhover);
			}
			try {
				mContainer = (PagerContainer) convertView
						.findViewById(R.id.pager_container);
				mPager = (ViewPager) convertView.findViewById(R.id.view_pager);
				lPager = (LinearLayout) convertView
						.findViewById(R.id.flinearid);
				pager = mContainer.getViewPager();
				handleImage(position, mContainer, mPager, lPager, pager);
				if (fhp.getImageArrayJson().length() == 0) {
					hideTheImageVidepPager(mContainer, mPager, lPager);
				} else {
					showTheImageVidepPager(mContainer, mPager, lPager);
				} // hide caption
				holder.Finaocaptiontvid.setVisibility(View.GONE);
			} catch (Exception e) {
				e.printStackTrace();
			}
			holder.Finaostory_TV.setTextSize((float) 16.5);
			holder.Finaostory_TV.setText(FinTitle);
			holder.Finaostory_TV.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					Intent intent = new Intent(getApplicationContext(),
							FinaoDetailsView.class);
					intent.putExtra("F_UserId",
							Followers_List_Data.get(position).getF_Updated());
					intent.putExtra("F_FinaoTitle",
							Followers_List_Data.get(position).getF_FinaoMsg());
					intent.putExtra("F_FinId", Followers_List_Data
							.get(position).getF_FinaoId());
					intent.putExtra("F_Public", "0");
					intent.putExtra("F_FinStatus",
							Followers_List_Data.get(position)
									.getF_FinaoStatus());
					intent.putExtra("F_Profile_Pic_path", Profile_Pic_path);
					intent.putExtra("F_UserName",
							Followers_List_Data.get(position)
									.getProfileUserName());
					intent.putExtra("F_From", "home");
					startActivity(intent);
				}
			});
			holder.profilename_TV.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					launchFinaopersonalprofile(position);
				}
			});
			holder.profile_IM.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					launchFinaopersonalprofile(position);
				}
			});

			holder.Is_Inspired.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					if (Followers_List_Data.get(position).getF_IsInspired()
							.equalsIgnoreCase("0")) {
						MultipartEntity entity = new MultipartEntity();
						try {
							entity.addPart("json", new StringBody(
									"getinspiredfrompost"));
							entity.addPart("userpostid", new StringBody(
									Followers_List_Data.get(position)
											.getF_UploadDetailID()));
							JSONObject obj = new JsonHelper().getJSONfromURL(
									fs.baseurl(), headerToken, entity);
							if (obj.has("IsSuccess")
									&& obj.getString("IsSuccess")
											.equalsIgnoreCase("true")) {
								Followers_List_Data.get(position)
										.setF_IsInspired("1");
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

			holder.btnoptions.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View arg0) {
					followtileid = Followers_List_Data.get(position)
							.getF_TitleId();
					markpostid = Followers_List_Data.get(position)
							.getF_UploadDetailID();
					followeduserid = Followers_List_Data.get(position)
							.getF_Updated();
					showPopup(FinaoHome.this, Followers_List_Data.get(position)
							.getF_TileName());
				}
			});

			return convertView;
		}

		public void showPopup(Context context, String tilename) {
			LayoutInflater inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			View popuplayout = inflater.inflate(R.layout.popup_options,
					(ViewGroup) findViewById(R.id.popup_menu_root));
			Button mark = (Button) popuplayout
					.findViewById(R.id.take_from_lib_btn);
			mark.setText("Flag as inappropriate");

			Button follow = (Button) popuplayout
					.findViewById(R.id.capture_photo);
			follow.setText("Follow " + tilename + " Tile");

			pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
					LayoutParams.MATCH_PARENT, true);
			pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);

		}

		private void hideTheImageVidepPager(PagerContainer mContainer,
				ViewPager mPager, LinearLayout lPager) {
			mContainer.setVisibility(View.GONE);
			mPager.setVisibility(View.GONE);
			lPager.setVisibility(View.GONE);
		}

		private void showTheImageVidepPager(PagerContainer mContainer,
				ViewPager mPager, LinearLayout lPager) {
			mContainer.setVisibility(View.VISIBLE);
			mPager.setVisibility(View.VISIBLE);
			lPager.setVisibility(View.VISIBLE);
		}

		private void launchFinaopersonalprofile(int position) {
			Intent intent = new Intent(getApplicationContext(),
					Finaopersonalprofile.class);
			intent.putExtra("Search_FN", Followers_List_Data.get(position)
					.getProfileUserName());
			intent.putExtra("Search_SN", "");
			intent.putExtra("Search_UID", Followers_List_Data.get(position)
					.getF_Updated());
			intent.putExtra("Search_PIC", Followers_List_Data.get(position)
					.getProfileImage());
			intent.putExtra("Search_Finao_Count",
					"" + Followers_List_Data.get(position).getF_Finao_Count());
			intent.putExtra("Search_Tile_Count",
					"" + Followers_List_Data.get(position).getF_Title_Count());
			intent.putExtra("Search_Following_Count", ""
					+ Followers_List_Data.get(position).getF_Following_Count());
			if (Followers_List_Data.get(position).getF_Finao_Story() != null
					&& !Followers_List_Data.get(position).getF_Finao_Story()
							.equalsIgnoreCase("null"))
				intent.putExtra("Search_story",
						Followers_List_Data.get(position).getF_Finao_Story());
			else
				intent.putExtra("Search_story", "");
			startActivity(intent);
		}

		ImagePagerAdapter adapter = null;

		private void handleImage(int position, PagerContainer mContainer,
				ViewPager mPager, LinearLayout lPager, ViewPager pager)
				throws JSONException {
			showTheImageVidepPager(mContainer, mPager, lPager);
			if (Followers_List_Data.get(position).getImageArrayJson() != null
					&& Followers_List_Data.get(position).getImageArrayJson()
							.length() > 0) {
				adapter = new ImagePagerAdapter(Followers_List_Data.get(
						position).getImageArrayJson());
				pager.setAdapter(adapter);
				pager.setOffscreenPageLimit(adapter.getCount());
				if (Followers_List_Data.get(position).getImageArrayJson()
						.length() > 0) {
					pager.setPageMargin(-25);
				}
				if (Followers_List_Data.get(position).getImageArrayJson()
						.getJSONObject(0).getString("image_url") != null
						&& Followers_List_Data.get(position)
								.getImageArrayJson().getJSONObject(0)
								.getString("image_url").toString()
								.compareTo("") == 0) {
					hideTheImageVidepPager(mContainer, mPager, lPager);
				} else {
					showTheImageVidepPager(mContainer, mPager, lPager);
				}
			} else {
				hideTheImageVidepPager(mContainer, mPager, lPager);
			}
		}
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			exitByBackKey();
			return true;
		}
		return super.onKeyDown(keyCode, event);
	}

	@SuppressWarnings("unused")
	protected void exitByBackKey() {
		AlertDialog alertbox = new AlertDialog.Builder(this)
				.setMessage("Do you want to exit application?")
				.setPositiveButton("Yes",
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dlg, int button) {
								System.exit(0);
							}
						})
				.setNegativeButton("No", new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dlg, int button) {
					}
				}).show();
	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
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
				new ProfilePageAssyncTask(headerToken).execute();
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
				new ProfilePageAssyncTask(headerToken).execute();
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

	private class ImagePagerAdapter extends PagerAdapter {

		ArrayList<String> imgar = new ArrayList<String>();
		// ArrayList<String> capar = new ArrayList<String>(); disabling
		JSONArray _f_imagearray;
		View layout;
		ImageView fina_im;

		public ImagePagerAdapter(JSONArray f_imagearray) {
			_f_imagearray = f_imagearray;
			for (int i = 0; i < f_imagearray.length(); i++) {
				try {
					JSONObject finao = _f_imagearray.getJSONObject(i);
					if (finao.getString("image_url") != null
							&& !finao.getString("image_url").equalsIgnoreCase(
									"")) {
						imgar.add(finao.getString("image_url").toString());
						// capar.add(finao.getString("image_caption").toString());
						// disabling captions
					}
				} catch (JSONException e1) {
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

		TextView Furl;
		FinaoServiceLinks fs = new FinaoServiceLinks();
		String str1;

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
			str1 = fs.FinaoImagesLink();
			finurl = str1
					+ imgar.get(position).toString().replaceAll(" ", "%20");
			loadImageCleanMem();

			// TextView cap = (TextView)layout.findViewById(R.id.Finaocaptiont);
			Furl = (TextView) layout.findViewById(R.id.Finaourl);
			Furl.setText(imgar.get(position).toString());
			// cap.setText(capar.get(position).toString()); disabling captions,
			((ViewPager) container).addView(layout, 0);
			layout.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					Intent in = new Intent(getApplicationContext(),
							DisplayHomeImages.class);
					in.putExtra("ProfilePicPath", imgar.get(position)
							.toString());
					startActivity(in);
				}
			});

			return layout;
		}

		@Override
		public float getPageWidth(int position) {
			if(getCount()>1)
				return 0.92f;
			else
				return 1.0f;
		}

		private void loadImageCleanMem() {
			runOnUiThread(new Runnable() {
				public void run() {
					Drawable drawable = fina_im.getDrawable();
					if (drawable instanceof BitmapDrawable) {
						BitmapDrawable bitmapDrawable = (BitmapDrawable) drawable;
						bitmapDrawable.getBitmap().recycle();
					}
					fina_im.setImageBitmap(null);
					System.gc();
					imageLoader.DisplayImage(finurl, fina_im, true, false);
				}
			});
		}

		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			((ViewPager) container).removeView((View) object);
		}
	}

}
