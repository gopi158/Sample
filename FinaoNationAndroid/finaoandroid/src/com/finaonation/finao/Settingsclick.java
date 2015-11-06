package com.finaonation.finao;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.LinearLayout;

public class Settingsclick extends Activity {
	LinearLayout Terms_click, Notification_click;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_settingsclick);
		Terms_click = (LinearLayout)findViewById(R.id.terms_click);
		Terms_click.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				Intent k = new Intent(Settingsclick.this,WebViewActivity.class);
				k.putExtra("url", "http://finaonation.com/profile/terms");
				k.putExtra("info", "Please review our terms and conditions. Thank you.");
				startActivity(k);
			}
		});
	
		Notification_click = (LinearLayout) findViewById(R.id.shop_click);
		Notification_click.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// To Do
				Intent intent = new Intent(getApplicationContext(), NotificationSettingActivity.class);
				startActivity(intent);
			}
		});
	}
	
	public void Done_click(View v){
		finish();
	}

	
}
