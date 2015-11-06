package com.finaonation.finao;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.media.AudioManager;
import android.media.AudioManager.OnAudioFocusChangeListener;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.view.View;
import android.webkit.ConsoleMessage;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class WebViewActivityLand extends Activity {
	private WebView webView;
	ProgressDialog pDialog;
	MediaPlayer thisMP;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_web_view);
		webView = (WebView) findViewById(R.id.webView1);

		webView.setWebViewClient(new myWebClient());
		webView.setWebChromeClient(new MyWebChromeClient());
		webView.getSettings().setJavaScriptEnabled(true);
		webView.loadUrl(getIntent().getExtras().getString("url"));

	}

	private class MyWebChromeClient extends WebChromeClient implements
			MediaPlayer.OnInfoListener, MediaPlayer.OnSeekCompleteListener,
			MediaPlayer.OnErrorListener,
			MediaPlayer.OnVideoSizeChangedListener,
			MediaPlayer.OnCompletionListener, MediaPlayer.OnPreparedListener,
			MediaPlayer.OnBufferingUpdateListener {

		@Override
		public void onProgressChanged(WebView view, int progress) {
		}

		@Override
		public boolean onConsoleMessage(ConsoleMessage cm) {
			return (true);
		}

		@Override
		public void onBufferingUpdate(MediaPlayer mp, int percent) {
			thisMP = mp;

		}

		@Override
		public void onPrepared(MediaPlayer mp) {
			thisMP = mp;

		}

		@Override
		public void onCompletion(MediaPlayer mp) {
			mp.release();
		}

		@Override
		public void onVideoSizeChanged(MediaPlayer mp, int w, int h) {
			thisMP = mp;

		}

		@Override
		public boolean onError(MediaPlayer mp, int what, int extra) {
			thisMP = mp;
			return false;
		}

		@Override
		public void onSeekComplete(MediaPlayer mp) {
			thisMP = mp;

		}

		@Override
		public boolean onInfo(MediaPlayer mp, int arg1what, int extra) {
			thisMP = mp;
			return false;
		}
	}

	@Override
	protected void onPause() {
		super.onPause();
		stopPlayerNow();
	}

	private void stopPlayerNow() {
		try {
			dismissDialog();
			releaseMP();
			((AudioManager) getSystemService(Context.AUDIO_SERVICE))
					.requestAudioFocus(new OnAudioFocusChangeListener() {
						@Override
						public void onAudioFocusChange(int focusChange) {
						}
					}, AudioManager.STREAM_MUSIC,
							AudioManager.AUDIOFOCUS_GAIN_TRANSIENT);
			webView.loadUrl("http://finaonation.com");
		} catch (Exception e) {
		}
	}

	private void releaseMP() {
		try {
			if (thisMP != null)
				thisMP.stop();
			thisMP.release();
		} catch (Exception e) {
		}
	}

	public class myWebClient extends WebViewClient {
		@Override
		public void onPageStarted(WebView view, String url, Bitmap favicon) {
			super.onPageStarted(view, url, favicon);
			try {
				pDialog = new ProgressDialog(WebViewActivityLand.this);
				pDialog.setCancelable(true);
			} catch (Exception e) {
			}
		}

		@Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			view.loadUrl(url);
			return true;

		}

		@Override
		public void onPageFinished(WebView view, String url) {
			super.onPageFinished(view, url);
			dismissDialog();
		}
	}

	public void Done_click(View v) {
		stopPlayerNow();
		dismissDialog();
		finish();
	}

	private void dismissDialog() {
		try {
			if (pDialog.isShowing()) {
				pDialog.dismiss();
			}
		} catch (Exception e) {
		}
	}

}
