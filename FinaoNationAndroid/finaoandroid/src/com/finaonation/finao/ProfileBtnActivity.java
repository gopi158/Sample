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
import android.widget.Button;
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
import com.finaonation.profile.CreateNewFinao;
import com.finaonation.profile.GettingFollowers;
import com.finaonation.profile.GettingTiles;
import com.finaonation.profile.TileFinaoList;
import com.finaonation.search.Finaopersonalprofile;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class ProfileBtnActivity extends Activity {
	public static final String TAG = "ProfileBtnActivity";
	int Btn_key;
	ArrayList<FinaosListPojo> Finao_List_Data = new ArrayList<FinaosListPojo>();
	ArrayList<GetTiles> Tiles_List_Data = new ArrayList<GetTiles>();
	ArrayList<FinaoNiotificationsPojo> Following_List_Data = new ArrayList<FinaoNiotificationsPojo>();
	ArrayList<FinaoNiotificationsPojo> Followers_List_Data = new ArrayList<FinaoNiotificationsPojo>();
	ListView ProfilePage_LV;
	ProgressDialog pDialog;
	Activity mActivity = null;
	String _UserID_SPS_Str, Profile_Pic_path, Username;
	FinaoListAdapter finaoListAdapter;
	FinaoServiceLinks fs;
	private InternetChecker ic;
	ImageLoader imageLoader;
	GridView profile_titlegrid;
	TextView Header, Text_type;
	Button Createfinao;
	String headerToken;
	SharedPreferences Finao_Preferences;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_peofile_btn);
	}

	private void refreshProfileBtnActivity() {
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		mActivity = this;
		fs = new FinaoServiceLinks();
		// Btn_key = getIntent().getIntExtra("Btn_key", 1);
		_UserID_SPS_Str = getIntent().getStringExtra("userid");
		Profile_Pic_path = getIntent().getStringExtra("profilepath");
		Username = getIntent().getStringExtra("username");

		ProfilePage_LV = (ListView) findViewById(R.id.profilepagelvid);
		profile_titlegrid = (GridView) findViewById(R.id.gridview);
		Header = (TextView) findViewById(R.id.header);

		ProfilePage_LV.setSmoothScrollbarEnabled(true);
		ProfilePage_LV.setAdapter(null);
		ic = new com.finaonation.internet.InternetChecker();
		imageLoader = new ImageLoader(this);
	}

	public void Create_finao(View v) {
		Intent i = new Intent(getApplicationContext(), CreateNewFinao.class);
		startActivity(i);
	}

	public void backClicked(View view){
		finish();
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		refreshProfileBtnActivity();
		Createfinao = (Button) findViewById(R.id.createfinao);
		Text_type = (TextView) findViewById(R.id.text_type);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		String Login_Key = Finao_Preferences.getString("Login_Session", "");
		Btn_key = getIntent().getIntExtra("Btn_key", 1);
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
		} else {
			if (Btn_key == 1) {
				Text_type.setText("FINAOs");
				Createfinao.setVisibility(View.VISIBLE);
			} else if (Btn_key == 2) {
				Text_type.setText("Tiles");
			} else if (Btn_key == 3) {
				Text_type.setText("Following");
			} else if (Btn_key == 4) {
				Text_type.setText("Followers");
			}
			new ProfilePageAssyncTask(Btn_key, headerToken).execute();
		}

	}

	private class ProfilePageAssyncTask extends AsyncTask<Void, Void, Integer> {
		String thisToken;
		String Loading_Msg = null;
		GettingFinaosList gs = null;
		GettingTiles gt = new GettingTiles();
		GettingFollowers gf;

		public ProfilePageAssyncTask(int btn_Key, String token) {
			thisToken = token;
			gs = new GettingFinaosList(thisToken);
			if (btn_Key == 1) {
				Loading_Msg = "Loading FINAOs";
			} else if (btn_Key == 2) {
				Loading_Msg = "Loading Tiles";
			} else if (btn_Key == 3) {
				Loading_Msg = "Loading Following";
				gf = new GettingFollowers("followings");
			} else if (btn_Key == 4) {
				Loading_Msg = "Loading Followers";
				gf = new GettingFollowers("followers");
			}
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(mActivity);
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					Loading_Msg);
		}

		protected Integer doInBackground(Void... params) {

			if (Btn_key == 1) {
				Finao_List_Data = gs.GetFinaosList(_UserID_SPS_Str, "user",
						"0", thisToken);
			} else if (Btn_key == 2) {
				Tiles_List_Data = gt.GetTilesList(_UserID_SPS_Str, "",
						thisToken);
			} else if (Btn_key == 3) {
				Following_List_Data = gf.GetFollowersList(null, thisToken);
			} else if (Btn_key == 4) {
				Followers_List_Data = gf.GetFollowersList(null, thisToken);
			}

			return 0;
		}

		protected void onPostExecute(Integer result) {
			super.onPostExecute(result);
			if (null != pDialog && pDialog.isShowing()) {
				pDialog.dismiss();
			}
			if (Btn_key == 1) {
				int no = Finao_List_Data.size();
				if (no != 0) {
					finaoListAdapter = new FinaoListAdapter(mActivity,
							Finao_List_Data);
					ProfilePage_LV.setAdapter(finaoListAdapter);
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No FINAO Items");
					Toast.makeText(mActivity, "No FINAO Items",
							Toast.LENGTH_SHORT).show();
				}

			} else if (Btn_key == 2) {
				int no = Tiles_List_Data.size();
				profile_titlegrid.setVisibility(View.VISIBLE);
				ProfilePage_LV.setVisibility(View.GONE);

				if (no != 0) {
					profile_titlegrid.setAdapter(new TilesListAdapter(
							mActivity, Tiles_List_Data));
				} else {
					profile_titlegrid.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No Tiles");
					// Toast.makeText(mActivity, "No Tiles",
					// Toast.LENGTH_SHORT).show();
				}

			} else if (Btn_key == 3) {
				int no = Following_List_Data.size();
				if (no != 0) {
					ProfilePage_LV.setAdapter(new FollowersAdapter(
							getApplicationContext(), Following_List_Data));
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No Followings are there");
					// Toast.makeText(getApplicationContext(),
					// "No Following are thr", Toast.LENGTH_SHORT).show();
				}
			} else if (Btn_key == 4) {
				int no = Followers_List_Data.size();
				if (no != 0) {
					ProfilePage_LV.setAdapter(new FollowersAdapter(
							getApplicationContext(), Followers_List_Data));
				} else {
					ProfilePage_LV.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					Header.setText("No Followers are there");
					// Toast.makeText(getApplicationContext(),
					// "No Follower are thr ", Toast.LENGTH_SHORT).show();
				}
			}

		}
	}

	public class FinaoListAdapter extends BaseAdapter {
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
				// size here FRED
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			final FinaosListPojo flp = Adapter_List.get(position);
			holder.Finao_Title.setText(flp.getF_FinaoTitle());

			if (flp.getF_Finao_Status().equalsIgnoreCase("1")) {
				holder.Finao_status.setImageResource(R.drawable.btnaheadhover);
			} else if (flp.getF_Finao_Status().equalsIgnoreCase("0")) {
				holder.Finao_status
						.setImageResource(R.drawable.btnontrackhover);
			} else if (flp.getF_Finao_Status().equalsIgnoreCase("2")) { 
				holder.Finao_status.setImageResource(R.drawable.btnbehindhover);
			}
			convertView.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {

					Intent intent = new Intent(getApplicationContext(),
							FinaoDetailsView.class);
					intent.putExtra("F_UserId", _UserID_SPS_Str);
					intent.putExtra("F_FinaoTitle", flp.getF_FinaoTitle());
					intent.putExtra("F_FinId", flp.getF_FinaoId());
					intent.putExtra("F_Public",
							flp.getF_Ispublic_or_Followstatus());
					intent.putExtra("F_FinStatus", flp.getF_Finao_Status());
					intent.putExtra("F_Profile_Pic_path", Profile_Pic_path);
					intent.putExtra("F_UserName", Username);
					intent.putExtra("F_From", "user");

					startActivity(intent);
				}
			});
			return convertView;

		}
	}

	public class TilesListAdapter extends BaseAdapter {
		Context con;
		ArrayList<GetTiles> Tile_Adapter_List = new ArrayList<GetTiles>();
		TextView Caption_TV;
		ImageView Tile_Image_IV;
		String imgtype, Tile_Image_Path, Tile_ID_Str;
		ViewHolder holder = null;

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
		public View getView(int position, View convertView, ViewGroup parent) {
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
			final GetTiles gt = Tile_Adapter_List.get(position);

			holder.Grid_TV.setText(gt.getTile_Name());
			Tile_ID_Str = gt.getTile_Id();
			if (Constants.LOG)
				Log.i(TAG, "Tile_ID_Str is :" + Tile_ID_Str);

			String str = fs.TileImagesLink();
			String str1 = gt.getTile_Image();
			Tile_Image_Path = str + str1;
			Log.i(TAG, Tile_Image_Path);
			imageLoader.DisplayImage(Tile_Image_Path, holder.Grid_Img_IV, true, true);

			convertView.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					try {
						if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
							Intent in = new Intent(con, TileFinaoList.class);
							in.putExtra("TileID", gt.getTile_Id());
							in.putExtra("Tile_Name", gt.getTile_Name());
							in.putExtra("Tile_Key", "Own_Profile");
							startActivity(in);
						} else {
							Toast toast = Toast
									.makeText(
											getApplicationContext(),
											"Please Check the Internet Connection.....",
											Toast.LENGTH_SHORT);
							toast.setGravity(Gravity.CENTER, 0, 0);
							toast.show();
						}
					} catch (Exception e) {
						Log.e(TAG, e.toString());
						e.printStackTrace();
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

		@Override
		public View getView(final int position, View view, ViewGroup arg2) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			view = li.inflate(R.layout.notificationsrow, null);

			TextView tv1 = (TextView) view.findViewById(R.id.textView1);
			tv1.setText(flist.get(position).getFName() + " "
					+ flist.get(position).getLName());

			String ImageURL = fs.ProfileImagesLink()
					+ flist.get(position).getProfileImage();
			if (Constants.LOG)
				Log.v("ImageURL", ImageURL);

			final ImageView iv = (ImageView) view.findViewById(R.id.imageView1);

			imageLoader.DisplayImage(ImageURL, iv, true, true);
			view.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					Intent intent = new Intent(getApplicationContext(),
							Finaopersonalprofile.class);
					intent.putExtra("Search_FN", flist.get(position).getFName());
					intent.putExtra("Search_SN", flist.get(position).getLName());
					if (Btn_key == 3) {
						Log.i("user id", "user id 3 = "
								+ flist.get(position).getTracking_ID());
						intent.putExtra("Search_UID", flist.get(position)
								.getTracking_UserID());
					} else if (Btn_key == 4) {
						Log.i("user id", "user id 4 = "
								+ flist.get(position).getTracking_ID());
						intent.putExtra("Search_UID", flist.get(position)
								.getTracking_ID());
					} else {
						Log.i("user id", "user id 5 = "
								+ flist.get(position).getTracking_ID());
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
			return view;
		}

	}

}
