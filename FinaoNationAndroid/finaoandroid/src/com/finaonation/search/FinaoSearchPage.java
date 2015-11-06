package com.finaonation.search;

import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnKeyListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.SearchByNameText;
import com.finaonation.finao.Contents;
import com.finaonation.finao.FinaoLoginOrRegister;
import com.finaonation.finao.QRCodeEncoder;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.finao.integration.android.IntentIntegrator;
import com.finaonation.finao.integration.android.IntentResult;
import com.finaonation.jsonhelper.JSonHelper;
import com.finaonation.profile.TileFinaoList;
import com.finaonation.utils.Constants;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;
import com.google.zxing.BarcodeFormat;
import com.makeramen.segmented.SegmentedRadioGroup;

@SuppressWarnings("unused")
public class FinaoSearchPage extends Activity implements
		OnCheckedChangeListener {
	private Context context;
	ListView lv_profiles;
	String headerToken;
	String searchtext;
	int button;
	boolean clearChecked = false;
	String imgurl;
	String userid;
	ArrayList<SearchByNameText> list_users;
	int btnval = 1;
	AutoCompleteTextView edt_search;
	Button qrscanner, scanner;
	LinearLayout linearsearch;
	protected Dialog view;
	public static final int DIALOG_DOWNLOAD_PROGRESS = 0;
	private static final String TAG = "FinaoSearchPage";
	SegmentedRadioGroup segmentedControl;
	SegmentedRadioGroup segmentImg;
	ImageLoader imageLoader;
	Toast mToast;
	int savedCheck = -1;
	TextView Header;
	ArrayList<String> Autocomplete;
	private SharedPreferences Finao_Preferences;
	profileAdapter profileadapter;

	@SuppressWarnings("deprecation")
	@Override
	protected void onResume() {
		super.onResume();
		ImageView imageView = (ImageView) findViewById(R.id.qrCode);
		imageView.setVisibility(View.GONE);
		showQRImage();
		segmentedControl = (SegmentedRadioGroup) findViewById(R.id.segment_text);
		RadioButton rb1 = (RadioButton) findViewById(R.id.button_one);
		RadioButton rb3 = (RadioButton) findViewById(R.id.button_three);
		rb3.setBackgroundDrawable(getResources().getDrawable(
				R.drawable.segment_radio_grey_left));
		rb3.setTextColor(Color.WHITE);
		segmentedControl.check(rb1.getId());
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);

		String Login_Key = Finao_Preferences.getString("Login_Session", "");

		if (Login_Key.length() == 0) {
			Intent i = new Intent(getApplicationContext(),
					FinaoLoginOrRegister.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(i);
			finish();
		}
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.finaosearchpage);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		Toast toast = Toast
				.makeText(getApplicationContext(),
						"Please tap on search bar on top of page to search for people or tiles",
						Toast.LENGTH_LONG);
		toast.show();
		imageLoader = new ImageLoader(this);
		Autocomplete = new ArrayList<String>();
		Header = (TextView) findViewById(R.id.header);
		segmentedControl = (SegmentedRadioGroup) findViewById(R.id.segment_text);
		segmentedControl.setOnCheckedChangeListener(this);
		segmentImg = (SegmentedRadioGroup) findViewById(R.id.segment_img);
		linearsearch = (LinearLayout) findViewById(R.id.layoutsearch);
		linearsearch.setVisibility(View.VISIBLE);
		list_users = new ArrayList<SearchByNameText>();
		context = this;
		edt_search = (AutoCompleteTextView) findViewById(R.id.editText1);
		searchtext = edt_search.getText().toString();
		lv_profiles = (ListView) findViewById(R.id.searchlistlvid);
		lv_profiles.setVisibility(View.GONE);
		ImageView imageView = (ImageView) findViewById(R.id.qrCode);
		imageView.setVisibility(View.GONE);

		showQRImage();
		lv_profiles.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> av, View v, int arg2,
					long arg3) {

				if (btnval == 1) {

					SearchByNameText list_item = list_users.get(arg2);
					if (Constants.LOG)
						Log.i(TAG, "list_item :" + list_item);

					String Search_First_Name = list_item.getFname();
					String Search_User_ID = list_item.getUserid();
					String search_Profile_Pic = list_item.getImgUrl();
					if (Constants.LOG)
						Log.i(TAG, "search_Profile_Pic" + search_Profile_Pic);
					String type = list_item.getResult_Type();
					String Finao_Count = list_item.getFinao_count();
					String Finao_story = list_item.getFinao_story();
					String Tile_Count = list_item.getTile_count();
					String Following_Count = list_item.getFollowing_count();
					Intent intent = null;
					if (type.equalsIgnoreCase("user")) {
						intent = new Intent(getApplicationContext(),
								Finaopersonalprofile.class);
						intent.putExtra("Search_BG_PIC",
								list_item.getBgimgUrl());
					} else {
						intent = new Intent(getApplicationContext(),
								TileFinaoList.class);
						intent.putExtra("TileID", Search_User_ID);
						intent.putExtra("Tile_Key", "Own_Profile");
					}
					intent.putExtra("Search_FN", Search_First_Name);
					intent.putExtra("Search_SN", "");
					intent.putExtra("Search_UID", Search_User_ID);
					intent.putExtra("Search_PIC", search_Profile_Pic);
					intent.putExtra("Search_Finao_Count", Finao_Count);
					intent.putExtra("Search_Tile_Count", Tile_Count);
					intent.putExtra("Search_Following_Count", Following_Count);
					if (Finao_story.equalsIgnoreCase("null")) {
						intent.putExtra("Search_story", "");
					} else {
						intent.putExtra("Search_story", Finao_story);
						if (Constants.LOG)
							Log.i(TAG, "Finao_story:" + Finao_story);
					}
					startActivity(intent);
				}
			}
		});

		edt_search.setOnKeyListener(new OnKeyListener() {
			public boolean onKey(View v, int keyCode, KeyEvent event) {
				if ((event.getAction() == KeyEvent.ACTION_DOWN)
						&& (keyCode == KeyEvent.KEYCODE_ENTER)) {
					list_users.clear();
					// list_tiles.clear();
					if (btnval == 1) {
						Toast toast = Toast
								.makeText(getApplicationContext(),
										"Updating search resuls....",
										Toast.LENGTH_LONG);
						toast.setGravity(Gravity.TOP, 0, 0);
						toast.show();
						new searchTextByNameAsyncTask(headerToken)
								.execute(searchtext);
					}
					hideSoftKeyboard(FinaoSearchPage.this);
					return true;
				}
				return false;
			}

		});

		edt_search.addTextChangedListener(new TextWatcher() {

			@Override
			public void onTextChanged(CharSequence start, int beforechar,
					int count, int arg3) {
				if (start.length() > 2) {
					// new AutocompletedataAsyncTask().execute(arg0.toString());
					Log.i(TAG, " Array size :" + Autocomplete.size());
					// ArrayAdapter<String> adapter = new
					// ArrayAdapter<String>(getApplicationContext(),
					// R.layout.autolistview, item);
					// edt_search.setThreshold(1);
					// edt_search.setAdapter(adapter);
					// adapter.notifyDataSetChanged();
					new searchTextByNameAsyncTask(headerToken).execute(start
							.toString());

				} else {
					Header.setVisibility(View.VISIBLE);
					linearsearch.setVisibility(View.VISIBLE);
					lv_profiles.setAdapter(null);
				}

			}

			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {

			}

			@Override
			public void afterTextChanged(Editable ed) {

			}
		});

		final Activity activityFinal = this;
		qrscanner = (Button) findViewById(R.id.button1);
		qrscanner.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				IntentIntegrator scanIntegrator = new IntentIntegrator(
						activityFinal);
				scanIntegrator.initiateScan();
			}

		});
	}

	public void Settingsclick(View v) {
		Intent in = new Intent(FinaoSearchPage.this, SettingActivity.class);
		overridePendingTransition(R.anim.slide_in, R.anim.slide_out);
		startActivity(in);
	}

	@SuppressWarnings("deprecation")
	public void onCheckedChanged(RadioGroup group, int checkedId) {
		if (clearChecked) {
			// clearChecked = false;
			return;
		}
		if (savedCheck != checkedId) {
			if (group == segmentedControl) {
				if (checkedId == R.id.button_one) {
					RadioButton rb1 = (RadioButton) findViewById(R.id.button_one);
					rb1.setBackgroundColor(getResources().getColor(
							R.color.orange));
					showQRImage();

				} else if (checkedId == R.id.button_two) {

				} else if (checkedId == R.id.button_three) {
					RadioButton rb1 = (RadioButton) findViewById(R.id.button_one);
					rb1.setBackgroundDrawable(getResources().getDrawable(
							R.drawable.segment_radio_grey_left));
					rb1.setTextColor(Color.WHITE);
					RadioButton rb3 = (RadioButton) findViewById(R.id.button_three);
					rb3.setTextColor(Color.WHITE);
					rb3.setBackgroundColor(getResources().getColor(
							R.color.orange));
					final Activity fActivity = this;
					Thread t = new Thread(new Runnable() {
						public void run() {
							runOnUiThread(new Runnable() {
								public void run() {
									Intent intent = new Intent(
											fActivity,
											com.finaonation.finao.client.android.CaptureActivity.class);
									fActivity.startActivity(intent);
								}
							});
						}
					});
					t.start();
				}
			}
		}
		savedCheck = checkedId;
	}

	private void showQRImage() {
		// ImageView to display the QR code in.
		ImageView imageView = (ImageView) findViewById(R.id.qrCode);
		imageView.setVisibility(View.VISIBLE);
		String qrData = "http://www.finaonation.com"; // TODO make this public &
														// a link to user's
														// profile saved in user
														// defaults
		int qrCodeDimention = 900;
		QRCodeEncoder qrCodeEncoder = new QRCodeEncoder(qrData, null,
				Contents.Type.TEXT, BarcodeFormat.QR_CODE.toString(),
				qrCodeDimention);
		try {
			Bitmap bitmap = qrCodeEncoder.encodeAsBitmap();
			imageView.setImageBitmap(bitmap);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void onActivityResult(int requestCode, int resultCode, Intent intent) {
		// retrieve scan result
		IntentResult scanningResult = IntentIntegrator.parseActivityResult(
				requestCode, resultCode, intent);
		if (scanningResult != null) {
			String scanFormat = scanningResult.getFormatName();
			Toast toast = Toast.makeText(getApplicationContext(), "Decoded "
					+ scanFormat, Toast.LENGTH_SHORT);
			toast.show();
		} else {
			Toast toast = Toast.makeText(getApplicationContext(),
					"No scan data received!", Toast.LENGTH_SHORT);
			toast.show();
		}
	}

	private class AutocompletedataAsyncTask extends
			AsyncTask<String, Void, JSONObject> {
		@Override
		protected JSONObject doInBackground(String... params) {
			// Making HTTP request

			FinaoServiceLinks obj = new FinaoServiceLinks();
			String str = obj.NameSpace();
			String url = str + "searchusers&username="
					+ edt_search.getText().toString(); // +params[0].toString();
			Log.i(TAG, " before %2o replace search url is :" + url);
			final String searchurl = url.replaceAll(" ", "%20");
			Log.i(TAG, "search url is :" + searchurl);
			JSonHelper objHelper = new JSonHelper();
			JSONObject jObj = objHelper.getJSONfromURL(searchurl, headerToken);

			return jObj;

		}

		protected void onPostExecute(JSONObject json) {
			Autocomplete.clear();
			try {
				if (json.get("res") != "") {
					JSONArray res = json.getJSONArray("res");
					for (int i = 0; i < res.length(); i++) {
						JSONObject user = res.getJSONObject(i);
						Autocomplete.add(user.getString("fname"));
					}

				} else {
				}

			} catch (JSONException e) {
				e.printStackTrace();
			} catch (Exception e) {
				e.printStackTrace();
			}
			ArrayAdapter<String> adapter = new ArrayAdapter<String>(
					getApplicationContext(), R.layout.autolistview,
					Autocomplete);
			edt_search.setThreshold(1);
			edt_search.setAdapter(adapter);
			// adapter.notifyDataSetChanged();

		}
	}

	private class searchTextByNameAsyncTask extends
			AsyncTask<String, Void, JSONObject> {
		ProgressDialog pd;
		String thisToken;

		public searchTextByNameAsyncTask(String headerToken) {
			thisToken = headerToken; // Fred empty token
		}

		protected void onPreExecute() {
			// ACTIVE_INSTANCE.showDialog(DIALOG_TASKING);
			// pd = new ProgressDialog(context);
			// pd.setMessage("loading...");
			// pd.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			// pd.show();
			// pd.setCancelable(true);
		}

		@Override
		protected JSONObject doInBackground(String... params) {
			// Making HTTP request
			FinaoServiceLinks obj = new FinaoServiceLinks();
			String str = obj.baseurl();
			MultipartEntity entity = null;
			try {
				entity = new MultipartEntity();
				entity.addPart("json", new StringBody("search"));
				entity.addPart("search", new StringBody(edt_search.getText()
						.toString()));
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			}

			JsonHelper objHelper = new JsonHelper();
			JSONObject jObj = objHelper
					.getJSONfromURL(str, headerToken, entity);

			return jObj;

		}

		protected void onPostExecute(JSONObject json) {
			list_users.clear();
			try {
				if (json.get("item") != "") {
					JSONArray res = json.getJSONArray("item");

					for (int i = 0; i < res.length(); i++) {
						JSONObject user = res.getJSONObject(i);
						if (Constants.LOG)
							Log.i(TAG, "user" + user);
						@SuppressWarnings("deprecation")
						final SharedPreferences Finao_Preferences = getSharedPreferences(
								"Finao_Preferences", MODE_WORLD_READABLE);
						if (!Finao_Preferences.getString("User_ID", "")
								.equalsIgnoreCase(user.getString("resultid"))) {
							SearchByNameText obj_user = new SearchByNameText();

							if (user.getString("name") != null
									&& !user.getString("name")
											.equalsIgnoreCase("null"))
								obj_user.setFname(user.getString("name"));
							else
								obj_user.setFname("");

							if (user.has("profile_bg_image"))
								obj_user.setBgimgUrl(user
										.getString("profile_bg_image"));

							obj_user.setResult_Type(user
									.getString("resulttype"));
							obj_user.setImgUrl(user.getString("image"));
							obj_user.setUserid(user.getString("resultid"));

							if (user.getString("mystory") != null
									&& !user.getString("mystory")
											.equalsIgnoreCase("null"))
								obj_user.setFinao_story(user
										.getString("mystory"));
							else
								obj_user.setFinao_story("");

							obj_user.setFinao_count(user
									.getString("totalfinaos"));
							obj_user.setTile_count(user.getString("totaltiles"));
							obj_user.setFollowing_count(user
									.getString("totalfollowings"));

							list_users.add(obj_user);
						}

					}
					// pd.dismiss();
					Header.setVisibility(View.GONE);
					linearsearch.setVisibility(View.GONE);
					lv_profiles.setVisibility(View.VISIBLE);
					profileadapter = new profileAdapter(getBaseContext(),
							R.layout.list_rowf, list_users);

					lv_profiles.setAdapter(profileadapter);
				} else {
					// pd.dismiss();

					lv_profiles.setAdapter(null);
					Header.setVisibility(View.VISIBLE);
					linearsearch.setVisibility(View.GONE);
					// Toast.makeText(getApplicationContext(), "No Posts Items",
					// Toast.LENGTH_SHORT).show();
				}

			} catch (JSONException e) {
				e.printStackTrace();
				// pd.dismiss();
				Toast toast = Toast.makeText(getApplicationContext(),
						"Search results missing", Toast.LENGTH_LONG);
				toast.setGravity(Gravity.TOP, 0, 0);
				toast.show();
				Header.setVisibility(View.VISIBLE);
				linearsearch.setVisibility(View.GONE);
			} catch (Exception e) {
				e.printStackTrace();
				Toast toast = Toast.makeText(getApplicationContext(),
						"No Search results", Toast.LENGTH_LONG);
				toast.setGravity(Gravity.TOP, 0, 0);
				toast.show();
			}

		}
	}

	@SuppressWarnings("rawtypes")
	public class profileAdapter extends ArrayAdapter {
		Context context;
		ArrayList<SearchByNameText> listProfiles = null;
		int rowid;

		@SuppressWarnings("unchecked")
		public profileAdapter(Context context, int textViewResourceId,
				ArrayList<SearchByNameText> listProfiles) {
			super(context, textViewResourceId, listProfiles);
			this.context = context;
			this.listProfiles = listProfiles;

		}

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {
			LayoutInflater inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			View rowView = inflater.inflate(R.layout.list_rowf, parent, false);
			TextView tv_fname = (TextView) rowView.findViewById(R.id.tv_Name);
			final ImageView Imgvw = (ImageView) rowView
					.findViewById(R.id.profile_image);
			tv_fname.setText(listProfiles.get(position).getFname());

			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str = null;

			if (listProfiles.get(position).getResult_Type()
					.equalsIgnoreCase("user"))
				str = fs.ProfileImagesLink();
			else
				str = fs.TileImagesLink();

			String path = str + listProfiles.get(position).getImgUrl();
			if (Constants.LOG)
				Log.i(TAG, "path is :" + path);
			imageLoader.DisplayImage(path, Imgvw, false, true);

			userid = listProfiles.get(position).getUserid();

			return rowView;
		}

	}

	public void searchTextByTile(View v) {

		btnval = 2;
		lv_profiles.setAdapter(null);
		setbuttons();
		edt_search.setText("");

	}

	public void setbuttons() {

	}

	public static void hideSoftKeyboard(Activity activity) {
		InputMethodManager inputMethodManager = (InputMethodManager) activity
				.getSystemService(Activity.INPUT_METHOD_SERVICE);
		inputMethodManager.hideSoftInputFromWindow(activity.getCurrentFocus()
				.getWindowToken(), 0);
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

							public void onClick(DialogInterface dlg, int which) {
								System.exit(0);
							}
						})
				.setNegativeButton("No", new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dlg, int which) {
					}
				}).show();

	}
}
