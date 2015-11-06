package com.finaonation.finao;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.EditText;

public class SettingsFinaoEditor extends Activity {
	EditText Fiaomsg;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_settings_finao_editor);
		Fiaomsg=(EditText)findViewById(R.id.Finaomsg_ET);
		Fiaomsg.setText(getIntent().getExtras().get("msg").toString());
	}
	@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub
//		super.onBackPressed();
		Intent returnIntent = new Intent();
		returnIntent.putExtra("result",Fiaomsg.getText().toString());
		setResult(RESULT_OK,returnIntent);     
		finish();
	}

	public void Done_click(View view){
		Intent returnIntent = new Intent();
		returnIntent.putExtra("result",Fiaomsg.getText().toString());
		setResult(RESULT_OK,returnIntent);     
		finish();
	}
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.settings_finao_editor, menu);
		return true;
	}

}
