package com.finaonation.finao;

import android.app.Activity;
import android.app.ProgressDialog;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import com.finaonation.utils.FinaoCustomProgress;

public class WebViewActivity extends Activity {
	private WebView webView;
	ProgressDialog pDialog ;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_web_view);
		webView = (WebView) findViewById(R.id.webView1);
		
		
		webView.setWebViewClient(new myWebClient());
		webView.getSettings().setJavaScriptEnabled(true);
		String info = getIntent().getExtras().getString("info");
		if(info != null && info.trim().compareTo("") != 0){
			Toast.makeText(getApplicationContext(), info,
					Toast.LENGTH_LONG).show();
		}
		webView.loadUrl(getIntent().getExtras().getString("url"));

	}


	public class myWebClient extends WebViewClient
	{
		@Override
		public void onPageStarted(WebView view, String url, Bitmap favicon) {
			super.onPageStarted(view, url, favicon);
			pDialog = new ProgressDialog(WebViewActivity.this);
			pDialog.setCancelable(true);
			pDialog = FinaoCustomProgress.show(WebViewActivity.this, "FINAO Nation", "Please Wait ....!");
		}

		@Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			view.loadUrl(url);
			return true;

		}

		@Override
		public void onPageFinished(WebView view, String url) {
			super.onPageFinished(view, url);
			pDialog.dismiss();
		}
	}

	public void Done_click(View v){
		finish();
	}

}
