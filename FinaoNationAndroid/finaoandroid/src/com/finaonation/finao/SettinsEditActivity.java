package com.finaonation.finao;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout.LayoutParams;
import android.widget.PopupWindow;
import android.widget.TextView;

import com.finaonation.addfinao.JsonHelper;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.utils.Constants;
import com.finaonation.utils.ImageLoader;
import com.finaonation.webservices.FinaoServiceLinks;

public class SettinsEditActivity extends Activity implements OnClickListener {
	public static final String TAG = "SettinsEditActivity";
	TextView Username;
	TextView Finaostory;
	String _FName_SPS_Str, _LName_SPS_Str, _MyStory_SPS_Str,
			_Finao_Profile_Pic_Str, Profile_Pic_path, headerToken;
	SharedPreferences Finao_Preferences;
	ImageLoader imageLoader;
	ImageView Profile_Pic_IV, Banner_Pic_IV;
	EditText Uname_ET;
	String p_name = "", b_path = "";
	private PopupWindow pw;
	private FinaoServiceLinks fs;
	private SharedPreferences.Editor Finao_Preference_Editor;
	private String mediaFilePath = "", Banner_pic_path, Bannerimg;
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 5;
	private static final int GALLERY_REQUEST = 6;
	private static final int FinaostoryEditor_Request = 7;
	private static final int REQUEST_CODE_CROP_IMAGE = 35;
	int image_type;

	@SuppressWarnings("deprecation")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_settins_edit);
		imageLoader = new ImageLoader(this);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		_FName_SPS_Str = Finao_Preferences.getString("FName", "");
		_LName_SPS_Str = Finao_Preferences.getString("LName", "");
		_MyStory_SPS_Str = Finao_Preferences.getString("MyStory", "");
		_Finao_Profile_Pic_Str = Finao_Preferences.getString("Profile_Image",
				"");
		Bannerimg = Finao_Preferences.getString("Profile_BG_Image", "");
		headerToken = Finao_Preferences.getString("logtoken", "");

		fs = new FinaoServiceLinks();
		String str = fs.ProfileImagesLink();
		Profile_Pic_path = str + _Finao_Profile_Pic_Str;
		Username = (TextView) findViewById(R.id.Uname_TV);
		Finaostory = (TextView) findViewById(R.id.Finaostory_TV);
		Profile_Pic_IV = (ImageView) findViewById(R.id.profilepic);
		Uname_ET = (EditText) findViewById(R.id.Uname_ET);
		Banner_Pic_IV = (ImageView) findViewById(R.id.bannerpic);

		Banner_pic_path = fs.bannerImagesLink() + Bannerimg;

		imageLoader.DisplayImage(Banner_pic_path, Banner_Pic_IV, true, true);

		Uname_ET.setText(_FName_SPS_Str + " " + _LName_SPS_Str);
		Username.setText(_FName_SPS_Str + " " + _LName_SPS_Str);
		Finaostory.setText(_MyStory_SPS_Str);
		imageLoader.DisplayImage(Profile_Pic_path, Profile_Pic_IV, true, true);
		Username.setOnClickListener(this);
		Profile_Pic_IV.setOnClickListener(this);
		Finaostory.setOnClickListener(this);
		Banner_Pic_IV.setOnClickListener(this);
	}

	public void Done_click(View v) {
		String url = fs.baseurl();
		MultipartEntity entity = null;
		try {
			entity = new MultipartEntity();
			entity.addPart("json", new StringBody("updateprofile"));
			entity.addPart("name",
					new StringBody(Uname_ET.getText().toString()));
			entity.addPart("bio", new StringBody(Finaostory.getText()
					.toString()));
			if (p_name != null && p_name != "") {
				entity.addPart("profile_image", new FileBody(new File(p_name)));
				Log.i("ppath", "path == " + p_name);
			}
			if (b_path != null && b_path != "") {
				entity.addPart("profile_bg_image", new FileBody(
						new File(b_path)));
				Log.i("bpath", "path == " + b_path);
			}
			JsonHelper json = new JsonHelper();
			JSONObject data = json.getJSONfromURL(url, headerToken, entity);
			if (data.getString("IsSuccess").equalsIgnoreCase("true")) {
				MultipartEntity newEntity = null;
				newEntity = new MultipartEntity();
				newEntity.addPart("json", new StringBody("user_details"));
				JSONObject newdata = json.getJSONfromURL(url, headerToken,
						newEntity);
				if (newdata.getString("IsSuccess").equalsIgnoreCase("true")) {

					Finao_Preference_Editor = Finao_Preferences.edit();
					Finao_Preference_Editor.putString("MyStory", Finaostory
							.getText().toString());
					Finao_Preference_Editor.putString("LName",
							newdata.getJSONArray("item").getJSONObject(0)
									.getString("lname"));
					Finao_Preference_Editor.putString("FName",
							newdata.getJSONArray("item").getJSONObject(0)
									.getString("fname"));
					if (p_name != null && p_name != "")
						Finao_Preference_Editor.putString("Profile_Image",
								newdata.getJSONArray("item").getJSONObject(0)
										.getString("profile_image"));
					if (b_path != null && b_path != "")
						Finao_Preference_Editor.putString("Profile_BG_Image",
								newdata.getJSONArray("item").getJSONObject(0)
										.getString("banner_image"));
					Finao_Preference_Editor.commit();
					finish();
				} else {
					Log.i(TAG, "didn't get profile details.");
				}

			}
		} catch (Exception e) {
			Log.e(TAG, e.toString());
			e.printStackTrace();
		}
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.Uname_TV:
			Uname_ET.setVisibility(View.VISIBLE);
			Uname_ET.setFocusable(true);
			Uname_ET.setText(_FName_SPS_Str + " " + _LName_SPS_Str);
			Username.setVisibility(View.GONE);
			break;
		case R.id.profilepic:
			ShowPopUp();
			image_type = 1;
			break;
		case R.id.bannerpic:
			ShowPopUp();
			image_type = 2;
			break;
		case R.id.Finaostory_TV:
			Intent intentforCam = new Intent(SettinsEditActivity.this,
					SettingsFinaoEditor.class);
			intentforCam.putExtra("msg", Finaostory.getText().toString());
			startActivityForResult(intentforCam, FinaostoryEditor_Request);

			break;
		default:
			break;
		}
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
		mediaFilePath = evidenceFilesStoragePath + "/_" + timestamp + ".png";
		Uri fileUri = Uri.fromFile(new File(mediaFilePath));
		Intent intentforCam = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		intentforCam.putExtra(MediaStore.EXTRA_OUTPUT, fileUri);
		startActivityForResult(intentforCam, TAKE_PHOTO_CAMERA_REQUEST);
	}

	public void clickGallery(View view) {
		pw.dismiss();

		Intent i = new Intent(Intent.ACTION_PICK,
				android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
		i.setType("image/*");
		startActivityForResult(i, GALLERY_REQUEST);
	}

	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == TAKE_PHOTO_CAMERA_REQUEST) {
			switch (resultCode) {
			case RESULT_OK:
				if (Constants.LOG)
					Log.d("camer click for profile img", "image_type --"
							+ image_type);
				if (image_type == 1) {
					// Profile_Pic_IV.setImageURI(selectedImage);
					startCropImage(mediaFilePath);
					p_name = mediaFilePath;
				} else {
					File f = new File(mediaFilePath);
					b_path = mediaFilePath;
					Banner_Pic_IV.setImageBitmap(decodeFile(f, 200, 200));
				}
				break;
			case RESULT_CANCELED:
				break;

			}

		} else if (requestCode == GALLERY_REQUEST) {
			if (Constants.LOG)
				Log.v("RequestCode", "" + requestCode);
			if (requestCode == GALLERY_REQUEST && resultCode == RESULT_OK
					&& null != data) {
				Uri selectedImage = data.getData();
				String[] filePathColumn = { MediaStore.Images.Media.DATA };

				Cursor cursor = getContentResolver().query(selectedImage,
						filePathColumn, null, null, null);
				cursor.moveToFirst();

				int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
				mediaFilePath = cursor.getString(columnIndex);
				cursor.close();
				Log.d("camer click for profile img", "image_type --"
						+ image_type);
				if (image_type == 1) {
					startCropImage(mediaFilePath);
					p_name = mediaFilePath;
				} else {
					File f = new File(mediaFilePath);
					b_path = mediaFilePath;
					Banner_Pic_IV.setImageBitmap(decodeFile(f, 200, 200));
				}
			}
		} else if (requestCode == FinaostoryEditor_Request) {
			if (requestCode == FinaostoryEditor_Request
					&& resultCode == RESULT_OK && null != data) {
				Finaostory.setText(data.getExtras().get("result").toString());

			}
		} else if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:

				File f = new File(mediaFilePath);
				Profile_Pic_IV.setImageBitmap(decodeFile(f, 200, 200));
				break;
			case RESULT_CANCELED:
				break;
			}
		}
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

	private void startCropImage(String imagePath) {
		Intent intent = new Intent(SettinsEditActivity.this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);
		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);
		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

}
