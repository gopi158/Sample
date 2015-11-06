package com.finaonation.finao;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.MalformedURLException;

import org.json.JSONException;
import org.json.JSONObject;

import com.facebook.android.AsyncFacebookRunner;
import com.facebook.android.FacebookError;
import com.facebook.android.AsyncFacebookRunner.RequestListener;
import com.facebook.android.Facebook;
import com.finaonation.utils.Constants;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;
import android.widget.Toast;

public class SettingActivity extends Activity implements OnClickListener {
	private static final String HTTP_FINAO_H264_1080P_HQ_MP4 = "http://503e51859492bd1db4c8-1c5fc9a4b7622394621a8967c79cf921.r53.cf2.rackcdn.com/FINAO_H264_1080P_HQ.mp4";
	private static final String HTTP_FINAOGEAR_COM = "http://finaogear.com/";
	private static final String WHATS_FINAO_MP4 = "http://503e51859492bd1db4c8-1c5fc9a4b7622394621a8967c79cf921.r53.cf2.rackcdn.com/Whats_FINAO.mp4";
	private LinearLayout profile, settings, notifications, shop, logout, whatis,
			moreonfinao;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_setting);
		profile = (LinearLayout) findViewById(R.id.profile_click);
		settings = (LinearLayout) findViewById(R.id.settings_click);
		notifications = (LinearLayout) findViewById(R.id.notification_click);
		shop = (LinearLayout) findViewById(R.id.shop_click);
		logout = (LinearLayout) findViewById(R.id.logot);
		whatis = (LinearLayout) findViewById(R.id.whatis);
		moreonfinao = (LinearLayout) findViewById(R.id.moreonfinao);
		profile.setOnClickListener(this);
		settings.setOnClickListener(this);
		notifications.setOnClickListener(this);
		shop.setOnClickListener(this);
		logout.setOnClickListener(this);
		whatis.setOnClickListener(this);
		moreonfinao.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		Intent in;
		switch (v.getId()) {
		case R.id.profile_click:
			Intent i = new Intent(SettingActivity.this,
					SettinsEditActivity.class);
			startActivity(i);
			break;
		case R.id.settings_click:
			Intent y = new Intent(SettingActivity.this, Settingsclick.class);
			startActivity(y);
			break;
		case R.id.notification_click:
			Intent n = new Intent(SettingActivity.this,
					NotificationActivity.class);
			startActivity(n);
			break;
		case R.id.shop_click:
			Intent k = new Intent(SettingActivity.this, WebViewActivity.class);
			k.putExtra("url", HTTP_FINAOGEAR_COM);
			k.putExtra("info", "Click login or Register to shop");
			startActivity(k);
			break;
		case R.id.whatis:
			in = new Intent(getApplicationContext(),
					com.finaonation.finao.Videoplayer.class);
			in.putExtra("videourl", WHATS_FINAO_MP4);
			startActivity(in);
			break;
		case R.id.moreonfinao:
			in = new Intent(getApplicationContext(),
					com.finaonation.finao.Videoplayer.class);
			in.putExtra("videourl", HTTP_FINAO_H264_1080P_HQ_MP4);
			startActivity(in);
			break;
		case R.id.logot:
			try {
				logout();
			} catch (Exception e) {
			}
			@SuppressWarnings("deprecation")
			SharedPreferences Finao_Login_Pref = getSharedPreferences(
					"Finao_Preferences", MODE_WORLD_READABLE);
			SharedPreferences.Editor finao_Login_Pref_Editor = Finao_Login_Pref
					.edit();
			finao_Login_Pref_Editor.putString("Login_Session", "");
			finao_Login_Pref_Editor.commit();
			Toast.makeText(v.getContext(), "Logged out successfully",
					Toast.LENGTH_SHORT).show();
			Intent loginintent = new Intent(getApplicationContext(),
					FinaoLoginOrRegister.class);
			loginintent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(loginintent);
			finish();
			break;
		default:
			break;
		}
	}

	public void Back_click(View view) {
		finish();
	}

	public void logout() {
		final Facebook fb = new Facebook(getResources().getString(
				R.string.fb_app_id));
		new AsyncFacebookRunner(fb).logout(getApplicationContext(),
				new RequestListener() {

					@Override
					public void onComplete(String response, Object state) {
						if (Constants.LOG)
							Log.d("Profile", response);
						String json = response;
						try {
							// Facebook Profile JSON data
							@SuppressWarnings("unused")
							JSONObject profile = new JSONObject(json);
							fb.setAccessExpires(0);

						} catch (JSONException e) {
							e.printStackTrace();
						}
					}

					@Override
					public void onIOException(IOException e, Object state) {
					}

					@Override
					public void onFileNotFoundException(
							FileNotFoundException e, Object state) {
					}

					@Override
					public void onMalformedURLException(
							MalformedURLException e, Object state) {
					}

					@Override
					public void onFacebookError(FacebookError e, Object state) {
					}
				});

	}

}
