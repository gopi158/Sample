package com.finaonation.finao;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Toast;

import com.finaonation.baseactivity.FinaoFooterTab;

public class FinaoSplash extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_finao_splash);
		Toast.makeText(getApplicationContext(), "Version 1.14",
				Toast.LENGTH_LONG).show();
		
		Thread t = new Thread(){

			@Override
			public void run() {
				try
				{
					int time =0;
					while(time < 300)
					{
						sleep(1000);
						time = time + 100;
					}
					finish();
				}
				catch(Exception e)
				{

				}finally 
				{

					final SharedPreferences Finao_Login_Pref = getSharedPreferences("Finao_Preferences", Context.MODE_PRIVATE);
					String Login_Key = Finao_Login_Pref.getString("Login_Session", "");

					if(Login_Key.length() != 0){
						Intent i = new Intent(getApplicationContext(),FinaoFooterTab.class);
						i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
						startActivity(i);
						finish();
					}else{
						Intent i = new Intent(getApplicationContext(),FinaoLoginOrRegister.class);
						i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
						startActivity(i);
						finish();
					}
				}
			}
		};

		t.start();

	}
}
