package com.finaonation.finao;

import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.beanclasses.GettingFinoDetailsItems;
import com.finaonation.beanclasses.Gettingchangefinaostatus;
import com.finaonation.beanclasses.InspiredDetailsListPojo;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.profile.DisplayHomeImages;
import com.finaonation.profile.ProfileEditStory;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class FinaoDetailsView extends Activity {
	public static final String TAG = "FinaoDetailsView";
	private TextView Finao_Title, Finaostatus;
	ImageLoader imageLoader;
	private String Finao_Id, User_Id, Finao_Status, Profile_Pic_path, username,
			from, _UserID_SPS_Str;
	ListView F_Detaillist;
	ImageView finaoStatus_IM;
	private String pubicorprivate;
	com.finaonation.internet.InternetChecker ic;
	Dialog dl;
	ImageView imgbtnOntrack;
	ImageView imgbtnahead;
	ImageView imgbtnbehind;
	ImageView imgbtncomplete;
	SharedPreferences Finao_Preferences;
	String headerToken;
	private String baseurl;
	private FinaoServiceLinks FS;
	ArrayList<InspiredDetailsListPojo> FinaoDetailsListData = new ArrayList<InspiredDetailsListPojo>();

	@SuppressWarnings("deprecation")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_WORLD_READABLE);
		setContentView(R.layout.activity_finao_details_view);
		Finao_Title = (TextView) findViewById(R.id.finao_Title);
		F_Detaillist = (ListView) findViewById(R.id.finao_detailslistview);
		finaoStatus_IM = (ImageView) findViewById(R.id.finaostatusivid);
		Finaostatus = (TextView) findViewById(R.id.Finaostatus);
		FS = new FinaoServiceLinks();
		baseurl = FS.NameSpace();
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
		headerToken = Finao_Preferences.getString("logtoken", "");
		imageLoader = new ImageLoader(this);
		F_Detaillist.setAdapter(null);
		ic = new com.finaonation.internet.InternetChecker();
		Finao_Title.setText(getIntent().getExtras().get("F_FinaoTitle")
				.toString());

		Finao_Id = getIntent().getExtras().get("F_FinId").toString();
		User_Id = getIntent().getExtras().get("F_UserId").toString();
		Finao_Status = getIntent().getExtras().get("F_FinStatus").toString();
		Profile_Pic_path = getIntent().getExtras().get("F_Profile_Pic_path")
				.toString();
		username = getIntent().getExtras().get("F_UserName").toString();
		from = getIntent().getExtras().get("F_From").toString();
		pubicorprivate = getIntent().getExtras().get("F_Public").toString();

		if (Constants.LOG)
			Log.d("TAG", "Finao_Status:" + Finao_Status);
		/* Setting Finao Tracking Status */
		if (Finao_Status.equalsIgnoreCase("1")) {
			finaoStatus_IM.setImageResource(R.drawable.btnaheadhover);
		} else if (Finao_Status.equalsIgnoreCase("0")) {
			finaoStatus_IM.setImageResource(R.drawable.btnontrackhover);
		} else if (Finao_Status.equalsIgnoreCase("2")) {
			finaoStatus_IM.setImageResource(R.drawable.btnbehindhover);
		} else {
			finaoStatus_IM.setImageResource(R.drawable.btncompletehover);
		}

		/* setting the public or Follow Status by user status */
		if (from.equalsIgnoreCase("user")) {
			if (pubicorprivate.equalsIgnoreCase("1")) {
				Finaostatus.setText("Public");
				Finaostatus.setTag("puborprivate");
			} else {
				Finaostatus.setText("Private");
				Finaostatus.setTag("puborprivate");
			}
		} else {
			Finaostatus.setVisibility(View.INVISIBLE);
		}

		Finaostatus.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				if (v.getTag().toString().equalsIgnoreCase("puborprivate")) {
					if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
						if (Finaostatus.getText().toString()
								.equalsIgnoreCase("Private")) {
							Finaostatus.setText("Public");
							Finaostatus.setTag("puborprivate");
							new changefinaostatus(headerToken).execute("1",
									User_Id, Finao_Id, "1", "1");
						} else {
							Finaostatus.setText("Private");
							Finaostatus.setTag("puborprivate");
							new changefinaostatus(headerToken).execute("1",
									User_Id, Finao_Id, "0", "0");

						}
					} else {
						Toast toast = Toast.makeText(getApplicationContext(),
								"Please Check the Internet Connection.....",
								Toast.LENGTH_SHORT);
						toast.setGravity(Gravity.CENTER, 0, 0);
						toast.show();
					}
				} else {
					String Tile_ID = getIntent().getExtras().get("F_Tile_Id")
							.toString();
					if (Finaostatus.getText().toString()
							.equalsIgnoreCase("Follow")) {
						Finaostatus.setText("UnFollow");
						Finaostatus.setTag("FolloworUnF");
						String str1 = baseurl + "addTracker&tracker_userid="
								+ User_Id + "";
						String str2 = str1 + "&tracked_userid="
								+ _UserID_SPS_Str + "";
						String str3 = str2 + "&tracked_tileid=" + Tile_ID + "";
						String str4 = str3 + "&status=1";
						if (Constants.LOG)
							Log.d("follow url", str4);
						new FollowUnFollowAssyntask(str4).execute();

					} else {
						Finaostatus.setText("Follow");
						Finaostatus.setTag("FolloworUnF");
						String str1 = baseurl + "addTracker&tracker_userid="
								+ User_Id + "";
						String str2 = str1 + "&tracked_userid="
								+ _UserID_SPS_Str + "";
						String str3 = str2 + "&tracked_tileid=" + Tile_ID + "";
						String str4 = str3 + "&status=0";
						if (Constants.LOG)
							Log.d("follow url", str4);
						new FollowUnFollowAssyntask(str4).execute();
					}
				}
			}
		});

		/************** Checking Net connectivity ***********/
		boolean b = ic.IsNetworkAvailable(getApplicationContext());

		if (b == true) {
			new FinoDetailsAssyncTask(headerToken).execute();
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"Please Check the Internet Connection and Come back.....",
					Toast.LENGTH_SHORT);
			toast.setGravity(Gravity.CENTER, 0, 0);
		}

		finaoStatus_IM.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				if (from.equalsIgnoreCase("user")) {
					if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
						finao_status_alertdailogue(Finao_Status,
								pubicorprivate, Finao_Id, pubicorprivate);
					} else {
						Toast toast = Toast.makeText(getApplicationContext(),
								"Please Check the Internet Connection .....",
								Toast.LENGTH_SHORT);
						toast.setGravity(Gravity.CENTER, 0, 0);
						toast.show();
					}
				}
			}
		});

		Finao_Title.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				if (from.equalsIgnoreCase("user")) {
					if (ic.IsNetworkAvailable(getApplicationContext()) == true) {
						Intent in = new Intent(getApplicationContext(),
								ProfileEditStory.class);
						in.putExtra("Profile_Page_Story", Finao_Title.getText()
								.toString());
						in.putExtra("FinaoID", Finao_Id);
						startActivity(in);
					} else {
						Toast toast = Toast.makeText(getApplicationContext(),
								"Please Check the Internet Connection.....",
								Toast.LENGTH_SHORT);
						toast.setGravity(Gravity.CENTER, 0, 0);
						toast.show();
					}
				}
			}
		});

	}

	public void backClicked(View view) {
		finish();
	}

	@SuppressWarnings("deprecation")
	@Override
	protected void onResume() {
		super.onResume();
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
				.edit();
		Finao_Title.setText(Finao_Preferences.getString("FinaoTitle",
				getIntent().getExtras().getString("F_FinaoTitle")));
		Finao_Preference_Editor.putString("FinaoTitle", null);
		Finao_Preference_Editor.commit();
	}

	/************** Getting Finao Detail Data by service ***********/
	private class FinoDetailsAssyncTask extends AsyncTask<Void, Void, Integer> {

		ProgressDialog pDialog = new ProgressDialog(FinaoDetailsView.this);
		String Loading_Msg = null;
		GettingFinoDetailsItems gf;
		String thisHeaderToken;

		public FinoDetailsAssyncTask(String token) {
			thisHeaderToken = token;
			gf = new GettingFinoDetailsItems(thisHeaderToken);
			Loading_Msg = "Loading Finao Items";
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = FinaoCustomProgress.show(FinaoDetailsView.this,
					"FINAO Nation", Loading_Msg, true, true);
		}

		protected Integer doInBackground(Void... params) {
			FinaoDetailsListData = gf.GetFinaoDetailsList(User_Id, Finao_Id,
					thisHeaderToken);
			return 0;
		}

		protected void onPostExecute(Integer result) {
			int no = FinaoDetailsListData.size();
			if (Constants.LOG)
				Log.d(TAG, "no:" + no);
			if (no != 0) {
				F_Detaillist.setAdapter(new FinaoDetailListAdapter(
						getApplicationContext(), FinaoDetailsListData));
			} else {
				F_Detaillist.setAdapter(null);
				Toast.makeText(getApplicationContext(), "No Finao Items",
						Toast.LENGTH_SHORT).show();
			}
			pDialog.dismiss();
		}

	}

	/************** Finao Details Adapter Setting ***********/
	private class FinaoDetailListAdapter extends BaseAdapter {
		ArrayList<InspiredDetailsListPojo> _finaoDetailsListData;

		public FinaoDetailListAdapter(Context applicationContext,
				ArrayList<InspiredDetailsListPojo> finaoDetailsListData) {
			this._finaoDetailsListData = finaoDetailsListData;
			if (Constants.LOG)
				Log.i(TAG, "no of finao items:" + _finaoDetailsListData.size());
		}

		@Override
		public int getCount() {
			return _finaoDetailsListData.size();
		}

		@Override
		public Object getItem(int position) {
			return position;
		}

		@Override
		public long getItemId(int position) {
			return position;
		}

		InspiredDetailsListPojo fhp;
		ImagePagerAdapter adapter;
		ViewPager pager;
		PagerContainer mContainer;
		String FinUploadtext;
		ImageView profile_IM, F_Status;
		TextView profilename_TV, Date_TV, up_Tv, Finaocaptiontvid;
		LayoutInflater li;
		RelativeLayout rPager, rVideo;

		@Override
		public View getView(int position, View convertVieww, ViewGroup parent) {
			li = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
			fhp = _finaoDetailsListData.get(position);
			if (Constants.LOG)
				Log.i(TAG, "detail count is  : " + _finaoDetailsListData.size());

			FinUploadtext = fhp.getF_Upload_Text();
			if (convertVieww == null) {
				convertVieww = li.inflate(R.layout.finao_imageinflater, null);
			}
			Finaocaptiontvid = (TextView) convertVieww
					.findViewById(R.id.finaoname);
			rPager = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RL);
			rVideo = (RelativeLayout) convertVieww
					.findViewById(R.id.finaoimgi_RLV);

			mContainer = (PagerContainer) convertVieww
					.findViewById(R.id.pager_container);
			pager = mContainer.getViewPager();
			F_Status = (ImageView) convertVieww
					.findViewById(R.id.finaostatusivid);
			if (Finao_Status.equalsIgnoreCase("1")) {
				F_Status.setImageResource(R.drawable.btnaheadhover);
			} else if (Finao_Status.equalsIgnoreCase("0")) {
				F_Status.setImageResource(R.drawable.btnontrackhover);
			} else if (Finao_Status.equalsIgnoreCase("2")) {
				F_Status.setImageResource(R.drawable.btnbehindhover);
			} else {
				F_Status.setImageResource(R.drawable.btncompletehover);
			}
			showImageViewPagerContainer();
			hideVideoContainer();

			if (fhp.getF_imagearray() != null
					&& fhp.getF_imagearray().length() > 0) {
				adapter = new ImagePagerAdapter(fhp.getF_imagearray());
				pager.setAdapter(adapter);
				pager.setOffscreenPageLimit(adapter.getCount());
				if (fhp.getF_imagearray().length() > 0)
					pager.setPageMargin(-25);
				showImageViewPagerContainer();
			} else {
				hideImageViewPagerContainer();
			}
			profile_IM = (ImageView) convertVieww.findViewById(R.id.Profile_IM);
			profilename_TV = (TextView) convertVieww
					.findViewById(R.id.username);
			Date_TV = (TextView) convertVieww.findViewById(R.id.finaodatetvid);

			up_Tv = (TextView) convertVieww.findViewById(R.id.upload_Tv);

			Finaocaptiontvid.setText(getIntent().getExtras()
					.get("F_FinaoTitle").toString());
			imageLoader.DisplayImage(Profile_Pic_path, profile_IM, false, true);
			profilename_TV.setText(username);
			Date_TV.setText(fhp.getF_Udate());

			up_Tv.setText(FinUploadtext);
			// remove this when videos get added
			if (fhp.getF_Type() == 0) {
				hideImageViewPagerContainer();
				hideVideoContainer();
			}
			if (fhp.getF_Type() == 2) {
				hideImageViewPagerContainer();
				showVideoContainer();
			}
			return convertVieww;
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

		private void hideVideoContainer() {
			rVideo.setVisibility(View.GONE);
		}

		private void showVideoContainer() {
			rVideo.setVisibility(View.VISIBLE);
		}
	}

	private class ImagePagerAdapter extends PagerAdapter {

		ArrayList<String> imgar = new ArrayList<String>();
		JSONArray _f_imagearray;
		View layout;
		ImageView fina_im;

		public ImagePagerAdapter(JSONArray f_imagearray) {
			_f_imagearray = f_imagearray;
			for (int i = 0; i < f_imagearray.length(); i++) {
				try {
					JSONObject finao = _f_imagearray.getJSONObject(i);
					if (finao.getString("image_url") != null
							&& !finao.getString("image_url").toString()
									.equalsIgnoreCase(""))
						imgar.add(finao.getString("image_url").toString());
				} catch (JSONException e1) {
					e1.printStackTrace();
				}
			}
		}

		@Override
		public int getCount() {
			return _f_imagearray.length();
		}

		@Override
		public boolean isViewFromObject(View view, Object object) {
			return view == ((View) object);
		}

		TextView Furl;

		@Override
		public Object instantiateItem(ViewGroup container, int position) {

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

			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str1 = fs.FinaoImagesLink();
			String finurl = str1
					+ imgar.get(position).toString().replaceAll(" ", "%20");
			imageLoader.DisplayImage(finurl, fina_im, true, true);
			Furl = (TextView) layout.findViewById(R.id.Finaourl);
			Furl.setText(imgar.get(position).toString());
			((ViewPager) container).addView(layout, 0);
			layout.setOnClickListener(new OnClickListener() {
				@Override
				public void onClick(View dlg) {
					Intent in = new Intent(getApplicationContext(),
							DisplayHomeImages.class);
					in.putExtra("ProfilePicPath", Furl.getText().toString());
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

	/**** Finao Status click DIALOG Box popup ****/
	public void finao_status_alertdailogue(String Userfinao_status,
			String Userfinao_iscompleted, final String Finao_ID,
			final String Fin_ispublic) {

		dl = new Dialog(FinaoDetailsView.this);
		dl.setCanceledOnTouchOutside(true);
		dl.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dl.setContentView(R.layout.finaostatuschangepopup);
		dl.setTitle("Select One");

		WindowManager.LayoutParams wmlp = dl.getWindow().getAttributes();
		wmlp.gravity = Gravity.TOP | Gravity.LEFT;
		wmlp.x = 50; // x position
		wmlp.y = 50; // y position

		// -----------------------------------------
		// --Popup Button Start Here----------------
		// -----------------------------------------
		imgbtnOntrack = (ImageView) dl.findViewById(R.id.imgbtnOntrack);
		imgbtnahead = (ImageView) dl.findViewById(R.id.imgbtnahead);
		imgbtnbehind = (ImageView) dl.findViewById(R.id.imgbtnbehind);
		imgbtncomplete = (ImageView) dl.findViewById(R.id.imgbtncomplete);

		if (Userfinao_status.equalsIgnoreCase("0")) {
			Finao_Status = "0";
			imgbtnOntrack.setImageResource(R.drawable.btnontrackhover);

		} else if (Userfinao_status.equalsIgnoreCase("1")) {
			Finao_Status = "1";
			imgbtnahead.setImageResource(R.drawable.btnaheadhover);

		} else if (Userfinao_status.equalsIgnoreCase("2")) {
			Finao_Status = "2";
			imgbtnbehind.setImageResource(R.drawable.btnbehindhover);
		}

		else {
			imgbtncomplete.setImageResource(R.drawable.btncomplete);
		}

		imgbtnOntrack.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				setnormalimages();
				Finao_Status = "0";
				imgbtnOntrack.setImageResource(R.drawable.btnontrackhover);
				new changefinaostatus(headerToken).execute("2", User_Id,
						Finao_Id, "0", "0");
				finaoStatus_IM.setImageResource(R.drawable.btnontrackhover);
			}
		});

		imgbtnahead.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {

				setnormalimages();
				Finao_Status = "1";
				imgbtnahead.setImageResource(R.drawable.btnaheadhover);
				new changefinaostatus(headerToken).execute("2", User_Id,
						Finao_Id, "1", "0");
				finaoStatus_IM.setImageResource(R.drawable.btnaheadhover);
			}
		});

		imgbtnbehind.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				setnormalimages();
				imgbtnbehind.setImageResource(R.drawable.btnbehindhover);
				new changefinaostatus(headerToken).execute("2", User_Id,
						Finao_Id, "2", "0");
				finaoStatus_IM.setImageResource(R.drawable.btnbehindhover);
			}
		});

		imgbtncomplete.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				imgbtncomplete.setImageResource(R.drawable.btncompletehover);
				new changefinaostatus(headerToken).execute("2", User_Id,
						Finao_Id, "3", "0");
				finaoStatus_IM.setImageResource(R.drawable.btncompletehover);
			}
		});
		dl.show();
	}

	public void setnormalimages() {
		imgbtnOntrack.setImageResource(R.drawable.btnontrack);
		imgbtnahead.setImageResource(R.drawable.btnahead);
		imgbtnbehind.setImageResource(R.drawable.btnbehind);
	}

	private class changefinaostatus extends AsyncTask<String, Void, String> {
		String thisHeaderToken;
		ProgressDialog pDialog = new ProgressDialog(FinaoDetailsView.this);
		Gettingchangefinaostatus cf = null;

		public changefinaostatus(String headerToken) {
			thisHeaderToken = headerToken;
			cf = new Gettingchangefinaostatus(thisHeaderToken);
		}

		@Override
		protected void onPreExecute() {
			pDialog.setMessage("Updating Please Wait.....");
			pDialog.setCancelable(true);
			pDialog.show();
		}

		@Override
		protected String doInBackground(String... data) {
			String update_status = cf.changefinaostatus(data[0], data[3],
					data[1], data[2], data[4]);
			if (Constants.LOG)
				Log.d("follow url", update_status.toString());

			return update_status;
		}

		@Override
		protected void onPostExecute(String result) {
			pDialog.dismiss();

			if (result.equalsIgnoreCase("success")) {
				if (dl != null) {
					dl.dismiss();
				}
				Toast.makeText(getApplicationContext(),
						"Updated Status Successfully", Toast.LENGTH_SHORT)
						.show();
			} else {
				Toast.makeText(getApplicationContext(),
						"Updated Status Failed", Toast.LENGTH_SHORT).show();
			}
			finish();
		}
	}

	/* Follow or unFollow Cnage sercice call */
	private class FollowUnFollowAssyntask extends
			AsyncTask<String, Void, String> {
		String URL;
		ProgressDialog pDialog = new ProgressDialog(FinaoDetailsView.this);

		public FollowUnFollowAssyntask(String str4) {
			this.URL = str4;
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
		protected void onPreExecute() {
			pDialog.setMessage("Updating Please Wait.....");
			pDialog.setCancelable(true);
			pDialog.show();// TODO
		}

		@Override
		protected void onPostExecute(String result) {
			pDialog.dismiss();
		}
	}
}