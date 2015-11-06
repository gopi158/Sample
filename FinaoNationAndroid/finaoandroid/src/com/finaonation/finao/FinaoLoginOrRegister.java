package com.finaonation.finao;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.MalformedURLException;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.animation.ArgbEvaluator;
import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.facebook.android.AsyncFacebookRunner;
import com.facebook.android.AsyncFacebookRunner.RequestListener;
import com.facebook.android.DialogError;
import com.facebook.android.Facebook;
import com.facebook.android.Facebook.DialogListener;
import com.facebook.android.FacebookError;
import com.finaonation.baseactivity.FinaoFooterTab;
import com.finaonation.internet.InternetChecker;
import com.finaonation.jsonhelper.JsonHelperRegister;
import com.finaonation.jsonhelper.JsonLogin;
import com.finaonation.jsonhelper.JsonLogin2;
import com.finaonation.jsonhelper.JsonMe2;
import com.finaonation.utils.Base64;
import com.finaonation.utils.Constants;
import com.finaonation.utils.EMailValidator;
import com.finaonation.utils.FinaoCustomProgress;

public class FinaoLoginOrRegister extends Activity {
	private static final String TAG = "FinaoLoginOrRegister";
	private static String APP_ID;
	private Facebook facebook;
	private AsyncFacebookRunner asyncFacebookRunner;
	private EditText Login_Email_ET, Login_Password_ET;
	private String headerToken;
	private SharedPreferences.Editor Finao_Preference_Editor;
	private ProgressDialog pDialog;
	private SharedPreferences Finao_Pref;
	private Button videoButton;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		setContentView(R.layout.activity_finaologin_or_register);
		APP_ID = getResources().getString(R.string.fb_app_id);
		Finao_Pref = getSharedPreferences("Finao_Preferences",
				Context.MODE_PRIVATE);
		Finao_Preference_Editor = Finao_Pref.edit();
		headerToken = Finao_Pref.getString("logtoken", "");
		facebook = new Facebook(APP_ID);
		asyncFacebookRunner = new AsyncFacebookRunner(facebook);

		Login_Email_ET = (EditText) findViewById(R.id.emaiedid);
		Login_Password_ET = (EditText) findViewById(R.id.passwordedid);

		Login_Email_ET.setText("wallace@finaonation.com");
		Login_Password_ET.setText("password");
		Login_Email_ET.setInputType(InputType.TYPE_CLASS_TEXT
				| InputType.TYPE_TEXT_VARIATION_EMAIL_ADDRESS);
		// Login_Email_ET.setText("sawan.kumar@battatech.com");
		// Login_Password_ET.setText("qwerty");

		videoButton = (Button) findViewById(R.id.VideoButton);
		animateVideoButtonTextColor();
		// animateVideoButtonBGColor();
	}

	@SuppressWarnings("unused")
	private void animateVideoButtonBGColor() {
		ObjectAnimator colorAnim = ObjectAnimator.ofInt(videoButton,
				"backgroundColor", Color.WHITE, Color.TRANSPARENT);
		colorAnim.setDuration(1000);
		colorAnim.setEvaluator(new ArgbEvaluator());
		colorAnim.setRepeatCount(ValueAnimator.INFINITE);
		colorAnim.setRepeatMode(ValueAnimator.REVERSE);
		colorAnim.start();
	}

	private void animateVideoButtonTextColor() {
		ObjectAnimator colorAnim = ObjectAnimator.ofInt(videoButton,
				"textColor", Color.WHITE, Color.TRANSPARENT);
		colorAnim.setDuration(1000);
		colorAnim.setEvaluator(new ArgbEvaluator());
		colorAnim.setRepeatCount(ValueAnimator.INFINITE);
		colorAnim.setRepeatMode(ValueAnimator.REVERSE);
		colorAnim.start();
	}

	@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub

	}

	@SuppressWarnings("deprecation")
	public void LoginBtn_Click(View v) {
		if (EMailValidator.isEmailValid(Login_Email_ET.getText().toString()) == false) {
			Toast.makeText(getApplicationContext(),
					"Please Enter Correct Email ID", Toast.LENGTH_SHORT).show();
			Login_Email_ET.requestFocus();
		} else if (Login_Password_ET.getText().length() == 0) {
			Toast.makeText(getApplicationContext(), "Please Enter  Password",
					Toast.LENGTH_SHORT).show();
			Login_Password_ET.requestFocus();
		} else {
			InternetChecker ic = new InternetChecker();
			boolean b = ic.IsNetworkAvailable(getApplicationContext());

			if (b == true) {
				String text = Login_Email_ET.getText().toString() + ":"
						+ Login_Password_ET.getText();
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
				new FinaoLoginTask(this).execute(header);

			} else {
				AlertDialog alertDialog = new AlertDialog.Builder(
						FinaoLoginOrRegister.this).create();
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

	public void whatsFinaoClick(View v) {
		Intent in = new Intent(getApplicationContext(),
				com.finaonation.finao.Videoplayer.class);
		in.putExtra(
				"videourl",
				"http://503e51859492bd1db4c8-1c5fc9a4b7622394621a8967c79cf921.r53.cf2.rackcdn.com/Whats_FINAO.mp4");
		startActivity(in);
	}

	private class FinaoLoginTask extends AsyncTask<String, Void, String> {
		private static final String LOGIN_FAILED = "Login failed";
		String Status_type;
		Activity act;

		public FinaoLoginTask(Activity ctx) {
			act = ctx;
		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(FinaoLoginOrRegister.this);
			pDialog.setCancelable(true);
			String Loading_Msg = "Please Wait....";
			pDialog = FinaoCustomProgress.show(FinaoLoginOrRegister.this,
					"FINAO Nation", Loading_Msg);
		}

		@Override
		protected String doInBackground(String... params) {
			// return oldAPI(params);
			return newAPI(params);
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();
			if (result.equalsIgnoreCase("Success")) {
				// if
				// (Status_type.equalsIgnoreCase("User succesfully logged in"))
				// {
				Toast.makeText(getApplicationContext(), "LOGIN SUCCESSFUL",
						Toast.LENGTH_SHORT).show();
				Finao_Preference_Editor = Finao_Pref.edit();
				Finao_Preference_Editor.putBoolean("share", false);
				Finao_Preference_Editor.putString("Login_Session", "True");
				Finao_Pref.getString("logtoken", "");
				Finao_Preference_Editor.commit();
				headerToken = Finao_Pref.getString("logtoken", "");
				new FinaoMeTask(act).execute(headerToken);
				// }
			} else {
				Toast.makeText(getApplicationContext(), LOGIN_FAILED,
						Toast.LENGTH_SHORT).show();
			}
		}

		private String newAPI(String... params) {
			JsonLogin2 jh = new JsonLogin2(headerToken);
			String status = null;
			JSONObject jb;
			try {
				String json = jh.getJSONfromURL(Login_Email_ET.getText()
						.toString(), Login_Password_ET.getText().toString(),
						params[0], act);
				jb = new JSONObject(json);
				Log.i(TAG, json);
				if (!jb.getBoolean("error")) {
					Status_type = jb.getString("data");
					storedata2(jb.getJSONArray("data"));
					status = "Success";
				} else {
					status = LOGIN_FAILED;
				}
			} catch (Exception e) {
				e.printStackTrace();
				status = LOGIN_FAILED;
			}
			return status;
		}

		private String oldAPI(String... params) {
			JsonLogin jh = new JsonLogin(headerToken);
			String status = null;
			JSONObject jb;
			try {
				String json = jh.getJSONfromURL(Login_Email_ET.getText()
						.toString(), Login_Password_ET.getText().toString(),
						params[0], act);
				jb = new JSONObject(json);
				Log.i(TAG, json);
				Status_type = jb.getString("message");
				if (jb.getBoolean("IsSuccess")) {
					storedata(jb.getJSONObject("item"));
					status = "Success";
				} else {
					status = LOGIN_FAILED;
				}
			} catch (Exception e) {
				e.printStackTrace();
				status = "faile";
			}
			return status;
		}
	}

	@SuppressWarnings("deprecation")
	public void Fb_click(View v) {

		InternetChecker ic = new InternetChecker();
		boolean b = ic.IsNetworkAvailable(getApplicationContext());

		if (b == true) {
			getFBDetails();
		} else {
			AlertDialog alertDialog = new AlertDialog.Builder(
					FinaoLoginOrRegister.this).create();
			alertDialog.setTitle("FinaoNation");
			alertDialog
					.setMessage("Network Failed - Please Check Your Internet Connection");
			alertDialog.setIcon(R.drawable.tick);
			alertDialog.setButton("OK", new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int which) {
				}
			});
			alertDialog.show();
		}

	}

	private void getFBDetails() {
		if (!facebook.isSessionValid()) {
			facebook.authorize(this,
					new String[] { "email", "publish_stream" },
					Facebook.FORCE_DIALOG_AUTH, new DialogListener() {
						@Override
						public void onCancel() {
						}

						@Override
						public void onComplete(Bundle values) {
							String access_token = facebook.getAccessToken();
							long expires = facebook.getAccessExpires();

							if (access_token != null) {
								facebook.setAccessToken(access_token);
							}

							if (expires != 0) {
								facebook.setAccessExpires(expires);
							}
							if (Constants.LOG)
								Log.d("FB_Access_Token  ", access_token);

							runOnUiThread(new Runnable() {

								@Override
								public void run() {
									pDialog = new ProgressDialog(
											FinaoLoginOrRegister.this);
									String Loading_Msg = "Please Wait....";
									pDialog.setCancelable(true);
									pDialog = FinaoCustomProgress.show(
											FinaoLoginOrRegister.this,
											"FINAO Nation", Loading_Msg);
								}

							});

							getProfileInformation();
						}

						@Override
						public void onError(DialogError error) {

						}

						@Override
						public void onFacebookError(FacebookError fberror) {

						}

					});
		}

	}

	public void getProfileInformation() {

		if (Constants.LOG)
			Log.i(TAG, "getProfileInformation() called.....");
		asyncFacebookRunner.request("me", new RequestListener() {

			@Override
			public void onComplete(String response, Object state) {
				if (Constants.LOG)
					Log.d("Profile", response);
				String json = response;
				try {
					// Facebook Profile JSON data
					JSONObject profile = new JSONObject(json);
					facebook.setAccessExpires(0);
					registerdetails(profile);

				} catch (JSONException e) {
					e.printStackTrace();
				}
			}

			@Override
			public void onIOException(IOException e, Object state) {
			}

			@Override
			public void onFileNotFoundException(FileNotFoundException e,
					Object state) {
			}

			@Override
			public void onMalformedURLException(MalformedURLException e,
					Object state) {
			}

			@Override
			public void onFacebookError(FacebookError e, Object state) {
			}
		});
	}

	private void registerdetails(JSONObject profile) {
		String first_name = null, last_name = null, gender = null, email = null, fbId = null;
		try {
			first_name = profile.getString("first_name");
			last_name = profile.getString("last_name");
			email = profile.getString("email");
			fbId = profile.getString("id");
			gender = profile.getString("gender");
			facebook.setAccessExpires(0);

		} catch (JSONException e) {
			e.printStackTrace();
		}

		Log.i(TAG, "profile" + profile);

		String text = email + ":" + fbId;
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

		new UserRegistrationTask().execute("" + 2, first_name, last_name,
				email, fbId, gender);

	}

	private class UserRegistrationTask extends AsyncTask<String, Void, String> {

		String Status_type;

		@Override
		protected String doInBackground(String... params) {
			JsonHelperRegister jh = new JsonHelperRegister(headerToken);
			String json = jh.getJSONfromURL(params[0], params[1], params[2],
					params[3], params[4], params[5]);
			if (Constants.LOG)
				Log.i(TAG, "json is :" + json);
			String status = null;
			JSONObject jb;
			try {
				jb = new JSONObject(json);
				if (jb.getBoolean("IsSuccess")) {
					Status_type = jb.getString("message");
					storedata(jb.getJSONObject("item"));
					status = "Success";
				} else {
					status = "fail";
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}
			return status;
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();
			if (result != null && result.equalsIgnoreCase("Success")) {
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
				} else if (Status_type != null
						&& Status_type
								.equalsIgnoreCase("User succesfully registered")) {
					Finao_Preference_Editor = Finao_Pref.edit();
					Finao_Preference_Editor.putBoolean("share", true);
					Finao_Preference_Editor.putString("Login_Session", "True");
					Finao_Preference_Editor.commit();

					Intent loginintent = new Intent(getApplicationContext(),
							FinaoFooterTab.class);
					startActivity(loginintent);
					finish();
				} else if (Status_type != null
						&& Status_type
								.equalsIgnoreCase("User registered with Facebook Plugin")) {
					Finao_Preference_Editor = Finao_Pref.edit();
					Finao_Preference_Editor.putBoolean("share", true);
					Finao_Preference_Editor.putString("Login_Session", "True");
					Finao_Preference_Editor.commit();

					Intent loginintent = new Intent(getApplicationContext(),
							FinaoFooterTab.class);
					startActivity(loginintent);
					finish();
				}
			} else {
				Toast.makeText(getApplicationContext(), Status_type,
						Toast.LENGTH_SHORT).show();
			}

		}
	}

	public void Signup_click(View v) {
		Intent in = new Intent(getApplicationContext(), FinaoRegister.class);
		startActivity(in);
	}

	public void storedata(JSONObject items) {
		try {
			Finao_Preference_Editor.putString("User_ID",
					items.getString("userid"));
			if (items.getString("profile_image") == null
					|| items.getString("profile_image")
							.equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("Profile_Image", "");
			else
				Finao_Preference_Editor.putString("Profile_Image",
						items.getString("profile_image"));

			if (items.getString("fname") == null
					|| items.getString("fname").equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("FName", "");
			else
				Finao_Preference_Editor.putString("FName",
						items.getString("fname"));

			if (items.getString("lname") == null
					|| items.getString("lname").equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("LName", "");
			else
				Finao_Preference_Editor.putString("LName",
						items.getString("lname"));

			if (items.getString("profile_bg_image") == null
					|| items.getString("profile_bg_image").equalsIgnoreCase(
							"null"))
				Finao_Preference_Editor.putString("Profile_BG_Image", "");
			else
				Finao_Preference_Editor.putString("Profile_BG_Image",
						items.getString("profile_bg_image"));

			String Story = items.getString("bio");
			if (Story == null || Story.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("bio", "");
			} else {
				Finao_Preference_Editor.putString("bio", Story);
			}

			Finao_Preference_Editor.commit();

		} catch (JSONException e) {
			e.printStackTrace();
		}

	}

	public void storedata2(JSONArray jsonArray) {
		try {
			JSONObject jb = new JSONObject(jsonArray.get(0).toString());
			Finao_Preference_Editor
					.putString("logtoken", jb.getString("token"));
			Finao_Preference_Editor.commit();

		} catch (JSONException e) {
			e.printStackTrace();
		}

	}

	private class FinaoMeTask extends AsyncTask<String, Void, String> {
		private static final String LOGIN_FAILED = "Login failed";

		Activity act;

		public FinaoMeTask(Activity ctx) {
			act = ctx;
		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(FinaoLoginOrRegister.this);
			pDialog.setCancelable(true);
			String Loading_Msg = "Getting Info....";
			pDialog = FinaoCustomProgress.show(FinaoLoginOrRegister.this,
					"FINAO Nation", Loading_Msg);
		}

		@Override
		protected String doInBackground(String... params) {
			return newAPIGet(params);
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();
			if (result.equalsIgnoreCase("Success")) {
				// if
				// (Status_type.equalsIgnoreCase("User succesfully logged in"))
				// {
				Toast.makeText(getApplicationContext(), "LOGIN SUCCESSFUL",
						Toast.LENGTH_SHORT).show();
				Finao_Preference_Editor = Finao_Pref.edit();
				Finao_Preference_Editor.putBoolean("share", false);
				Finao_Preference_Editor.putString("Login_Session", "True");
				Finao_Preference_Editor.commit();

				Intent loginintent = new Intent(getApplicationContext(),
						FinaoFooterTab.class);
				startActivity(loginintent);
				finish();
				// }
			} else {
				Toast.makeText(getApplicationContext(), LOGIN_FAILED,
						Toast.LENGTH_SHORT).show();
			}
		}

		private String newAPIGet(String... params) {
			JsonMe2 jh = new JsonMe2(headerToken);
			String status = null;
			JSONObject jb;
			try {
				String json = jh.getJSONfromURL(act);
				jb = new JSONObject(json);
				Log.i(TAG, json);
				if (!jb.getBoolean("error")) {
					storedata3(jb.getJSONArray("data"));
					status = "Success";
					Intent loginintent = new Intent(getApplicationContext(),
							FinaoFooterTab.class);
					startActivity(loginintent);
					finish();
				} else {
					status = LOGIN_FAILED;
				}
			} catch (Exception e) {
				e.printStackTrace();
				status = LOGIN_FAILED;
			}
			return status;
		}
	}

	public void storedata3(JSONArray itemsArray) {
		try {
			JSONObject items = new JSONObject(itemsArray.get(0).toString());
			String theItemValue = items.getString("customer_id");
			Finao_Preference_Editor.putString("User_ID",
					items.getString("customer_id"));
			if (items.getString("profile_image_url") == null
					|| items.getString("profile_image_url").equalsIgnoreCase(
							"null"))
				Finao_Preference_Editor.putString("Profile_Image", "");
			else
				Finao_Preference_Editor.putString("Profile_Image",
						items.getString("profile_image_url"));

			if (items.getString("first_name") == null
					|| items.getString("first_name").equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("FName", "");
			else
				Finao_Preference_Editor.putString("FName",
						items.getString("first_name"));

			if (items.getString("last_name") == null
					|| items.getString("last_name").equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("LName", "");
			else
				Finao_Preference_Editor.putString("LName",
						items.getString("last_name"));

			if (items.getString("profile_timeline_image_url") == null
					|| items.getString("profile_timeline_image_url")
							.equalsIgnoreCase("null"))
				Finao_Preference_Editor.putString("Profile_BG_Image","");
			else
				Finao_Preference_Editor.putString("Profile_BG_Image",
						items.getString("profile_timeline_image_url"));

			theItemValue = items.getString("bio");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("MyStory", "");
			} else {
				Finao_Preference_Editor.putString("MyStory", theItemValue);
			}
			theItemValue = items.getString("username");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("username", "");
			} else {
				Finao_Preference_Editor.putString("username", theItemValue);
			}

			theItemValue = items.getString("dob");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("dob", "");
			} else {
				Finao_Preference_Editor.putString("dob", theItemValue);
			}
			theItemValue = items.getString("posts");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("posts", "");
			} else {
				Finao_Preference_Editor.putString("posts", theItemValue);
			}
			theItemValue = items.getString("finaos");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("finaos", "");
			} else {
				Finao_Preference_Editor.putString("finaos", theItemValue);
			}
			theItemValue = items.getString("tiles");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("tiles", "");
			} else {
				Finao_Preference_Editor.putString("tiles", theItemValue);
			}
			theItemValue = items.getString("following");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("following", "");
			} else {
				Finao_Preference_Editor.putString("following", theItemValue);
			}
			theItemValue = items.getString("followers");
			if (theItemValue == null || theItemValue.equalsIgnoreCase("null")) {
				Finao_Preference_Editor.putString("followers", "");
			} else {
				Finao_Preference_Editor.putString("followers", theItemValue);
			}

			Finao_Preference_Editor.commit();
		} catch (JSONException e) {
			e.printStackTrace();
		}

	}
}
