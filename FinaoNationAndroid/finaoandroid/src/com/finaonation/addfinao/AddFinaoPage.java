package com.finaonation.addfinao;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.AssetFileDescriptor;
import android.content.res.Configuration;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ThumbnailUtils;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.util.SparseBooleanArray;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.LinearLayout.LayoutParams;
import android.widget.PopupWindow;
import android.widget.Toast;

import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.finao.FinaoLoginOrRegister;
import com.finaonation.finao.R;
import com.finaonation.finao.SettingActivity;
import com.finaonation.finao.Cropping.CropImage;
import com.finaonation.utils.Constants;
import com.finaonation.utils.SingleTon;
import com.finaonation.utils.Util;
import com.finaonation.webservices.FinaoServiceLinks;

@SuppressWarnings("unused")
public class AddFinaoPage extends Activity {

	private LayoutInflater inflater;
	private PopupWindow pw;
	private View popupView;
	EditText text_ED;
	private String headerToken;
	private ArrayList<String> uriArray = null;
	SparseBooleanArray mSparseBooleanArray;
	private ProgressDialog pDialog;
	private static final int TAKE_PHOTO_CAMERA_REQUEST = 1009;
	private static final int TAKE_PHOTO_FROM_GALLERY = 9;
	private static final int TAKE_Video_FROM_GALLERY = 11;
	private static final int TAKE_VIDEO_CAMERA_REQUEST = 19;
	private static final int REQUEST_CODE_CROP_IMAGE = 39;
	public static final String TEMP_PHOTO_FILE_NAME = "temp_photo.jpg";
	protected static final String TAG = "AddFinaoPage";
	private String mediaFilePath = "";
	private Bitmap imageTaken;
	String finaoId;
	private String dirString = "/finao_videos/";
	private String video_file_name = "";
	private File videofile;
	GridView listView;
	private SharedPreferences Finao_Preferences;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.addfinaopage);
		inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		popupView = inflater.inflate(R.layout.menu_layout, null, false);
		listView = (GridView) findViewById(R.id.gridview);
		text_ED = (EditText) findViewById(R.id.edittext);
		finaoId = getIntent().getExtras().getString("finaoid");
		uriArray = new ArrayList<String>();
		mSparseBooleanArray = new SparseBooleanArray();
		listView.setAdapter(mAdapter);

	}

	@SuppressWarnings("deprecation")
	@Override
	protected void onResume() {
		super.onResume();
		pDialog = new ProgressDialog(this);
		InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
		imm.toggleSoftInput(InputMethodManager.SHOW_FORCED, 0);
		Finao_Preferences = getSharedPreferences("Finao_Preferences",
				MODE_WORLD_READABLE);
		headerToken = Finao_Preferences.getString("logtoken", "");
		String Login_Key = Finao_Preferences.getString("Login_Session", "");

		if (Login_Key.length() == 0) {
			Intent i = new Intent(getApplicationContext(),
					FinaoLoginOrRegister.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(i);
			finish();
		}

	}

	public void Settingsclick(View v) {
		Intent in = new Intent(AddFinaoPage.this, SettingActivity.class);
		overridePendingTransition(R.anim.slide_in, R.anim.slide_out);
		startActivity(in);
	}

	public void hideSoftKeyboard() {
		if (getCurrentFocus() != null) {
			InputMethodManager inputMethodManager = (InputMethodManager) getSystemService(INPUT_METHOD_SERVICE);
			inputMethodManager.hideSoftInputFromWindow(getCurrentFocus()
					.getWindowToken(), 0);
		}
	}

	public void backClicked(View view) {
		finish();
	}

	public void showPopup(View view) {
		hideSoftKeyboard();
		if (uriArray.size() < 4 || !uriArray.get(0).contains(".mp4")) {
			LayoutInflater inflater = (LayoutInflater) this
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			View popuplayout = inflater.inflate(R.layout.popup_layout,
					(ViewGroup) findViewById(R.id.popup_menu_root));
			pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
					LayoutParams.MATCH_PARENT, true);
			pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);

		} else {
			showAlert(
					"Can select only 4 images, please remove existing images",
					"Alert");
		}

	}

	public void showcaptureVideo(View view) {
		hideSoftKeyboard();
		if (uriArray.size() < 1) {
			LayoutInflater inflater = (LayoutInflater) this
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			View popuplayout = inflater.inflate(R.layout.videpopup_layout,
					(ViewGroup) findViewById(R.id.popup_menu_root));
			pw = new PopupWindow(popuplayout, LayoutParams.MATCH_PARENT,
					LayoutParams.MATCH_PARENT, true);
			pw.showAtLocation(popuplayout, Gravity.BOTTOM, 0, 0);

		} else {
			showAlert(
					"Can select only 1 Video, please remove existing images",
					"Alert");
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

	public void clickvideoGallery(View view) {
		Intent intentforCam = new Intent(AddFinaoPage.this,
				MultiVideoSelectActivity.class);
		intentforCam.putExtra("size", uriArray.size());
		startActivityForResult(intentforCam, TAKE_Video_FROM_GALLERY);
		pw.dismiss();

	}

	public void captureVideo(View view) {
		pw.dismiss();
		if (uriArray.size() < 1) {
			SimpleDateFormat sdf = new SimpleDateFormat(
					"MMM_dd_yyyy_hh_mm_ss_a");
			String timestamp = sdf.format(new Date()).toString();
			dirString = Environment.getExternalStorageDirectory()
					.getAbsolutePath() + "/Finao";
			File subDir = new File(dirString);
			if (!subDir.exists()) {
				subDir.mkdir();
			}
			video_file_name = subDir.getAbsolutePath() + "/" + timestamp
					+ ".mp4";

			Uri videoUri = Uri.fromFile(new File(video_file_name));
			Intent intentforCam = new Intent(
					android.provider.MediaStore.ACTION_VIDEO_CAPTURE);
			intentforCam.putExtra(MediaStore.EXTRA_VIDEO_QUALITY, 1);
			startActivityForResult(intentforCam, TAKE_VIDEO_CAMERA_REQUEST);

		} else {
			showAlert(
					"Can select only 1 images, please remove existing images",
					"Alert");
		}

	}

	public void cancelPopup(View view) {
		if (pw != null) {
			pw.dismiss();

		}
	}

	public void postClicked(View view) {
		hideSoftKeyboard();
		if (text_ED.length() == 0) {
			Toast.makeText(getApplicationContext(),
					"Text is empty, please enter text", Toast.LENGTH_LONG)
					.show();
		} else if (uriArray.size() != 0 || text_ED.length() != 0) {
			new VideoFileUploadAssync(getIntent().getExtras().getString(
					"finaoid"), headerToken).execute();
		} else {
			Toast.makeText(getApplicationContext(),
					"Please Choose Image/Video", Toast.LENGTH_LONG).show();
		}
	}

	public void deleteImage(int pos) {
		uriArray.remove(pos);
		mAdapter.notifyDataSetChanged();

	}

	private BaseAdapter mAdapter = new BaseAdapter() {

		@Override
		public int getCount() {
			return uriArray.size();
		}

		@Override
		public Object getItem(int position) {
			return null;
		}

		@Override
		public long getItemId(int position) {
			return 0;
		}

		@SuppressLint("NewApi")
		@Override
		public View getView(int position, View convertView, ViewGroup parent) {

			View view = convertView;
			ViewHolder viewHolder = null;
			if (null == view) {
				viewHolder = new ViewHolder();
				view = LayoutInflater.from(parent.getContext()).inflate(
						R.layout.viewitem, null);
				viewHolder.image = (ImageView) view.findViewById(R.id.image);
				viewHolder.mCheckBox = (CheckBox) view
						.findViewById(R.id.checkBox1);
				view.setTag(viewHolder);
			} else {
				viewHolder = (ViewHolder) view.getTag();
			}

			viewHolder.mCheckBox.setTag(position);
			viewHolder.mCheckBox.setChecked(mSparseBooleanArray.get(position));
			viewHolder.mCheckBox
					.setOnCheckedChangeListener(mCheckedChangeListener);
			if (Constants.LOG)
				Log.i(TAG, "array size " + uriArray.size());
			if (uriArray != null && uriArray.get(position) != null
					&& !uriArray.get(position).equals("")) {
				if (!uriArray.get(position).contains(".mp4")) {
					if (Constants.LOG)
						Log.i(TAG, "camera " + uriArray.get(position));

					File f = new File(uriArray.get(position));
					viewHolder.image.setImageBitmap(decodeFile(f, 200, 200));

				} else {
					Bitmap thumb = ThumbnailUtils.createVideoThumbnail(
							uriArray.get(position),
							MediaStore.Images.Thumbnails.MINI_KIND);
					viewHolder.image.setImageBitmap(thumb);
				}

			}
			System.gc();
			return view;
		}

	};

	@SuppressLint("NewApi")
	private class VideoFileUploadAssync extends AsyncTask<Void, Void, Integer> {
		private final String TAG = "VideoFileUploadAssync";
		String fin_id = "";
		String thisHeader = "";

		public VideoFileUploadAssync(String Fin_IDD, String header) {
			this.fin_id = Fin_IDD;
			thisHeader = header;
		}

		protected void onPreExecute() {
			pDialog.setMessage("Posting Please Wait");
			pDialog.setIndeterminate(false);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected Integer doInBackground(Void... params) {
			FinaoServiceLinks FS = new FinaoServiceLinks();
			String str = FS.baseurl();
			try {
				if (Constants.LOG)
					Log.v("Upload Image URL", str);
				HttpClient httpclient = SingleTon.getInstance().getHttpClient();
				HttpPost httppost = new HttpPost(str);
				MultipartEntity reqEntity = new MultipartEntity();
				reqEntity.addPart("json", new StringBody("createpost"));
				reqEntity.addPart("finao_id", new StringBody(fin_id));
				reqEntity.addPart("postdata", new StringBody(text_ED.getText()
						.toString()));
				reqEntity.addPart("type", new StringBody("1"));
				httppost.setHeader("Authorization", "Basic " + thisHeader);
				httppost.setHeader("Finao-Token", thisHeader);
				if (uriArray.size() != 0) {
					if (!uriArray.get(0).contains(".mp4")) {
						for (int i = 0; i < uriArray.size(); i++) {
							if (uriArray.get(i) != null
									&& !uriArray.get(i).equals("")) {
								if (Constants.LOG)
									Log.d(TAG,
											"image file name" + uriArray.get(i));

								String imgname = "postimage" + i;
								reqEntity.addPart(imgname, new FileBody(
										new File(uriArray.get(i))));
							}
						}
					} else {
						FileBody filebodyVideo = new FileBody(new File(
								uriArray.get(0)));
						if (Constants.LOG)
							Log.d(TAG, "video file name" + uriArray.get(0));
						reqEntity.addPart("video", filebodyVideo);
					}
				}

				if (Constants.LOG)
					Log.i(TAG, "reqEntity" + reqEntity);
				httppost.setEntity(reqEntity);
				HttpResponse response = httpclient.execute(httppost);
				if (Constants.LOG)
					Log.i(TAG, "response" + response.getStatusLine());
				String res = Util.convertResponseToString(response);
				if (Constants.LOG)
					Log.i(TAG, "res" + res);

			} catch (Exception e) {
				e.printStackTrace();

			}

			return 0;
		}

		protected void onPostExecute(Integer result) {

			pDialog.dismiss();

			Toast.makeText(getApplicationContext(), "Posted Successfully",
					Toast.LENGTH_SHORT).show();
			Intent in = new Intent(getApplicationContext(),
					FinaoFooterTab.class);
			Bundle bundle = new Bundle();
			bundle.putInt("Tab_Key", 1);  
			in.putExtras(bundle);
			in.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(in);

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

	static class ViewHolder {
		ImageView image;
		CheckBox mCheckBox;
	}

	OnCheckedChangeListener mCheckedChangeListener = new OnCheckedChangeListener() {

		@Override
		public void onCheckedChanged(CompoundButton buttonView,
				boolean isChecked) {
			// mSparseBooleanArray.put((Integer) buttonView.getTag(),
			// isChecked);

			if (isChecked) {
				showForDeleteItem("Do you want to delete this item?", "Alert",
						(Integer) buttonView.getTag());
			}
		}
	};

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
				/*
				 * imageTaken = (Bitmap) data.getExtras().get("data");
				 * FileOutputStream out = null; try {
				 * 
				 * out = new FileOutputStream(mediaFilePath);
				 * imageTaken.compress(Bitmap.CompressFormat.JPEG, 100, out); if
				 * (uriArray.size() < 4) { uriArray.add(mediaFilePath); }
				 * 
				 * mediaFilePath = "";
				 * 
				 * mAdapter.notifyDataSetChanged();
				 * 
				 * } catch (FileNotFoundException e) { e.printStackTrace(); }
				 */
				break;
			case RESULT_CANCELED:
				// fileInputStream = null;
				imageTaken = null;

			}

		} else if (requestCode == TAKE_VIDEO_CAMERA_REQUEST) {
			switch (resultCode) {
			case RESULT_OK:
				try {
					AssetFileDescriptor videoAsset = getContentResolver()
							.openAssetFileDescriptor(data.getData(), "r");
					FileInputStream fis = videoAsset.createInputStream();
					File tmpFile = new File(video_file_name);
					FileOutputStream fos = new FileOutputStream(tmpFile);

					byte[] buf = new byte[1024];
					int len;
					while ((len = fis.read(buf)) > 0) {
						fos.write(buf, 0, len);
					}
					fis.close();
					fos.close();

					if (video_file_name != null) {
						// tmpFile = new File(video_file_name);
						if (tmpFile.exists()) {
							if (uriArray.size() < 2) {
								uriArray.add(video_file_name);
							}

							video_file_name = "";
							mAdapter.notifyDataSetChanged();
						} else {
							showAlert(
									"Problem occured while capturing the video ",
									"Error");
						}
					}

				} catch (IOException io_e) {
				}

				break;

			case RESULT_CANCELED:
				// fileInputStream = null;
				break;
			}
		} else if (requestCode == TAKE_PHOTO_FROM_GALLERY) {
			if (Constants.LOG)
				Log.d("DetailsAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:

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
						Log.i(TAG, "media file path in gallary :"
								+ mediaFilePath);

					startCropImage(mediaFilePath);

				}

				break;
			case RESULT_CANCELED:
				imageTaken = null;
				break;
			}
		} else if (requestCode == TAKE_Video_FROM_GALLERY) {
			if (Constants.LOG)
				Log.d("DetailsAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:
				ArrayList<String> list = data.getStringArrayListExtra("result");

				if (list != null) {
					for (int i = 0; i < list.size(); i++) {
						uriArray.add(list.get(i));
						if (Constants.LOG)
							Log.i(TAG, "uriArray" + list.get(i));
					}

					mAdapter.notifyDataSetChanged();
				}

				break;
			case RESULT_CANCELED:
				imageTaken = null;
				break;
			}
		} else if (requestCode == REQUEST_CODE_CROP_IMAGE) {
			if (Constants.LOG)
				Log.d("CropAct", "-- Take photo from lib returned --");
			switch (resultCode) {
			case RESULT_OK:
				uriArray.add(mediaFilePath);
				mAdapter.notifyDataSetChanged();
				break;
			case RESULT_CANCELED:
				break;
			}
		}
	}

	private void startCropImage(String imagePath) {
		Intent intent = new Intent(AddFinaoPage.this, CropImage.class);
		intent.putExtra(CropImage.IMAGE_PATH, imagePath);
		intent.putExtra(CropImage.SCALE, true);
		intent.putExtra(CropImage.ASPECT_X, 4);
		intent.putExtra(CropImage.ASPECT_Y, 4);
		startActivityForResult(intent, REQUEST_CODE_CROP_IMAGE);
	}

	public void showAlert(final String displayText, String title) {
		AlertDialog.Builder alertbox = new AlertDialog.Builder(
				AddFinaoPage.this);
		alertbox.setMessage(displayText);
		alertbox.setTitle(title);
		alertbox.setNeutralButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface arg0, int arg1) {

			}
		});
		alertbox.show();
	}

	public void showForDeleteItem(final String displayText, String title,
			final int pos) {
		AlertDialog.Builder alertbox = new AlertDialog.Builder(
				AddFinaoPage.this);
		alertbox.setMessage(displayText);
		alertbox.setTitle(title);
		alertbox.setPositiveButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface arg0, int arg1) {

				deleteImage(pos);
			}
		});
		alertbox.setNegativeButton("CANCEL",
				new DialogInterface.OnClickListener() {

					@Override
					public void onClick(DialogInterface dialog, int which) {

					}
				});

		alertbox.show();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		super.onConfigurationChanged(newConfig);

	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			finish();

			return true;
		}
		return super.onKeyDown(keyCode, event);
	}


}
