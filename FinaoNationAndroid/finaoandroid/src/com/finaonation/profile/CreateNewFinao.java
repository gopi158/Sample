package com.finaonation.profile;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONArray;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.LinearLayout.LayoutParams;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.beanclasses.GetTiles;
import com.finaonation.finao.R;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.utils.Constants;
import com.finaonation.utils.FinaoCustomProgress;
import com.finaonation.utils.ImageLoader;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class CreateNewFinao extends Activity {
	private ArrayList<String> uriArray = null;
	GridView Tiles_GridView;
	Activity mActivity = null;
	ArrayList<GetTiles> Tiles_List_Data = new ArrayList<GetTiles>();
	String _UserID_SPS_Str, _FinaoCount_SPS_Str;
	EditText Finao_Text;
	ImageView Finao_Img_Preview;
	TextView Private_ChkBox;
	private PopupWindow pw;
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 10;
	private static final int REQUEST_CODE_CROP_IMAGE = 38;
	private static final int TAKE_PHOTO_FROM_GALLERY = 8;
	protected static final String TAG = "CreateNewFinao";
	private String mediaFilePath = "";
	private Bitmap imageTaken;
	String headerToken;
	SharedPreferences Finao_Preferences;
	private SharedPreferences.Editor Finao_Preference_Editor;
	String Caption;
	public ImageLoader imageLoader;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		setContentView(R.layout.createfinao);
		mActivity = this;
		@SuppressWarnings("deprecation")
		final SharedPreferences Finao_Preferences = getSharedPreferences(
				"Finao_Preferences", MODE_WORLD_READABLE);
		_UserID_SPS_Str = Finao_Preferences.getString("User_ID", "");
		_FinaoCount_SPS_Str = Finao_Preferences.getString("TotalFinaos", "");
		gettingIDs();
		uriArray = new ArrayList<String>();
		new GetTilesAssyncTask(headerToken).execute();

		Finao_Img_Preview = (ImageView) findViewById(R.id.finpreviewivid);

		Finao_Img_Preview.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				InputMethodManager imm = (InputMethodManager) CreateNewFinao.this
						.getSystemService(Context.INPUT_METHOD_SERVICE);

				if (imm.isAcceptingText()) {
					InputMethodManager inputMethodManager = (InputMethodManager) CreateNewFinao.this
							.getSystemService(Activity.INPUT_METHOD_SERVICE);
					inputMethodManager.hideSoftInputFromWindow(
							CreateNewFinao.this.getCurrentFocus()
									.getWindowToken(), 0);
				}
				ShowPopUp();
			}
		});
		Private_ChkBox.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				if (Private_ChkBox.getText().toString()
						.equalsIgnoreCase("Public")) {
					Private_ChkBox.setText("Private");
				} else {
					Private_ChkBox.setText("Public");
				}

			}
		});

		Tiles_GridView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> av, View v, int position,
					long arg3) {
				if (Finao_Text.getText().length() == 0) {
					Toast.makeText(mActivity, "Please Enter Finao",
							Toast.LENGTH_SHORT).show();
				} else {

					int private_key;
					if (Private_ChkBox.getText().toString()
							.equalsIgnoreCase("Private")) {
						private_key = 0;
					} else {
						private_key = 1;
					}
					GetTiles fp = Tiles_List_Data.get(position);
					String Finao_Name = Finao_Text.getText().toString().trim();
					String Finao_Tile_ID = fp.getTile_Id();
					String Finao_Tile_Name = fp.getTile_Name();
					String Finao_UpdatedBy = fp.getUpdateBy();
					MultipartEntity reqEntity = null;
					try {
						reqEntity = new MultipartEntity();
						reqEntity
								.addPart("json", new StringBody("createfinao"));
						reqEntity.addPart("caption", new StringBody(""));
						reqEntity.addPart("tile_id", new StringBody(
								Finao_Tile_ID));
						reqEntity.addPart("tile_name", new StringBody(
								Finao_Tile_Name));
						reqEntity.addPart("finao_msg", new StringBody(
								Finao_Name));
						reqEntity.addPart("finao_status_ispublic",
								new StringBody("" + private_key));
						// FileBody filebodyFinao = new FileBody(new
						// File(mediaFilePath));
						// reqEntity.addPart("image", filebodyFinao);
					} catch (Exception e) {
						e.printStackTrace(); 
					}
					FinaoServiceLinks fs = new FinaoServiceLinks();
					new CreateFinaoAssync(fs.baseurl(), headerToken, reqEntity)
							.execute();
				}
			}
		});

	}

	public void backClicked(View view){
		finish();
	}
	
	private void ShowPopUp() {
		LayoutInflater inflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View popuplayout = inflater.inflate(R.layout.popup_layout,
				(ViewGroup) findViewById(R.id.popup_menu_root));
		pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
				LayoutParams.MATCH_PARENT, true);
		pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);
	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();
		}
	}

	public void clickCamera(View view) {
		pw.dismiss();
		SimpleDateFormat sdf = new SimpleDateFormat("MM_dd_yyyy_hh_mm_ss_a");
		String timestamp = sdf.format(new Date()).toString();
		File evidenceFilesStoragePath = new File(
				Environment.getExternalStorageDirectory() + "/Finao");
		if (!evidenceFilesStoragePath.exists())
			evidenceFilesStoragePath.mkdir();
		mediaFilePath = evidenceFilesStoragePath + "/" + timestamp + ".png";
		Uri fileUri = Uri.fromFile(new File(mediaFilePath));
		if (Constants.LOG)
			Log.i(TAG, "media file path is :" + mediaFilePath);
		Intent intentforCam = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		intentforCam.putExtra(MediaStore.EXTRA_OUTPUT, fileUri);
		startActivityForResult(intentforCam, TAKE_PHOTO_CAMERA_REQUEST);
	}

	public void clickGallery(View view) {
		pw.dismiss();
		Intent i = new Intent(Intent.ACTION_PICK,
				android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
		i.setType("image/*");
		startActivityForResult(i, TAKE_PHOTO_FROM_GALLERY);

	}

	private void gettingIDs() {
		Tiles_GridView = (GridView) findViewById(R.id.createfinaogridviewid);
		Finao_Text = (EditText) findViewById(R.id.finaotextedid);
		Private_ChkBox = (TextView) findViewById(R.id.privatechid);
	}

	private class GetTilesAssyncTask extends AsyncTask<Void, Void, Integer> {

		ProgressDialog pDialog = new ProgressDialog(mActivity);
		GettingTiles gt = new GettingTiles();
		ArrayList<GetTiles> List1 = new ArrayList<GetTiles>();
		ArrayList<GetTiles> List2 = new ArrayList<GetTiles>();
		String thisHeader;

		public GetTilesAssyncTask(String headerToken) {
			thisHeader = headerToken;
		}

		protected void onPreExecute() {
			super.onPreExecute();
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(mActivity, "FINAO Nation",
					"Loading Tiles", true, true);
		}

		protected Integer doInBackground(Void... params) {
			List1 = gt.GetTilesList(_UserID_SPS_Str, "finao", thisHeader);
			Tiles_List_Data.addAll(List1);
			return 0;
		}

		protected void onPostExecute(Integer result) {

			pDialog.dismiss();

			int no = Tiles_List_Data.size();
			if (no != 0) {
				Tiles_GridView.setAdapter(new TilesGridAdapter(mActivity,
						Tiles_List_Data));
			} else {
				Tiles_GridView.setAdapter(null);
				Toast.makeText(getApplicationContext(), "No Tiles",
						Toast.LENGTH_SHORT).show();
			}

		}
	}

	class TilesGridAdapter extends BaseAdapter {

		Context con;
		ArrayList<GetTiles> tlist;
		ViewHolder holder = null;

		public TilesGridAdapter(Activity conte,
				ArrayList<GetTiles> tiles_List_Data) {
			this.con = conte;
			this.tlist = tiles_List_Data;
			imageLoader = new ImageLoader(conte);
		}

		@Override
		public int getCount() {
			return tlist.size();
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
				convertView = li.inflate(R.layout.gridrow, null);
				holder = new ViewHolder();
				holder.Grid_Img_IV = (ImageView) convertView
						.findViewById(R.id.gridimgivid);
				holder.Grid_TV = (TextView) convertView
						.findViewById(R.id.gridtexttvid);
				convertView.setTag(holder);
			} else {
				holder = (ViewHolder) convertView.getTag();
			}

			GetTiles gt = tlist.get(position);
			String ImgPath = gt.getTile_Image();
			FinaoServiceLinks fs = new FinaoServiceLinks();
			String str = fs.TileImagesLink();
			String Img_Final_Path = str + ImgPath;
			if (Constants.LOG)
				Log.i(TAG, "image url is :" + Img_Final_Path);
			holder.Grid_TV.setText(gt.getTile_Name());
			imageLoader.DisplayImage(Img_Final_Path, holder.Grid_Img_IV, false, true);

			return convertView;
		}

	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == TAKE_PHOTO_CAMERA_REQUEST) {
			switch (resultCode) {
			case RESULT_OK:

				if (Constants.LOG)
					Log.i(TAG, "TAKE_PHOTO_CAMERA_REQUEST media file path is :"
							+ mediaFilePath);
				startCropImage(mediaFilePath);

				break;
			case RESULT_CANCELED:
				imageTaken = null;

			}

		} else if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:

				File f = new File(mediaFilePath);
				Finao_Img_Preview.setImageBitmap(decodeFile(f, 200, 200));
				break;
			case RESULT_CANCELED:
				// imageTaken = null;
				break;
			}
		} else if (requestCode == TAKE_PHOTO_FROM_GALLERY) {
			if (Constants.LOG)
				Log.v("RequestCode", "" + requestCode);
			if (requestCode == TAKE_PHOTO_FROM_GALLERY
					&& resultCode == RESULT_OK && null != data) {
				Uri selectedImage = data.getData();
				String[] filePathColumn = { MediaStore.Images.Media.DATA };

				Cursor cursor = getContentResolver().query(selectedImage,
						filePathColumn, null, null, null);
				cursor.moveToFirst();
				int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
				mediaFilePath = cursor.getString(columnIndex);
				cursor.close();
				if (Constants.LOG)
					Log.i(TAG, "media file path in gallary :" + mediaFilePath);

				startCropImage(mediaFilePath);

			}
		}
		/*
		 * if (requestCode == TAKE_PHOTO_CAMERA_REQUEST) { switch (resultCode) {
		 * case RESULT_OK: imageTaken = (Bitmap) data.getExtras().get("data");
		 * FileOutputStream out = null; try {
		 * 
		 * out = new FileOutputStream(mediaFilePath);
		 * imageTaken.compress(Bitmap.CompressFormat.PNG, 100, out);
		 * Finao_Img_Preview.setImageBitmap(imageTaken); } catch
		 * (FileNotFoundException e) { e.printStackTrace(); }
		 * 
		 * break; case RESULT_CANCELED: imageTaken = null; }
		 * 
		 * }else if (requestCode == TAKE_PHOTO_FROM_GALLERY) { if(Constants.LOG)
		 * Log.v("RequestCode", "" + requestCode); switch (resultCode) { case
		 * RESULT_OK: ArrayList<String> list =
		 * data.getStringArrayListExtra("result");
		 * 
		 * if (list != null) { uriArray.add(list.get(0)); if(Constants.LOG)
		 * Log.i(TAG, "uriArray"+list.get(0)); }
		 * 
		 * mediaFilePath = uriArray.get(0).toString(); if(Constants.LOG)
		 * Log.i(TAG, "mediaFilePath:"+mediaFilePath); File f = new
		 * File(uriArray.get(0)); Bitmap thumb = decodeFile(f,250,250);
		 * Finao_Img_Preview.setImageBitmap(thumb);
		 * 
		 * break; case RESULT_CANCELED: imageTaken = null; break; } }
		 */
	}

	private void startCropImage(String imagePath) {
		Intent intent = new Intent(CreateNewFinao.this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);
		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);
		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

	public static Bitmap decodeFile(File f, int WIDTH, int HIGHT) {
		try {
			// Decode image size
			BitmapFactory.Options o = new BitmapFactory.Options();
			o.inJustDecodeBounds = true;
			BitmapFactory.decodeStream(new FileInputStream(f), null, o);
			// The new size we want to scale to
			final int REQUIRED_WIDTH = WIDTH;
			final int REQUIRED_HIGHT = HIGHT;
			// Find the correct scale value. It should be the power of 2.
			int scale = 1;
			while (o.outWidth / scale / 2 >= REQUIRED_WIDTH
					&& o.outHeight / scale / 2 >= REQUIRED_HIGHT)
				scale *= 2;
			// Decode with inSampleSize
			BitmapFactory.Options o2 = new BitmapFactory.Options();
			o2.inSampleSize = scale;
			return BitmapFactory.decodeStream(new FileInputStream(f), null, o2);
		} catch (FileNotFoundException e) {
		}
		return null;
	}

	private class ImageUploadAssyn extends AsyncTask<String, Void, String> {

		int finao_no;
		ProgressDialog pDialog = new ProgressDialog(CreateNewFinao.this);
		String resstring;
		String caption_str;
		JSONArray capp;
		String thisHeaderToken;

		public ImageUploadAssyn(int fin_no, String cap, String headerToken) {
			this.finao_no = fin_no;
			this.caption_str = cap;
			thisHeaderToken = headerToken;
		}

		protected void onPreExecute() {
			pDialog.setMessage("Uploading Image Please Wait");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
			capp = new JSONArray();
			capp.put(caption_str);
		}

		protected String doInBackground(String... params) {

			FinaoServiceLinks fs = new FinaoServiceLinks();
			String link = fs.baseurl();
			String urll = link;
			if (Constants.LOG)
				Log.v(TAG, " image upload urll is " + urll);
			urll = urll.replaceAll(" ", "%20");
			if (Constants.LOG)
				Log.i(TAG, "image upload after replace is urll is " + urll);
			try {
				HttpClient httpclient = SingleTon.getInstance().getHttpClient();
				HttpPost httppost = new HttpPost(urll);
				MultipartEntity reqEntity = new MultipartEntity();
				reqEntity.addPart("json", new StringBody("uploadimagesfinao"));
				reqEntity.addPart("finaoid", new StringBody("" + finao_no));
				reqEntity.addPart("upload_text", new StringBody(""));
				reqEntity.addPart("type", new StringBody("1"));
				reqEntity.addPart("captiondata",
						new StringBody(capp.toString()));
				FileBody filebodyFinao = new FileBody(new File(mediaFilePath));
				reqEntity.addPart("image1", filebodyFinao);
				httppost.setEntity(reqEntity);
				httppost.setHeader("Authorization", "Basic " + thisHeaderToken);
				httppost.setHeader("Finao-Token", thisHeaderToken);
				HttpResponse response = httpclient.execute(httppost);
				String res = Util.convertResponseToString(response);
				if (Constants.LOG)
					Log.i(" image upload", "res is " + res);
				if (Constants.LOG)
					Log.d("after response ", "" + res);
				if (response != null) {
					JSONObject jb = new JSONObject(res);
					String message = jb.getString("message");
					return message;
				}

			} catch (Exception e) {
				e.printStackTrace();

			}

			return null;
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();
			if (result != null)
				Toast.makeText(mActivity, result, Toast.LENGTH_SHORT).show();
			mActivity.finish();
		}
	}

	private class CreateFinaoAssync extends AsyncTask<String, Void, String> {

		ProgressDialog pDialog = new ProgressDialog(CreateNewFinao.this);
		String URL;
		JSONObject json;
		String thisHeaderToken;
		MultipartEntity inputs;

		public CreateFinaoAssync(String url_str, String headerToken,
				MultipartEntity entity) {
			this.URL = url_str;
			thisHeaderToken = headerToken;
			inputs = entity;
		}

		@Override
		protected String doInBackground(String... params) {
			JsonHelper jh = new JsonHelper();
			json = jh.getJSONfromURL(URL, thisHeaderToken, inputs);
			return null;

		}

		@Override
		protected void onPreExecute() {
			pDialog.setMessage("Creating FINAO Please Wait...");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		@Override
		protected void onPostExecute(String result) {
			super.onPostExecute(result);
			pDialog.dismiss();
			try {
				int no = 0;
				if (json.getJSONObject("item") != null) {
					JSONObject obj = json.getJSONObject("item");
					String response = obj.getString("finao_id");
					no = Integer.parseInt(response);
				}

				if (no != 0) {
					Toast.makeText(getApplicationContext(),
							"Finao Created Successfully", Toast.LENGTH_SHORT)
							.show();
					int count = Integer.parseInt(_FinaoCount_SPS_Str);
					int Notifications_Count_inte = count + 1;

					@SuppressWarnings("deprecation")
					SharedPreferences Finao_Preferences = getSharedPreferences(
							"Finao_Preferences", MODE_WORLD_READABLE);
					SharedPreferences.Editor Finao_Preference_Editor = Finao_Preferences
							.edit();
					Finao_Preference_Editor.putString("TotalFinaos", ""
							+ Notifications_Count_inte);
					Finao_Preference_Editor.commit();

					/*
					 * if (Finao_Img_Preview.getDrawable() != null) { new
					 * ImageUploadAssyn(no, Caption, thisHeaderToken)
					 * .execute(); } else {
					 */
					mActivity.finish();
					// }
				} else {
					Toast.makeText(getApplicationContext(),
							"Finao couldn't be created.", Toast.LENGTH_SHORT).show();
				}
			} catch (Exception e) {
				Log.e(TAG, e.toString());
			}
		}
	}

}
