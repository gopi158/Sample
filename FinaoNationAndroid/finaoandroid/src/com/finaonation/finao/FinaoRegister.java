package com.finaonation.finao;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.UnsupportedEncodingException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
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
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout.LayoutParams;
import android.widget.PopupWindow;
import android.widget.Toast;

import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.internet.InternetChecker;
import com.finaonation.jsonhelper.JsonHelperRegister;
import com.finaonation.utils.Base64;
import com.finaonation.utils.Constants;
import com.finaonation.utils.EMailValidator;

public class FinaoRegister extends Activity {
	private EditText FName_ET, LName_ET, Email_ET, Password_ET, confirmPwd;
	private ImageView profile_IM;
	private PopupWindow pw;
	private static final int REQUEST_CODE_CROP_IMAGE = 33;
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 4;
	private static final int GALLERY_REQUEST = 3;
	protected static final String TAG = "FinaoRegister";
	private String mediaFilePath = "";
	String headerToken;
	SharedPreferences Finao_Preferences;
	private SharedPreferences Finao_Pref;
	private SharedPreferences.Editor Finao_Preference_Editor;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_finaoregister);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		Finao_Pref = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		Finao_Preference_Editor = Finao_Pref.edit();

		FName_ET = (EditText) findViewById(R.id.signupfnameetid);
		LName_ET = (EditText) findViewById(R.id.signuplnameetid);
		Email_ET = (EditText) findViewById(R.id.signupemailetid);
		Password_ET = (EditText) findViewById(R.id.signuppasswordetid);
		confirmPwd = (EditText) findViewById(R.id.confirmpassword);
		profile_IM = (ImageView) findViewById(R.id.register_profile_img);
	}

	/* Registration click */
	@SuppressWarnings("deprecation")
	public void Register_click(View v) {
		if (FName_ET.getText().length() == 0) {
			Toast.makeText(getApplicationContext(), "Please Enter First Name",
					Toast.LENGTH_SHORT).show();
			FName_ET.requestFocus();
		} else if (LName_ET.getText().length() == 0) {
			Toast.makeText(getApplicationContext(), "Please Enter Last Name",
					Toast.LENGTH_SHORT).show();
			LName_ET.requestFocus();
		} else if (EMailValidator.isEmailValid(Email_ET.getText().toString()) == false) {
			Toast.makeText(getApplicationContext(),
					"Please Enter Correct Emailid", Toast.LENGTH_SHORT).show();
			Email_ET.requestFocus();
		} else if (Password_ET.getText().length() == 0) {
			Toast.makeText(getApplicationContext(), "Please Enter Password",
					Toast.LENGTH_SHORT).show();
			Password_ET.requestFocus();
		} else if (!confirmPwd.getText().toString()
				.equalsIgnoreCase(Password_ET.getText().toString())) {
			Toast.makeText(getApplicationContext(),
					"Please ReEnter the Correct Password ", Toast.LENGTH_SHORT)
					.show();
			Password_ET.requestFocus();
		} else {
			InternetChecker ic = new InternetChecker();
			boolean b = ic.IsNetworkAvailable(getApplicationContext());

			if (b == true) {
				if (Constants.LOG)
					Log.i(TAG,
							"profile img file after registeration click is :"
									+ mediaFilePath);

				new UserRegistrationTask().execute();
			} else {
				AlertDialog alertDialog = new AlertDialog.Builder(
						FinaoRegister.this).create();
				alertDialog.setTitle("FinaoNation");
				alertDialog
						.setMessage("Network Failed - Please Check Your Internet Connection");
				alertDialog.setIcon(R.drawable.tick);
				alertDialog.setButton("OK",
						new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {

							}
						});
				alertDialog.show();
			}
		}

	}

	private class UserRegistrationTask extends AsyncTask<String, Void, String> {
		ProgressDialog pDialog = new ProgressDialog(FinaoRegister.this);
		String Status_type;

		protected void onPreExecute() {
			pDialog.setMessage("Registration Under Process Please Wait...");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		@Override
		protected String doInBackground(String... arg0) {
			JsonHelperRegister jh = new JsonHelperRegister(headerToken);
			if (Constants.LOG)
				Log.i(TAG, "json is :" + mediaFilePath);
			String json = jh.getJSONfromURL("" + 1, FName_ET.getText()
					.toString(), LName_ET.getText().toString(), Email_ET
					.getText().toString(), Password_ET.getText().toString(),
					mediaFilePath);
			if (Constants.LOG)
				Log.i(TAG, "json is :" + json);

			String status = "";
			JSONObject jb;
			try {
				jb = new JSONObject(json);
				Status_type = jb.getString("message");
				if ("false" == jb.getString("IsSuccess")) {
					Log.i(TAG, "ZZZ Failed = " + " Response: " + json);
					status = "fail";
				} else {
					if (jb.getBoolean("IsSuccess")) {

						storedata(jb.getJSONObject("item"));
						status = "Success";
					} else {
						status = "fail";
					}
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}
			return status;
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();
			if (result.equalsIgnoreCase("Success")) {
				String text = Email_ET.getText().toString() + ":"
						+ Password_ET.getText();
				byte[] data = null;
				try {
					data = text.getBytes("UTF-8");
				} catch (UnsupportedEncodingException e) {
					e.printStackTrace();
				}
				if (Constants.LOG)
					Log.i("PXR", "response : " + Base64.encodeBytes(data));
				String header = Base64.encodeBytes(data);
				Finao_Preference_Editor.putString("headertext", header);
				Finao_Preference_Editor.commit();

				if (Status_type.equalsIgnoreCase("User succesfully logged in")
						|| Status_type
								.equalsIgnoreCase("Both the accounts are mapped")) {
					Finao_Preference_Editor = Finao_Pref.edit();
					Finao_Preference_Editor.putBoolean("share", false);
					Finao_Preference_Editor.putString("Login_Session", "True");
					Finao_Preference_Editor.commit();

					Intent loginintent = new Intent(getApplicationContext(),
							FinaoFooterTab.class);
					startActivity(loginintent);
					finish();
				} else if (Status_type
						.equalsIgnoreCase("User succesfully registered")) {
					Finao_Preference_Editor = Finao_Pref.edit();
					Finao_Preference_Editor.putBoolean("share", true);
					Finao_Preference_Editor.putString("Login_Session", "True");
					Finao_Preference_Editor.commit();

					Toast.makeText(getApplicationContext(), "User succesfully registered.",
							Toast.LENGTH_SHORT).show();
					finish();
				}
			} else {
				Toast.makeText(getApplicationContext(), Status_type,
						Toast.LENGTH_SHORT).show();
				Intent loginintent = new Intent(getApplicationContext(),
						FinaoLoginOrRegister.class);
				loginintent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(loginintent);

				finish();
			}

		}
	}

	public void storedata(JSONObject items) {
		try {
			Finao_Preference_Editor.putString("User_ID",
					items.getString("userid"));
			Finao_Preference_Editor.putString("Profile_Image",
					items.getString("profile_image"));
			Finao_Preference_Editor
					.putString("FName", items.getString("fname"));
			Finao_Preference_Editor
					.putString("LName", items.getString("lname"));
			Finao_Preference_Editor.putString("Profile_BG_Image",
					items.getString("profile_bg_image"));
			String Story = items.getString("mystory");
			if (Story.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("MyStory", "");
			} else {
				Finao_Preference_Editor.putString("MyStory", Story);
			}
			Finao_Preference_Editor.commit();

		} catch (JSONException e) {
			e.printStackTrace();
		}

	}

	/* Image pick up click */
	public void Image_click(View v) {
		ShowPopUp();
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
		startActivityForResult(i, GALLERY_REQUEST);
	}

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
				break;
			}

		} else if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:

				File f = new File(mediaFilePath);
				profile_IM.setImageBitmap(decodeFile(f, 200, 200));
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
				if (Constants.LOG)
					Log.i(TAG, "media file path in gallary :" + mediaFilePath);

				startCropImage(mediaFilePath);

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
		Intent intent = new Intent(FinaoRegister.this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);
		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);
		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

}
