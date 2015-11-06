package com.finaonation.profile;


import com.finaonation.finao.R;

import android.app.Activity;
import android.os.Bundle;
import android.widget.EditText;

public class FinaoHomeDetail extends Activity{
	
	EditText Status_ET;
	String Status_Str;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.finaohomedetail);
		Bundle b = getIntent().getExtras();
		if(b != null){
			Status_Str = b.getString("StatusKey");
		}
		
		Status_ET = (EditText) findViewById(R.id.homedetailstatusedid);
		Status_ET.setText(Status_Str);
	}
}
