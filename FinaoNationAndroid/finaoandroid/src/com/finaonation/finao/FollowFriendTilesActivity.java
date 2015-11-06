package com.finaonation.finao;

import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.GetTiles;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class FollowFriendTilesActivity extends Activity {

	public static final String TAG = "FollowFriendTiles";
	String headerToken, frienduserid;
	private SharedPreferences Finao_Preferences;
	ArrayList<GetTiles> Tiles_List_Data;
	ListView tilelist;
	TextView header;
	ImageLoader imageLoader;
	FinaoServiceLinks fs;
	String userid;
	private int followingcount = 0;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_follow_friend_tiles);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		userid = Finao_Preferences.getString("User_ID", "0");
		headerToken = Finao_Preferences.getString("logtoken", "");
		frienduserid = getIntent().getExtras().getString("userid");
		header = (TextView) findViewById(R.id.header);
		tilelist = (ListView) findViewById(R.id.profilepagelvid);
		imageLoader = new ImageLoader(this);
		fs = new FinaoServiceLinks();
		new FriendTilesAssyncTask("tiles").execute();
	}

	private class FriendTilesAssyncTask extends
			AsyncTask<String, Void, Integer> {
		ProgressDialog pDialog = new ProgressDialog(
				FollowFriendTilesActivity.this);
		String Loading_Msg;
		String method = null;
		boolean status = true;

		public FriendTilesAssyncTask(String api) {
			method = api;
			if (api.equalsIgnoreCase("tiles")) {
				Loading_Msg = "Loading Tiles...";
				Tiles_List_Data = new ArrayList<GetTiles>();
			} else if (api.equalsIgnoreCase("followall")) {
				status = false;
				Loading_Msg = "Following All Tiles...";
			} else if (api.equalsIgnoreCase("unfollow")) {
				status = false;
				Loading_Msg = "Unfollowing tile...";
			} else if (api.equalsIgnoreCase("unfollowall")) {
				status = false;
				Loading_Msg = "Unfollowing all...";
			} else {
				status = false;
				Loading_Msg = "Following Tile...";
			}
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(FollowFriendTilesActivity.this,
					"FINAO Nation", Loading_Msg, true, true);
		}

		protected Integer doInBackground(String... params) {
			MultipartEntity entity = new MultipartEntity();
			JsonHelper helper = new JsonHelper();
			try {
				if (method.equalsIgnoreCase("follow")) {
					MultipartEntity reqentity = new MultipartEntity();
					reqentity.addPart("json", new StringBody("followuser"));
					reqentity.addPart("tileid", new StringBody(params[0]));
					reqentity.addPart("followeduserid", new StringBody(
							params[1]));
					JSONObject update = helper.getJSONfromURL(fs.baseurl(),
							headerToken, reqentity);
					if (update.has("IsSuccess")
							&& update.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						status = true;
						Tiles_List_Data.removeAll(Tiles_List_Data);
					} else {
						status = false;
					}
				} else if (method.equalsIgnoreCase("unfollowall")) {
					MultipartEntity reqentity = new MultipartEntity();
					reqentity.addPart("json",
							new StringBody("unfollowalltiles"));
					reqentity.addPart("id", new StringBody(params[1]));
					JSONObject update = helper.getJSONfromURL(fs.baseurl(),
							headerToken, reqentity);
					if (update.has("IsSuccess")
							&& update.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						status = true;
						Tiles_List_Data.removeAll(Tiles_List_Data);
					} else {
						status = false;
					}
				} else if (method.equalsIgnoreCase("unfollow")) {
					MultipartEntity reqentity = new MultipartEntity();
					reqentity.addPart("json", new StringBody("unfollow"));
					reqentity.addPart("tileid", new StringBody(params[0]));
					reqentity.addPart("followeduserid", new StringBody(
							params[1]));
					JSONObject update = helper.getJSONfromURL(fs.baseurl(),
							headerToken, reqentity);
					if (update.has("IsSuccess")
							&& update.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						status = true;
						Tiles_List_Data.removeAll(Tiles_List_Data);
					} else {
						status = false;
					}
				} else if (method.equalsIgnoreCase("followall")) {
					MultipartEntity reqentity = new MultipartEntity();
					reqentity.addPart("json", new StringBody("followalltiles"));
					reqentity.addPart("id", new StringBody(params[1]));
					JSONObject update = helper.getJSONfromURL(fs.baseurl(),
							headerToken, reqentity);
					if (update.has("IsSuccess")
							&& update.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						status = true;
						Tiles_List_Data.removeAll(Tiles_List_Data);
					} else {
						status = false;
					}
				}
				if (status == true) {
					entity.addPart("json",
							new StringBody("public_followedtile"));
					entity.addPart("userid", new StringBody(frienduserid));

					JSONObject obj = helper.getJSONfromURL(fs.baseurl(),
							headerToken, entity);
					if (obj != null
							&& obj.has("IsSuccess")
							&& obj.getString("IsSuccess").equalsIgnoreCase(
									"true")) {
						JSONArray res = obj.getJSONArray("item");
						GetTiles fp;
						int length = res.length();
						if (length > 0) {
							GetTiles all = new GetTiles();
							all.setTile_Name("All Tiles");
							all.setTile_Id("0");
							all.setIsFollowed("0");
							Tiles_List_Data.add(all);

						}
						followingcount = 0;
						for (int index = 0; index < length; index++) {
							JSONObject finao = res.getJSONObject(index);
							fp = new GetTiles();
							if (finao.has("tile_name")) {
								fp.setTile_Name(finao.getString("tile_name"));
							} else {
								fp.setTile_Name("");
							}
							fp.setTile_Image(finao.getString("tile_image"));
							fp.setIsFollowed(finao.getString("type"));
							if (finao.getString("type").equalsIgnoreCase("1"))
								followingcount = followingcount + 1;
							fp.setTile_Id(finao.getString("tile_id"));
							Tiles_List_Data.add(fp);
						}
					}
				}
			} catch (Exception e) {
				e.printStackTrace();
			}
			return 0;
		}

		protected void onPostExecute(Integer result) {
			pDialog.dismiss();

			tilelist.setVisibility(View.VISIBLE);
			int no = Tiles_List_Data.size();
			if (no != 0 && status == true) {
				tilelist.setAdapter(null);
				tilelist.setAdapter(new TilesListAdapter(
						FollowFriendTilesActivity.this, Tiles_List_Data));
			} else {
				tilelist.setAdapter(null);
				header.setVisibility(View.VISIBLE);
				header.setText("No Tiles");
			}

		}
	}

	public void backClicked(View view){
		finish();
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
			ImageView followbtn;
		}

		@Override
		public View getView(final int position, View convertView,
				ViewGroup parent) {
			LayoutInflater li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			if (convertView == null) {
				convertView = li.inflate(R.layout.follow_tile_list, null);
				holder = new ViewHolder();
				holder.Grid_Img_IV = (ImageView) convertView
						.findViewById(R.id.profile_image);
				holder.Grid_TV = (TextView) convertView
						.findViewById(R.id.tv_Name);
				holder.followbtn = (ImageView) convertView
						.findViewById(R.id.imageView2);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			holder.Grid_TV.setText(Tile_Adapter_List.get(position)
					.getTile_Name());
			Tile_Image_Path = Tile_Adapter_List.get(position).getTile_Image();
			if (Tile_Adapter_List.get(position).getTile_Id()
					.equalsIgnoreCase("0"))
				holder.Grid_Img_IV
						.setBackgroundResource(R.drawable.logo_finao);
			else
	 			imageLoader.DisplayImage(Tile_Image_Path, holder.Grid_Img_IV, 
	 					false , false);

			if (Tile_Adapter_List.get(position).getIsFollowed()
					.equalsIgnoreCase("1")
					|| followingcount >= Tile_Adapter_List.size() - 1) {
				holder.followbtn.setImageResource(R.drawable.btnfollowing);
			} else {
				holder.followbtn.setImageResource(R.drawable.btnfollow);
			}
			if (frienduserid.equalsIgnoreCase(userid))
				holder.followbtn.setVisibility(View.GONE);
			holder.followbtn.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View v) {
					if (position == 0
							&& followingcount < Tile_Adapter_List.size() - 1) {
						new FriendTilesAssyncTask("followall").execute(null,
								frienduserid);
					} else if (position == 0
							&& followingcount == Tile_Adapter_List.size() - 1) {
						new FriendTilesAssyncTask("unfollowall").execute(null,
								frienduserid);
					} else if (Tile_Adapter_List.get(position).getIsFollowed()
							.equalsIgnoreCase("0")
							&& position != 0) {
						if (!frienduserid.equalsIgnoreCase(userid))
							new FriendTilesAssyncTask("follow").execute(
									Tile_Adapter_List.get(position)
											.getTile_Id(), frienduserid);
						else
							Toast.makeText(v.getContext(),
									"Can't follow yourself", Toast.LENGTH_SHORT)
									.show();
					} else if (Tile_Adapter_List.get(position).getIsFollowed()
							.equalsIgnoreCase("1")) {
						new FriendTilesAssyncTask("unfollow").execute(
								Tile_Adapter_List.get(position).getTile_Id(),
								frienduserid);
					} else {

					}
				}
			});

			return convertView;
		}
	}

}
