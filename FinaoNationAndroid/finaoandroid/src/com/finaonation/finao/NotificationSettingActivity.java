package com.finaonation.finao;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.View;

public class NotificationSettingActivity extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_notification_setting);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.notification_setting, menu);
		return true;
	}
	
	public void Done_click(View v){
		finish();
	}
}
