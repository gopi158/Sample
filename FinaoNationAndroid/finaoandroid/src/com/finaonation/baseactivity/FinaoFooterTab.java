package com.finaonation.baseactivity;

import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TabHost;

import com.finaonation.addfinao.SelectFinaoToPost;
import com.finaonation.finao.R;
import com.finaonation.home.FinaoHome;
import com.finaonation.profile.FinaoProfilePage;
import com.finaonation.search.FinaoSearchPage;
@SuppressWarnings("deprecation")
public class FinaoFooterTab extends TabActivity {
	TabHost tabHost;
	int key;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.finaofootertab);

		Bundle b = getIntent().getExtras();
		if(b!=null){
			key = b.getInt("Tab_Key");
		}
		tabHost = getTabHost();
		setTabs();

		if(key == 1){
			tabHost.setCurrentTab(3);
		}else{
			tabHost.setCurrentTab(0);
		}
	}
	private void setTabs()
	{	
		addTab(R.drawable.tab_home, FinaoHome.class);
		addTab(R.drawable.tab_search, FinaoSearchPage.class);
		addTab(R.drawable.tab_add, SelectFinaoToPost.class);
		addTab(R.drawable.tab_profile, FinaoProfilePage.class);
	}

	private void addTab(int drawableId, Class<?> c)
	{
		//		TabHost tabHost = getTabHost();
		Intent intent = new Intent(this, c);
		TabHost.TabSpec spec = tabHost.newTabSpec("tab"); 	

		View tabIndicator = LayoutInflater.from(this).inflate(R.layout.tab_indicator, getTabWidget(), false);

		ImageView icon = (ImageView) tabIndicator.findViewById(R.id.imageView1);
		icon.setImageResource(drawableId);
		spec.setIndicator(tabIndicator);
		spec.setContent(intent);
		tabHost.addTab(spec);
	}
}
