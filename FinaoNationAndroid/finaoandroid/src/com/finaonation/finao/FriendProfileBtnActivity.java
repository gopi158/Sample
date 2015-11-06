package com.finaonation.finao;

import java.util.ArrayList;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.beanclasses.FinaoNiotificationsPojo;
import com.finaonation.beanclasses.FinaosListPojo;
import com.finaonation.beanclasses.GetTiles;
import com.finaonation.beanclasses.GettingFinaosList;
import com.finaonation.internet.InternetChecker;
import com.finaonation.profile.GettingFollowers;
import com.finaonation.profile.GettingTiles;
import com.finaonation.profile.TileFinaoList;
import com.finaonation.search.Finaopersonalprofile;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class FriendProfileBtnActivity extends Activity {
	public static final String TAG = null;
	ArrayList<FinaosListPojo> FinaoListData = new ArrayList<FinaosListPojo>();
	ArrayList<GetTiles> Tiles_List_Data = new ArrayList<GetTiles>();
	ArrayList<FinaoNiotificationsPojo> Following_List_Data = new ArrayList<FinaoNiotificationsPojo>();
	FinaoServiceLinks fs;
	private InternetChecker ic;
	String Profile_Pic_path, User_ID;

	String Username, _UserID_SPS_Str, _FName_SPS_Str, _LName_SPS_Str,
			_MyStory_SPS_Str, _Finaos_Count_Str, _Finao_Profile_Pic_Str;
	int Btn_key;
	ImageLoader imageLoader;
	ListView ProfilePage_LV;
	GridView profile_titlegrid;
	FinaoListAdapter finaoListAdapter;
	TextView Header, Text_type;
	String headerToken;
	SharedPreferences Finao_Preferences;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_friend_profile_btn);
	}
	@Override
	protected void onResume() {
		super.onResume();
		refreshContents();
	}
	@SuppressWarnings("deprecation")
	private void refreshContents() {
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		Header = (TextView) findViewById(R.id.header);
		profile_titlegrid = (GridView) findViewById(R.id.gridview);
		imageLoader = new ImageLoader(this);
		ProfilePage_LV = (ListView) findViewById(R.id.profilepagelvid);
		Text_type = (TextView) findViewById(R.id.text_type);

		fs = new FinaoServiceLinks();
		Btn_key = getIntent().getIntExtra("Btn_key", 1);
		_UserID_SPS_Str = getIntent().getStringExtra("userid");
		User_ID = getIntent().getStringExtra("f_userid");
		Profile_Pic_path = getIntent().getStringExtra("profilepath");
		Username = getIntent().getStringExtra("username");

		if (Btn_key == 1) {
			Text_type.setText("FINAOs");
		} else if (Btn_key == 2) {
			Text_type.setText("Tiles");
		} else if (Btn_key == 3) {
			Text_type.setText("Following");
		}

		ic = new InternetChecker();
		new ProfilePageAssyncTask(Btn_key, headerToken).execute();
	}

	private class ProfilePageAssyncTask extends AsyncTask<Void, Void, Integer> {
		String thisToken;
		ProgressDialog pDialog = new ProgressDialog(
				FriendProfileBtnActivity.this);
		String Loading_Msg = null;

		GettingFinaosList gs = new GettingFinaosList(thisToken);
		GettingTiles gt = new GettingTiles();
		GettingFollowers gf;

		public ProfilePageAssyncTask(int btn_Key, String token) {
			thisToken = token;
			if (btn_Key == 1) {
				Loading_Msg = "Loading FINAOs";
			} else if (btn_Key == 2) {
				Loading_Msg = "Loading Tiles";
			} else if (btn_Key == 3) {
				Loading_Msg = "Loading Following";
				gf = new GettingFollowers("followings");
			}
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = FinaoCustomProgress.show(FriendProfileBtnActivity.this,
					"FINAO Nation", Loading_Msg, true, true);
			pDialog.setCancelable(true);
		}

		protected Integer doInBackground(Void... params) {
			if (Btn_key == 1) {
				FinaoListData = gs.GetFinaosList(_UserID_SPS_Str, User_ID, "1",
						headerToken);
			} else if (Btn_key == 2) {
				Tiles_List_Data = gt.GetFriendTilesList(User_ID, headerToken);
			} else if (Btn_key == 3) {
				Following_List_Data = gf.GetFollowersList(User_ID, headerToken);
			}

			return 0;
		}

		protected void onPostExecute(Integer result) {
			pDialog.dismiss();
			if (Btn_key == 1) {
				int no = FinaoListData.size();
				if (no != 0) {
					finaoListAdapter = new FinaoListAdapter(
							FriendProfileBtnActivity.this, FinaoListData);
					ProfilePage_LV.setAdapter(finaoListAdapter);
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No FINAO Items");
				}

			} else if (Btn_key == 2) {
				profile_titlegrid.setVisibility(View.VISIBLE);
				ProfilePage_LV.setVisibility(View.GONE);
				int no = Tiles_List_Data.size();
				if (no != 0) {
					profile_titlegrid.setAdapter(new TilesListAdapter(
							FriendProfileBtnActivity.this, Tiles_List_Data));
				} else {
					profile_titlegrid.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No Titles");
				}

			} else if (Btn_key == 3) {
				int no = Following_List_Data.size();
				if (no != 0) {
					ProfilePage_LV.setAdapter(new FollowersAdapter(
							getApplicationContext(), Following_List_Data));
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("There are no followings");
				}
			}
		}
	}

	public void backClicked(View view){
		finish();
	}
	private class FinaoListAdapter extends BaseAdapter {
		Context con;
		ArrayList<FinaosListPojo> Adapter_List = new ArrayList<FinaosListPojo>();
		ViewHolder holder = null;

		public FinaoListAdapter(Activity mActivity,
				ArrayList<FinaosListPojo> finao_List_Data) {
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
			TextView Finao_Title;
			ImageView Finao_status;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) con
					.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.finaos_inflater, null);
				holder = new ViewHolder();
				holder.Finao_Title = (TextView) convertView
						.findViewById(R.id.Finao_Title);
				holder.Finao_status = (ImageView) convertView
						.findViewById(R.id.imageView2);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			holder.Finao_Title.setText(Adapter_List.get(position)
					.getF_FinaoTitle());
			if (Adapter_List.get(position).getF_Finao_Status()
					.equalsIgnoreCase("1")) {
				holder.Finao_status
						.setBackgroundResource(R.drawable.btnaheadhover);
			} else if (Adapter_List.get(position).getF_Finao_Status()
					.equalsIgnoreCase("0")) {
				holder.Finao_status
						.setBackgroundResource(R.drawable.btnontrackhover);
			} else if (Adapter_List.get(position).getF_Finao_Status()
					.equalsIgnoreCase("2")) {
				holder.Finao_status
						.setBackgroundResource(R.drawable.btnbehindhover);
			}
			convertView.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					Intent intent = new Intent(getApplicationContext(),
							FinaoDetailsView.class);
					intent.putExtra("F_UserId", User_ID);
					intent.putExtra("F_FinaoTitle", Adapter_List.get(position)
							.getF_FinaoTitle());
					intent.putExtra("F_FinId", Adapter_List.get(position)
							.getF_FinaoId());
					intent.putExtra("F_Public", Adapter_List.get(position)
							.getF_Ispublic_or_Followstatus());
					intent.putExtra("F_FinStatus", Adapter_List.get(position)
							.getF_Finao_Status());
					intent.putExtra("F_Profile_Pic_path", Profile_Pic_path);
					intent.putExtra("F_UserName", Username);
					intent.putExtra("F_From", "friend");
					intent.putExtra("F_Tile_Id", Adapter_List.get(position)
							.getF_Tile_Id());
					startActivity(intent);
				}
			});
			return convertView;
		}

	}

	public class TilesListAdapter extends BaseAdapter {
		ViewHolder holder = null;
		Context con;
		ArrayList<GetTiles> Tile_Adapter_List = new ArrayList<GetTiles>();
		TextView Caption_TV;
		ImageView Tile_Image_IV;
		String imgtype, Tile_Image_Path;

		public TilesListAdapter(Activity mActivity,
				ArrayList<GetTiles> tiles_List_Data) {
			con = mActivity;
			Tile_Adapter_List = tiles_List_Data;
		}

		@Override
		public int getCount() {
			return Tile_Adapter_List.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		public class ViewHolder {
			ImageView Grid_Img_IV;
			TextView Grid_TV;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.profiletilegrid, null);
				holder = new ViewHolder();
				holder.Grid_Img_IV = (ImageView) convertView
						.findViewById(R.id.gridimgivid);
				holder.Grid_TV = (TextView) convertView
						.findViewById(R.id.gridtexttvid);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			holder.Grid_TV.setText(Tile_Adapter_List.get(position)
					.getTile_Name());
			String str = fs.TileImagesLink();
			String str1 = Tile_Adapter_List.get(position).getTile_Image();
			Tile_Image_Path = str + str1;
			imageLoader.DisplayImage(Tile_Image_Path, holder.Grid_Img_IV, true, true);

			convertView.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					if (ic.IsNetworkAvailable(getApplicationContext()) == true) {

						Intent in = new Intent(con, TileFinaoList.class);
						in.putExtra("TileID", Tile_Adapter_List.get(position)
								.getTile_Id());
						in.putExtra("TileUserID", User_ID);
						in.putExtra("Tile_Name", Tile_Adapter_List
								.get(position).getTile_Name());
						in.putExtra("Tile_Key", "Friend_Profile");
						startActivity(in);
					} else {
						Toast toast = Toast.makeText(getApplicationContext(),
								"Please Check the Internet Connection.....",
								Toast.LENGTH_SHORT);
						toast.setGravity(Gravity.CENTER, 0, 0);
						toast.show();
					}
				}
			});

			return convertView;
		}
	}

	public class FollowersAdapter extends BaseAdapter {

		Context con;
		ArrayList<FinaoNiotificationsPojo> flist;

		public FollowersAdapter(Context applicationContext,
				ArrayList<FinaoNiotificationsPojo> flist) {
			this.con = applicationContext;
			this.flist = flist;
		}

		@Override
		public int getCount() {
			return flist.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		FinaoNiotificationsPojo fnp;
		FinaoServiceLinks fs;
		ImageView iv;

		@Override
		public View getView(final int position, View vw, ViewGroup vwg) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			View v = li.inflate(R.layout.notificationsrow, null);
			fnp = flist.get(position);

			TextView tv1 = (TextView) v.findViewById(R.id.textView1);
			tv1.setText(fnp.getFName() + " " + fnp.getLName());
			fs = new FinaoServiceLinks();
			String str = fs.ProfileImagesLink();
			String ImageURL = str + fnp.getProfileImage();
			if (Constants.LOG)
				Log.v("ImageURL", ImageURL);
			v.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					Intent intent = new Intent(getApplicationContext(),
							Finaopersonalprofile.class);
					intent.putExtra("Search_FN", flist.get(position).getFName());
					intent.putExtra("Search_SN", flist.get(position).getLName());
					if (Btn_key == 3) {
						intent.putExtra("Search_UID", flist.get(position)
								.getTracking_UserID());
					} else if (Btn_key == 4) {
						intent.putExtra("Search_UID", flist.get(position)
								.getTracking_ID());
					}
					intent.putExtra("Search_PIC", flist.get(position)
							.getProfileImage());
					intent.putExtra("Search_Finao_Count", flist.get(position)
							.getFinaocount());
					intent.putExtra("Search_Tile_Count", flist.get(position)
							.getTilecount());
					intent.putExtra("Search_Following_Count", flist.get(position)
							.getFollowingcount());
					if (flist.get(position).getStory().equalsIgnoreCase("null")) {
						intent.putExtra("Search_story", "");
					} else {
						intent.putExtra("Search_story", flist.get(position)
								.getStory());
					}
					startActivity(intent);
				}
			});

			ImageView iv = (ImageView) v.findViewById(R.id.imageView1);

			imageLoader.DisplayImage(ImageURL, iv, true, true);

			return v;
		}

	}

}
