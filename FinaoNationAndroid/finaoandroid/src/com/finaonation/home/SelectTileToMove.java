package com.finaonation.home;

import java.util.ArrayList;

import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap.CompressFormat;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.beanclasses.GetTiles;
import com.finaonation.finao.R;
import com.finaonation.home.TrendingDetail.Myadapter;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.profile.GettingTiles;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.webservices.FinaoServiceLinks;
import com.nostra13.universalimageloader.cache.disc.naming.HashCodeFileNameGenerator;
import com.nostra13.universalimageloader.cache.memory.impl.UsingFreqLimitedMemoryCache;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageLoadingListener;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;

public class SelectTileToMove extends Activity {

	TextView List_Header_TV;
	Activity mActivity;
	ListView Tiles_LV;
	String Fin_ID, Til_ID, _UserID_SPS_Str;
	ArrayList<GetTiles> mylist;
	ArrayList<GetTiles> fpolist = new ArrayList<GetTiles>();
	Myadapter adapter;
	ArrayList<GetTiles> Tiles_List_Data = new ArrayList<GetTiles>();
	ImageLoadingListener loadingListner;
	DisplayImageOptions imgDisplayOptions;
	ImageLoader imageLoader;
	String headerToken;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.selectfinaotopost);
		@SuppressWarnings("deprecation")
		SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
		headerToken = Finao_Preferences.getString("logtoken", "");
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
				// .showImageOnFail(R.string.error_loading)
				// .imageScaleType(ImageScaleType.EXACT)
				.build();
		imageLoader = ImageLoader.getInstance();
		imageLoader.init(config);

		mActivity = this;
		getIDs();
		List_Header_TV.setText("Select Tile to Move FINAO");
		Fin_ID = getIntent().getExtras().getString("Finao_ID");
		Til_ID = getIntent().getExtras().getString("");
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");

		new FinaoTilesAssync().execute();

		Tiles_LV.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> av, View v, int position,
					long arg3) {
				// TODO Auto-generated method stub
				GetTiles gt = Tiles_List_Data.get(position);
				String Target_Tile_ID = gt.getTile_Id();

				FinaoServiceLinks fs = new FinaoServiceLinks();
				String str = fs.NameSpace();
				String str1 = str + "movefinao&finao_id=";
				String str2 = str1 + Fin_ID;
				String str3 = str2 + "&user_id=";
				String str4 = str3 + _UserID_SPS_Str;
				String str5 = str4 + "&srctile_id=";
				String str6 = str5 + Til_ID;
				String str7 = str6 + "&targettile_id=";
				String str8 = str7 + Target_Tile_ID;

				String temp = str8.replaceAll(" ", "%20");
				if (Constants.LOG)
					Log.v("MoveFinaoURL", temp);

				JSonHelper jh = new JSonHelper();
				JSONObject json = jh.getJSONfromURL(temp, headerToken);

				try {
					// JSONArray res = null;
					String res = json.getString("res");
					String resss = "OK";

					if (res.equalsIgnoreCase(resss)) {

						Toast.makeText(mActivity, "Finao Moved Successfully",
								Toast.LENGTH_SHORT).show();

						Intent refreshintent = new Intent(mActivity,
								FinaoFooterTab.class);
						refreshintent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
						startActivity(refreshintent);
						finish();
					}
				} catch (Exception e) {

					e.printStackTrace();

				}
			}
		});
	}

	private class FinaoTilesAssync extends AsyncTask<Void, Void, Integer> {
		ProgressDialog pDialog = new ProgressDialog(mActivity);

		GettingTiles gt = new GettingTiles();

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					"Loading Tiles", true, true);
		}

		protected Integer doInBackground(Void... params) {

			Tiles_List_Data = gt.GetTilesList(_UserID_SPS_Str, "", headerToken);
			return 0;
		}

		protected void onPostExecute(Integer result) {
			pDialog.dismiss();

			int no = Tiles_List_Data.size();
			if (no != 0) {
				Tiles_LV.setAdapter(new TilesListAdapter(mActivity,
						Tiles_List_Data));
			} else {
				Tiles_LV.setAdapter(null);
				Toast.makeText(mActivity, "No Tiles", Toast.LENGTH_SHORT)
						.show();
			}
		}

	}

	public class TilesListAdapter extends BaseAdapter {

		Context con;
		ArrayList<GetTiles> Tile_Adapter_List = new ArrayList<GetTiles>();
		TextView Caption_TV;
		ImageView Tile_Image_IV;
		String imgtype, Tile_Image_Path, Tile_ID_Str;

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

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {

			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			View v = li.inflate(R.layout.tilerow, null);

			GetTiles gt = Tile_Adapter_List.get(position);

			Caption_TV = (TextView) v.findViewById(R.id.tilecaptiontvid);
			Tile_Image_IV = (ImageView) v.findViewById(R.id.tileimageivid);

			imgtype = gt.getTile_Name();
			Tile_ID_Str = gt.getTile_Id();

			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str = fs.TileImagesLink();
			String str1 = gt.getTile_Image();
			Tile_Image_Path = str + str1;

			try {
				Caption_TV.setText(imgtype);
				imageLoader.displayImage(Tile_Image_Path, Tile_Image_IV,
						imgDisplayOptions, loadingListner);
			} catch (Exception e) {
				e.printStackTrace();
			}

			return v;
		}

	}

	private void getIDs() {
		List_Header_TV = (TextView) findViewById(R.id.selectfinaotoposttvid);
		Tiles_LV = (ListView) findViewById(R.id.selectfinaotopostlvid);
	}
}
