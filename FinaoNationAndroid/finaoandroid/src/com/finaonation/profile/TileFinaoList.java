package com.finaonation.profile;

import java.util.ArrayList;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.Bitmap.CompressFormat;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.FinaosPojo;
import com.finaonation.addfinao.GettingFinaos;
import com.finaonation.finao.FinaoDetailsView;
import com.finaonation.finao.R;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.webservices.FinaoServiceLinks;
import com.nostra13.universalimageloader.cache.disc.naming.HashCodeFileNameGenerator;
import com.nostra13.universalimageloader.cache.memory.impl.UsingFreqLimitedMemoryCache;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.FailReason;
import com.nostra13.universalimageloader.core.assist.ImageLoadingListener;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;

public class TileFinaoList extends Activity {

	TextView SelectFinaoToPost_TV;
	ListView Finao_LV;
	Activity mActivity;
	ImageLoadingListener loadingListner;
	DisplayImageOptions imgDisplayOptions;
	ImageLoader imageLoader;
	String _UserID_SPS_Str, Tile_ID, Tile_Key, User_ID, Profile_pic_path, UserName;
	ArrayList<FinaosPojo> Finao_List_Data = new ArrayList<FinaosPojo>();
	private static final String TAG = "TileFinaoList";
	Button Post, back;
	String headerToken;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.selectfinaotopost);
	}

	private void refreshTileFinaoList() {
		mActivity = this;
		@SuppressWarnings("deprecation")
		SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		Post = (Button) findViewById(R.id.post);
		Post.setVisibility(View.GONE);
		Finao_LV = (ListView) findViewById(R.id.selectfinaotopostlvid);
		back = (Button) findViewById(R.id.back);
		back.setVisibility(View.VISIBLE);

		ImageLoaderConfiguration config = new ImageLoaderConfiguration.Builder(
				getApplicationContext())
				.memoryCacheExtraOptions(150, 150)
				.discCacheExtraOptions(480, 800, CompressFormat.JPEG, 75)
				.threadPoolSize(3)
				// default
				.threadPriority(Thread.NORM_PRIORITY - 1)
				// default
				.denyCacheImageMultipleSizesInMemory()
				.memoryCache(new UsingFreqLimitedMemoryCache(2 * 1024 * 1024))
				// default
				.memoryCacheSize(2 * 1024 * 1024)
				.discCacheSize(50 * 1024 * 1024).discCacheFileCount(100)
				.discCacheFileNameGenerator(new HashCodeFileNameGenerator()) // default

				.tasksProcessingOrder(QueueProcessingType.FIFO) // default
				.defaultDisplayImageOptions(DisplayImageOptions.createSimple()) // default
				.enableLogging().build();

		// Get instance from ImageLoader
		ImageLoader.getInstance().init(config);

		imgDisplayOptions = new DisplayImageOptions.Builder().cacheInMemory()
				.cacheOnDisc().showImageForEmptyUri(R.drawable.app_icon)
				.cacheInMemory().cacheOnDisc()
				.showImageForEmptyUri(R.drawable.noimage)
				// .showImageOnFail(R.string.error_loading)
				// .imageScaleType(ImageScaleType.EXACT)
				.build();
		imageLoader = ImageLoader.getInstance();
		imageLoader.init(config);

		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
	}

	public void backClicked(View view){
		finish();
	}
	@Override
	protected void onResume() {
		super.onResume();
		refreshTileFinaoList();
		SharedPreferences Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		Tile_Key = getIntent().getExtras().getString("Tile_Key");
		SelectFinaoToPost_TV = (TextView) findViewById(R.id.selectfinaotoposttvid);
		SelectFinaoToPost_TV.setText(getIntent().getExtras().getString("Tile_Name"));
		if (Tile_Key.equalsIgnoreCase("Own_Profile")) {
			Profile_pic_path = Finao_Preferences.getString("Profile_Image", "");
			String fname = Finao_Preferences.getString("FName", "");
			String lname = Finao_Preferences.getString("LName", "");
			UserName = fname + " " + lname;
			Tile_ID = getIntent().getExtras().getString("TileID");
			new FinaosAssyncTask(Tile_ID).execute();

		} else if (Tile_Key.equalsIgnoreCase("Friend_Profile")) {

			Tile_ID = getIntent().getExtras().getString("TileID");
			User_ID = getIntent().getExtras().getString("TileUserID");
			Button createfinao = (Button) findViewById(R.id.createfinao);
			createfinao.setVisibility(View.GONE);
			new FriendFinaosAssyncTask(Tile_ID, User_ID).execute();
		}
	}

	public void Create_finao(View v) {
		Intent i = new Intent(getApplicationContext(), CreateNewFinao.class);
		startActivity(i);
	}

	private class FinaosAssyncTask extends AsyncTask<Void, Void, Integer> {

		String Tile_ID_Str;

		public FinaosAssyncTask(String Tile_ID) {
			this.Tile_ID_Str = Tile_ID;
		}

		ProgressDialog pDialog = new ProgressDialog(mActivity);

		GettingFinaos gs = new GettingFinaos();

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					"Loading Finao's", true, true);
		}

		protected Integer doInBackground(Void... params) {

			Finao_List_Data = gs.GetFinaosListWithTileID(Tile_ID_Str,
					_UserID_SPS_Str, headerToken);
			return 0;
		}

		protected void onPostExecute(Integer result) {

			pDialog.dismiss();

			int no = Finao_List_Data.size();
			if (no != 0) {
				Finao_LV.setAdapter(new FinaoListAdapter(mActivity,
						Finao_List_Data));
			} else {
				Finao_LV.setAdapter(null);
				Toast.makeText(mActivity, "No FINAO Items", Toast.LENGTH_SHORT)
						.show();
			}

		}
	}

	private class FriendFinaosAssyncTask extends AsyncTask<Void, Void, Integer> {

		String Tile_ID_Str;
		String User_ID;

		public FriendFinaosAssyncTask(String tile_ID, String user_ID) {
			this.Tile_ID_Str = tile_ID;
			this.User_ID = user_ID;
		}

		ProgressDialog pDialog = new ProgressDialog(mActivity);

		GettingFinaos gs = new GettingFinaos();

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					"Loading Finao's", true, true);
		}

		protected Integer doInBackground(Void... params) {

			Finao_List_Data = gs.GetFriendFianoswithUserID(Tile_ID_Str,
					User_ID, _UserID_SPS_Str, headerToken);

			return 0;
		}

		protected void onPostExecute(Integer result) {

			pDialog.dismiss();

			int no = Finao_List_Data.size();
			if (no != 0) {
				Finao_LV.setAdapter(new FriendFinaoListAdapter(mActivity,
						Finao_List_Data));
			} else {
				Finao_LV.setAdapter(null);
				Toast.makeText(mActivity, "No FINAO Items", Toast.LENGTH_SHORT)
						.show();
			}

		}
	}

	public class FinaoListAdapter extends BaseAdapter {

		Context con;
		ArrayList<FinaosPojo> Adapter_List = new ArrayList<FinaosPojo>();
		String Fin_Img_Path;
		ViewHolder holder = null;

		public FinaoListAdapter(Activity mActivity,
				ArrayList<FinaosPojo> finao_List_Data) {
			con = mActivity;
			Adapter_List = finao_List_Data;
		}

		@Override
		public int getCount() {
			return Adapter_List.size();
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
			ImageView FinaoImg_IV;
			TextView FinaoMessage_TV;
			ImageView FinaoStatus_IV;
			TextView FinaoStatus_TV;
			TextView FinaoDate_TV;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) con
					.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.finaoroww, null);
				holder = new ViewHolder();
				holder.FinaoImg_IV = (ImageView) convertView
						.findViewById(R.id.finaoimgivid);
				holder.FinaoMessage_TV = (TextView) convertView
						.findViewById(R.id.finaorowfingmsgtvid);
				holder.FinaoStatus_IV = (ImageView) convertView
						.findViewById(R.id.finaostatusivid);
				holder.FinaoStatus_TV = (TextView) convertView
						.findViewById(R.id.finao_statu_tvid);
				holder.FinaoDate_TV = (TextView) convertView
						.findViewById(R.id.finaodatetvid);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			holder.FinaoMessage_TV.setText(Adapter_List.get(position)
					.getFinao_msg());
			holder.FinaoDate_TV.setText(Adapter_List.get(position)
					.getCreateddate());
			String Fin_Status = Adapter_List.get(position).getStatus();
			@SuppressWarnings("unused")
			String Fin_ID = Adapter_List.get(position).getFinao_id();
			String Fin_IsPublic = Adapter_List.get(position)
					.getFin_Status_ISPublic();

			if (Fin_Status.equalsIgnoreCase("0")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnontrackhover);
			} else if (Fin_Status.equalsIgnoreCase("1")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnaheadhover);
			} else if (Fin_Status.equalsIgnoreCase("2")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnbehindhover);
			}  else {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btncompletehover);
			}

			if (Fin_IsPublic.equalsIgnoreCase("0")) {
				holder.FinaoStatus_TV.setText("Private");
			} else if (Fin_IsPublic.equalsIgnoreCase("1")) {
				holder.FinaoStatus_TV.setText("Public");
			}

			String UploadFilePath = Adapter_List.get(position)
					.getUploadFilePath();
			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str = fs.FinaoImagesLink();
			Fin_Img_Path = str + UploadFilePath;

			if (Constants.LOG)
				Log.v("Fin_Img_Tag", Fin_Img_Path);

			imageLoader.displayImage(Fin_Img_Path, holder.FinaoImg_IV,
					imgDisplayOptions, new ImageLoadingListener() {

						@Override
						public void onLoadingStarted() {
							holder.FinaoImg_IV.setImageResource(R.drawable.app_icon);
						}

						@Override
						public void onLoadingComplete(Bitmap bmp) {
							holder.FinaoImg_IV.setVisibility(View.VISIBLE);
							holder.FinaoImg_IV.setImageBitmap(bmp);
						}

						@Override
						public void onLoadingFailed(FailReason bmp) {
							Log.i(TAG, "displayImage failed for "
									+ Fin_Img_Path);
							//we can just hide the image 
							// holder.FinaoImg_IV.setVisibility(View.GONE);
							// should be this image holder.FinaoImg_IV.setImageResource(R.drawable.noimage);
							// but while the API comes in, show something
							holder.FinaoImg_IV.setImageResource(R.drawable.app_icon);
						}

						@Override
						public void onLoadingCancelled() {
							holder.FinaoImg_IV.setVisibility(View.GONE);
						}
					});

			convertView.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					if (Constants.LOG)
						Log.i(TAG, "follow is "
								+ Adapter_List.get(position).getIsFollow());
					Intent intent = new Intent(getApplicationContext(),
							FinaoDetailsView.class);
					intent.putExtra("F_UserId",
							_UserID_SPS_Str);
					intent.putExtra("F_FinaoTitle",
							Adapter_List.get(position).getFinao_msg());
					intent.putExtra("F_FinId", Adapter_List
							.get(position).getFinao_id());
					intent.putExtra("F_Public", Adapter_List
							.get(position).getFin_Status_ISPublic());
					intent.putExtra("F_FinStatus",
							Adapter_List.get(position)
									.getStatus());
					intent.putExtra("F_Profile_Pic_path", Profile_pic_path);
					intent.putExtra("F_UserName",
							UserName);
					intent.putExtra("F_From", "user");
					startActivity(intent);

				}
			});

			return convertView;
		}

	}

	public class FriendFinaoListAdapter extends BaseAdapter {

		Context con;
		ArrayList<FinaosPojo> Adapter_List = new ArrayList<FinaosPojo>();
		String Fin_Img_Path;
		ViewHolder holder = null;

		public FriendFinaoListAdapter(Activity mActivity,
				ArrayList<FinaosPojo> finao_List_Data) {
			con = mActivity;
			Adapter_List = finao_List_Data;
		}

		@Override
		public int getCount() {
			return Adapter_List.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		@SuppressWarnings("unused")
		private class ViewHolder {
			ImageView FinaoImg_IV;
			TextView FinaoMessage_TV;
			ImageView FinaoStatus_IV;
			TextView FinaoStatus_TV;

			TextView FinaoDate_TV;
		}

		@SuppressWarnings("unused")
		@Override
		public View getView(int position, View convertView, ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) con
					.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.finaoroww, null);
				holder = new ViewHolder();
				holder.FinaoImg_IV = (ImageView) convertView
						.findViewById(R.id.finaoimgivid);
				holder.FinaoMessage_TV = (TextView) convertView
						.findViewById(R.id.finaorowfingmsgtvid);
				holder.FinaoStatus_IV = (ImageView) convertView
						.findViewById(R.id.finaostatusivid);
				holder.FinaoStatus_TV = (TextView) convertView
						.findViewById(R.id.finao_statu_tvid);
				holder.FinaoDate_TV = (TextView) convertView
						.findViewById(R.id.finaodatetvid);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			holder.FinaoMessage_TV.setText(Adapter_List.get(position)
					.getFinao_msg());
			// holder.FinaoDate_TV.setText(fp.getCreateddate());

			// String Fin_Status = fp.getStatus();

			String Fin_Message = Adapter_List.get(position).getFinao_msg();
			String Fin_Status = Adapter_List.get(position).getStatus();
			String Fin_ID = Adapter_List.get(position).getFinao_id();

			if (Fin_Status.equalsIgnoreCase("0")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnontrackhover);
			} else if (Fin_Status.equalsIgnoreCase("1")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnaheadhover);
			} else if (Fin_Status.equalsIgnoreCase("2")) {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnbehindhover);
			} else {
				holder.FinaoStatus_IV
						.setImageResource(R.drawable.btnontrackhover);
			}

			// String Fin_IsPublic = fp.getFin_Status_ISPublic();

			/*
			 * if (Fin_IsPublic.equalsIgnoreCase("0")) {
			 * holder.FinaoStatus_TV.setText("private"); } else if
			 * (Fin_IsPublic.equalsIgnoreCase("1")) {
			 * holder.FinaoStatus_TV.setText("public"); }
			 */

			final String UploadFilePath = "";
			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str = fs.FinaoImagesLink();
			Fin_Img_Path = str + UploadFilePath;

			if (Constants.LOG)
				Log.v("Fin_Img_Tag", Fin_Img_Path);

			imageLoader.displayImage(Fin_Img_Path, holder.FinaoImg_IV,
					imgDisplayOptions, new ImageLoadingListener() {

						@Override
						public void onLoadingStarted() {
							holder.FinaoImg_IV
									.setImageResource(R.drawable.loading);
						}

						@Override
						public void onLoadingComplete(Bitmap bmp) {
							holder.FinaoImg_IV.setImageBitmap(bmp);
						}

						@Override
						public void onLoadingFailed(FailReason fr) {
						}

						@Override
						public void onLoadingCancelled() {

						}
					});

			convertView.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {

					/*
					 * Intent in = new Intent(con, TrendingDetail.class);
					 * in.putExtra("UserID", User_ID); in.putExtra("TileID",
					 * fp.getTile_id()); in.putExtra("ProfileImage",
					 * UploadFilePath); in.putExtra("FinaoMessage",
					 * Fin_Message); in.putExtra("FinaoID", Fin_ID);
					 * in.putExtra("Options_Key", "one"); in.putExtra("FinDate",
					 * Fin_Date); in.putExtra("FinStatus", Fin_Status);
					 * in.putExtra("FinIsCompleted", Fin_IsCompleted);
					 * in.putExtra("FinIsPublic", Fin_IsPublic);
					 * in.putExtra("Follow", fp.getIsFollow());
					 * startActivity(in);
					 */

				}
			});

			return convertView;
		}

	}
}
