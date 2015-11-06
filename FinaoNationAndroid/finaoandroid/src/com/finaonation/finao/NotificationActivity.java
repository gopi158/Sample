package com.finaonation.finao;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.FinaoNiotificationsPojo;
import com.finaonation.search.Finaopersonalprofile;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class NotificationActivity extends Activity {

	public static final String TAG = "NotificationActivity";
	String headerToken;
	Activity mActivity = null;
	TextView header;
	ListView notificationlist;
	FinaoServiceLinks links;
	ImageLoader imageLoader;
	ArrayList<FinaoNiotificationsPojo> Notification_List = new ArrayList<FinaoNiotificationsPojo>();
	private SharedPreferences Finao_Preferences;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_notification);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		String headerToken = Finao_Preferences.getString("logtoken", "");

		mActivity = this;
		imageLoader = new ImageLoader(this);
		notificationlist = (ListView) findViewById(R.id.notificationlist);
		header = (TextView) findViewById(R.id.header);
		links = new FinaoServiceLinks();

		new NotificationPageAssyncTask(headerToken).execute();

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.notification, menu);
		return true;
	}
	
	public void backClicked(View view){
		finish();
	}

	private class NotificationPageAssyncTask extends
			AsyncTask<Void, Void, JSONObject> {
		String thisToken;
		String Loading_Msg = "Loading Notifications...";
		ProgressDialog pDialog;

		public NotificationPageAssyncTask(String token) {
			thisToken = token;
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(mActivity);
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					Loading_Msg, true, true);
		}

		protected JSONObject doInBackground(Void... params) {
			JsonHelper helper = new JsonHelper();

			try {
				MultipartEntity entity = new MultipartEntity();
				entity.addPart("json", new StringBody("getnotifications"));

				JSONObject obj = helper.getJSONfromURL(links.baseurl(),
						thisToken, entity);
				return obj;
			} catch (Exception e) {
				Log.i(TAG, "error in do in background");
				e.printStackTrace();
			}
			return null;
		}

		protected void onPostExecute(JSONObject result) {
			super.onPostExecute(result);
			if (null != pDialog && pDialog.isShowing()) {
				pDialog.dismiss();
			}
			if (result == null) {
				header.setVisibility(View.VISIBLE);
				notificationlist.setAdapter(null);
				notificationlist.setVisibility(View.INVISIBLE);
			} else {
				try {
					if (result.has("IsSuccess")
							&& result.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						JSONArray item = result.getJSONArray("item");
						JSONObject obj = null;
						if (item.length() > 0) {
							for (int index = 0; index < item.length(); index++) {

								obj = item.getJSONObject(index);
								FinaoNiotificationsPojo data = new FinaoNiotificationsPojo();
								data.setTracking_ID(obj.getString("userid"));
								if (obj.getString("profile_image") != null
										&& !obj.getString("profile_image")
												.equalsIgnoreCase("null"))
									data.setProfileImage(obj
											.getString("profile_image"));
								else
									data.setProfileImage("");
								data.setStory(obj.getString("action"));
								data.setCreatedDate(obj
										.getString("createddate"));

								Notification_List.add(data);
							}
							NotificationAdapter adapter = new NotificationAdapter(
									getBaseContext(), R.layout.list_rowf,
									Notification_List);
							notificationlist.setAdapter(adapter);
							header.setVisibility(View.INVISIBLE);
							notificationlist.setVisibility(View.VISIBLE);
						} else {
							Toast.makeText(mActivity,
									"No notification available",
									Toast.LENGTH_SHORT);
							header.setVisibility(View.VISIBLE);
							notificationlist.setAdapter(null);
							notificationlist.setVisibility(View.INVISIBLE);
						}
					} else {
						header.setVisibility(View.VISIBLE);
						notificationlist.setAdapter(null);
						notificationlist.setVisibility(View.INVISIBLE);
						Toast.makeText(mActivity, result.getString("message"),
								Toast.LENGTH_SHORT).show();
					}
				} catch (Exception e) {
					Log.e(TAG, e.toString());
					header.setVisibility(View.VISIBLE);
					notificationlist.setAdapter(null);
					notificationlist.setVisibility(View.INVISIBLE);
				}
			}
		}
	}

	@SuppressWarnings("rawtypes")
	public class NotificationAdapter extends ArrayAdapter {
		Context context;
		ArrayList<FinaoNiotificationsPojo> listNotifications = null;
		int rowid;

		@SuppressWarnings("unchecked")
		public NotificationAdapter(Context context, int textViewResourceId,
				ArrayList<FinaoNiotificationsPojo> notifications) {
			super(context, textViewResourceId, notifications);
			this.context = context;
			this.listNotifications = notifications;

		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			if (convertView == null)
				convertView = inflater.inflate(R.layout.list_rowf, parent,
						false);
			TextView tv_fname = (TextView) convertView
					.findViewById(R.id.tv_Name);
			ImageView Imgvw = (ImageView) convertView
					.findViewById(R.id.profile_image);
			TextView time = (TextView) convertView
					.findViewById(R.id.finaodatetvid);
			tv_fname.setTextColor(Color.BLACK);
			tv_fname.setText(listNotifications.get(position).getStory());
			ImageView im = (ImageView) convertView
					.findViewById(R.id.imageView2);
			im.setVisibility(View.INVISIBLE);
			time.setText(listNotifications.get(position).getCreatedDate());
			time.setVisibility(View.VISIBLE);
			String path = links.ProfileImagesLink()
					+ listNotifications.get(position).getProfileImage();
			if (Constants.LOG)
				Log.i(TAG, "path is :" + path);
			imageLoader.DisplayImage(path, Imgvw, true, true);

			convertView.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View arg0) {
					Intent intent = new Intent(getApplicationContext(),
							Finaopersonalprofile.class);
					intent.putExtra("Search_UID",
							listNotifications.get(position).getTracking_ID());
					startActivity(intent);
				}
			});
			return convertView;
		}

	}

}
